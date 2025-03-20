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

                        <strong class="card-title">Pincode</strong>

                        <a href="add-pincode" class="right"><i class="fa fa-plus-square"></i> Add Pincode</a>

                    </div>

                      @include('templates.myadmin.messages')

                    <div class="card-body">

                        <table id="bootstrap-data-table" class="table table-striped table-bordered table-responsive-sm">

                          <thead>

                            <tr>

                              <th>Sr.No</th>

                              <th>Pincode</th>

                              <th>Delivery Charge</th>

                              <th>Actions</th>

                            </tr>

                          </thead>

                          <tbody>

                            @if(!empty($allpincode))

                              @php $i = 0 @endphp

                              @foreach($allpincode as $pincode)

                                @php $i++; @endphp

                                  <tr>

                                      <td>{{$i}}</td>

                                      <td>{{$pincode->pincode}}</td>

                                      <td>{{$pincode->delivery_charge}}</td>                       

                                      <td>
                                        
                                        <a href="{{url('edit-pincode')}}/{{$pincode->id}}" class="btn btn-primary" title="" data-toggle="tooltip" data-original-title="Edit"><i class="fa fa-edit"></i></a>

                                      <a onclick="return confirm('Are You Sure to delete selected data?')" href="{{url('delete-pincode')}}/{{$pincode->id}}" class="btn btn-danger" title="" data-toggle="tooltip" data-original-title="Delete"><i class="fa fa-close"></i></a>
                                    
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