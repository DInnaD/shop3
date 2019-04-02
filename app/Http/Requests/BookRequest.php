<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;//or check()?
        //or on BookController
//         class LetterController extends Controller
// {
// protected $user;?????????????????????????
// public function __construct()
// {
//     $this->middleware(function ($request, $next){
//        $this->user = Auth::user();
//         return $next($request);
//     });

// }
// public function edit(Letter $letter)
// {
//     if($this->user->can('update', $letter)){           
//        //edit
//     }
//     else
//         abort('403', 'Access Denied');
// }
    //     $comment = Comment::find($this->route('comment'));

    // return $comment && $this->user()->can('update', $comment);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }
}
