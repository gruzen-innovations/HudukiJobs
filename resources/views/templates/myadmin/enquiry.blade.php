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
                        <strong class="card-title">Enquiries</strong>
                    
                    </div>
                      @if (Session::has('success'))
                        <div class="alert alert-success">{{ Session::get('success') }}</div>
                     @endif
                    <div class="card-body">
                        <table id="bootstrap-data-table" class="table table-striped table-bordered">
                          <thead>
                            <tr>
                              <th>No</th>
                              <th>Customer Details</th>
                                <th>Type</th>
                                <th>Message</th>
                                 <th>Date</th>
                              <th>Actions</th>
                            </tr>
                          </thead>
                          <tbody>
                            @if(!empty($enquiries))
                              @php $i = 0 @endphp
                              @foreach($enquiries as $enquiry)
                                @php $i++; @endphp
                                  <tr>
                                      <td>{{$i}}</td>
                                      <td>Name : {{$enquiry->name}}<br> 
                                          Email : {{$enquiry->email}}<br>
                                          Contact : {{$enquiry->contact}}
                                      </td>
                                      <td>{{$enquiry->type}}</td>
                                     <td>{{$enquiry->message}}</td>
                                      <td>{{$enquiry->created_at}}</td>
                                   
                                      
                                      <td>
                                      
                                        <a onclick="return confirm('Are You Sure, to delete selected data?')"  href="{{url('deleteEnquiry')}}/{{$enquiry->id}}" class="btn btn-danger" title="" data-toggle="tooltip" data-original-title="Delete"><i class="fa fa-close"></i></a>
                                       
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