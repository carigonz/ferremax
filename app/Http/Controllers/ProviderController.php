<?php

namespace App\Http\Controllers;

use App\Repositories\ProviderTypeRepository;
use App\Repositories\ProviderRepository;
use App\Repositories\CatalogRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProviderController extends Controller
{
    /** @var ProviderRepository $providerRepository */
    protected $providerRepository;

    /** @var ProviderTypeRepository $providerTypeRepository */
    protected $providerTypeRepository;

    /** @var CatalogRepository $catalogRepository */
    protected $catalogRepository;

    public function __construct(ProviderTypeRepository $providerTypeRepository, ProviderRepository $providerRepository, CatalogRepository $catalogRepository)
    {
        $this->providerTypeRepository = $providerTypeRepository;
        $this->providerRepository = $providerRepository;
        $this->catalogRepository = $catalogRepository;
    }
    /**
     * 
     */
    public function index()
    {
        try {
            /** @var Collection $providers */
            $providers = $this->providerRepository->all();

            /** @var Collection $providerTypes */
            $providerTypes = $this->providerTypeRepository->all();

            return view('providers.index')
                ->with('providers', $providers)
                ->with('providerTypes', $providerTypes);

        } catch (Exception $e) {
            logger($e->getMessage());
            logger($e->getTraceAsString());
            return redirect()
                ->back()
                ->withErrors('Ha ocurrido un error imprevisto. Por favor contactar a administración');
        }
    } 
    /**
     * Create new provider view
     */
    public function create()
    {
        /** @var Collection $types */
        $types = $this->providerTypeRepository->all();

        try {
            return view('providers.create')
                ->with('providerTypes', $types);

        } catch (Exception $e) {
            logger($e->getMessage());
            logger($e->getTraceAsString());
            return redirect()
                ->back()
                ->withErrors('Ha ocurrido un error imprevisto. Por favor contactar a administración');
        }
    }

    /**
     * Create new provider view
     * @param int $id
     * @return View|void
     */
    public function show($id)
    {
        try {
            /** @var Collection $types */
            $types = $this->providerTypeRepository->all();

            /** @var Provider $provider */
            $provider = $this->providerRepository->getById($id);

            return view('providers.show')
                ->with('provider', $provider)
                ->with('providerTypes', $types);

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
    public function store(Request $request)
    {
        $params = $request->validate([
            'name' => 'required|unique:providers|max:255',
            'description' => 'max:255',
            'provider_type_id' => 'required|integer'
        ]);

        $params['name'] = ucfirst(mb_strtolower($params['name']));
        $params['description'] = ucfirst(mb_strtolower($params['description']));

        try {
            DB::beginTransaction();

            /** @var Provider $provider */
            $this->providerRepository->create($params);

            DB::commit();
    
            return redirect('configuration')
                ->with('alert_success', 'El proveedor se ha creado correctamente');

        } catch (Exception $e) {
            DB::rollback();
            logger($e->getMessage());
            logger($e->getTraceAsString());
            return redirect()->back()
                ->withErrors('El proveedor no pudo ser creado. Por favor contactar a administración');
        }
    }

    /**
     * @param Request $request
     */
    public function update(Request $request, $id)
    {
        $params = $request->validate([
            'name' => 'min:3|max:255',
            'description' => 'max:255',
            'provider_type_id' => 'integer',
            'status' => 'boolean'
        ]);

        if (isset($params['name'] )) {
            $params['name'] = ucfirst(mb_strtolower($params['name']));

        } elseif (isset($params['description'])) {
            $params['description'] = ucfirst(mb_strtolower($params['description']));
        }
        
        try {

            DB::beginTransaction();
            /** @var Provider $provider */
            $provider = $this->providerRepository->getById($id);

            if (!$provider){
                throw new Exception("No se encontró proveedor con id: {$id}. Contacte administración.");
            }
    
            /** @var Provider $provider */
            $this->providerRepository->update($provider, $params);
            DB::commit();

            return redirect()->route('providers.index')
                ->with('alert_success', "El proveedor ha sido actualizado.");

        } catch (Exception $e) {
            DB::rollback();
            logger($e->getMessage());
            logger($e->getTraceAsString());
            return redirect()->back()->withErrors('El proveedor no pudo ser actualizado. Por favor contactar a administración');
        }
    }

    /**
     * @param int $id
     */
    public function destroy($id)
    {
        try {
            /** @var Provider $provider */
            $provider = $this->providerRepository->getById($id);

            if (!$provider){
                throw new Exception("No se encontró proveedor con id: {$id}. Contacte administración.");
            }

            DB::beginTransaction();
    
            /** @var Category $category */
            $this->providerRepository->delete($provider);

            DB::commit();

            return redirect()
                ->route('providers.index')
                ->with('alert_success', 'El proveedor ha sido eliminado correctamente.');

        } catch (Exception $e) {
            DB::rollback();
            logger($e->getMessage());
            logger($e->getTraceAsString());
            return redirect()
                ->back()->withErrors('La clasificación no pudo ser eliminada. Por favor contactar a administración');
        }
    }

    /**
     * @param int $id
     */
    public function configurate($id)
    {
       // try {
            /** @var Provider $provider */
            $provider = $this->providerRepository->getById($id);

            if (!$provider){
                throw new Exception("No se encontró proveedor con id: {$id}. Contacte administración.");
            }

            /** @var Collection $catalogs */
            $catalogs = $this->catalogRepository->search(['provider_id' => $provider->id])->get();

            return view('providers.configurate.index')
                ->with('catalogs', $catalogs)
                ->with('provider', $provider);

        // } catch (Exception $e) {
        //     DB::rollback();
        //     logger($e->getMessage());
        //     logger($e->getTraceAsString());
        //     return redirect()
        //         ->back()->withErrors('La clasificación no pudo ser eliminada. Por favor contactar a administración');
        // }
    }
}
