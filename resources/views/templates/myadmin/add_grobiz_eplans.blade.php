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
                        <strong class="card-title">Subscriptions Plans</strong>
                    </div>
                     <div class="card-body">
                        <div class="col-md-12 col-lg-12">
                            <div class="card">
                                <div class="card-header"><strong>Add Subscriptions Plans</strong></div>
                                <div class="card-body card-block"> 
                                    {!! Form::open(['method' => 'POST', 'url' => 'store-ecomm-plans', 'enctype' => 'multipart/form-data']) !!}
                                        @csrf  

                                          <div class="form-group col-md-6">

                                                <label for="vat" class="form-control-label">Plan Name</label> 

                                                <input type="text" id="name" name="name"  class="form-control" value="">

                                                <small class="text-danger">{{ $errors->first('name') }}</small>
                                            </div>
                                       
                                     
                                          <div class="form-group col-md-6">

                                                <label for="vat" class="form-control-label">Price</label> 

                                                <input type="text" id="price" name="price"  class="form-control" value="">

                                                <small class="text-danger">{{ $errors->first('price') }}</small>
                                            </div>
                                            <div class="form-group col-md-6">

                                                <label for="vat" class="form-control-label">Offer Percentage</label> 

                                                <input type="text" id="offer_percentage" name="offer_percentage"  class="form-control" value="">

                                                <small class="text-danger">{{ $errors->first('offer_percentage') }}</small>
                                            </div>
                                       
                                     
                                          <div class="form-group col-md-6">

                                                <label for="vat" class="form-control-label">Validity</label> 

                                                <input type="number" id="validity" name="validity"  class="form-control" value="">

                                                <small class="text-danger">{{ $errors->first('validity') }}</small>
                                            </div>
                                         <div class="form-group col-md-6">
											
											<label for="vat" class="form-control-label">Validity Unit</label>
											
											<select name="validity_unit" id="validity_unit" class="form-control">
											
                                                       					 <option value="">Please select</option>
                                                         
                                                        				<option value="Day">Day</option>
                                                   
                            											<option value="Month">Month</option>
                            										    <option value="Year">Year</option>
                                                    
                                              					  </select>
											
											</div>
                                             <div class="form-group col-md-6">

                                                <label for="vat" class="form-control-label">Features (Comma Seperated)</label> 

                                                <input type="text" id="features" name="features"  class="form-control" value="">

                                                <small class="text-danger">{{ $errors->first('features') }}</small>
                                            </div>
                                             <div class="form-group col-md-6">

                                                <label for="vat" class="form-control-label">User Limit</label> 

                                                <input type="number" id="user_limit" name="user_limit"  class="form-control" value="">

                                                <small class="text-danger">{{ $errors->first('user_limit') }}</small>
                                            </div>
                                             <div class="form-group col-md-6">

                                                <label for="vat" class="form-control-label">Description (Comma Seperated)</label> 

                            
                                                 <textarea cols="80" id="description" name="description" rows="10" class="form-control" placeholder="Description" ></textarea>
                                                <small class="text-danger">{{ $errors->first('description') }}</small>
                                            </div>
  					                         <div class="form-group col-md-6">

                                                <label for="vat" class="form-control-label">Sort Order</label> 

                                                <input type="number" id="sort_number" name="sort_number"  class="form-control" value="">

                                                <small class="text-danger">{{ $errors->first('sort_number') }}</small>
                                            </div>

                                        <div class="card-footer col-md-12">  
                                            <button type="submit" class="btn btn-success btn-sm">
                                                <i class="fa fa-dot-circle-o"></i> Submit
                                            </button>
                                            <button type="button" class="btn btn-info btn-sm"><i class="fa fa-times-circle-o" aria-hidden="true"></i> <a href="{{url('ecomm-plans')}}">Cancel</a></button> 
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>                                      
@endsection