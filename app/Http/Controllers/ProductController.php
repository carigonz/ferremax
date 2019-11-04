<?php

namespace App\Http\Controllers;

use App\Supplier;
use App\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
                    .' %" data-html="true" class="">'.$product->factoryName.'</a></td>'.
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
                        '<td><a tabindex="0" class="btn btn-lg btn-info" role="button" data-toggle="popover" data-trigger="focus" title="Descuento '. $product->discount*100 .' %" data-html="true" class="">'.$product->factoryName.'</a></td>'.
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

        //necesito validar para mostrar errores

        if($request->product){
            $rules = [
                'id_supplier' => ['required','integer', 'gt:0'],
                'code' => ['required','string', 'max:255'],
                'price' => ['required','numeric', 'gt:0'],
            ];
            } else {
                $rules = [
                    'id_supplier' => ['required','integer', 'gt:0'],
                    'csv_file' => ['required','file'],
                    'extension' => 'required|in:csv',
                ];
            }

          $messages = [
            'string' => 'El campo :attribute debe contener sólo letras',
            'max' => 'El campo :attribute debe tener como máximo :max caracteres',
            'required' => 'El campo :attribute es obligatorio.',
            'unique' => 'El campo :attribute debe ser único.',
            'numeric' => 'Ingrese un valor numérico.',
            'integer' => 'Ingrese un número entero.',
            'in' => 'El archivo debe ser sólo extensión .csv.',
            'file' => 'Hubo un error en la subida del archivo.',
            'gt' => 'El campo :attribute no puede estar vacío.'
          ];

        $niceNames = array(
            'id_supplier' => 'proveedor',
            'csv_file' => 'archivo',
            'price' => 'precio',
            'code' => 'código',
        );


        $data =$request->all();
        if ($request->hasFile('csv_file')){
            $data += ['extension' => strtolower($data['csv_file']->getClientOriginalExtension())];
        }

        $validator = Validator::make($data, $rules, $messages);
        $validator->setAttributeNames($niceNames);
        $errors = $validator->errors();

        //dd($data);

        if ($validator->fails())
        {
            //dd($validator);
            if (array_key_exists('list',$data)){
                return redirect('update')->withErrors($validator->messages(),'file')->withInput();
            } else {
            //dd($validator->messages());
                return redirect('update')->withErrors($validator->messages(),'product')->withInput();
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
                    $item2 = Product::where('id','=',$item[0]['id'])->update(['price' => $product['price']]);
                    //dd('item actualizado :D');
                }
            }
            return redirect('success');

        } else {

            $data = Product::where('code', '=' , $request->code)->get();
            //dd($data[0]->id_supplier, $request->all());

            //dd($data);
                        
            if(($data[0]->id_supplier == $request->id_supplier) && (count($data) === 1)){
                Product::where("code", "=", $request->code)->update(['price' => $request->price]);
                dump('todo ok');
            } else {

                //como tiro un warning de que la data esta mal???
                $errors = ['id_supplier' => 'El código del producto no coincide con el proveedor seleccionado en la base de datos.'];
                return redirect('update')->withErrors($errors, 'product')->withInput();
            }
            
        }

        dd('no entra en el if');



    }


}