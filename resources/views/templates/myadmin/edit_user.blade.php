@if (Session::has('AccessToken'))

   <?php $value = Session::get('AccessToken') ?>

@else

    <script>window.location.href = "MyDashboard";</script>

@endif



@if($wholesalers->isNotEmpty()) 

    @foreach($wholesalers as $wholesaler)

        @php

            $id = $wholesaler->id;

            $name = $wholesaler->name;

            $email = $wholesaler->email_id;

            $contact = $wholesaler->mobile_number;

            $register_date = $wholesaler->register_date;

            $profile_photo = $wholesaler->profile_photo;

            $pincode = $wholesaler->pincode;

            $address = $wholesaler->address;

            $status = $wholesaler->status;

        @endphp

    @endforeach

@endif



@extends('templates.myadmin.layout')

@section('content')

<div class="content mt-3">

    <div class="animated fadeIn">

        <div class="row">

            <div class="col-md-12">

                <div class="card">

                    <div class="card-header">

                        <strong class="card-title">Edit Employer</strong>

                    </div>

                     <div class="card-body">

                        <div class="col-md-12 col-lg-12">

                            <div class="card">

                                <div class="card-header"><strong>Profile</strong></div>

                                <div class="card-body card-block"> 

                                    {!! Form::open(['method' => 'POST', 'url' => 'update-wholesaler-status', 'enctype' => 'multipart/form-data']) !!}

                                        @csrf

                                        <input type="hidden" name="id" value="{{$id}}">

                                        <div class="form-group col-md-4">

                                            <label class="form-control-label">Name</label>

                                            <input type="text" id="name" name="name" placeholder="" class="form-control" value="{{$name}}" readonly>

                                        </div>

                                        

                                        <div class="form-group col-md-4">

                                            <label class="form-control-label">Email</label> 

                                            <input type="email" id="email" name="email" placeholder="" class="form-control" value="{{$email}}" readonly>

                                        </div>



                                        <div class="form-group col-md-4">

                                            <label class="form-control-label">Contact</label>

                                            <input type="text" id="contact" name="contact" placeholder="" class="form-control" value="{{$contact}}" readonly>

                                        </div>



                                        <div class="form-group col-md-6">

                                            <label class="form-control-label">Registration Date</label>

                                            <input type="text" id="city" name="city" placeholder="" class="form-control" value="{{$register_date}}" readonly>

                                        </div>



                                       <div class="form-group col-md-6">
                                            <label for="vat" class="form-control-label">Profile Image</label><br/>
                                            <img src="../images/profile_photo/{{$profile_photo}}" style="width:30%" >

                                        </div>



                                        <!--<div class="form-group col-md-12">-->

                                        <!--    <label class="form-control-label">Address</label>-->

                                        <!--    <textarea id="area" name="area" placeholder="" class="form-control" readonly>{{$address}}</textarea>-->

                                        <!--</div>-->



                                        <!--<div class="form-group col-md-6">-->

                                        <!--    <label class="form-control-label">Pincode</label>-->

                                        <!--    <input type="text" id="pincode" name="pincode" placeholder="" class="form-control" value="{{$pincode}}" readonly>-->

                                        <!--</div>-->



                                        <div class="form-group col-md-12">

                                            <label for="vat" class="form-control-label">Status</label> 

                                            <select class="form-control" title="select central looking" name="status" id="status" >

                                                <option value="Unblock" @if($status == "Unblock") selected @endif>Unblock</option>

                                                <option value="Block" @if($status == "Block") selected @endif>Block</option>

                                            </select>

                                            <small class="text-danger">{{ $errors->first('status') }}</small>

                                        </div>  

                                            

                                        <div class="card-footer col-md-12">  

                                            <button type="submit" class="btn btn-success btn-sm">

                                                <i class="fa fa-dot-circle-o"></i> Submit

                                            </button>

                                            <button class="btn btn-info btn-sm"><i class="fa fa-times-circle-o" aria-hidden="true"></i> <a href="{{url('wholesalers')}}">Cancel</a></button>

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