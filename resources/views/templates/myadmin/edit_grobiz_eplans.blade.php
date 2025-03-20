@if (Session::has('AccessToken'))
   <?php $value = Session::get('AccessToken') ?>
@else
    <script>window.location.href = "MyDashboard";</script>
@endif
@extends('templates.myadmin.layout')
@section('content')
@if(!empty($offers))
    @foreach($offers as $offer)
        @php
            $id = $offer->id;
            $name = $offer->name;
            $price = $offer->price;
            $offer_percentage = $offer->offer_percentage;
            $validity = $offer->validity;
            $features = $offer->features;
            $description = $offer->description;
            $country_id = $offer->country_id;
            $validity_unit = $offer->validity_unit;
            $status = $offer->status;
            $user_limit = $offer->user_limit;
	    $sort_number = $offer->sort_number;
        @endphp
    @endforeach
@endif
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
                                <div class="card-header"><strong>Edit Plans</strong></div>
                                <div class="card-body card-block"> 
                                    {!! Form::open(['method' => 'POST', 'url' => 'update-ecomm-plans', 'enctype' => 'multipart/form-data']) !!}
                                        @csrf 
                                        <input type="hidden" name="id" value="{{$id}}"> 
                                           
                                            <div class="form-group col-md-6">

                                                <label class="form-control-label">Plan Name</label> 
                                                <input type="text" name="name" class="form-control" value="{{$name}}" >
                                                <small class="text-danger">{{ $errors->first('name') }}</small>

                                            </div>
                                                 <div class="form-group col-md-6">
                                                <label class="form-control-label">Price</label> 
                                                <input type="text" name="price" class="form-control" value="{{$price}}" >
                                                <small class="text-danger">{{ $errors->first('price') }}</small>

                                            </div>

                                            <div class="form-group col-md-6">



                                                <label class="form-control-label">Offer Percentage</label> 



                                                <input type="text" name="offer_percentage" class="form-control" value="{{$offer_percentage}}" >



                                                <small class="text-danger">{{ $errors->first('offer_percentage') }}</small>



                                            </div>
                                                 <div class="form-group col-md-6">



                                                <label class="form-control-label">Validity</label> 



                                                <input type="number" name="validity" class="form-control" value="{{$validity}}" >



                                                <small class="text-danger">{{ $errors->first('validity') }}</small>



                                            </div>
                                            <div class="form-group col-md-6">
                                            <label for="select" class=" form-control-label">Validity Unit</label>
                                            <select name="validity_unit" id="validity_unit" class="form-control">
                                                <option value="">Please select</option>
                                                        
                                                <option value="Day" @if($validity_unit == "Day") selected="" @endif>Day</option>
                                                <option value="Month" @if($validity_unit == "Month") selected="" @endif>Month</option>
                                                <option value="Year" @if($validity_unit == "Year") selected="" @endif>Year</option>


                                            </select>
                                            <small class="text-danger">{{ $errors->first('validity_unit') }}</small><br/>
                                        </div>
                                            <div class="form-group col-md-6">
                                                <label class="form-control-label">Features (Comma Seperated)</label> 
                                                <input type="text" name="features" class="form-control" value="{{$features}}" >
                                                <small class="text-danger">{{ $errors->first('features') }}</small>
                                            </div>
                                                 <div class="form-group col-md-6">
                                                <label class="form-control-label">Description (Comma Seperated)</label> 

                                                <textarea cols="80" id="description" name="description" rows="10" class="form-control">{{$description}}</textarea>
                                                <small class="text-danger">{{ $errors->first('description') }}</small>

                                            </div>
                                              <div class="form-group col-md-6">
                                            <label for="select" class=" form-control-label">Status</label>
                                            <select name="status" id="status" class="form-control">
                                                <option value="">Please select</option>
                                                        
                                                <option value="Active" @if($status == "Active") selected="" @endif>Active</option>
                                                <option value="Deactive" @if($status == "Deactive") selected="" @endif>Deactive</option>

                                            </select>
                                            <small class="text-danger">{{ $errors->first('status') }}</small><br/>
                                        </div>
                                                <div class="form-group col-md-6">

                                                <label for="vat" class="form-control-label">User Limit</label> 

                                                <input type="number" id="user_limit" name="user_limit"  class="form-control" value="{{$user_limit}}">

                                                <small class="text-danger">{{ $errors->first('user_limit') }}</small>
                                            </div>
					                        <div class="form-group col-md-6">

                                                <label for="vat" class="form-control-label">Sort Order</label> 

                                                <input type="number" id="sort_number" name="sort_number"  class="form-control" value="{{$sort_number}}">

                                                <small class="text-danger">{{ $errors->first('sort_number') }}</small>
                                            </div>

                             
                                        <div class="card-footer col-md-12">  
                                            <button type="submit" class="btn btn-success btn-sm">
                                                <i class="fa fa-dot-circle-o"></i> Submit
                                            </button>
                                            <button type="button" class="btn btn-info btn-sm"><i class="fa fa-times-circle-o" aria-hidden="true"></i> 
                                                <a href="{{url('ecomm-plans')}}"> Cancel</a>
                                            </button> 
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