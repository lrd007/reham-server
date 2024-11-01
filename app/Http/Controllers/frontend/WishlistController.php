<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function wishlist()
    {
        $user=Auth::user();
        $items = $user->wishlist('wishlist');
        //dd($items);
        return view('frontend.wishlist',compact('items'));
    }
}
