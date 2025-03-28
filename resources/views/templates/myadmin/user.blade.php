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
                        <strong class="card-title">Employer Lists</strong>
                       <!--  <a href="add-user" class="right"><i class="fa fa-plus-square"></i> Add Users</a> -->
                    </div>
                      @include('templates.myadmin.messages')
                    <div class="card-body">
                        <table id="bootstrap-data-table" class="table table-striped table-bordered table-responsive-sm">
                          <thead>
                            <tr>
                              <th>No</th>
                              <th>Name</th>
                                <th>E-mail</th>
                                <th>Contact</th>
                                 <th>Status</th>
                              <th>Actions</th>
                            </tr>
                          </thead>
                          <tbody>
                            @if(!empty($customers))
                              @php $i = 0 @endphp
                              @foreach($customers as $customer)
                                @php $i++; @endphp
                                  <tr>
                                      <td>{{$i}}</td>
                                      <td>{{$customer->name}}</td>
                                      <td>{{$customer->email_id}}</td>
                                      <td>{{$customer->mobile_number}}</td>
                                      <td>{{$customer->status}}</td>
                                      <!-- <td><a href="#" class="switch" title="" data-toggle="tooltip" data-original-title="status"><i class="fa"></i></a></td> -->
                                      
                                      <td>
                                        <a href="{{url('edit-user')}}/{{$customer->id}}" class="btn btn-primary" title="Edit" data-toggle="tooltip" data-original-title="Edit"><i class="fa fa-edit"></i></a>

                                        <a href="{{url('view_posted_jobs_list')}}/{{$customer->id}}" class="btn btn-warning" title="Jobs" data-toggle="tooltip" data-original-title="View"><i class="fa fa-eye"></i></a>
                                       
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