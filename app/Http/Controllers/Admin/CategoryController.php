<?php

namespace App\Http\Controllers\Admin;

use App\Models\pizza;
use App\Models\Category;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\FuncCall;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{

    // category page
    public function category(){


        $data= Category::select('categories.*',DB::raw('COUNT(pizzas.category_id) as count'))
                        ->leftJoin('pizzas','pizzas.category_id','categories.category_id')
                        ->groupBy('categories.category_id')
                        ->paginate(7);


        return view('admin.category.list')->with(['category'=>$data]);
    }

    // Add Category

    public function addCategory(){

        return view('admin.category.addCategory');
    }

    // create Category for pizza

    public function createCategory(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $data=[
            'category_name'=>$request->name
        ];

        Category::create($data);
        return redirect()->route('admin#category')->with(['categorySuccess'=>'hahahaha Category Added....']);
    }


    // delete Category

    public function deleteCategory($id){
        Category::where('category_id',$id)->delete();

        return back()->with(['deleteSuccess'=>'Category Deleted...']);
    }

    // Edit Category pizza

    public function editCategory($id){

        $data = Category::where('category_id',$id)->first();

        return view('admin.category.updateCategory')->with(['category'=>$data]);
    }

    public function updateCategory(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $data =[
            'category_name'=>$request->name
        ];

        Category::where('category_id',$request->id)->update($data);
        return redirect()->route('admin#category')->with(['updateSuccess'=>'Category Updated...']);
    }

    // Search Category

    public function searchCategory(Request $request){

        $data = Category::where('category_name','like','%'.$request->searchData.'%')->paginate(7);

        $data->appends($request->all());

        return view('admin.category.list')->with(['category'=>$data]);

    }

    // pizza page
    public function pizza(){
        return view('admin.pizza.list');
    }

    // Category Item Page

    public function categoryItem($id){
        $data=pizza::select('pizzas.*','categories.category_name as categoryName')
                    ->join('categories','categories.category_id','pizzas.category_id')
                    ->where('pizzas.category_id',$id)
                    ->paginate(5);

        return view('admin.category.item')->with(['pizza'=>$data]);
    }
}
