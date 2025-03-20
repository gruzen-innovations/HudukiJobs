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

                        <strong class="card-title">Notifications</strong>

                    </div>

                    <div class="card-body">

                        <div class="col-md-12 col-lg-12">

                            <div class="card">

                                <div class="card-header"><strong>Add Notifications</strong></div>

                                    <div class="card-body card-block"> 

                                        {!! Form::open(['method' => 'POST', 'url' => 'addnotify']) !!}

                                            <div class="form-group col-md-12">

                                                <label for="vat" class=" form-control-label">Title</label> 

                                                 <input type="text" id="title" name="title" placeholder="Title" class="form-control" value="{{old('title')}}">

                                                <small class="text-danger">{{ $errors->first('title') }}</small>

                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="vat" class=" form-control-label">Message</label> 
                                                <textarea id="message" name="message" placeholder="Message" class="form-control" cols="40" rows="10" value="{{old('message')}}" style="margin-top: 0px;margin-bottom: 0px;height: 80px;"></textarea>
                                                <small class="text-danger">{{ $errors->first('message') }}</small>
                                            </div>


                                        </div>
                                          

                                            <div class="card-footer">  

                                                <button type="submit" class="btn btn-success btn-sm">

                                                    <i class="fa fa-dot-circle-o"></i> Submit

                                                </button>

                                                <button class="btn btn-info btn-sm"><i class="fa fa-times-circle-o" aria-hidden="true"></i> <a href="notifications">Cancel</a></button> 

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

    </div><!-- .animated -->

</div><!-- .content -->

@endsection