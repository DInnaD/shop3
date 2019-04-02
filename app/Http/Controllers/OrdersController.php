<?php

namespace App\Http\Controllers;

use Auth;
use App\Magazin;
use App\Book;
use App\Order;
use App\OrdersAll;
use App\Purchase;
use Illuminate\Http\Request;

class OrdersController extends Controller
{


   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     //story 
    public function index(Order $order, Purchase $purchase)
    {
         return view('homes.payBuy', [
          'orders' => Order::orderBy('created_at', 'desc')->paginate(10)
        ]);

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */ 
    //index
    public function indexOrders()
    {
         return view('homes.indexOrders', [
          'orders' => Order::orderBy('created_at', 'desc')->paginate(10)
        ]);

    }

    public function store(Request $request)
    {


    }

    /**pluck(
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order->ordersAlls()->deattach($ordersAll->id);
        Order::find($id)->remove();
        return redirect()->back();
    }

}
