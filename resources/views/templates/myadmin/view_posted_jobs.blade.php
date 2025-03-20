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
                        <strong class="card-title">Job Details</strong>
                    </div>
                    <div class="card-body">
                        @if (Session::has('message'))
                            <div class="alert alert-warning">{{ Session::get('message') }}</div>
                        @endif
                        @if (Session::has('success'))
                            <div class="alert alert-success">{{ Session::get('success') }}</div>
                        @endif
                        <table id="bootstrap-data-table" class="table table-striped table-bordered">
                          <thead>
                            <tr>
                              <th>Sr.No</th>
                              <th>Job Details</th>
                             
                              <!--<th>Actions</th>-->
                            </tr>
                          </thead>
                          <tbody>
                              @if(!empty($jobs))
                              <?php  $i = 0; ?>
                                @foreach($jobs as $history)
                                  <?php $i++; ?>
                                  <tr>
                                      <td>{{$i}} </td>

                                      <td>
                                    

                                          <b>Job Role : </b> {{$history->job_role}}<br>
                                          <b>Job Type : </b> {{$history->job_type}}<br>
                                          <b>Job Locations : </b> {{$history->job_location}}<br>
                                          <b>Required Qualifications : </b> {{$history->required_qualification}}<br>
                                          <b>Salary : </b> {{$history->min_salary}} - {{$history->max_salary}} LPA<br>
                                          <b>Hiring Process : </b> {{$history->hiring_process}}<br>
                                          <b>WalkIn Interview : </b> {{$history->walkIn_Interview}}<br>
                                          <b>Job Options : </b> {{$history->job_option}}<br>
                                          <b>Experience : </b> {{$history->experience_from_years}} - {{$history->experience_to_years}}<br>
                                          <b>Passing Year : </b> {{$history->year_of_passing_from}} - {{$history->year_of_passing_to}}<br>
                                          <b>Skills : </b> {{$history->skills}}<br>
                                          <b>Gender : </b> {{$history->gender}}<br>
                                          <b>Job Description : </b> {{$history->job_description}}<br>
                                          <b>Percentage Required : </b> {{$history->percent}} / {{$history->cgpa}}<br>
                                      </td>

                                      
                                      <!--<td>-->
                                      <!-- <a href="{{ url('/delete-purchased-history',$history->id)}}" class="btn btn-danger" title="" data-toggle="tooltip" data-original-title="Delete" onclick="return confirm('Are you sure you want to delete this data ?');"><i class="fa fa-close"></i></a>-->
                                      <!-- </td>-->
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