<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
//use Cviebrock\EloquentSluggable\Sluggable;

class OrdersAll extends Model
{
    protected $fillable = ['user_id', 'number', 'qty', 'qty_m', 'sum', 'date'];

    public function author()//isAdmin
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

    public function orders()
    {

    	return $this->belongsToMany('App\Orders');
    }

    public static function add($id)//, $sum_qty, $sum_qty_m
    {// var_dump(get_called_class());
        $ordersAll = new static;//edit
        //$order->fill($fields);
        $ordersAll->id = $id;
        $ordersAll->sum = 0;
        $ordersAll->qty = 0;
        $ordersAll->qty_m = 0;  
        //$ordersAll->setOrders($request->get('orders'));      
        $ordersAll->save();

        return $ordersAll;

    }

    public function edit($fields)
    {
        //$this->fill($fields);
        $this->id = \Purchase::purchases()->ordersAll_id;
        $this->getQtySum($request->get('number'));
        $this->getQty($request->get('qty'));
        $this->getQty_m($request->get('qty_m'));
        //not enought$purchase->order()...//$this->getSum($request->get('sum'));
        $this->getDate($request->get('date'));        
        $this->setOrders($request->get('orders'));
        $this->save();
    }

    public function setDateAttribute()
    {
        $date = Carbon::createFromFormat('d/m/y', $value)->format('Y-m-d');
        $this->attributes['date'] = $date;
    }

    public function getDateAttribute()
    {
        $date = Carbon::createFromFormat('Y-m-d', $value)->format('d/m/y');

        return $date;
    }

    public function getDate()
    {
        return Carbon::createFromFormat('d/m/y', $this->date)->format('F d, Y');
    }

    public function getQty($qty)
    {
        if($qty != null)
        {
            $this->sum = getQuantity($quantity);
            $this->save();
        }

    }

    public function getQty_m($qty_m)
    {
        if($qty_m != null)
        {
            $this->sum = getQuantity_m($quantity_m);
            $this->save();
        }

    }

    public function getQtySum($qty, $qty_m)
    {
        if($qty != null && $qty_m != null)
        {
            $this->number = getQty() + getQty_m();
            $this->save();
        }

    }

    public function getSum($summa)
    {
        if($summa != null)
        {
            $this->sum = getSumma($summa);
            $this->save();
        }
    }   
//edit with ordersAll->purchase
    // public function getSumma()
    // {

    //     $summa = 0;
    //     foreach ($purchases as $purchase) {//place for future comments

    //         if($purchase->first()->book->author->status_discont_id == 1 && $purchase->first()->book->discont_privat != null && $purchase->magazin->author->status_discont_id == 1 && $purchase->magazin->discont_privat != null)

    //         {//

    //             if (round($purchase->first()->book->discont_global,2) >= round($purchase->first()->book->author->discont_id,2) && round($purchase->magazin->discont_global,2) >= round($purchase->magazin->author->discont_id,2)) 

    //             {//

    //                 $summa += ($purchase->first()->book->price - ($purchase->first()->book->price * $purchase->first()->book->discont_global / 100)) * $purchase->qty + ($purchase->magazin->price - ($purchase->magazin->price * $purchase->magazin->discont_global / 100)) * $purchase->qty_m;

    //                 } elseif(round($purchase->first()->book->discont_global,2) <= round($purchase->first()->book->author->discont_id,2) && round($purchase->magazin->discont_global,2) <= round($purchase->magazin->author->discont_id,2))

    //                 {//

    //                     $summa += ($purchase->first()->book->price - ($purchase->first()->book->price * $purchase->first()->book->author->discont_id / 100)) * $purchase->qty + $purchase->magazin->price - ($purchase->magazin->price * $purchase->magazin->author->discont_id / 100)) * $purchase->qty_m;

    //                     } elseif (round($purchase->first()->book->discont_global,2) >= round($purchase->first()->book->author->discont_id,2) && round($purchase->magazin->discont_global,2) <= round($purchase->magazin->author->discont_id,2))

    //                     {//

    //                         $summa += ($purchase->first()->book->price - ($purchase->first()->book->price * $purchase->first()->book->discont_global / 100)) * $purchase->qty + $purchase->magazin->price - ($purchase->magazin->price * $purchase->magazin->author->discont_id / 100)) * $purchase->qty_m;

    //                         } elseif (round($purchase->first()->book->discont_global,2) <= round($purchase->first()->book->author->discont_id,2) && round($purchase->magazin->discont_global,2) >= round($purchase->magazin->author->discont_id,2))

    //                         {//

    //                             $summa += ($purchase->first()->book->price - ($purchase->first()->book->price * $purchase->first()->book->author->discont_id / 100)) * $purchase->qty + ($purchase->magazin->price - ($purchase->magazin->price * $purchase->magazin->discont_global / 100)) * $purchase->qty_m;

    //                             } elseif (round($purchase->first()->book->discont_global,2) >= round($purchase->first()->book->author->discont_id,2))

    //                             {//

    //                                 $summa += ($purchase->first()->book->price - ($purchase->first()->book->price * $purchase->first()->book->discont_global / 100)) * $purchase->qty  + $purchase->magazin->price * $purchase->qty_m;//

    //                                 } elseif (round($purchase->first()->book->discont_global,2) <= round($purchase->first()->book->author->discont_id,2))

    //                                 {//

    //                                     $summa += ($purchase->first()->book->price - ($purchase->first()->book->price * $purchase->first()->book->author->discont_id / 100)) * $purchase->qty + $purchase->magazin->price * $purchase->qty_m;

    //                                     } elseif (round($purchase->magazin->discont_global,2) >= round($purchase->magazin->author->discont_id,2))

    //                                     {//

    //                                         $summa += ($purchase->magazin->price - ($purchase->magazin->price * $purchase->magazin->discont_global / 100)) * $purchase->qty_m + $purchase->first()->book->price  * $purchase->qty;

    //                                         } elseif (round($purchase->magazin->discont_global,2) <= round($purchase->magazin->author->discont_id,2))

    //                                         {//

    //                                             $summa += ($purchase->magazin->price - ($purchase->magazin->price * $purchase->magazin->author->discont_id / 100)) * $purchase->qty_m + $purchase->first()->book->price  * $purchase->qty;

    //                                         }

    //         //                               
    //         } elseif($purchase->first()->book->discont_privat != null && $purchase->magazin->discont_privat != null)

    //             {//
    //                 if($purchase->first()->book->discont_privat != null) 

    //                 {//

    //                     $summa += ($purchase->first()->book->price - ($purchase->first()->book->price * $purchase->first()->book->discont_global / 100)) * $purchase->qty + $purchase->magazin->price * $purchase->qty_m;


    //                 }

    //                     elseif($purchase->magazin->discont_privat != null) 

    //                     {//

    //                         $summa += ($purchase->magazin->price - ($purchase->magazin->price * $purchase->magazin->discont_global / 100)) * $purchase->qty_m + $purchase->first()->book->price  * $purchase->qty;

    //                     }

    //                 $summa += ($purchase->first()->book->price - ($purchase->first()->book->price * $purchase->first()->book->discont_global / 100)) * $purchase->qty + ($purchase->magazin->price - ($purchase->magazin->price * $purchase->magazin->discont_global / 100)) * $purchase->qty_m;

    //             //
    //             } elseif($purchase->first()->book->author->status_discont_id == 1 && $purchase->magazin->author->status_discont_id == 1)

    //                 {//

    //                     if($purchase->first()->book->author->status_discont_id == 1) 

    //                     {//
    //                         $summa += ($purchase->first()->book->price - ($purchase->first()->book->price * $purchase->first()->book->author->discont_id / 100)) * $purchase->qty + $purchase->magazin->price * $purchase->qty_m;

    //                     }
    //                         elseif($purchase->magazin->author->status_discont_id == 1) 

    //                         {//

    //                             $summa += ($purchase->magazin->price - ($purchase->magazin->price * $purchase->magazin->author->discont_id / 100)) * $purchase->qty_m + $purchase->first()->book->price  * $purchase->qty;

    //                         }

    //                     $summa += ($purchase->first()->book->price - ($purchase->first()->book->price * $purchase->first()->book->author->discont_id / 100)) * $purchase->qty + ($purchase->magazin->price - ($purchase->magazin->price * $purchase->magazin->author->discont_id / 100)) * $purchase->qty_m;

    //                 //    
    //                 } else 

    //                         {//

    //                         $summa += $purchase->first()->book->price  * $purchase->qty + $purchase->magazin->price * $purchase->qty_m;

    //                         } 

    //     }
    //     return $summa;

    // }     
}
