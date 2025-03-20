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

                        <strong class="card-title">Qualifications List</strong>

                        <a href="{{url('add-qualification')}}" class="right"><i class="fa fa-plus-square"></i> Add Qualification</a>

                    </div>

                     @if (Session::has('success'))

                        <div class="alert alert-success">{{ Session::get('success') }}</div>

                     @endif

                    <div class="card-body">

                        <table id="bootstrap-data-table" class="table table-striped table-bordered">

                         <thead>

                            <tr>            

                              <th>No</th>
          
                              <th>Name</th>

                          
                              <th>Actions</th>

                            </tr>

                          </thead>

                           <tbody>

                            @if(!empty($qualifications))

                              @php $i = 0 @endphp

                              @foreach($qualifications as $promocode)

                                @php $i++; @endphp

                                  <tr>

                                      <td>{{$i}}</td>

                                      <td>{{$promocode->name}}</td>
                                      <td>
                                   
                                        <a href="{{url('edit-qualification',$promocode->id)}}" class="btn btn-primary" title="" data-toggle="tooltip" data-original-title="Edit"><i class="fa fa-edit"></i></a>
                                      <a onclick="return confirm('Are You Sure, to delete selected data?')" href="{{url('delete-qualification')}}/{{$promocode->id}}" class="btn btn-danger" title="" data-toggle="tooltip" data-original-title="Delete"><i class="fa fa-close"></i></a>
                                   
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