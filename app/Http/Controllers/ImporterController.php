
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