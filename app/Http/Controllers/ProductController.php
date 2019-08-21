<?php

namespace App\Http\Controllers;

use App\Supplier;
use App\Product;
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

    protected function validator(array $data)
    {
      $rules = [
          'name' => 'required|string|max:60',
          'code' => 'required|string|max:45|unique',
          'price' => 'required|string|max:45',
          'email' => 'required|string|email|max:255|unique:users',
          'password' => 'required|string|min:6|confirmed',
      ];

      $messages = [
        'required' => ':attribute es obligatorio.',
        'string' => ':attribute debe ser una cadena de texto.',
        'max' => 'El campo :attribute no debe superar :max',
        'min' => 'El campo :attribute deber tener al menos :min caracteres.',
        'confirmed' => ':attribute no coinciden',
        //'unique'=>
      ];

        return Validator::make($data, $rules, $messages);
    }

    public function action(Request $request)
    {
        if($request->ajax())
        {
            $query = $Request->get('query');
            //dd($query);
            if($query != ''){

                $data = Product::where("name", "LIKE", "%" . $query . "%")
                ->orwhere("description", "LIKE", "%" . $query . "%")
                ->orderBy('id_supplier');

            }else {
                $data = Product::all();
            }

            $suppliers = Supplier::all();
            $total_row = $data->count();
            if($total_row>0){
                $i = 1;
                foreach ($data as $row) {
                    $output .=`
                    <tr>
                        <th scope="row">$i</th>
                        <td>$row->name</td>
                        <td>$row->desc</td>
                        <td>$row->id_supplier (?</td>
                        <td>$row->price*1.6</td>
                    </tr>
                    `;
                    $i++;
                }
            } else{
                    $output = `
                    <tr>
                        <td>No data found</td>
                    <tr>
                    `;
                }
            $data = array(
                'table_data' => $output,
                'total_data' => $total_data,
                'suppliers_data' => $suppliers
            );
            console.log($data);
            return json_encode($data);
            }
        }
    }

    function update(Request $request)
    {
        /**
         * Validate request/input 
         **/
        //dd($request);
        //logic for user upload of avatar
        if($request->hasFile('avatar')){
            //dd($request->foto_perfil);
            $avatar = $request->foto_perfil->store('/public/products');
            $fileName = basename($avatar);
            //dd($avatar,$fileName);
            $user = Auth::user();
            $user->avatar = $fileName;
            $user->save();
            //dd($user);
        }else {
            $request->foto_perfil='custom.png';
          }

        //dd($user);
        
        //if ($request->)
        $usuario = User::find(Auth::User()->id);

        //dd($update);
        $update= [];

        //dd($usuario);
        $rules = [
            'name' => 'string|max:45',
            'code' => 'string|max:45',
            'price' => 'nullable|string|max:45',
            'email' => 'nullable|string|email|max:255|unique:users,email,'.$usuario->id.'id',
            'email2' => 'nullable|string|email|max:255|unique:users,email,'.$usuario->id.'id',
            'pass' => 'required|string|min:6',
            'pass2' => 'sometimes|nullable|string|min:6|confirmed',
            'pass3' => 'sometimes|nullable|string|min:6|confirmed',
        ];
  
        $messages = [
          'required' => 'El campo es obligatorio.',
          'string' => ':attribute debe ser una cadena de texto.',
          'max' => 'El campo :attribute no debe superar :max',
          'min' => 'El campo :attribute deber tener al menos :min caracteres.',
          'confirmed' => ':attribute no coinciden',
  
        ];
        //dd($request);
        //$validacion = Validator::make($update, $rules, $messages);
        //dd($validacion);
        $this->validate($request, $rules, $messages);
        //dd($errors->all());

        if($request->name !== null){
            $usuario->name = $request->name;
        } 
        if($request->lastName !== null){
            $usuario->lastName = $request->lastName;
        } 
        if($request->gender !== null){
            $usuario->gender = $request->gender;
        } 
        if($request->email !== null && $request->email !== $usuario->email && $request->email===$request->email2){
            $usuario->email = $request->email;
        }
        if(($request->pass2 === $request->pass3) && $request->pass2!== null){
            $usuario->email = bcrypt($request->email);
        } 

        //dd($usuario);     
        $usuario->save();

        //dd($usuario);
        Flash::success('Perfil actualizado con éxito.');
        return redirect(route('home'));
        //dd ($usuario);
    }
