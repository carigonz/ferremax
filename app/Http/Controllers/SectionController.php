<?php

namespace App\Http\Controllers;

use App\Repositories\CategoryRepository;
use App\Repositories\SectionRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SectionController extends Controller
{
    /** @var SectionRepository $sectionRepository */
    protected $sectionRepository;

    /** @var CategoryRepository $categoryRepository */
    protected $categoryRepository;

    public function __construct(SectionRepository $sectionRepository, CategoryRepository $categoryRepository)
    {
        $this->sectionRepository = $sectionRepository;
        $this->categoryRepository = $categoryRepository;
    }
    /**
     * 
     */
    public function index()
    {
        try {
            /** @var Collection $sections */
            $sections = $this->sectionRepository->all();

            /** @var Collection $classifications */
            $categories = $this->categoryRepository->all();

            return view('sections.index')
                ->with('sections', $sections)
                ->with('categories', $categories);

        } catch (Exception $e) {
            logger($e->getMessage());
            logger($e->getTraceAsString());
            return redirect()
                ->back()
                ->withErrors('Ha ocurrido un error imprevisto. Por favor contactar a administración');
        }
    } 
    /**
     * Create new sections view
     */
    public function create()
    {

        /** @var Collection $classifications */
        $categories = $this->categoryRepository->all();

        try {
            return view('sections.create')
            ->with('categories', $categories);

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
            /** @var Section $section */
            $section = $this->sectionRepository->getById($id);

            /** @var Collection $classifications */
            $categories = $this->categoryRepository->all();

            return view('sections.show')
                ->with('section', $section)
                ->with('categories', $categories);

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
            'name' => 'required|unique:sections|max:255',
            'description' => 'max:255',
            'category_id' => 'required|int'
        ]);

        $params['name'] = ucfirst(mb_strtolower($params['name']));
        $params['description'] = ucfirst(mb_strtolower($params['description']));

        try {
            DB::beginTransaction();

            /** @var SectionRepository $section */
            $asd =$this->sectionRepository->create($params);

            DB::commit();

            return redirect()->route('sections.index')
                ->with('alert_success', 'La sección se ha creado correctamente');

        } catch (Exception $e) {
            DB::rollback();
            logger($e->getMessage());
            logger($e->getTraceAsString());
            return redirect()->back()
                ->withErrors('La sección no pudo ser creada. Por favor contactar a administración');
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
            'category_id' => 'integer'
        ]);
        $params['name'] = ucfirst(mb_strtolower($params['name']));
        $params['description'] = ucfirst(mb_strtolower($params['description']));

        try {

            DB::beginTransaction();
            /** @var Section $section */
            $section = $this->sectionRepository->getById($id);

            /** @var Section $section */
            $this->sectionRepository->update($section, $params);
            DB::commit();

            return redirect()->route('sections.index')
                ->with('alert_success', "La sección ha sido actualizada.");

        } catch (Exception $e) {
            DB::rollback();
            logger($e->getMessage());
            logger($e->getTraceAsString());
            return redirect()->back()->withErrors('La sección no pudo ser actualizada. Por favor contactar a administración');
        }
    }

    /**
     * @param int $id
     */
    public function destroy($id)
    {
        try {
            /** @var Section $section */
            $section = $this->sectionRepository->getById($id);

            if (!$section){
                throw new Exception("No se encontró sección con id: {$id}. Contacte administración.");
            }
            DB::beginTransaction();
    
            /** @var Section $section */
            $this->sectionRepository->delete($section);

            DB::commit();

            return redirect()
                ->route('sections.index')
                ->with('alert_success', 'La sección ha sido eliminada correctamente.');

        } catch (Exception $e) {
            DB::rollback();
            logger($e->getMessage());
            logger($e->getTraceAsString());
            return redirect()
                ->back()->withErrors('La sección no pudo ser eliminada. Por favor contactar a administración');
        }
    }

}
