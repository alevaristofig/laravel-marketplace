<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\UserOrder;
use DB;

class OrdersController extends Controller
{
    private $order;
    
    public  function __construct(UserOrder $order) 
    {
        $this->order = $order;
    }
    
    public function index()
    {
         // DB::enableQueryLog();

        $orders = auth()->user()->store->orders()->paginate(15);
                //print_r(DB::getQueryLog());exit;
        
        //dd($orders);
        return view('admin.orders.index',compact('orders'));
    }
}
