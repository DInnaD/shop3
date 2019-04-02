<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrdersAllsController extends Controller
{
   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(OrdersAll $ordersAll)
    {
		$ordersAlls = OrdersAll::orderBy('id', 'asc')->get();
		return view('purchases.ordersAll', compact('ordersAlls'));
        //return view('purchases.ordersAll', ['ordersAlls' => OrdersAll::get()]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
		return view('ordersAll.show', compact('ordersAll'));
    }


}
