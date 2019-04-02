<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
//use Cviebrock\EloquentSluggable\Sluggable;


class Order extends Model
{
    //use Sluggable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 
        'user_id', 'qty', 'qty_m', 'status', 'note', 'date', 'amount',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

        public function ordersAlls()
    {
        return $this->belongsToMany('App\OrdersAll');
    }
 //setOrdersAlls()?????????
    // public function setPurchasesOrder_id($ids)
    // {
    //     if($ids == null){return;}

    //     $this->orders()->sync($ids);
    // }

    // public function getPurchases()
    // {
    //     return (!$this->purchases->isEmpty())
    //         ?   implode(', ', $this->purchases->pluck('order_id')->all())
    //         : 'No orders';
    // }    

    public static function add($id)//, $sum_qty, $sum_qty_m
    {// var_dump(get_called_class());
        $order = new static;
        //$order->fill($fields);
        $order->id = $id;
        $order->user_id = \Auth::user()->id;
        $order->amount->getSum($request->get('sum'));
        $order->setOrdersAlls($request->get('ordersAlls'));
        //$order->amount = $summa;
        //$order->qty = $sum_qty;
        //$order->qty_m = $sum_qty_m;
        $order->save();

        return $order;

    }

    public function edit($fields)
    {
        $this->fill($fields);
        $this->save();
    }

    public function allow()
    {
    	$this->status = 1;
    	$this->save();
    }

    public function disAllow()
    {
    	$this->status = 0;
    	$this->save();
    }

    public function toggleStatus()
    {
    	if($this->status == 0)
    	{
    		return $this->allow();
    	}

    	return $this->disAllow();
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

    //setOrdersAlls() 
    
}
