<?php

namespace App\Http\Controllers;

use App\Repositories\ClassificationRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClassificationController extends Controller
{
    /** @var ClassificationRepository $classificationRepository */
    protected $classificationRepository;

    public function __construct(ClassificationRepository $classificationRepository)
    {
        $this->classificationRepository = $classificationRepository;
    }
    /**
     * 
     */
    public function index()
    {
        try {
            /** @var Collection $classifications */
            $classifications = $this->classificationRepository->all();

            return view('classifications/index')
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
     * Create new classifications view
     */
    public function create()
    {
        try {
            return view('classifications.create');

        } catch (Exception $e) {
            logger($e->getMessage());
            logger($e->getTraceAsString());
            return redirect()
                ->back()
                ->withErrors('Ha ocurrido un error imprevisto. Por favor contactar a administración');
        }
    }

    /**
     * Create new classification v
     */
    public function show($id)
    {
        try {
            /** @var Classification $classification */
            $classification = $this->classificationRepository->getById($id);
    
            return view('classifications.show')
                ->with('classification', $classification);

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
            'type' => 'bail|required|unique:classifications|max:255'
        ]);

        $params['type'] = ucfirst(mb_strtolower($params['type']));
        try {
            DB::beginTransaction();

            /** @var Classification $classification */
            $this->classificationRepository->create($params);
            DB::commit();
    
            return redirect()->route('classifications.index')
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
            'type' => 'min:3|max:255',
            //'description' => 'max:255'
        ]);
        $params['type'] = ucfirst(mb_strtolower($params['type']));

        try {

            DB::beginTransaction();
            /** @var Classification $classification */
            $classification = $this->classificationRepository->getById($id);

            /** @var Classification $classification */
            $this->classificationRepository->update($classification, $params);
            DB::commit();

            return redirect()->route('classifications.index')
                ->with('alert_success', "La clasificación ha sido actualizada.");

        } catch (Exception $e) {
            DB::rollback();
            logger($e->getMessage());
            logger($e->getTraceAsString());
            return redirect()->back()->withErrors('La clasificación no pudo ser actualizada. Por favor contactar a administración');
        }
    }

    /**
     * @param Request $request
     */
    public function destroy($id)
    {
        
        try {
            /** @var Classification $classification */
            $classification = $this->classificationRepository->getById($id);

            if (!$classification){
                throw new Exception("No se encontró clasificación con id: {$id}. Contacte administración.");
            }
            DB::beginTransaction();
    
            /** @var Classification $classification */
            $this->classificationRepository->delete($classification);

            DB::commit();

            return redirect()
                ->route('classifications.index')
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
