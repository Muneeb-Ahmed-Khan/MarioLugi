@extends('layouts.dashboardEssentials')
@section('content')


<div style="max-width:1000px; margin:auto; margin-top:30px; ">
   <div class="my-3 my-md-5">
      <div class="container">
         <div class="page-header" style=" margin-top: 25px; margin-bottom: 25px; ">
            <h4 class="page-title">My Account</h4>
         </div>
         <div class="row">
            <div class="col-md-12">
               <div class="row">
                  
                  <div class="col-md-4 grid-margin">
                     <div class="card">
                        <div class="card-body">
                           <h4>Edit Telegram & E-mail</h4>
                           <hr>
                           <form class="form-horizontal" method="POST" action="">
                           @csrf
                              <div class="form-group">
                                 <label>Telegram</label>
                                 <input class="form-control" required name="telegram" type="text">
                              </div>
                              <div class="form-group">
                                 <label>Email</label>
                                 <input class="form-control" required  disabled name="email" value="{{ Auth::user()->email }}" type="email">
                              </div>
                              <div class="form-group">
                                 <input type="submit" value="Save Changes" name="profileForm" class="btn btn-danger center-block">
                              </div>
                           </form>
                        </div>
                     </div>
                  </div>
                  
                  <div class="col-md-4 grid-margin">
                     <div class="card">
                        <div class="card-body">
                           <h4>Change Password</h4>
                           <form class="form-horizontal" method="POST" action="">
                           @csrf
                              <hr>
                              <div class="form-group">
                                 <label>Current Password</label>
                                 <input class="form-control" required name="curPass" placeholder="Password" type="password">
                              </div>
                              <div class="form-group">
                                 <label>New Password</label>
                                 <input class="form-control" required name="newPass" placeholder="New Password" type="password">
                              </div>
                              <div class="form-group">
                                 <input type="submit" value="Save Changes" name="passwordForm" class="btn btn-danger center-block">
                              </div>
                           </form>
                        </div>
                     </div>
                  </div>
                  
                  <div class="col-md-4 grid-margin">
                     <div class="card">
                        <div class="card-body">
                           <h4>My details</h4>
                           <br>
                           <p>
                              <b>Username:</b> {{ Auth::user()->name }}
                              <br>
                              <b>Email:</b> {{ Auth::user()->email }}
                              <br>
                              <b>Telegram:</b> {{ Auth::user()->telegram }}
                              <br>
                              <b>Balance:</b> $0
                              <br>
                              <b>Money spent:</b> $0
                              <br>
                              <b>Registered on:</b> {{ Auth::user()->created_at }}
                              <br>
                              <br>
                           </p>
                        </div>
                     </div>
                  </div>
               </div>
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
