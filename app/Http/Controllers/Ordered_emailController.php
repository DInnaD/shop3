<?php

namespace App\Http\Controllers;

use App\Subscription;
use App\Mail\Ordered_email;
use Illuminate\Http\Request;

class Ordered_emailController extends Controller
{
   public function subscribe(Request $request)
    {
        $this->validate($request, [
            'email' =>  'required|email|unique:subscriptions'
        ]);
        
        $subs = Subscription::add($request->get('email'));
        $subs->generateToken();
        
        \Mail::to($subs)->send(new SubscribeEmail($subs));

        return redirect()->back()->with('status','Проверьте вашу почту!');
    }

    public function verify($token)
    {
        $subs = Subscription::where('token', $token)->firstOrFail();
        $subs->token = null;
        $subs->save();
        return redirect('/')->with('status', 'Ваша почта подтверждена!СПАСИБО!');
    }
}
