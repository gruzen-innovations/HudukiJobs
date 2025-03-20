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
                        <strong class="card-title">Main Category</strong>
                        
                        <a href="{{url('add-maincategory')}}" class="right"><i class="fa fa-plus-square"></i>  Add Main Category</a>
                    </div>
                     @if (Session::has('success'))
                        <div class="alert alert-success">{{ Session::get('success') }}</div>
                     @endif
                    <div class="card-body">
                        <table id="bootstrap-data-table" class="table table-striped table-bordered table-responsive-sm">
                          <thead>
                            <tr>
                              <th>No</th>
                              <th>Main Category Name</th>
                              <th>Main Category Code</th>
                              <th>Status</th>
                              <th>Sort(Set Priority)</th> 
                              <th>Image</th>
                              <th>Actions</th>
                            </tr>
                          </thead>
                          <tbody>
                            @if(!empty($main_categories))
                            
                              @php $i = 0 @endphp
                              @foreach($main_categories as $maincategory)
                                @php $i++;  @endphp
                                  <tr>
                                      
                                      <td>{{$i}}</td>
                                      <td>{{$maincategory->main_category_name_english}}</td>
                                      <td>{{$maincategory->code}}</td>
                                      <td>{{$maincategory->status}}</td>
                                      <td>{{$maincategory->sort_number}}</td> 
                                     <td>
                                        <img src="images/maincategory/{{$maincategory->image}}" style="width: 150px;height:100px"/>
                                        
                                        </td>
                                      <td>
                                           <a href="{{ url('edit_main_category',$maincategory->id)}}" class="btn btn-primary" title="" data-toggle="tooltip" data-original-title="Edit"><i class="fa fa-edit"></i></a>
                                        <a onclick="return confirm('Are You Sure to delete selected data?')" href="{{url('delete-main-category')}}/{{$maincategory->id}}" class="btn btn-danger" title="" data-toggle="tooltip" data-original-title="Delete"><i class="fa fa-close"></i>
                                         
                                            
                                        </a>
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