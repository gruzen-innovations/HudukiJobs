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

                        <strong class="card-title">Brands</strong>

                        <a href="{{url('add_brand')}}" class="right"><i class="fa fa-plus-square"></i> Add Brand</a>

                    </div>

                    <div class="card-body">

                        @if (Session::has('message'))

                            <div class="alert alert-warning">{{ Session::get('message') }}</div>

                        @endif

                        @if (Session::has('success'))

                            <div class="alert alert-success">{{ Session::get('success') }}</div>

                        @endif

                        <table id="bootstrap-data-table" class="table table-striped table-bordered table-responsive-sm">

                          <thead>

                            <tr>

                              <th>Sr.No</th>

                              <th>Main Category</th> 

                              <th>Brand Name</th>

                              <th>Brand Image</th>

                              <th>Actions</th>

                            </tr>

                          </thead>

                          <tbody>

                              @if(!empty($brands))

                              <?php $i=0; ?>

                              @foreach($brands as $brands)

                                <?php $i++; ?>

                                <tr>

                                    <td>{{$i}}</td>

                                     <td>{{$brands->main_category_name_english}}</td> 

                                    <td>{{$brands->name}}</td>

                                   
                                    <td>
                                    
                                        
                                        <img src="images/brands/{{$brands->bimage}}" style="width: 100px;height:100px"/>
                                      
                                      </td>
                                    <td>
                               
                                    <a href="edit_brand?id={{$brands->brand_id}}" class="btn btn-primary" title="" data-toggle="tooltip" data-original-title="Edit"><i class="fa fa-pencil"></i></a>
                                  <a onclick="return confirm('Are You Sure to delete selected data?')" href="{{url('delete-brand')}}/{{$brands->id}}" class="btn btn-danger" title="" data-toggle="tooltip" data-original-title="Delete"><i class="fa fa-close"></i></a>
                                 
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