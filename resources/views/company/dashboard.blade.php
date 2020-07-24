@extends('layouts.dashboardEssentials')
@section('content')
<div id="main" class="main-padding main-dashboard extend">
<div class="container">
  <button type="button" style='margin-top: 5px;' data-target="#pop-login" data-toggle="modal" class="btn btn-primary">Add Admin</button>
  <button type="button" style='margin-top: 5px;' data-target="#pop-logout" data-toggle="modal" class="btn btn-danger">Delete Admin</button>
  <a type="button" style='margin-top: 5px;' href='company/ViewIdleUsers' class="btn btn-danger">Delete Idle Users</a>
</div>
<br>
    <div class="main-content">
        <div class="mc-stats-detail">
            <div class="row">

            @foreach($admins as $admin)
                <div class="col-lg-4 mcs-balance">
                    <div class="mbox">
                        <div class="mbox-title">
                            <div class="s-title">
                                <h5>{{ $admin->id }}</h5>
                            </div>
                        </div>
                        <div class="mbox-content mbox-number">
                            <span class="highlight">{{ $admin->name }}</span>
                        </div>
                        <div class="mbox-link">
                            <a href="/company/{{ $admin->id }}" title="Admin">Admin <span class="pull-right"><i class="fa fa-arrow-right"></i></span></a>
                        </div>
                    </div>
                </div>
            @endforeach

                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>

@if(!empty($errors))
<script type="text/javascript" src="{{asset('/js/toastr.js')}}"></script>
@foreach ($errors->all() as $error)
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
    Command: toastr["error"]("{{$error}}");
    </script>
@endforeach
@endif


@if(session()->has('success'))
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
    Command: toastr["success"]("{{__(session('success'))}}");
</script>
@endif

@if(session()->has('info'))
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
    Command: toastr["info"]("{{__(session('info'))}}");
</script>
@endif

<!--  Register Popup      -->
<div class="modal fade modal-cuz" id="pop-login" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="fa fa-close"></i>
                    </button>
                </div>
                <div class="modal-body">

                    <form class="sp-form" id="login-form-1" method="post" action="{{ route('ManageAdmin') }}">
                        @csrf
                        <div class="form-group">
                            <input autocomplete="off" required name="name" type="text" class="form-control" placeholder="Name...">
                        </div>

                        <div class="form-group">
                            <input autocomplete="off" required name="email" type="text" class="form-control" placeholder="Email...">
                        </div>
                        
                        <button id="login-submit" name="RegisterAdmin" type="submit" class="btn btn-success btn-block mt20" style="background: #3b8de3 !important;">Register</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

<!--    Delete Popup    -->
<div class="modal fade modal-cuz" id="pop-logout" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="fa fa-close"></i>
                    </button>
                </div>
                <div class="modal-body">

                    <form class="sp-form" id="login-form-1" method="post" action="{{ route('ManageAdmin') }}">
                        @csrf

                        <div class="form-group">
                            <input autocomplete="off" required name="admin_id" type="text" class="form-control" placeholder="ID no...">
                        </div>

                        <button id="login-submit" type="submit" name="DeleteAdmin" class="btn btn-success btn-block mt20" style="background: #3b8de3 !important;">Delete School</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
