<?php

namespace App\Policies;

use Auth;
use App\User;
use App\Book;
use Illuminate\Auth\Access\HandlesAuthorization;

class BookPolicy
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

    public function before(User $user) {
        if (!Auth::check()) {
            return false;
    }
});

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
     * Determine if the given post can be updated by the user.
     *
     * @param  \App\User  $user
     * @param  \App\Book  $book
     * @return bool
     */
    // public function update(?User $user, Book $book)
    // {
    //     return $user->id ===!!! $book->user_id;
    // }
    public function update(User $user, Book $book)
    {
        return $user->id == $book->user_id;
    }
}
