<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
//use Cviebrock\EloquentSluggable\Sluggable;

class Purchase extends Model
{
    //use Sluggable;

      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['book_id', 'magazin_id', 
        'user_id', 'order_id', 'status_bought','status_paied', 'date', 'qty_m', 'qty', 'price', 'sum', 'sum_m', 'book_or_mag',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];

        public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function magazin()
    {
        return $this->belongsTo(Magazin::class);
    }

    public function author()//isAdmin
    {
        return $this->belongsTo(User::class, 'user_id');
    }  

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

        public function ordersAll()
    {
        return $this->belongsTo(OrdersAll::class);
    }


    // public function orders()
    // {
    //     return $this->belongsTo(Order::class,
    //         'order_purchases',
    //         'purchase_id',
    //         'order_id'
    //     );
    // }

    // public function sluggable()
    // {
    //     return [
    //         'slug' => [
    //             'source' => 'order_id'
    //         ]
    //     ]; 
    // }
    
    public static function add($fields)
    {// var_dump(get_called_class());
    	$purchase = new static;
    	$purchase->fill($fields);
    	$purchase->book_id = Book::book()->id;
    	$purchase->magazin_id = Magazin::magazin()->id;
    	$purchase->user_id = \Auth::user()->id;//is it true?
    	$purchase->save();

    	return $purchase;

    }

    public function edit($fields)
    {
    	//$this->fill($fields);
        $this->qty = $fields['qty'];
        $this->qty_m = $fields['qty_m'];
    	$this->save();
    }

    public function remove()
    {
    	//$this->removeImage();
    	$this->delete();
    }


    public function Buy()
    {
    	
    	$this->status_bought = 1;
    	$this->save();
    	
    }

    public function disBuy()
    {
    	$this->status_bought = 0;
    	$this->save();
    }

    public function toggleStatusBuy()
    {
    	if($this->status_bought == 0)
    	{
    		return $this->Buy();
    	}

    	return $this->disBuy();
    }    
    //for admin controller
    public function pay()
    {
    	
    	$this->status_paied = 1;
    	$this->save();
    	
    }

    public function disPay()
    {
    	$this->status_paied = 0;
    	$this->save();
    }

    public function toggleStatus()
    {
    	if($this->status_paied == 0)
    	{
    		return $this->pay();
    	}

    	return $this->disPay();
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
  
}
