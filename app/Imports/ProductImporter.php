<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\Catalog;
use App\Models\Discount;
use Exception;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Validators\ValidationException;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProductImporter implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading, WithValidation
{
    public function __construct(Catalog $catalog)
    {
        $this->catalog = $catalog;
        $this->regex = "/^(?!0*[.,]?0+$)\d*[.,]?\d+[.,]?\d+$/";
    }

    /**
    * @param array $row
    * @throws Exception
    * @return Product|null
    */
    public function model(array $row)
    {
        if (collect($row)->filter()->isEmpty()) {
            return null;
        }

        if (isset($row['costo']) && $row['costo'] && preg_match($this->regex, $row['costo'])) {
            $costPrice = $this->currencyToDecimal($row['costo']);

        } elseif (isset($row['neto']) && $row['neto'] && preg_match($this->regex, $row['neto']) ) {
            $costPrice = $this->currencyToDecimal($row['neto']);
        }

        if (!isset($costPrice)){
            throw new Exception("Hubo un error al formatear el costo de los productos. Verifique que las columnas tenga el nombre correcto. Producto {$row['name']} - Código {$row['codigo']}.");
        }

        # add taxes when needed
        if (!isset($row['publico']) && !isset($row['precio_publico']) && $this->catalog->taxes == false) {
            $publicPrice = $this->addTaxesToCostPrice($costPrice);
        } elseif ($this->catalog->taxes && !isset($row['publico']) && !isset($row['precio_publico'])) {
            $publicPrice = $costPrice;
        }

        if (!isset($publicPrice) && !isset($row['publico']) and !isset($row['precio_publico'])){
            throw new Exception('Hubo un error al formatear el precio al público. Contacte administración.');
        }

        if ($this->catalog->has('discounts')) {
            $this->processDiscounts($publicPrice);
        }

        # custom code
        $customCode = $this->catalog->acronym . '-' . (string)$row['codigo'];

        $descripcion = isset($row['descripcion']) ? ucfirst(mb_strtolower($row['descripcion'])) : null;

        $finalPrice = $this->addGanancia($publicPrice);

        return new Product([
            'name' => ucfirst(mb_strtolower($row['nombre'])),
            'code' => $customCode,
            'provider_code' => (string)$row['codigo'],
            'price' => $costPrice ,
            'public_price' => $row['publico'] ?? $row['precio_publico'] ?? $finalPrice ,
            'catalog_id' => $this->catalog->id,
            'description' => $descripcion,
            'custom' => $row['custom'] ?? 0,
            'section_id' => $row['section'] ?? null,
        ]);
    }

    /**
    * @return array
    */
    public function  rules(): array {
        return [
            '*.code' => 'unique:products',
        ];
    }

    /**
     * @return array
     */
    public function customValidationMessages()
    {
        return [
            '*.code' => 'El código ya existe con el mismo acrónimo de la lista. Modifique el código del producto',
        ];
    }
    
    public function batchSize(): int
    {
        return 500;
    }
    
    public function chunkSize(): int
    {
        return 1000;
    }

    /** @param float $value */
    private function addGanancia($value) 
    {
        return ($value * 1.4);
    }

    /** @param float $value */
    private function processDiscounts(&$value) 
    {
        /** @var Discount $discount */
        foreach ($this->catalog->discounts()->get() as $discount) {
            $value = $value - ($value * ($discount->amount / 100));
        }
        return $value;
    }

    /** @param float $cost */
    private function addTaxesToCostPrice($cost) 
    {
        return $this->catalog->getTariffWithIVA($cost);
    }

    private function currencyToDecimal($value) {

        $value = trim($value);

        /**
         * Standardize readability delimiters
         *****************************************************/

            // Space used as thousands separator between digits
            $value = preg_replace('/(\d)(\s)(\d)/', '$1$3', $value); 

            // Decimal used as delimiter when comma used as radix
            if (stristr($value, '.') && stristr($value, ',')) {
                // Ensure last period is BEFORE first comma
                if (strrpos($value, '.') < strpos($value, ',')) {
                    $value = str_replace('.', '', $value);
                }
            }

            // Comma used as delimiter when decimal used as radix
            if (stristr($value, ',') && stristr($value, '.')) {
                // Ensure last period is BEFORE first comma
                if (strrpos($value, ',') < strpos($value, '.')) {
                    $value = str_replace(',', '', $value);
                }
            }

        /**
         * Standardize radix (decimal separator)
         *****************************************************/

            // Possible radix options
            $radixOptions = [',', ' '];

            // Convert comma radix to "point" or "period"
            $value = str_replace(',', '.', $value);

        /**
         * Strip non-numeric and non-radix characters
         *****************************************************/

            // Remove other symbols like currency characters
            $value = preg_replace('/[^\d\.]/', '', $value);

            // String to float first before formatting
            $value = floatval($value);

        return $value;

    }

}
