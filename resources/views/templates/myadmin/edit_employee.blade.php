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

                        <strong class="card-title">Edit Employee</strong>

                    </div>

                     <div class="card-body">

                        <div class="col-md-12 col-lg-12">

                            <div class="card">

                                <div class="card-header"><strong>Profile</strong></div>

                                <div class="card-body card-block"> 

                                    {!! Form::open(['method' => 'POST', 'url' => 'update-employee-status', 'enctype' => 'multipart/form-data']) !!}

                                        @csrf

                                        <input type="hidden" name="id" value="{{$id}}">

                                        <div class="form-group col-md-6">

                                            <label class="form-control-label">Name</label>

                                            <input type="text" id="name" name="name" placeholder="" class="form-control" value="{{$name}}" readonly>

                                        </div>

                                        

                                        <div class="form-group col-md-6">

                                            <label class="form-control-label">Email</label> 

                                            <input type="email" id="email" name="email" placeholder="" class="form-control" value="{{$email}}" readonly>

                                        </div>



                                        <div class="form-group col-md-6">

                                            <label class="form-control-label">Contact</label>

                                            <input type="text" id="contact" name="contact" placeholder="" class="form-control" value="{{$contact}}" readonly>

                                        </div>



                                        <div class="form-group col-md-6">

                                            <label class="form-control-label">Registration Date</label>

                                            <input type="text" id="city" name="city" placeholder="" class="form-control" value="{{$register_date}}" readonly>

                                        </div>



                                       <div class="form-group col-md-4">
                                            <label for="vat" class="form-control-label">Profile Image</label><br/>
                                            <img src="../images/profile_photo/{{$profile_photo}}" style="width:30%" >

                                        </div>

                                    @if($emp_details->isNotEmpty())

                                      @foreach($emp_details as $emp)

                                        @if($id == $emp->employee_auto_id)
                                            <div class="form-group col-md-4">
                                            <label for="vat" class="form-control-label">Resume</label><br/>
                                            <img src="../images/employee_details/{{$emp->resume}}" style="width:30%" >

                                        </div>
                                            <div class="form-group col-md-4">
                                            <label for="vat" class="form-control-label">Video Profile</label><br/>
                                            <img src="../images/employee_details/{{$emp->video_resume}}" style="width:30%" >

                                        </div>

                                        <div class="form-group col-md-4">

                                            <label class="form-control-label">First Name</label> 

                                            <input type="email" id="email" name="email" placeholder="" class="form-control" value="{{$emp->first_name}}" readonly>

                                        </div>



                                        <div class="form-group col-md-4">

                                            <label class="form-control-label">Middle Name</label>

                                            <input type="text" id="contact" name="contact" placeholder="" class="form-control" value="{{$emp->middle_name}}" readonly>

                                        </div>
                                        
                                        <div class="form-group col-md-4">

                                            <label class="form-control-label">Last Name</label>

                                            <input type="text" id="contact" name="contact" placeholder="" class="form-control" value="{{$emp->last_name}}" readonly>

                                        </div>
                                        <div class="form-group col-md-4">

                                            <label class="form-control-label">Gender</label> 

                                            <input type="email" id="email" name="email" placeholder="" class="form-control" value="{{$emp->gender}}" readonly>

                                        </div>



                                        <div class="form-group col-md-4">

                                            <label class="form-control-label">Date of Birth</label>

                                            <input type="text" id="contact" name="contact" placeholder="" class="form-control" value="{{$emp->date_of_birth}}" readonly>

                                        </div>
                                        
                                        <div class="form-group col-md-4">

                                            <label class="form-control-label">City</label>

                                            <input type="text" id="contact" name="contact" placeholder="" class="form-control" value="{{$emp->city}}" readonly>

                                        </div>
                                         <div class="form-group col-md-6">

                                            <label class="form-control-label">Pincode</label>

                                            <input type="text" id="contact" name="contact" placeholder="" class="form-control" value="{{$emp->pincode}}" readonly>

                                        </div>
                                         <div class="form-group col-md-6">

                                            <label class="form-control-label">Highest Qualification</label>

                                            <input type="text" id="contact" name="contact" placeholder="" class="form-control" value="{{$emp->highest_qualification}}" readonly>

                                        </div>
                                         <div class="form-group col-md-6">

                                            <label class="form-control-label">Address</label>

                                            <input type="text" id="contact" name="contact" placeholder="" class="form-control" value="{{$emp->address}}" readonly>

                                        </div>
                                         <div class="form-group col-md-6">

                                            <label class="form-control-label">Course</label>

                                            <input type="text" id="contact" name="contact" placeholder="" class="form-control" value="{{$emp->course}}" readonly>

                                        </div>
                                         <div class="form-group col-md-6">

                                            <label class="form-control-label">University</label>

                                            <input type="text" id="contact" name="contact" placeholder="" class="form-control" value="{{$emp->university}}" readonly>

                                        </div>
                                             <div class="form-group col-md-6">

                                            <label class="form-control-label">Year of Completion</label>

                                            <input type="text" id="contact" name="contact" placeholder="" class="form-control" value="{{$emp->year_of_completion}}" readonly>

                                        </div>
                                         <div class="form-group col-md-6">

                                            <label class="form-control-label">Marks/Percentage</label>

                                            <input type="text" id="contact" name="contact" placeholder="" class="form-control" value="{{$emp->marks_or_percentage}}" readonly>

                                        </div>
                                         <div class="form-group col-md-6">

                                            <label class="form-control-label">Fresher/Experienced</label>

                                            <input type="text" id="contact" name="contact" placeholder="" class="form-control" value="{{$emp->fresher_or_experienced}}" readonly>

                                        </div>
                                        <div class="form-group col-md-6">

                                            <label class="form-control-label">Skills</label>

                                            <input type="text" id="contact" name="contact" placeholder="" class="form-control" value="{{$emp->skills}}" readonly>

                                        </div>
                                         <div class="form-group col-md-6">

                                            <label class="form-control-label">Job Role</label>

                                            <input type="text" id="contact" name="contact" placeholder="" class="form-control" value="{{$emp->prefered_jobrole}}" readonly>

                                        </div>
                                          <div class="form-group col-md-3">

                                            <label class="form-control-label">Job Locations</label>

                                            <input type="text" id="contact" name="contact" placeholder="" class="form-control" value="{{$emp->prefered_job_locaion}}" readonly>

                                        </div>
                                         <div class="form-group col-md-3">

                                            <label class="form-control-label">Field of Experience</label>

                                            <input type="text" id="contact" name="contact" placeholder="" class="form-control" value="{{$emp->field_of_experience}}" readonly>

                                        </div>
                                        <div class="form-group col-md-3">

                                            <label class="form-control-label">Total Year Of Experience</label>

                                            <input type="text" id="contact" name="contact" placeholder="" class="form-control" value="{{$emp->total_year_experience}}" readonly>

                                        </div>
                                         <div class="form-group col-md-3">

                                            <label class="form-control-label">Project Count</label>

                                            <input type="text" id="contact" name="contact" placeholder="" class="form-control" value="{{$emp->project_count}}" readonly>

                                        </div>
                                        <div class="form-group col-md-6">

                                            <label class="form-control-label">Project Details</label>

                                            <input type="text" id="contact" name="contact" placeholder="" class="form-control" value="{{$emp->description_of_project}}" readonly>

                                        </div>
                                         <div class="form-group col-md-6">

                                            <label class="form-control-label">Advance Skills</label>

                                            <input type="text" id="contact" name="contact" placeholder="" class="form-control" value="{{$emp->advance_skills}}" readonly>

                                        </div>
                                        <div class="form-group col-md-6">

                                            <label class="form-control-label">Current CTC</label>

                                            <input type="text" id="contact" name="contact" placeholder="" class="form-control" value="{{$emp->current_ctc}}" readonly>

                                        </div>
                                         <div class="form-group col-md-6">

                                            <label class="form-control-label">Expected CTC</label>

                                            <input type="text" id="contact" name="contact" placeholder="" class="form-control" value="{{$emp->expected_ctc}}" readonly>
                                             </div>

                                            @endif

                                      @endforeach

                                    @endif

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

                                            <button class="btn btn-info btn-sm"><i class="fa fa-times-circle-o" aria-hidden="true"></i> <a href="{{url('employee')}}">Cancel</a></button>

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