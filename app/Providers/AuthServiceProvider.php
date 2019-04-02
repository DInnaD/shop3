<?php

namespace App\Providers;

use Auth;
use App\User;
use App\Book;
use App\Magazin;
use App\Purchase;
use App\Profile;
use App\Policies\UserPolicy;
use App\Policies\BookPolicy;
use App\Policies\MagazinPolicy;
use App\Policies\PurchasePolicy;
use App\Policies\ProfilePolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    // protected $policies = [
    //     'App\Model' => 'App\Policies\ModelPolicy',
    // ];
    // protected $policies = [
    //     'App\User' => 'App\Policies\UserPolicy',
    // ];
    protected $policies = [
        User::class => UserPolicy::class,
        Book::class => BookPolicy::class,
        Magazin::class => MagazinPolicy::class,
        Purchase::class => PurchasePolicy::class,
        Profile::class => ProfilePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        
        Gate::define('update-post', function($user, Book $book){

            return $user->hasAccess(['update-post']) or $user->id == $book->user_id;
        });

        Gate::define('update-post', function($user, Magazin $magazin){

            return $user->hasAccess(['update-post']) or $user->id == $magazin->user_id;
        });

        Gate::define('update-post', function($user, Profile $profile){

            return $user->hasAccess(['update-post']) or $user->id == $profile->user_id;
        });

        Gate::define('update-post', function($user, Purchase $purchase){

            return $user->hasAccess(['update-post']) or $user->id == $purchase->user_id;
        });
//is it true?
        Gate::define('update-post', function(User $user){

            return $user->hasAccess(['update-post']) or $user->id == true;
        });

        
        //Gate::resource('users', 'UserPolicy', [
            //'discont_id' => 'discont_id',//=> updateDiscont_id            
        //]);
//use
//         if (Gate::forUser($user)->allows('update-post', $post)) {
//     // The user can update the post...
// }

// if (Gate::forUser($user)->denies('update-post', $post)) {
//     // The user can't update the post...
// }
        //or clouther? is_admin will change sometimes?
    //     Gate::define('update-post//users.edit', function ($user, $user->discont_id) {
    //     return $user->id == $post->user_id//$user->discont_id;
    // });
//use
//         if (Gate::allows('update-post', $post)) {
//     // The current user can update the post...
// }

// if (Gate::denies('update-post', $post)) {
//     // The current user can't update the post...
// }
        //use to viev??????
//         Gate::before//after(function ($user, $ability) {
//     if ($user->isSuperAdmin()) {
//         return true;
//     }
// });
    }
}
