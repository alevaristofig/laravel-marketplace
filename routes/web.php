<?php

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

Route::get('/','HomeController@index')->name('home');
Route::get('/product/{slug}','HomeController@single')->name('product.single');
Route::get('/category/{slug}','CategoryController@index')->name('cateory.single');
Route::get('/store/{slug}','StoreController@index')->name('store.single');

Route::prefix('cart')->name('cart.')->group(function(){
    Route::get('/','CartController@index')->name('index');
    Route::post('add','CartController@add')->name('add');
    Route::get('remove/{slug}','CartController@remove')->name('remove');  
    Route::get('cancel','CartController@cancel')->name('cancel');
});

Route::prefix('checkout')->name('checkout.')->group(function(){    
    Route::get('/','CheckoutController@index')->name('index');
    Route::post('/proccess','CheckoutController@proccess')->name('proccess');
    Route::get('/thanks','CheckoutController@thanks')->name('thanks');
});

Route::get('/model',function(){
    
    //$user = new \App\User();
   // $user = \App\User::find(3);
   // $user->name = 'Usuario Teste Editado...';
    //$user->email = 'email@teste.com';
    //$user->password = bcrypt('12345678');
    
   // $user->save();
    
    //return \App\User::paginate(10);
    
    //$products = \App\Product::all();
    
    //return $products;
    
    //mass assignment
   /* $user = \App\User::create([
        'name' => 'Zé',
        'email' => 'emailze@email.com',
        'password' => bcrypt('12345678')
    ]);*/
    
    //mass update
   /* $user = \App\User::find(42);
    $user->update([
        'name' => 'Zé das Couves'        
    ]);
    
    return \App\User::all();*/
    
   // $user = \App\User::find(41);
    
   // dd($user->store()->count());
    
   // $store = \App\Store::find(1);
    
    //return $store->products()->where('id',1)->get();
    
    /*$user = \App\User::find(4);
    
    $store = $user->store()->create([
        'name' => 'Loja Teste',
        'description' => 'Loja Teste Produtos de Informática',
        'phone' => 'XX XXXX-XXX',
        'mobile_phone' => 'XX XXXXX-XXXX',
        'slug' => 'loja-teste'
    ]);*/
    
    /*$store = \App\Store::find(41);
    
    $product = $store->products()->create([
        'name' => 'Notebook Dell',
        'description' => 'Core I5 10GB',
        'body' => 'Qualquer coisa...',
        'price' => 2999.90,
        'slug' => 'notebook-dell'
    ]);
    
    \App\Category::create([
       'name' => 'Games',
        'description' => null,
        'slug' => 'games'
    ]);
    
    \App\Category::create([
       'name' => 'Notebooks',
        'description' => null,
        'slug' => 'notebooks'
    ]);
    
    return \App\Category::all();*/
    
    //$product = \App\Product::find(41);
    
    //dd($product->categories()->sync([2]));
    
    $product = \App\Product::find(41);
    
    return $product->categories;
    
});

Route::group(['middleware' => 'auth'],function(){
    
     Route::get('my-orders','UserOrderController@index')->name('user.orders');
     Route::prefix('admin')->name('admin.')->namespace('Admin')->group(function(){
        Route::resource('stores','StoreController');    
        Route::resource('products','ProductController');
        Route::resource('categories', 'CategoryController');        
        
        Route::post('photos/remove','ProductPhotoController@removePhoto')->name('photo.remove');
        
        Route::get('orders/my','OrdersController@index')->name('orders.my');
     });
});

/*Route::prefix('admin')->name('admin.')->namespace('Admin')->group(function(){
    Route::prefix('stores')->name('stores.')->group(function(){
        Route::get('/','StoreController@index')->name('index');
        Route::get('/create','StoreController@create')->name('create');
        Route::post('/store','StoreController@store')->name('store');
        Route::get('/{store}/edit','StoreController@edit')->name('edit');
        Route::post('/update/{store}','StoreController@update')->name('update');
        Route::get('/destroy/{store}','StoreController@destroy')->name('destroy');
    }); 
    
    Route::resource('stores','StoreController');
    
    Route::resource('products','ProductController');
});*/

Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');
