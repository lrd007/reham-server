<?php

namespace App\Http\Controllers\frontend;

use App\Cart;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use LamaLama\Wishlist\HasWishlists;
use Modules\Course\Entities\Course;
use Modules\Program\Entities\Program;

class CartController extends Controller
{
    use HasWishlists;
    public function __construct()
    {
        return $this->middleware('auth:web');
    }

    public function cart()
    {
        $title = __('words.Cart');
        $user = auth()->user();
        $cart_item = $user->wishlist('cart');
        return view('website.cart',compact('title','cart_item'));
    }

    public function getCart()
    {
        $user_id = auth()->user()->id;
        $cart_item = Cart::where('user_id', $user_id)->get();
        return response()->json(['cart_item' => count($cart_item),'cart_data' => $cart_item], 200);
    }

    public function addCart($program_id)
    {
        $user = auth()->user();
        $program = Program::find($program_id);

        foreach ($program->courses as $course){
            $user->wish($course,'cart');
        }
        $cart_item = $user->wishlist('cart');;
        return response()->json(['cart_item' => count($cart_item)], 200);
    }

    public function removeCart($cart_id){

        $user = auth()->user();;
        $course = Course::find($cart_id);
        $user->unwish($course, 'cart');

        return redirect()->route('cart');
    }
}
