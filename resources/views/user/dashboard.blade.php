@extends('layouts.dashboardEssentials')
@section('content')



<div style="max-width:1000px; margin:auto; margin-top:30px; ">
   <div class="page-header" style="margin-bottom: 35px;">
      <h4 class="page-title">Home</h4>
   </div>
   <div class="card">
      <div class="card-body">
         <div class="d-flex mt-4 align-items-top">
            <div class="mb-0 flex-grow">
               <h5 class="mr-2 mb-2">Welcome to Mario & Luigi’s Store.</h5>
               <p class="mb-0 font-weight-light">Here at the Mario & Luigi’s Store, we deliver the finest Fullz, Logs & Web accounts on the market.</p>
               <p class="mb-0 font-weight-light">We have everything you need. Whatever your preference we can cater to it.</p>
               <p class="mb-0 font-weight-light">We ensure all our products are of top quality. Nobody else does it like us. Enjoy your time on the market, Happy Carding & Spoofing !</p>
               <p class="mb-0 font-weight-light">Fresh spam is sent out every couple of days so there will be abundant amounts of work. Join our Telegram group for updates & free give aways: <b><a href="https://t.me/mariolugiscc">FREE GIVEAWAY !!!</a><b> </p>
            </div>
         </div>
      </div>
   </div>
</div>



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
