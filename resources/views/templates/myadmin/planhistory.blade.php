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
                        <strong class="card-title">Grobiz Plan Hisotry</strong>
                      <!--   <a href="add_appointment" class="right"><i class="fa fa-plus-square"></i> Add Appointment</a> -->
                    </div>
                     @if (Session::has('success'))
                        <div class="alert alert-success">{{ Session::get('success') }}</div>
                     @endif
                     <div class="card-body">
                        <table id="bootstrap-data-table" class="table table-striped table-bordered table-responsive-sm">
                          <thead> 
                            <tr>
                              <th>No</th>
                              <th>Order Details</th>
                              <th>Plan</th>
                              <th>Price</th>
                              <th>Status</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>
                              @if(!empty($allorders))
                                @php $i = 0 @endphp
                                @foreach($allorders as $orders)
                                  @php $i++; @endphp
                                  <tr>
                                      <td>{{$i}}</td>
                                      <td>
                                        <b>ID: </b> {{$orders->order_id}}<br/>
                                        <b>Date: </b> {{$orders->order_date}} {{$orders->order_time}}<br/>
                                        <b>Category: </b> {{$orders->main_category_name}}<br/>
                                        <b>Transaction ID: </b>{{$orders->tranzaction_id}}
                                      </td>
                                     
                                      <td>
                                        <b>Name:</b> {{$orders->plan_name}}<br/>
                                        <b>Category:</b> {{$orders->plan_category_name}}<br/>
                                        <b>Validity:</b> {{$orders->plan_validity}} days<br/>
                                      </td>
                                      <td>
                                        <b>Price:</b> {{$orders->final_price}}<br/>
                                        <b>GST:</b> {{$orders->total_gst_on_final_price}}<br/>
                                        <b>Total:</b> {{$orders->final_price_with_gst}}<br/>
                                        <b>Wallet:</b> {{$orders->cutbalance}}<br/>
                                        <b>Paid Price:</b> {{$orders->paid_price}}
                                      </td>
                                      <td>{{$orders->purchase_status}}</td>
                                     <td>
                                    
                                      <a href="{{url('view_feature',$orders->id)}}" class="btn btn-secondary" title="view features" data-toggle="tooltip" data-original-title="View"><i class="fa fa-eye"></i></a>
                                     <a href="{{url('view_plan',$orders->id)}}" class="btn btn-primary" title="view Order" data-toggle="tooltip" data-original-title="View"><i class="fa fa-eye"></i></a>
                                  
                                     </td>                                    
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