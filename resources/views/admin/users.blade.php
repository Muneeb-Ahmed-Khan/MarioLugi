@extends('layouts.dashboardEssentialsAdmin')
@section('content')


<div style="max-width:1000px; margin:auto; margin-top:30px; ">


    <form method="post" action="/admin/block-user" hidden>    
    @csrf
        <input type="text" name="user_id" id="user_id_block"/>
        <input type="submit" id="form_submit_block"/>
    </form>

    <form method="post" action="/admin/unblock-user" hidden>    
    @csrf
        <input type="text" name="user_id" id="user_id_unblock"/>
        <input type="submit" id="form_submit_unblock"/>
    </form>

    <script>
    function blockUser(row_id)
    {
        document.getElementById('user_id_block').value = row_id;
        document.getElementById('form_submit_block').click();
    }

    function UnblockUser(row_id)
    {
        document.getElementById('user_id_unblock').value = row_id;
        document.getElementById('form_submit_unblock').click();
    }
    </script>

    <div class="my-3 my-md-5">
    <div class="container">
        <div class="page-header">
            <h4 class="page-title">Users</h4>
        </div>
        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                    <th scope="col">Full Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Telegram</th>
                                    <th scope="col">Balance</th>
                                    <th scope="col">    </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                    @foreach($users as $u)
                                        <tr>
                                            <td> {{ $u->name }}  </td>
                                            <td> {{ $u->email }}  </td>
                                            <td> {{ $u->telegram }}  </td>
                                            <td> {{ $u->balance }}$  </td>
                                            <td>
                                                
                                                @if( $u->isActive == 1  )
                                                    <button onclick="blockUser({{$u->id}})" style="float:right;" class="btn btn-primary">BLOCK</button>
                                                @endif

                                                @if( $u->isActive == 0  )
                                                    <button onclick="UnblockUser({{$u->id}})" style="float:right;" class="btn btn-danger">Un Block</button>
                                                @endif
                                                
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $users->links() }}
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


