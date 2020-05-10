<?php

namespace App\Http\Controllers;

use App\Models\Classification;
use App\Models\Supplier;
use App\Models\Product;
use App\Repositories\ClassificationRepository;
use App\Repositories\ProviderRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Repositories\SectionRepository;
use App\Repositories\ProductRepository;
use Exception;

class ProductController extends Controller
{
    /** @var ProviderRepository $providerRepository */
    protected $providerRepository;

    /** @var SectionRepository $sectionRepository */
    protected $sectionRepository;

    /** @var ProductRepository $productRepository */
    protected $productRepository;

    public function __construct(ProductRepository $productRepository, SectionRepository $sectionRepository, ProviderRepository $providerRepository, ClassificationRepository $classificationRepository)
    {
        $this->providerRepository = $providerRepository;
        $this->classificationRepository = $classificationRepository;
        $this->sectionRepository = $sectionRepository;
        $this->productRepository = $productRepository;
    }

    /**
     * 
     */
    public function index()
    {
        try {
            /** @var Collection $sections */
            $sections = $this->sectionRepository->all();

            /** @var Collection $products */
            $products = $this->productRepository->all();

            return view('products.index')
                ->with('sections', $sections)
                ->with('products', $products);

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
        /** @var Collection $sections */
        $sections = $this->sectionRepository->all();

        try {
            return view('products.create')
            ->with('sections', $sections);

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
            /** @var Product $product */
            $product = $this->productRepository->getById($id);

            /** @var Collection $sections */
            $sections = $this->sectionRepository->all();

            return view('categories.show')
                ->with('product', $product)
                ->with('sections', $sections);

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
            'code' => 'required|max:255',
            'section_id' => 'required|max:255',
            'tariff_id',
            'catalog_id' => 'required|max:255',
            'name' => 'required|unique:categories|max:255',
            'description' => 'required|max:255',
            'section_id' => 'required|int'
        ]);

        $params['name'] = ucfirst(mb_strtolower($params['name']));
        $params['description'] = ucfirst(mb_strtolower($params['description']));

        try {
            DB::beginTransaction();

            /** @var CategoryRepository $category */
            $this->productRepository->create($params);

            DB::commit();

            return redirect()->route('products.index')
                ->with('alert_success', 'La clasificación se ha creado correctamente');

        } catch (Exception $e) {
            DB::rollback();
            logger($e->getMessage());
            logger($e->getTraceAsString());
            return redirect()->back()
                ->withErrors('El producto no pudo ser creado. Por favor contactar a administración');
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
            'section_id' => 'integer|required'
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














    //////////////////////////////////////////////////////////////////////////////////

    function newProduct(){
       //$suppliers = Supplier::getNames();
        return view('newProduct');//->with('suppliers',$suppliers);
    } 
    function viewUpdate(){
        //$suppliers = Supplier::getNames();
        return view('update');
    } 
    function configuration(){

        return view('configuration.index');
    } 
    public function search(){
        //$suppliers = Supplier::getNames();

        /** @var Collection $proudcts */
        $products =  DB::table('products')
            //->leftJoin('suppliers', 'id_supplier', '=', 'suppliers.id')
            ->orderBy('name')
            ->orderBy('description')
            ->get();

        return view('searcher');

    } 
    // public function create(Request $data)
    // {
    //     $product = Product::create([
    //         'name' => $data['name'],
    //         'code'  => $data['code'],
    //         'price' => $data['price'],
    //         'id_supplier' => $data['id_supplier'],
    //         'description' => $data['description'],
    //         'created_at' => date("Y-m-d H:i:s")
    //         //'stock' => $data['stock']
    //     ]);

    //     //dd($product);

    //     //$products = Product::orderBy('id', 'DESC')->paginate(20);
    //     return redirect('success');
    // }


    function action(Request $request)
    {   //dd($request);
        //console.log($request);
        $data = "";
        $output = 0;
        $suppliers = Supplier::all();
        $total_row = 0;
        $ya = 'test';
        if($request->ajax()){
            $query = $request->get('query');
            //dd($query);
            if($query != ''){

                $data = Product::where("name", "LIKE", "%" . $query . "%")
                ->orwhere("description", "LIKE", "%" . $query . "%")
                ->orwhere("code", "LIKE", "%" . $query . "%")
                ->leftJoin('suppliers', 'id_supplier', '=', 'suppliers.id')
                ->orderBy('name')
                ->orderBy('description')
                ->get();

            }else {
                $data =  DB::table('products')
                ->leftJoin('suppliers', 'id_supplier', '=', 'suppliers.id')
                ->orderBy('name')
                ->orderBy('description')
                ->get();
            }


            $total_row = $data->count();
            if($total_row>0){
                $i = 1;
                foreach ($data as $key => $product) {
                    if ($product->discount === 0){
                    $output.='<tr>'.
                    '<th scope="row">'.$i.'</th>'.
                    '<td>'.strtoupper($product->name).'</td>'.
                    '<td>'.ucfirst(strtolower($product->description)).'</td>'.
                    '<td><a tabindex="0" href="#" class="btn btn-lg btn-info" role="button" data-toggle="popover" data-trigger="focus"  title="descuento '.$product->discount*100
                    .' %" data-html="true" onClick="searchFilter(' . $product->factoryName . ')" class="">'.$product->factoryName.'</a></td>'.
                    '<td class="d-none">'.$product->discount*100 .' %</td>'.
                    '<td data-toggle="popover" data-trigger="focus" title=" '. $product->updated_at .'ss " data-html="true">'.$product->price.'</td>'.
                    '<td class="bg-success text-center">'.round($product->price*1.6,2).'</td>'.
                    '</tr>';
                    $i++;
                    } else {
                        $output.='<tr>'.
                        '<th scope="row">'.$i.'</th>'.
                        '<td>'.strtoupper($product->name).'</td>'.
                        '<td>'.ucfirst(strtolower($product->description)).'</td>'.
                        '<td><a tabindex="0" class="btn btn-lg btn-info" role="button" data-toggle="popover" data-trigger="focus" title="Descuento '. $product->discount*100 .' %" onClick="searchFilter(' . $product->factoryName . ')" data-html="true" class="">'.$product->factoryName.'</a></td>'.
                        '<td class="d-none">'.$product->discount*100 .' %</td>'.
                        '<td data-toggle="popover" data-trigger="focus" title=" ss'. $product->updated_at .' " data-html="true">'.$product->price .'</td>'.
                        '<td class="bg-success text-center">'.
                        round(($product->price-($product->price*$product->discount))*1.6,2)
                        .'</td>'.
                        '</tr>';
                        $i++;
                    }
                }
            } else{
                    $output .= '
                    <tr>
                        <td>No data found</td>
                    <tr>
                    ';
                }
            $encoded_output = mb_convert_encoding($output, 'UTF-8', 'UTF-8');
            $chan = array(
                'table_data' => $encoded_output,
                'total_data' => $total_row,
                'suppliers_data' => $suppliers
            );
            
            $finish = json_encode($chan);
            return $finish;
        }
        else {
            $query = $request->get('query');
            //($query);
        }
     }

}