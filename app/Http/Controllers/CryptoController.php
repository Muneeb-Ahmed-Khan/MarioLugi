<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CryptoController extends Controller
{
    public function __construct()
    {
        /*Only GUESTS can use it. any authorized person that uses it will be redirected to Authenticate.php Middleware
        and it will return it to the ReturnToUnauthorizedPage route and that will redirect it accoring to it's gurad */
        $this->middleware('guest');
        $this->middleware('guest:company');
        $this->middleware('guest:admin');
        $this->middleware('guest:user');
    }

    public function PaymentCallback(Request $request)
    {
        return view('libs.paymentcallback');
    }

    public function Sample(Request $request)
    {
        return view('libs.cryptobox-callback');
    }
}
