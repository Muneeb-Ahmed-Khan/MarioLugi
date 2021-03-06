@extends('layouts.dashboardEssentials')
@section('content')



<div style="max-width:1000px; margin:auto; margin-top:30px; ">

    <form method="post" action="/user/accounts" hidden>
    @csrf
        <input type="text" name="account_id" id="account_id"/>
        <input type="submit" id="form_submit"/>
    </form>

    <script>
    function buyAccounts(row_id)
    {
        document.getElementById('account_id').value = row_id;
        document.getElementById('form_submit').click();
    }
    </script>


    <div class="card" style="margin-bottom: 35px; margin-top: 20px;">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                        <th scope="col">username</th>
                        <th scope="col">Location</th>
                        <th scope="col">Time</th>
                        <th scope="col">Price</th>
                        <th scope="col">    </th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        @foreach($accounts as $acc)
                            <tr>
                                <th scope="row"> {{ $acc->username }} </th>
                                <td> {{ $acc->location }}  </td>
                                <td> {{ $acc->time }}  </td>
                                <td> {{ $acc->price }}$  </td>
                                <td>
                                    <button onclick="buyAccounts({{ $acc->id }});" style="float:right;" class="btn btn-primary">BUY</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    
                </table>
                {{ $accounts->links() }}
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
