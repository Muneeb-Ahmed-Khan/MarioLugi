@extends('layouts.dashboardEssentials')
@section('content')



<div style="max-width:1000px; margin:auto; margin-top:30px; ">

    <form method="post" action="/user/fullz" hidden>
    @csrf
        <input type="text" name="fullz_id" id="fullz_id"/>
        <input type="submit" id="form_submit"/>
    </form>

    <script>
    function buyFullz(row_id)
    {
        document.getElementById('fullz_id').value = row_id;
        document.getElementById('form_submit').click();
    }
    </script>

    <form class="form-inline" style="display: inline;"  method="post" >
    @csrf
            <input name="binSearch" maxlength="6" class="form-control" type="text" placeholder="Bin Search" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form>


    <div class="card" style="margin-bottom: 35px; margin-top: 20px;">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                        <th scope="col">BIN</th>
                        <th scope="col">Full Name</th>
                        <th scope="col">Date of Birth</th>
                        <th scope="col">Sort Code</th>
                        <th scope="col">Price</th>
                        <th scope="col">    </th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        @foreach($accounts as $acc)
                            <tr>
                                <th scope="row"> {{ $acc->card_bin }} </th>
                                <td> {{ $acc->full_name }}  </td>
                                <td> {{ $acc->dob }}  </td>
                                <td> {{ $acc->sort_code }}  </td>
                                <td> {{ $acc->price }}$ </td>
                                <td>
                                    <button style="float:right; " onclick="buyFullz({{ $acc->id }});" class="btn btn-primary">BUY</button>
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
