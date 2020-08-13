@extends('layouts.dashboardEssentialsAdmin')
@section('content')



<div style="max-width:1000px; margin:auto; margin-top:30px; ">

    <div class="page-header" style="margin-bottom: 35px;">
        <h4 class="page-title">Home</h4>
    </div>
    <div class="card">
        <div class="card-body">
                <div class="d-flex mt-4 align-items-top">
                    <div class="mb-0 flex-grow">
                        <h5 class="mr-2 mb-2">Official MarioLugi Update Channel!</h5>
                        <p class="mb-0 font-weight-light">https://t.me/joinchat/NEsLqlQli9_S4Wlf9HZaQg</p>
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
