<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use DB;
use Session;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('products.index',compact('products'));
    }

    public function  create()
    {
       return view('products.create'); 
    } 

    public function store(Request $request)
    {
        
        $name = !empty($request->name)?$request->name:NULL;
        $description = !empty($request->description)?$request->description:NULL;
        $price = !empty($request->price)?$request->price:NULL;
        $file = !empty($request->file('image'))?$request->file('image'):NULL;

       if (!empty($file))   //issue
        {
            
            $extenstion = $file->getClientOriginalExtension();
            $filename = time().'.'.$extenstion;
            $destinationPath = public_path('product');
            $pathfprBD = 'product/'.$filename;
            $file -> move($destinationPath,$filename);

        }

        else
        {
            $pathfprBD = NULL;
        }
        $myArr=[
            'name' =>$name,
            'description' =>$description,
            'price' =>$price,
            'image' =>$pathfprBD,

        ];

        DB::beginTransaction();
        $query=product::create($myArr);
        if($query){
            DB::Commit();
        }
        else{
            DB::rollback();
        }

        return redirect()->back()->with('status','Product Added Successfully');
    }

    public function edit($id)
    {
        $product = Product::find($id);
        return view('products.edit', compact('product'));
    }

    public function update(Request $request,$id)
    {
        $product = Product::find($id);
        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->price = $request->input('price');

        if($request->hasfile('image'));   //issue
        {
            $destiantion = 'uploads/product/'.$product->image;
            if(File::exists($destination))
            {
                File::delete($destination);
            }
            $file = $request->file('image');
            $extenstion = $file->getClientOriginalExtension();
            $filename = time().'.'.$extenstion;
            $file->move('uploads/product/',$filename);
            $product->image = $filename;
        }
        $product->update();

        return redirect()->back()->with('status','Product Updated Successfully');
    }

    public function destroy($id)
    {
        $product= Product::where('id',$id);
        $product->delete();
        return redirect()->back()->with('status','Product Deleted Successfully');    
    }

    public function downloadCSV() {
        // Replace this with the path to your CSV file
        $csvFilePath = 'products.csv';
        $fileName = 'products.csv';

        // Set appropriate headers for download
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $fileName . '"');
        header('Pragma: no-cache');
        header('Expires: 0');

        // Output the file content
        readfile($csvFilePath);
        exit();
        }
    public function importData(Request $request){   
        $csv_file = $request->excelFile;
                if (($getfile = fopen($csv_file, "r")) !== FALSE) {
                    $arr_to_insert = [];
                    $data = fgetcsv($getfile, 1000, ",");
                    $total_updates = 0;
                    $total_inserts = 0;
                     DB::beginTransaction();
                    while (($data = fgetcsv($getfile, 1000, ",")) !== FALSE) {
                        $curr_date = date('Y-m-d H:m:s');
                        $result = $data;
                        $result1  = str_replace(",","",$result);  
                        $str = implode(",", $result1);
                        $slice = explode(",", $str);
                        if(count($slice) >= 7) {
                            $new_arr = [
                                'id' => !empty($slice[0])?$slice[0]:NULL,
                                'name' => !empty($slice[1])?$slice[1]:NULL,
                                'description' => !empty($slice[2])?$slice[2]:NULL,
                                'price' => !empty($slice[3])?$slice[3]:NULL,
                                'image' => !empty($slice[4])?$slice[4]:NULL,
                                'created_at' => !empty($slice[5])?$slice[5]:NULL,
                                'updated_at' => !empty($slice[6])?$slice[6]:NULL,
            
                            ];

                            //update code starts here
                            $key = $slice[0];
                            if(!empty($key)) {
                                $present_data = DB::table('products')->where('id', $key)->first();
                                if(!empty($present_data)) {
                                    $update_data = DB::table('products')
                                                    ->where('id', $key)
                                                    ->update($new_arr);
                                    $total_updates += 1;
                                }
                                else {
                                    $arr_to_insert[] = $new_arr;
                                }
                            }                      
                        }
                    }
                    $tempQuery=0;

                        if(count($arr_to_insert) > 0) {
                    $tempQuery=1;
                        $collected = collect($arr_to_insert);
                        $chunked_array = $collected->chunk(1000);
                        foreach ($chunked_array as $value) {
                            # code... 
                            $query =DB::table('products')->insert($value->toArray());
                            if(!$query)
                            {
                                $tempQuery=0;
                            }
                        }  
                    }
                        if ($total_updates || $tempQuery) {
                             DB::commit();
                             Session::flash('message', 'Uploaded Succesfully');
                             Session::flash('alert-class', 'alert-success');
                        }
                        else {
                             DB::rollback();
                             Session::flash('message', 'Something went wrong!');
                             Session::flash('alert-class', 'alert-danger');
                        }
                }
        // dd($request);

                return redirect('products');
    }
}   

