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
        return view('newProduct')->with('suppliers',$suppliers);
    } 
    function viewUpdate(){
        $suppliers = Supplier::getNames();
        return view('update')->with('suppliers',$suppliers);
    } 
    function search(){
        $suppliers = Supplier::getNames();
        return view('searcher')->with('suppliers',$suppliers);
    } 
    public function create(Request $data)
    {
        $product = Product::create([
            'name' => $data['name'],
            'code'  => $data['code'],
            'price' => $data['price'],
            'id_supplier' => $data['id_supplier'],
            'description' => $data['description'],
            'created_at' => date("Y-m-d H:i:s")
            //'stock' => $data['stock']
        ]);

        //dd($product);

        //$products = Product::orderBy('id', 'DESC')->paginate(20);
        return redirect('success');
    }


    function action(Request $request)
    {   //dd($request);
        //console.log($request);
        $data = "";
        $output = 0;
        $suppliers = Supplier::all();
        $total_row = 0;
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
                    if ($product->price){
                    $output.='<tr>'.
                    '<th scope="row">'.$i.'</th>'.
                    '<td>'.strtoupper($product->name).'</td>'.
                    '<td>'.ucfirst(strtolower($product->description)).'</td>'.
                    '<td><a tabindex="0" href="#" class="btn btn-lg btn-info" role="button" data-toggle="popover" data-trigger="focus" data-content="If you sort the ID col or use search or toggle or resize ... i will not exist any more !!!" title="descuento '.$product->discount*100
                    .' %" data-html="true" class="">'.$product->factoryName.'</a></td>'.
                    '<td class="d-none">'.$product->discount*100 .' %</td>'.
                    '<td>'.$product->price.'</td>'.
                    '<td class="bg-success text-center">'.round($product->price*1.6,2).'</td>'.
                    '</tr>';
                    $i++;
                    } else {
                        $output.='<tr>'.
                        '<th scope="row">'.$i.'</th>'.
                        '<td>'.strtoupper($product->name).'</td>'.
                        '<td>'.ucfirst(strtolower($product->description)).'</td>'.
                        '<td><a tabindex="0" class="btn btn-lg btn-info" role="button" data-toggle="popover" data-trigger="focus" data-content="If you sort the ID col or use search or toggle or resize ... i will not exist any more !!!" title="Descuento" data-html="true" class="">'.$product->factoryName.'</a></td>'.
                        '<td class="d-none">'.$product->discount*100 .' %</td>'.
                        '<td>'.$product->price.'</td>'.
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

    public function csvToArray($filename = '', $delimiter = ';')
    {
        if (!file_exists($filename) || !is_readable($filename)){
            return false;
        }
        //dd($filename,file_exists($filename), is_readable($filename));
        $header = null;
        $data = array();
        if (($handle = fopen($filename, 'r')) !== false)
        {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== false)
            {
                if (!$header)
                    $header = $row;
                else
                    $data[] = array_combine($header, $row);
            }
            fclose($handle);
        }

        return $data;
    }
    public function update(Request $request){

        if ($request->product){

            $data = Product::where('code', '=' , $request->code)->get();
            //dd($data[0]->id_supplier, $request->all());
                        
            if(($data[0]->id_supplier == $request->id_supplier) && (count($data) === 1)){
                Product::where("code", "=", $request->code)->update(['price' => $request->price]);
                dump('todo ok');
            } else {
                dump('te mandaste un moco');
                //como tiro un warning de que la data esta mal???
            }
            
        } 
        if($request->hasFile('csv_file')) {

            $path = $request->file('csv_file')->store('storage/files');
            $basename = $request->file('csv_file')->getRealPath();
            $data = $this->csvToArray($basename);

            foreach ($data as $row=> $product) {
                $item = Product::where('code', '=', $product['code'])->get();
                $item = $item->toArray();
                //dd($item);
                
                if($item){
                    //actualizar
                    $item2 = Product::find($item[0]['id'])->update(['price' => $product['price']]);
                    dd(Product::find($item[0]['id']));
                }
            }
            dd('actualizado completo');

        }

        dd('no entra en el if');



    }


}