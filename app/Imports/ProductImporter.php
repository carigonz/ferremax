<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\Catalog;
use App\Models\Discount;
use Exception;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProductImporter implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading
{
    public function __construct(Catalog $catalog)
    {
        $this->catalog = $catalog;
    }

    /**
    * @param array $row
    *p
    * @return Product|null
    */
    public function model(array $row)
    {
        # custom code
        $row['codigo'] = $this->catalog->acronym . '-' . (string)$row['codigo'];

        if (isset($row['costo'])) {
            $costPrice = $this->currencyToDecimal($row['costo']);

        } elseif (isset($row['neto'])) {
            $costPrice = $this->currencyToDecimal($row['neto']);
        }

        if (!isset($costPrice)){
            throw new Exception('Hubo un error al formatear el costo de los productos. Verifique que la columna tenga el nombre correcto.');
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

        $finalPrice = $this->addGanancia($publicPrice);

        return new Product([
            'name' => ucfirst(mb_strtolower($row['nombre'])),
            'code' => $row['codigo'],
            'price' => $costPrice ,
            'public_price' => $row['publico'] ?? $row['precio_publico'] ?? $finalPrice ,
            'catalog_id' => $this->catalog->id,
            'description' => ucfirst(mb_strtolower($row['descripcion'])) ?? null,
            'custom' => $row['custom'] ?? 0,
            'section_id' => $row['section'] ?? null,
        ]);
    }
    
    public function batchSize(): int
    {
        return 100;
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
