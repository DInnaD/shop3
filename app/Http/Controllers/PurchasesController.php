<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Magazin;
use App\Book;
use App\Order;
use App\Purchase;

class PurchasesController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Purchase::class, 'purchase');
    }

    // public function purchase($slug)
    // {
    //     $purchase = Purchase::where('slug', $slug)->firstOrFail();

    //     $orders = $purchase->orders()->paginate(10);

    //     return view('pages.list', ['orders'  =>  $orders]);
    // }

    //     /**
    //  * Display a listing of the resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function indexAll()
    // {
    //     $purchases = Purchase::all();
    //     return view('purchases.indexAll', ['purchases'=>$purchases]);
    // }

    public function toggleBeforeToggle($id)
    {

        $purchase = Purchase::find($id);//where it got// order in toggle
        $purchase->toggleStatusBuy();

            
        return redirect()->back();
    }

    public function getSumma()
    {
        // $summa += $purchase->book->price * qty + $purchase->magazin->price * qty_m;///count() from purch to order    
        $summa = 0;

        foreach ($purchases as $purchase) {//place for future comments

            if($purchase->status_bought == 1)
            {

                if($purchase->first()->book->author->status_discont_id == 1 && $purchase->first()->book->discont_privat != 0 && $purchase->magazin->author->status_discont_id == 1 && $purchase->magazin->discont_privat != 0)

                {//

                    if (round($purchase->first()->book->discont_global,2) >= round($purchase->first()->book->author->discont_id,2) && round($purchase->magazin->discont_global,2) >= round($purchase->magazin->author->discont_id,2)) 

                    {//

                        $summa += ($purchase->first()->book->price - ($purchase->first()->book->price * $purchase->first()->book->discont_global / 100)) * $purchase->qty + ($purchase->magazin->price - ($purchase->magazin->price * $purchase->magazin->discont_global / 100)) * $purchase->qty_m;

                        } elseif(round($purchase->first()->book->discont_global,2) <= round($purchase->first()->book->author->discont_id,2) && round($purchase->magazin->discont_global,2) <= round($purchase->magazin->author->discont_id,2))

                        {//

                            $summa += ($purchase->first()->book->price - ($purchase->first()->book->price * $purchase->first()->book->author->discont_id / 100)) * $purchase->qty + $purchase->magazin->price - ($purchase->magazin->price * $purchase->magazin->author->discont_id / 100)) * $purchase->qty_m;

                            } elseif (round($purchase->first()->book->discont_global,2) >= round($purchase->first()->book->author->discont_id,2) && round($purchase->magazin->discont_global,2) <= round($purchase->magazin->author->discont_id,2))

                            {//

                                $summa += ($purchase->first()->book->price - ($purchase->first()->book->price * $purchase->first()->book->discont_global / 100)) * $purchase->qty + $purchase->magazin->price - ($purchase->magazin->price * $purchase->magazin->author->discont_id / 100)) * $purchase->qty_m;

                                } elseif (round($purchase->first()->book->discont_global,2) <= round($purchase->first()->book->author->discont_id,2) && round($purchase->magazin->discont_global,2) >= round($purchase->magazin->author->discont_id,2))

                                {//

                                    $summa += ($purchase->first()->book->price - ($purchase->first()->book->price * $purchase->first()->book->author->discont_id / 100)) * $purchase->qty + ($purchase->magazin->price - ($purchase->magazin->price * $purchase->magazin->discont_global / 100)) * $purchase->qty_m;

                                    } elseif (round($purchase->first()->book->discont_global,2) >= round($purchase->first()->book->author->discont_id,2))

                                    {//

                                        $summa += ($purchase->first()->book->price - ($purchase->first()->book->price * $purchase->first()->book->discont_global / 100)) * $purchase->qty  + $purchase->magazin->price * $purchase->qty_m;//

                                        } elseif (round($purchase->first()->book->discont_global,2) <= round($purchase->first()->book->author->discont_id,2))

                                        {//

                                            $summa += ($purchase->first()->book->price - ($purchase->first()->book->price * $purchase->first()->book->author->discont_id / 100)) * $purchase->qty + $purchase->magazin->price * $purchase->qty_m;

                                            } elseif (round($purchase->magazin->discont_global,2) >= round($purchase->magazin->author->discont_id,2))

                                            {//

                                                $summa += ($purchase->magazin->price - ($purchase->magazin->price * $purchase->magazin->discont_global / 100)) * $purchase->qty_m + $purchase->first()->book->price  * $purchase->qty;

                                                } elseif (round($purchase->magazin->discont_global,2) <= round($purchase->magazin->author->discont_id,2))

                                                {//

                                                    $summa += ($purchase->magazin->price - ($purchase->magazin->price * $purchase->magazin->author->discont_id / 100)) * $purchase->qty_m + $purchase->first()->book->price  * $purchase->qty;

                                                }

                //                               
                } elseif($purchase->first()->book->discont_privat != 0 && $purchase->magazin->discont_privat != 0)

                    {//
                        if($purchase->first()->book->discont_privat != 0) 

                        {//

                            $summa += ($purchase->first()->book->price - ($purchase->first()->book->price * $purchase->first()->book->discont_global / 100)) * $purchase->qty + $purchase->magazin->price * $purchase->qty_m;


                        }

                            elseif($purchase->magazin->discont_privat != 0) 

                            {//

                                $summa += ($purchase->magazin->price - ($purchase->magazin->price * $purchase->magazin->discont_global / 100)) * $purchase->qty_m + $purchase->first()->book->price  * $purchase->qty;

                            }

                        $summa += ($purchase->first()->book->price - ($purchase->first()->book->price * $purchase->first()->book->discont_global / 100)) * $purchase->qty + ($purchase->magazin->price - ($purchase->magazin->price * $purchase->magazin->discont_global / 100)) * $purchase->qty_m;

                    //
                    } elseif($purchase->first()->book->author->status_discont_id == 1 && $purchase->magazin->author->status_discont_id == 1)

                        {//

                            if($purchase->first()->book->author->status_discont_id == 1) 

                            {//
                                $summa += ($purchase->first()->book->price - ($purchase->first()->book->price * $purchase->first()->book->author->discont_id / 100)) * $purchase->qty + $purchase->magazin->price * $purchase->qty_m;

                            }
                                elseif($purchase->magazin->author->status_discont_id == 1) 

                                {//

                                    $summa += ($purchase->magazin->price - ($purchase->magazin->price * $purchase->magazin->author->discont_id / 100)) * $purchase->qty_m + $purchase->first()->book->price  * $purchase->qty;

                                }

                            $summa += ($purchase->first()->book->price - ($purchase->first()->book->price * $purchase->first()->book->author->discont_id / 100)) * $purchase->qty + ($purchase->magazin->price - ($purchase->magazin->price * $purchase->magazin->author->discont_id / 100)) * $purchase->qty_m;

                        //    
                        } else 

                                {//

                                $summa += $purchase->first()->book->price  * $purchase->qty + $purchase->magazin->price * $purchase->qty_m;

                                }
            }     

        }
        return $summa;

    }
    //{{$purchase->getSum()}} ::where(status_bought == 1)
    public function getSum($summa)
    {
        if($summa != null)
        {
            $this->sum = getSumma($summa);
            $this->save();
        }
    }

    public function getQuantitySum($sumQty, $sumQty_m)
    {
        $sumQty = 0;          
        foreach($purchases as $purchase)
        {

            if($purchase->status_bought == 1)
            {
                        {{$sumQty = ($sumQty += $purchase->qty) + ($sumQty_m += $purchase->qty_m);
            }

        }
    }


    public function getQuantity()
    {
        $sumQty = 0;
                          
        foreach($purchases as $purchase)
        {

            if($purchase->status_bought == 1)
                        {{$sumQty += $purchase->qty;

        }

    public function getQuantity_m()
    {
        $sumQty_m = 0;
                          
        foreach($purchases as $purchase)
        {

            if($purchase->status_bought == 1)
                        {{$sumQty_m += $purchase->qty_m;

        }
//$purchase->ordersAll()->getQtySum; 
    //     public function //to view

    //Pay button on the cart
        //showAlls button on the cart
    public function buyAlls(Request $request)//, $summa

    {

        $user_id = \Auth::author()->id;

        $purchases = Purchase::where('user_id', $user_id)->where('status_bought', '!=', '0')->where('status_paied', '!=', '1')->get();

        $ordersAll = new OrdersAll(); 
        $ordersAll = OrdersAll::add($request->get('id'));
        $ordersAll = OrdersAll::add($request->get('sum'));
        $ordersAll = OrdersAll::add($request->get('qty'));
        $ordersAll = OrdersAll::add($request->get('qty_m'));
        $ordersAll = OrdersAll::add($request->get('number'));
        $ordersAll->user_id = \Auth::author()->id;

        foreach ($purchases as $purchase) {
            
            $purchase->ordersAll_id = $ordersAll->id;

        }    
        // @foreach ($ordersAlls as $ordersAll) {

        // $ordersAll->orders()->pluck('order_id')->implode(', ');///code to views////
        $ordersAll->save();
        
    }

    //Pay button on the cart//showAlls button on the cart
    public function buy(Request $request)//, $summa

    {

        $user_id = \Auth::author()->id;

        $purchases = Purchase::where('user_id', $user_id)->where('status_bought', '!=', '0')->where('status_paied', '!=', '1')->get();

        $order = new Order();
        $order = Order::add($request->get('id'));
        $order->user_id = \Auth::author()->id; 
        //$order->amount->getSum($request->get('sum'));
        $order->ordersAlls()->attach($request->get('ordersAlls'));

        //extraInfo make already ~user from new obj of class
        foreach ($purchases as $purchase) {
            
            $purchase->order_id = $order->id;
            
        //     $sum_qty = 0;
        //     $sum_qty_m = 0;
            //1. Delete all items from view http://shop/order(that items I can see in the next http://shop/orderall) and http://shop/cart(sum not count in the cart); with 'status_paied' == 0 to == 1. 

            $purchase->toggleStatus(); 
            
            //for clean cart instead next if{remove}
            if($purchase->status_bought == 1)
            {
                $purchase->status_bought = 2;
            }

        } 

        // $order->qty = $sum_qty;
        // $order->qty_m = $sum_qty_m;        

        $order->save();
        //update OrdersAll
        $ordersAll_id = \OrdersAll::ordersAll()->id;//renew $id from 'orders_alls' table
        
        $purchases = Purchase::where('user_id', $user_id)->where('status_bought', '!=', '0')->where('status_paied', '!=', '2')->where('ordersAll_id', $ordersAll_id)->get();

        $ordersAll = new OrdersAll(); 
        $ordersAll = OrdersAll::getQtySum($request->get('number'));
        $ordersAll = OrdersAll::getQty($request->get('qty'));
        $ordersAll = OrdersAll::getQty_m($request->get('qty_m'));
        $ordersAll = OrdersAll::getSum($request->get('sum'));
        $ordersAll = OrdersAll::getDate($request->get('date'));
        $ordersAll->user_id = \Auth::author()->id;
        //renew $id with add()
        $ordersAll->id = \Purchase::purchases()->ordersAll_id; 

        $ordersAll->save();

        return redirect()->route('cart');//to pay service
    } 

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function indexCart()
    {
        $user_id = \Auth::user()->id;
        //auto clean cart when account paid confirm with 'status_paied' == 0
        if(true)
        {
            //2. Delete all items from view http://shop/order(that items I can see in the next http://shop/orderall) and http://shop/cart(sum not count in the cart)
            $purchases = Purchase::where('user_id', $user_id)->where('status_bought', '!=', 'null')->where('status_paied', '==', '0')->get();

        }    
            return view('purchases.index', ['purchases'=>$purchases]);
        

        //return view('purchases.thanksForPaid');//?on

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Purchase $purchase, Book $book, Magazin $magazin)
    {

         $user_id = \Auth::user()->id;
         $purchases = Purchase::all()->where('status_bought', '!=', '2')->where('status_paied', '!=', '1')->get();//->orderBy('created_at', 'desc')->paginate(10);//query()->with(['book', 'magazin'])->get();//->toArray();
        return view('homes.pay', ['purchases'=>$purchases]);
   }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // if($purchase->book_id != null){
        //         $this->validate($request, [
        //             'qty'   =>  'required'
        //         ]);//not 0
        // }
        // else{
        //         $this->validate($request, [
        //             'qty_m'   =>  'required'
        //         ]);//not 0
        // }
        //Purchase::create($request->all());//or????
        $purchase = new Purchase;
        $purchase->qty = $request->get('qty');
        $purchase->qty_m = $request->get('qty_m');
        $purchase->book_id = $request->get('book_id');
        $purchase->magazin_id = $request->get('magazin_id');
        $purchase->user_id = \Auth::user()->id;

        $purchase->save();

        
        return redirect()->route('purchases.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('purchases.show', compact('purchase'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $purchase = Purchase::find($id);

       // return view('purchases.edit', compact(
       //     'purchase'
       // ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Purchase $purchase
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    { 
        $purchase = Purchase::find($id);
        $purchase->edit($request->get('qty'));
        $purchase->edit($request->get('qty_m'));

        return redirect()->route('cart');
        
    }
    //     public function update(Request $request, Purchase $purchase)
    // {
    //     $purchase->update($request->all());
    //     return redirect()->route('cart');
    // }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Purchase::find($id)->remove();
        return redirect()->back();
    }

    public function destroyAll()
    {
        foreach ($purchases as $purchase) {
            $purchase->remove();
        }
        return redirect()->back();
    }
}
