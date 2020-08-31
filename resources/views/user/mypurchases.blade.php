
@extends('layouts.dashboardEssentials')
@section('content')


<div class="container my-4">
   <div class="row">
      <!-- Grid column -->
      <div class="col-xl mb-4 mb-xl-10">
         <!-- Section: Live preview -->
         <section>
            <ul class="nav nav-tabs" id="myTab" role="tablist">
               <li class="nav-item waves-effect waves-light">
                  <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Accounts</a>
               </li>
               <li class="nav-item waves-effect waves-light">
                  <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Fullz</a>
               </li>
               <li class="nav-item waves-effect waves-light">
                  <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Banks</a>
               </li>
            </ul>
            
            <br>
            <div class="tab-content" id="myTabContent">
               
               <div class="tab-pane fade active show" id="home" role="tabpanel" aria-labelledby="home-tab">
               <!-- Accounts Section-->
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                <th scope="col">username</th>
                                <th scope="col">Location</th>
                                <th scope="col">Time</th>
                                <th scope="col">Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                                @foreach($accounts as $acc)
                                    <tr>
                                        <th scope="row"> {{ $acc->username }} </th>
                                        <td> {{ $acc->location }}  </td>
                                        <td> {{ $acc->time }}  </td>
                                        <td> {{ $acc->price }}$  </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

               </div>


               <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
               <!-- Fullz Section-->
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                <th scope="col">BIN</th>
                                <th scope="col">Full Name</th>
                                <th scope="col">Date of Birth</th>
                                <th scope="col">Sort Code</th>
                                <th scope="col">Price</th>
                                <th scope="col">Type</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                                @foreach($fullz as $acc)
                                    <tr>
                                        <th scope="row"> {{ $acc->card_bin }} </th>
                                        <td> {{ $acc->full_name }}  </td>
                                        <td> {{ $acc->dob }}  </td>
                                        <td> {{ $acc->sort_code }}  </td>
                                        <td> {{ $acc->price }}$ </td>
                                        <td> {{ $acc->record_type }} </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
               </div>



               <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
               <!-- Banks Section-->
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
                                </tr>
                            </thead>
                            <tbody>
                                
                                @foreach($banks as $acc)
                                    <tr>
                                        <th scope="row"> {{ $acc->full_name }} </th>
                                        <td> {{ $acc->dob }}  </td>
                                        <td> {{ $acc->telephone }}  </td>
                                        <td> {{ $acc->account_no }}  </td>
                                        <td> {{ $acc->price }}$ </td>
                                        <td> {{ $acc->price }}$ </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
               </div>


            </div>
         </section>
      </div>
   </div>
</div>
@endsection