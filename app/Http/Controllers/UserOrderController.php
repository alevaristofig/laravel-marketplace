<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserOrderController extends Controller
{
    public function index()
    {
        $userOrder = auth()->user()->orders()->orderBy('id', 'DESC')->paginate(2);
            
        return view('user_orders',compact('userOrder'));
    }
}
