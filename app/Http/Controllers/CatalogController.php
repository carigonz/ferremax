<?php

namespace App\Http\Controllers;

use App\Repositories\CategoryRepository;
use App\Repositories\ClassificationRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CatalogController extends Controller
{
    /** @var CategoryRepository $categoryRepository */
    protected $categoryRepository;

    /** @var ClassificationRepository $classificationRepository */
    protected $classificationRepository;

    public function __construct(CategoryRepository $categoryRepository, ClassificationRepository $classificationRepository)
    {
        $this->categoryRepository = $categoryRepository;
        $this->classificationRepository = $classificationRepository;
    }
    /**
     * 
     */
    public function index()
    {
        try {
            /** @var Collection $categories */
            $categories = $this->categoryRepository->all();

            /** @var Collection $classifications */
            $classifications = $this->classificationRepository->all();

            return view('categories.index')
                ->with('categories', $categories)
                ->with('classifications', $classifications);

        } catch (Exception $e) {
            logger($e->getMessage());
            logger($e->getTraceAsString());
            return redirect()
                ->back()
                ->withErrors('Ha ocurrido un error imprevisto. Por favor contactar a administración');
        }
    } 
    /**
     * Create new categories view
     */
    public function create()
    {
        /** @var Collection $providers */
        //$classifications = $this->classificationRepository->all();

        try {
            return view('providers.catalogs.create')
            /* ->with('classifications', $classifications) */;

        } catch (Exception $e) {
            logger($e->getMessage());
            logger($e->getTraceAsString());
            return redirect()
                ->back()
                ->withErrors('Ha ocurrido un error imprevisto. Por favor contactar a administración');
        }
    }

    /**
     * Create new categorie v
     */
    public function show($id)
    {
        try {
            /** @var Category $category */
            $category = $this->categoryRepository->getById($id);

            /** @var Collection $providers */
            $classifications = $this->classificationRepository->all();

            return view('categories.show')
                ->with('category', $category)
                ->with('classifications', $classifications);

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
            'name' => 'required|unique:categories|max:255',
            'description' => 'required|max:255',
            'classification_id' => 'required|int'
        ]);

        $params['name'] = ucfirst(mb_strtolower($params['name']));
        $params['description'] = ucfirst(mb_strtolower($params['description']));

        try {
            DB::beginTransaction();

            /** @var CategoryRepository $category */
            $this->categoryRepository->create($params);

            DB::commit();

            return redirect()->route('categories.index')
                ->with('alert_success', 'La clasificación se ha creado correctamente');

        } catch (Exception $e) {
            DB::rollback();
            logger($e->getMessage());
            logger($e->getTraceAsString());
            return redirect()->back()
                ->withErrors('La clasificación no pudo ser creada. Por favor contactar a administración');
        }
    }

    /**
     * @param Request $request
     */
    public function update(Request $request, $id)
    {
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
    public function destroy($id)
    {
        try {
            /** @var Category $category */
            $category = $this->categoryRepository->getById($id);

            if (!$category){
                throw new Exception("No se encontró clasificación con id: {$id}. Contacte administración.");
            }
            DB::beginTransaction();
    
            /** @var Category $category */
            $this->categoryRepository->delete($category);

            DB::commit();

            return redirect()
                ->route('categories.index')
                ->with('alert_success', 'La clasificación ha sido eliminada correctamente.');

        } catch (Exception $e) {
            DB::rollback();
            logger($e->getMessage());
            logger($e->getTraceAsString());
            return redirect()
                ->back()->withErrors('La clasificación no pudo ser eliminada. Por favor contactar a administración');
        }
    }

}
