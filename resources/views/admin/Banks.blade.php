@extends('layouts.dashboardEssentialsAdmin')
@section('content')


<form method="post" hidden action="{{ route('ManageBanksUpload') }}" >
    @csrf
    <input type="submit" name="delete" id="DeleteForm">
</form>
<script>
function DeleteRecords()
{
    document.getElementById('DeleteForm').click();
}
</script>


<div style="max-width:1000px; margin:auto; margin-top:30px; ">

<button type="button" style='margin-top: 5px;' data-target="#addBanks" data-toggle="modal" class="btn btn-danger">Add Banks</button>
<button type="button" class="btn btn-danger" style='margin-top: 5px;' onclick="DeleteRecords()">Delete</button>

    <div class="card" style="margin-bottom: 35px; margin-top: 20px;">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Bank</th>
                            <th scope="col">Birth Year</th>
                            <th scope="col">Network</th>
                            <th scope="col">Balance</th>
                            <th scope="col">TELEPINSCREENSHOT</th>
                            <th scope="col">Price</th>
                            <th scope="col">  </th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        @foreach($accounts as $acc)
                            <tr>
                                <th scope="row"> {{ $acc->full_name }} </th>
                                <td> {{ $acc->dob }}  </td>
                                <td> {{ $acc->telephone }}  </td>
                                <td> {{ $acc->account_no }}  </td>
                                <td> {{ $acc->price }}$ </td>
                                <td> {{ $acc->price }}$ </td>
                                <td>
                                    <button style="float:right; " onclick="buyFullz({{ $acc->id }});" class="btn btn-primary">BUY</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    
                </table>
                    <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-end">
                            <li class="page-item disabled">
                                <a class="page-link" href="#" tabindex="-1">Previous</a>
                            </li>
                                <li class="page-item"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item">
                                <a class="page-link" href="#">Next</a>
                            </li>
                        </ul>
                    </nav>
            </div>
        </div>
    </div>
</div>




<!-- Add Product Modal -->
<div class="modal fade" id="addBanks" tabindex="-1" role="dialog" aria-labelledby="addProductTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
        <div class="modal-content">
        
            <div class="modal-header">
                <h5 class="modal-title" id="addProductTitle">Add Banks</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form method="post" action="{{ route('ManageBanksUpload') }}" enctype="multipart/form-data">
            @csrf

                <div class="modal-body">
                    
                    
                    <div class="form-group">
                        <label>CSV File</label>
                        <input type="file" name="file" accept=".csv" class="form-control" required>
                    </div>
                    

                </div>

                <div class="modal-footer">
                    <input type="submit" class="btn btn-danger" name="addBanks" value="Upload">
                    <input type="reset" class="btn btn-default" value="Reset">
                </div>

            </form>

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
