@if (Session::has('AccessToken'))
   <?php $value = Session::get('AccessToken') ?>
@else
    <script>window.location.href = "MyDashboard";</script>
@endif
@extends('templates.myadmin.layout')
@section('content')

<div class="content mt-3">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <strong class="card-title">Plan Purchased History</strong>
                    </div>
                    <div class="card-body">
                        @if (Session::has('message'))
                            <div class="alert alert-warning">{{ Session::get('message') }}</div>
                        @endif
                        @if (Session::has('success'))
                            <div class="alert alert-success">{{ Session::get('success') }}</div>
                        @endif
                        <table id="bootstrap-data-table" class="table table-striped table-bordered">
                          <thead>
                            <tr>
                              <th>Sr.No</th>
                              <th>Purchased ID</th>
                              <th>Customer Details</th>
                              <th>Plan Details</th>
                              <th>Payment Details</th>
                              <!--<th>Actions</th>-->
                            </tr>
                          </thead>
                          <tbody>
                              @if(!empty($order_history))
                              <?php  $i = 0; ?>
                                @foreach($order_history as $history)
                                  <?php $i++; ?>
                                  <tr>
                                      <td>{{$i}} </td>
                                      <td>{{$history->order_id}}</td>
                                       <td>
                                       @if(!empty($cust_details))

                                      @foreach($cust_details as $cust)

                                        @if($history->user_auto_id == $cust->id)

                                           
                                           <b>User Name : </b> {{$cust->name}}<br>
                                           <b>User Email : </b> {{$cust->email}}<br>
                                           <b>User Contact : </b> {{$cust->contact}}<br>
                                            <b>Country : </b> {{$cust->country}}<br>
                                          
                                        @endif

                                      @endforeach

                                    @endif
                                      </td>
                                      <td>
                                    
                                          <b>Name : </b> {{$history->plan_name}}<br>
                                          <b>Price : </b> {{$history->price}}<br>
                                          <b>Offer Percentage : </b> {{$history->offer_percentage}}<br>
                                          <b>Final Price : </b> {{$history->final_price}}<br>
                                          <b>Validity : </b> {{$history->validity}}<br>
                                                                              
                                      </td>
                                      <td>
                                       
                                          <b>Payment Mode : </b> {{$history->payment_mode}}<br>
                                          <b>Transaction ID : </b> {{$history->transaction_id}}<br>
                                          <b>Transaction Status : </b> {{$history->transaction_status}}<br>
                                          <b>Purchase Status : </b> {{$history->status}}<br>
                                          <b>Purchase Date : </b> {{$history->rdate}}<br>
                                      
                                      </td>
                                      
                                      <!--<td>-->
                                      <!-- <a href="{{ url('/delete-purchased-history',$history->id)}}" class="btn btn-danger" title="" data-toggle="tooltip" data-original-title="Delete" onclick="return confirm('Are you sure you want to delete this data ?');"><i class="fa fa-close"></i></a>-->
                                      <!-- </td>-->
                                  </tr>
                                @endforeach
                              @endif
                          </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- .animated -->
</div><!-- .content -->
@endsection