<?php

namespace App\Policies;

use Auth;
use App\User;
use App\Book;
use App\Magazin;
use App\Purchase;
use App\Profile;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    //is_admin?
    /**
     * Determine if the given user can create posts.
     *
     * @param  \App\User  $user
     * @return bool
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine if the given user can create posts.
     *
     * @param  \App\User  $user
     * @return bool
     */
    public function update(User $user)
    {
    
        return $user->id == true;
    
    }
}
