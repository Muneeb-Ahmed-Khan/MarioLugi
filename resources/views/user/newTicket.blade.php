@extends('layouts.dashboardEssentials')
@section('content')

<script src='https://www.google.com/recaptcha/api.js' async defer></script>

<div style="max-width:1000px; margin:auto; margin-top:30px; ">
    <div class="my-3 my-md-5">
    <div class="container">
        <div class="page-header">
            <h4 class="page-title">New Ticket</h4>
        </div>
        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                <div class="card-body">
                    

                        <form class="form-horizontal" method="POST" action=""  id="ticketForm">
                           @csrf
                              <div class="form-group">
                                 <label>Subject</label>
                                 <input class="form-control" required name="subject" type="text">
                              </div>
                              
                              <div class="form-group">
                                <label>Mail</label>
                                <textarea rows="4"  class="form-control"  name="content" form="ticketForm"></textarea>
                              </div>

                              <div class="g-recaptcha" data-sitekey="6Ldp_8QZAAAAAL-1_CW8Qu5y98tUg2MIZbzhUImN"></div>
                                <br>
                              <div class="form-group">
                                 <input type="submit" value="Submit Ticket" name="passwordForm" class="btn btn-danger center-block">
                              </div>

                        </form>
                           


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