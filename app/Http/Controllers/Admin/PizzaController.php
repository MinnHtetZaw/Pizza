<?php

namespace App\Http\Controllers\Admin;

use App\Models\pizza;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class PizzaController extends Controller
{
    // Pizza list page

    public function pizza(){

        $data=pizza::paginate(7);



        if( count($data)==0){
            $emptyStatus =0;
        }else {
            $emptyStatus = 1;
        }


        return view('admin.pizza.list')->with(['pizza'=>$data,'status'=>$emptyStatus]);
    }

    // Create Pizza

    public function createPizza(){

           $category=Category::get();

            return view ('admin.pizza.createPizza')->with(['category'=>$category]);
    }

    // insert Pizza

    public function insertPizza(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'image' => 'required',
            'price' => 'required',
            'publish' => 'required',
            'category' => 'required',
            'discount' => 'required',
            'buyOneGetOne' => 'required',
            'waitingTime' => 'required',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $file=$request->file('image');

        $fileName= uniqid().'_'.$file->getClientOriginalName();

        $file->move(public_path().'/uploads/',$fileName);


        $data=$this->getPizzaData($request,$fileName);

        pizza::create($data);
        return redirect()->route('admin#pizza')->with(['createSuccess'=>'Pizza Created...']);

    }

    // Delete Pizza

    public function deletePizza($id){

        $data=pizza::select('image')->where('pizza_id',$id)->first();
        $fileName =$data->image;

        pizza::where('pizza_id',$id)->delete();

        if(File::exists(public_path().'/uploads/'.$fileName))
        {
            File::delete(public_path().'/uploads/'.$fileName);
        }

        return back()->with(['deleteSuccess'=>'Pizza Deleted...']);
    }

    // Pizza Information page

    public function infoPizza($id){

        $data=Pizza::where('pizza_id',$id)->first();

        return view('admin.pizza.info')->with(['info'=>$data]);
    }


    // Edit Pizza Page

        public function editPizza($id){

            $category =Category::get();

            $data=pizza::select('pizzas.*','categories.category_id','categories.category_name')
                        ->join('categories','categories.category_id','pizzas.category_id')
                        ->where('pizza_id',$id)
                        ->first();

            $category =Category::get();
            return view('admin.pizza.edit')->with(['edit'=>$data,'category'=>$category]);
        }

    // Update Pizza Function

        public function updatePizza($id,Request $request){
            $validator = Validator::make($request->all(), [
                'name' => 'required',

                'price' => 'required',
                'publish' => 'required',
                'category' => 'required',
                'discount' => 'required',
                'buyOneGetOne' => 'required',
                'waitingTime' => 'required',
                'description' => 'required',
            ]);

            if ($validator->fails()) {
                return back()
                            ->withErrors($validator)
                            ->withInput();
            }

            $data= $this->requestUpdataPizza($request);

            if(isset($data['image'])){

                // Get Old Image Data
                $image=pizza::select('image')->where('pizza_id',$id)->first();
                $fileName =$image['image'];

                // Delete Old Image Data
                if(File::exists(public_path().'/uploads/'.$fileName))
                {
                    File::delete(public_path().'/uploads/'.$fileName);
                }

                // Get New Image Data

                $file=$request->file('image');
                $fileName= uniqid().'_'.$file->getClientOriginalName();

                $file->move(public_path().'/uploads/',$fileName);

                $data['image']=$fileName;

                // Update DB
                pizza::where('pizza_id',$id)->update($data);
                return redirect()->route('admin#pizza')->with(['updateSuccess'=>'Pizza Updated...']);
            }
            else{
                pizza::where('pizza_id',$id)->update($data);
                return redirect()->route('admin#pizza')->with(['updateSuccess'=>'Pizza Updated...']);
            }

        }


    // Search Pizza Data

    public function searchPizza(Request $request){
        $searchKey = $request->table_search;

        $searchData = pizza::orWhere('pizza_name','like','%'.$searchKey.'%')
                            ->orWhere('price','like','%'.$searchKey.'%')
                            ->paginate(7);
        $searchData->appends($request->all());

        if( count($searchData)==0){
            $emptyStatus =0;
        }else {
            $emptyStatus = 1;
        }

        return view('admin.pizza.list')->with(['pizza'=>$searchData,'status'=>$emptyStatus]);
    }


    // Update Pizza Data

    private function requestUpdataPizza($request){
        $arr=[
            'pizza_name'=>$request->name,

            'price'=>$request->price,
            'publish_status'=>$request->publish,
            'category_id'=>$request->category,
            'discount_price'=>$request->discount,
            'buy_one_get_one_status'=>$request->buyOneGetOne,
            'waiing_time'=>$request->waitingTime,
            'description'=>$request->description,
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ];

        if (isset($request->image)){
            $arr['image']=$request->image;
        }

        return $arr;

    }

    // Pizza Data

    private function getPizzaData($request,$fileName){
        return [
            'pizza_name'=>$request->name,
            'image'=>$fileName,
            'price'=>$request->price,
            'publish_status'=>$request->publish,
            'category_id'=>$request->category,
            'discount_price'=>$request->discount,
            'buy_one_get_one_status'=>$request->buyOneGetOne,
            'waiing_time'=>$request->waitingTime,
            'description'=>$request->description,
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ];
    }

}
