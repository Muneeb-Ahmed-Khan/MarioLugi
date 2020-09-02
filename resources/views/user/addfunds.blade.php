@extends('layouts.dashboardEssentials')
@section('content')






<?php

	// bitcoin/altcoin payment box; open source
	
	// Change path to your files
	// --------------------------------------
	DEFINE("CRYPTOBOX_PHP_FILES_PATH", "../libs/");        	// path to directory with files: cryptobox.class.php / cryptobox.callback.php / cryptobox.newpayment.php; 
												// cryptobox.newpayment.php will be automatically call through ajax/php two times - payment received/confirmed
    DEFINE("CRYPTOBOX_IMG_FILES_PATH", asset('bitcoin')."/images/");      // path to directory with coin image files (directory 'images' by default)
    DEFINE("CRYPTOBOX_JS_FILES_PATH", asset('bitcoin')."/js/");			// path to directory with files: ajax.min.js/support.min.js
                                                
                                                
	
	// Change values below
	// --------------------------------------
	DEFINE("CRYPTOBOX_LANGUAGE_HTMLID", "alang");	// any value; customize - language selection list html id; change it to any other - for example 'aa';	default 'alang'
	DEFINE("CRYPTOBOX_COINS_HTMLID", "acoin");		// any value;  customize - coins selection list html id; change it to any other - for example 'bb';	default 'acoin'
	DEFINE("CRYPTOBOX_PREFIX_HTMLID", "acrypto_");	// any value; prefix for all html elements; change it to any other - for example 'cc';	default 'acrypto_'
	
	
	// Open Source Bitcoin Payment Library
    // ---------------------------------------------------------------
    
    $filename = "sample.php";
    if (is_file($filename)) {
        ob_start();
        include_once $filename;
        return ob_get_clean();
    }
	
?>


<div style="max-width:1100px; margin:auto; margin-top:30px; ">
    <div class="my-3 my-md-5">
    <div class="container">
        <div class="page-header">
            <h4 class="page-title">Add funds</h4>
        </div>
        <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                <div class="card-body">
                    <br>
                    <h6>
                        <ul style="">
                            <li style="margin-bottom: 6px;font-size: 15px;">Don't change internet Connection, Don't close the Window, don't change the VPN/Socks5 during the payment else your payment is lost and we will not refund you. </li>
                            <li style="margin-bottom: 6px;font-size: 15px;">We only accept Bitcoin as way to fund your account </li>
                            <li style="margin-bottom: 6px;font-size: 15px;">Minimum is 1 USD</li>
                            <li style="margin-bottom: 6px;font-size: 15px;">After your transaction has received <b>2 confirmations</b>, click on: "<b>Check Payment</b>" in order for the funds to be credited into your account.</li>
                        </ul>
                    </h6>
                    <br>
                    <br>
                    
                    @if(!isset($amount))
                    <form class="form-horizontal" method="POST" action="{{ route('addFunds') }}">
                           @csrf
                              <div class="form-group">
                                    <label>Amount (USD)</label>
                                    <input class="form-control" required name="amount" type="number" min="1" max="2000">
                              </div>
                              
                              <div class="form-group">
                                    <input type="submit" value="Pay with Bitcoin" name="fundsButton" class="btn btn-danger center-block">
                              </div>
                    </form>
                    @else

                        <div>
                            <div class="col-md-2"></div>
                            <div class="col-md-3">
                                <img src="https://chart.googleapis.com/chart?cht=qr&amp;chl=bitcoin:13eRcbA58q4BXUZgt3pCg9zGKzhc3YU3pi&amp;message=ArthurShelby&amp;choe=UTF-8&amp;chs=200x200"><br>
                            </div>
                            <div class="col-md-5"> <br>
                                Address: <code style="color: red;">13eRcbA58q4BXUZgt3pCg9zGKzhc3YU3pi</code><br> <br>
                                Status: <b><span id="message"></span></b><img src="{{asset('images/spin2.gif')}}" id="loading" style="width: 45px; display: none;"><br> <br>
                                <button type="button" class="btn btn-info btn-sm" onclick="call()">Check payment</button>
                            </div>
                            <div class="col-md-2"></div>
                        </div>

                    @endif

                    


                </div>
                </div>
            </div>
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                <div class="card-body">
                    <h4>Payment history</h4>
                    <br>
                    <div class="table-responsive">
                        <table id="order-listing" class="table">
                            <thead>
                            <tr>
                                <th>Date</th>
                                <th>Amount</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($history as $h)
                                    <tr>
                                        <td> {{ $h->txDate }}  </td>
                                        <td> {{ $h->amountUSD }}  </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>

<script>
function call() {
	document.getElementById("loading").style.display = "block"; 
	
    setTimeout(function(){ 

        var xhttp = new XMLHttpRequest();
        
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
            document.getElementById("message").innerHTML = this.responseText;
            document.getElementById("loading").style.display = "none"; 
            }
        };

        xhttp.open("GET", "core.php?action=checkPayment&user=15077&address=13eRcbA58q4BXUZgt3pCg9zGKzhc3YU3pi", true);
        xhttp.send();
   
    }, Math.floor((Math.random() * 10) + 1) * 1000);  
}
   

</script>

<script type="text/javascript" src="{{asset('/js/toastr.js')}}"></script>
<script>
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": false,
        "positionClass": "toast-top-center",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
        }
</script>


@if(!empty($errors))

    @foreach ($errors->all() as $error)
        <script>
            Command: toastr["error"]("{{$error}}");
        </script>
    @endforeach
@endif


@if(session()->has('success'))
    <script>
        Command: toastr["success"]("{{__(session('success'))}}");
    </script>
@endif

@if(session()->has('info'))
    <script>
        Command: toastr["info"]("{{__(session('info'))}}");
    </script>
@endif

@endsection
