<?php

namespace App\Http\Controllers;

use App\Supplier;
use App\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    function newProduct(){
        $suppliers = Supplier::getNames();
        //$vac = compact('suppliers'->$suppliers);
        //$suppliers = Supplier::All()->get();
        //dd($suppliers);
        return view('newProduct')->with('suppliers',$suppliers);
    } 

    public function create(Request $data)
    {
        $product = Product::create([
            'name' => $data['name'],
            'code'  => $data['code'],
            'price' => $data['price'],
            'id_supplier' => $data['id_supplier'],
            'description' => $data['description']
            //'stock' => $data['stock']
        ]);

        //dd($product);

        //$products = Product::orderBy('id', 'DESC')->paginate(20);
        return redirect('success');
    }


    function action(Request $request)
    {   //dd($request);
        //console.log($request);
        $data;
        $output = 0;
        $suppliers = Supplier::all();
        $total_row = 0;
        if($request->ajax()){
            $query = $request->get('query');
            //dd($query);
            if($query != ''){

                $data = Product::where("name", "LIKE", "%" . $query . "%")
                ->orwhere("description", "LIKE", "%" . $query . "%")
                ->leftJoin('suppliers', 'id_supplier', '=', 'suppliers.id')
                ->orderBy('name')
                ->get();

            }else {
                /* $data = Product::all();
                $data->leftJoin('suppliers', 'id_supplier', '=', 'suppliers.id')
                ->get(); */
                $data =  DB::table('products')
                ->leftJoin('suppliers', 'id_supplier', '=', 'suppliers.id')
                //->crossJoin('suppliers')
                //->select('products.*','id_supplier as suppliers.factoryName','suppliers.discount')
                ->orderBy('name')
                ->get();

            }

            $total_row = $data->count();
            if($total_row>0){
                $i = 1;
                foreach ($data as $key => $product) {
                    $output.='<tr>'.
                    '<th scope="row">'.$i.'</th>'.
                    '<td>'.$product->name.'</td>'.
                    '<td>'.$product->factoryName.'</td>'.
                    '<td>'.$product->discount.'</td>'.
                    '<td>'.$product->price.'</td>'.
                    '<td>'.$product->price*1.6.'</td>'.
                    '</tr>';
                    $i++;
                }
            } else{
                    $output .= '
                    <tr>
                        <td>No data found</td>
                    <tr>
                    ';
                }
            $chan = array(
                'table_data' => $output,
                'total_data' => $total_row,
                'suppliers_data' => $suppliers
            );
            //console.log($data);
            $finish = json_encode($chan);
            return $finish;
        }
        else {
            $query = $Request->get('query');
            //($query);
        }
    }

}