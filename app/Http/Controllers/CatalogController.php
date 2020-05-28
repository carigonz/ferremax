<?php

namespace App\Http\Controllers;

use App\Repositories\CatalogRepository;
use App\Repositories\ProviderRepository;
use Exception;
use App\Imports\ProductImporter;
use App\Repositories\DiscountRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Catalog;

class CatalogController extends Controller
{
    /** @var CatalogRepository $catalogRepository */
    protected $catalogRepository;

    /** @var ProviderRepository $providerRepository */
    protected $providerRepository;

    /** @var DiscountRepository $discountRepository */
    protected $discountRepository;

    public function __construct(CatalogRepository $catalogRepository, ProviderRepository $providerRepository, DiscountRepository $discountRepository)
    {
        $this->catalogRepository = $catalogRepository;
        $this->providerRepository = $providerRepository;
        $this->discountRepository = $discountRepository;
    }
    /**
     * 
     */
    // public function index()
    // {
    //     try {
    //         /** @var Collection $categories */
    //         $categories = $this->categoryRepository->all();

    //         /** @var Collection $classifications */
    //         $classifications = $this->classificationRepository->all();

    //         return view('categories.index')
    //             ->with('categories', $categories)
    //             ->with('classifications', $classifications);

    //     } catch (Exception $e) {
    //         logger($e->getMessage());
    //         logger($e->getTraceAsString());
    //         return redirect()
    //             ->back()
    //             ->withErrors('Ha ocurrido un error imprevisto. Por favor contactar a administración');
    //     }
    // } 
    /**
     * Create new categories view
     */
    public function create($id)
    {
        /** @var Collection $providers */
        $provider = $this->providerRepository->getById($id);

        try {
            return view('providers.catalogs.create')
            ->with('provider', $provider);

        } catch (Exception $e) {
            logger($e->getMessage());
            logger($e->getTraceAsString());
            return redirect()
                ->back()
                ->withErrors('Ha ocurrido un error imprevisto. Por favor contactar a administración');
        }
    }

    /**
     * 
     */
    public function show($id, $catalog_id)
    {
        try {
            /** @var Provider $provider */
            $provider = $this->providerRepository->search(['id' => $id])->with(['parent'])->first();

            /** @var Catalog $catalog */
            $catalog = $this->catalogRepository->getById($catalog_id);

            return view('providers.catalogs.show')
                ->with('catalog', $catalog)
                ->with('provider', $provider);

        } catch (Exception $e) {
            logger($e->getMessage());
            logger($e->getTraceAsString());
            return redirect()
                ->back()
                ->withErrors('Ha ocurrido un error imprevisto. Por favor contactar a administración');
        }
    }

    /**
     * @param Request $request
     */
    public function store(Request $request, $id)
    {
        $catalogRequest = $request->validate([
            'name' => 'required|max:255',
            'acronym' => 'required|unique:catalogs|max:255',
            'file' => 'required|max:50000|mimetypes:application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/x-vnd.oasis.opendocument.spreadsheet',
            'taxes' => 'boolean',
            'taxes_amount' => 'regex:/^\d+(\.\d{1,2})?$/|nullable',
            "discounts"    => "array|min:1",
            "discounts.*"  => "required|regex:/^\d+(\.\d{1,2})?$/",
        ]);

        try {
            # Storage file 
            $file = $catalogRequest['file'];
            $file_name = $file->getClientOriginalName();
            $file->move('storage/files', $file_name);
            unset($catalogRequest['file']);

            # Prepare Catalog Instance
            $catalogRequest['provider_id'] = $id;
            $catalogRequest['acronym'] = strtoupper($catalogRequest['acronym']);
            $catalogRequest['taxes_amount'] = isset($catalogRequest['taxes']) ? 21 : $catalogRequest['taxes_amount'] ;
            $catalogRequest['name'] = ucfirst(mb_strtolower($catalogRequest['name']));
            $catalogRequest['file_name'] = $file_name;
        
            DB::beginTransaction();

            # Create catalog instance
            /** @var CatalogRepository $category */
            $catalog = $this->catalogRepository->create($catalogRequest);
    
            # Store discounts instances
            if (isset($catalogRequest['discounts'])) {
                foreach ($catalogRequest['discounts'] as $discount) {
                    $test = $this->discountRepository->create([
                        'discountable_id' => $catalog->id,
                        'discountable_type' => Catalog::class,
                        'amount' => floatval($discount),
                        'active' => true
                    ]);
                    logger($test->amount);
                }
            }

            # Import products
            Excel::import(new ProductImporter($catalog), 'files/'. $file_name);

            DB::commit();

            return redirect()->back()
                ->with('alert_success', 'La lista ha sido procesada correctamente');

        } catch (Exception $e) {
            DB::rollback();
            //$failures = $e->failures();
            logger($e->getMessage());
            logger($e->getTraceAsString());
            /* $errors = [];

            foreach ($failures as $failure) {
                $row = $failure->row(); // row that went wrong
                $key = $failure->attribute(); // either heading key (if using heading row concern) or column index
                $error = $failure->errors(); // Actual error messages from Laravel validator
                $value = $failure->values(); // The values of the row that has failed.
                $errors[] = "El valor {$value} ingresado en {$key} es no pudo ser procesado, fila {$row}, error: {$error}.";
            } */

            return redirect()->back()
                //->with('alert_danger', $errors)
                ->withErrors($e->getMessage())
                ->withInput($catalogRequest);
        }
    }

    /**
     * @param Request $request
     * working here now
     */
    public function update(Request $request, $id)
    {
        dd($request->all());
        $params = $request->validate([
            'name' => 'required|min:3|max:255',
            'description' => 'max:255',
            'classification_id' => 'integer|required'
        ]);
        $params['name'] = ucfirst(mb_strtolower($params['name']));
        $params['description'] = ucfirst(mb_strtolower($params['description']));

        try {

            DB::beginTransaction();
            /** @var Category $category */
            $category = $this->categoryRepository->getById($id);

            /** @var Category $category */
            $this->categoryRepository->update($category, $params);
            DB::commit();

            return redirect()->route('categories.index')
                ->with('alert_success', "La clasificación ha sido actualizada.");

        } catch (Exception $e) {
            DB::rollback();
            logger($e->getMessage());
            logger($e->getTraceAsString());
            return redirect()->back()->withErrors('La clasificación no pudo ser actualizada. Por favor contactar a administración');
        }
    }

    /**
     * @param int $id
     */
    // public function destroy($id)
    // {
    //     try {
    //         /** @var Category $category */
    //         $category = $this->categoryRepository->getById($id);

    //         if (!$category){
    //             throw new Exception("No se encontró clasificación con id: {$id}. Contacte administración.");
    //         }
    //         DB::beginTransaction();
    
    //         /** @var Category $category */
    //         $this->categoryRepository->delete($category);

    //         DB::commit();

    //         return redirect()
    //             ->route('categories.index')
    //             ->with('alert_success', 'La clasificación ha sido eliminada correctamente.');

    //     } catch (Exception $e) {
    //         DB::rollback();
    //         logger($e->getMessage());
    //         logger($e->getTraceAsString());
    //         return redirect()
    //             ->back()->withErrors('La clasificación no pudo ser eliminada. Por favor contactar a administración');
    //     }
    // }

}
