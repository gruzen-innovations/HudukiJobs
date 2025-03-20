<!-- @if (Session::has('Access-Token'))
   <?php $value = Session::get('Access-Token') ?>
@else
    <script>window.location.href = "MyDashboard";</script>
@endif -->
@extends('templates.myadmin.layout')
@section('content')

<div class="content mt-3">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <strong class="card-title"> Slider</strong>
                        <a href="{{url('add-slider')}}" class="right"><i class="fa fa-plus-square"></i> Add Slider</a>
                    </div>
                     @include('templates.myadmin.messages')
                    <div class="card-body">
                        <table id="bootstrap-data-table" class="table table-striped table-bordered table-responsive-sm">
                         <thead>
                            <tr>            
                              <th>No</th>
                               <th>Main Category</th>
                              <th>Sub Category</th>
                              <th>Name</th>
                              <th>Image</th>
                              <th>Actions</th>
                            </tr>
                          </thead>
                           <tbody>
                            @if(!empty($sliders))
                              @php $i = 0 @endphp
                              @foreach($sliders as $slider)
                                @php $i++; @endphp
                                  <tr>
                                      <td>{{$i}}</td>
                                       <td>{{$slider->main_category_name_english}}</td>
                                      <td>{{$slider->sub_category_name}}</td>
                                      <td>{{$slider->sname}}</td>
                                     
                                        <td>
                                     
                                        
                                        <img src="images/slider/{{$slider->image}}" style="width: 150px;height:100px"/>
                                        
                                      
                                        </td>
                                      <td>
                                       
                                        <a href="{{ url('edit-slider',$slider->id)}}" class="btn btn-primary" title="" data-toggle="tooltip" data-original-title="Edit"><i class="fa fa-edit"></i></a>
                                        <a onclick="return confirm('Are You Sure to delete selected data?')" href="{{url('delete-slider')}}/{{$slider->id}}" class="btn btn-danger" title="" data-toggle="tooltip" data-original-title="Delete"><i class="fa fa-close"></i></a>
                                       
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