<?php


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    if (Auth::check()){
        if(Auth::user()->role == 'admin'){
            return redirect()->route('admin#profile');
        }else if(Auth::user()->role == 'user'){
            return redirect()->route('user#index');
        }
    }


})->name('dashboard');


// admin page
Route::group(['prefix'=>'admin','namespace'=>'Admin'],function(){

    Route::get('profile','AdminController@profile')->name('admin#profile');
    Route::post('updateprofile/{id}','AdminController@updateProfile')->name('admin#updateProfile');
    Route::get('changePassword','AdminController@change')->name('admin#change');
    Route::post('changePassword/{id}','AdminController@changePassword')->name('admin#changePassword');

    Route::get('category','CategoryController@category')->name('admin#category');
    Route::get('addCategory','CategoryController@addCategory')->name('admin#addCategory');
    Route::post('addCategory','CategoryController@createCategory')->name('admin#createCategory');
    Route::get('deleteCategory/{id}','CategoryController@deleteCategory')->name('admin#deleteCategory');
    Route::get('editCategory/{id}','CategoryController@editCategory')->name('admin#editCategory');
    Route::post('updateCategory','CategoryController@updateCategory')->name('admin#updateCategory');
    Route::get('category/search','CategoryController@searchCategory')->name('admin#searchCategory');
    Route::get('categoryItem/{id}','CategoryController@categoryItem')->name('admin#categoryItem');

    Route::get('pizza','PizzaController@pizza')->name('admin#pizza');
    Route::get('createPizza','PizzaController@createPizza')->name('admin#createPizza');
    Route::post('insertPizza','PizzaController@insertPizza')->name('admin#insertPizaa');
    Route::get('deletePizza/{id}','PizzaController@deletePizza')->name('admin#deletePizza');
    Route::get('pizzainfo/{id}','PizzaController@infoPizza')->name('admin#pizzainfo');
    Route::get('editPizza/{id}','PizzaController@editPizza')->name('admin#editPizza');
    Route::post('updatePizza/{id}','PizzaController@updatePizza')->name('admin#updatePizza');
    Route::get('pizza/search','PizzaController@searchPizza')->name('admin#searchPizza');

    Route::get('userData','UserController@user')->name('admin#userData');
    Route::get('adminData','UserController@admin')->name('admin#adminData');
    Route::get('userData/search','UserController@userSearch')->name('admin#userSearch');
    Route::get('adminData/search','UserController@adminSearch')->name('admin#adminSearch');
    Route::get('userDelete/{id}','UserController@userDelete')->name('admin#userDelete');

    Route::get('contact','ContactController@contactList')->name('admin#contactList');
    Route::get('contact/search','ContactController@contactSearch')->name('admin#contactSearch');
});


// user page
Route::group(['prefix'=>'user'],function(){
    Route::get('/','UserController@index')->name('user#index');
    Route::get('contact','UserController@contact')->name('user#contact');
});
