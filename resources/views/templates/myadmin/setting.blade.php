@if (Session::has('AccessToken'))
   <?php $value = Session::get('AccessToken') ?>
@else
    <script>window.location.href = "MyDashboard";</script>
@endif

@if($settings->isNotEmpty())

    @foreach($settings as $setting)

        @php
        $contact = $setting->contact;
        $email = $setting->email;
        $address = $setting->address;
        $facebook = $setting->facebook;
        $youtube = $setting->youtube;
        $instagram = $setting->instagram;
        $twitter = $setting->twitter;
        $id = $setting->id;
        @endphp

    @endforeach

@else

    @php
    $contact = "";
    $email = "";
    $address = "";
    $facebook = "";
    $youtube = "";
    $instagram = "";
    $twitter = "";
    $id = 0;
     @endphp

@endif
<script src="{{asset('templates-assets/myadminweb/ckeditor/js/ckeditor/ckeditor.js')}}"></script>

<script src="{{asset('templates-assets/myadminweb/ckeditor/sample.js')}}"></script>

<link href="{{asset('templates-assets/myadminweb/ckeditor/sample.css')}}" rel="stylesheet"/>

@extends('templates.myadmin.layout')

@section('content')

<div class="content mt-3">

    <div class="animated fadeIn">

        <div class="row">

            <div class="col-md-12">

                <div class="card">

                    <div class="card-header">

                        <strong class="card-title">Settings</strong>

                    </div>

                    <div class="card-body">

                        <div class="col-md-12 col-lg-12">

                            <div class="card">

                                <div class="card-header"><strong>Update Settings</strong></div>

                                <div class="card-body card-block">

                                    @include('templates.myadmin.messages')

                                    {!! Form::open(['method' => 'POST', 'url' => 'update-setting', 'enctype' => 'multipart/form-data']) !!}

                                        @csrf

                                        <input type="hidden" name="id" value="{{$id}}">
                                         <div class="form-group col-md-4">

                                        <label for="vat" class="form-control-label">Contact</label>

                                        <input type="text" id="contact" name="contact" placeholder="" class="form-control" value="{{$contact}}" >

                                        <small class="text-danger">{{ $errors->first('contact') }}</small>

                                       </div>
                                        <div class="form-group col-md-4">

                                        <label for="vat" class="form-control-label">Email ID</label>

                                        <input type="text" id="email" name="email" placeholder="" class="form-control" value="{{$email}}" >

                                        <small class="text-danger">{{ $errors->first('email') }}</small>

                                       </div>
                                        <div class="form-group col-md-4">

                                        <label for="vat" class="form-control-label">Address</label>

                                        <input type="text" id="address" name="address" placeholder="" class="form-control" value="{{$address}}" >

                                        <small class="text-danger">{{ $errors->first('address') }}</small>

                                       </div>
                                        <div class="form-group col-md-4">

                                        <label for="vat" class="form-control-label">Facebook</label>

                                        <input type="text" id="facebook" name="facebook" placeholder="" class="form-control" value="{{$facebook}}" >

                                        <small class="text-danger">{{ $errors->first('facebook') }}</small>

                                        </div>

                                        <div class="form-group col-md-4">

                                        <label for="vat" class="form-control-label">Youtube</label>

                                        <input type="text" id="youtube" name="youtube" placeholder="" class="form-control" value="{{$youtube}}" >

                                        <small class="text-danger">{{ $errors->first('youtube') }}</small>

                                        </div>

                                        <div class="form-group col-md-4">

                                        <label for="vat" class="form-control-label">Instagram</label>

                                        <input type="text" id="instagram" name="instagram" placeholder="" class="form-control" value="{{$instagram}}" >

                                        <small class="text-danger">{{ $errors->first('instagram') }}</small>

                                       </div>
                                        <div class="form-group col-md-4">

                                        <label for="vat" class="form-control-label">Twitter</label>

                                        <input type="text" id="twitter" name="twitter" placeholder="" class="form-control" value="{{$twitter}}" >

                                        <small class="text-danger">{{ $errors->first('twitter') }}</small>

                                       </div>


                                        <div class="card-footer col-md-12">

                                            <button type="submit" class="btn btn-success btn-sm">

                                                <i class="fa fa-dot-circle-o"></i> Submit

                                            </button>



                                            <button type="button" class="btn btn-info btn-sm"><i class="fa fa-times-circle-o" aria-hidden="true"></i> <a href="{{url('setting')}}">Cancel</a></button>

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
 <script>
//<![CDATA[

   // This call can be placed at any point after the
   // <textarea>, or inside a <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"><script> in a
   // window.onload event handler.

   // Replace the <textarea id="editor"> with an CKEditor
   // instance, using default configurations.
   CKEDITOR.replace( 'about',
   {
       filebrowserBrowseUrl :"js/ckeditor/filemanager/browser/default/browser.html?Connector={{asset('templates-assets/myadminweb/ckeditor/js/ckeditor/filemanager/connectors/php/connector.php')}}",
       filebrowserImageBrowseUrl : "js/ckeditor/filemanager/browser/default/browser.html?Type=Image&Connector={{asset('templates-assets/myadminweb/ckeditor/js/ckeditor/filemanager/connectors/php/connector.php')}}",
       filebrowserFlashBrowseUrl :"js/ckeditor/filemanager/browser/default/browser.html?Type=Flash&Connector={{asset('templates-assets/myadminweb/ckeditor/js/ckeditor/filemanager/connectors/php/connector.php')}}",
       filebrowserUploadUrl  :"{{asset('templates-assets/myadminweb/ckeditor/js/ckeditor/filemanager/connectors/php/upload.php?Type=File')}}",
       filebrowserImageUploadUrl : "{{asset('templates-assets/myadminweb/ckeditor/js/ckeditor/filemanager/connectors/php/upload.php?Type=Image')}}",
       filebrowserFlashUploadUrl : "{{asset('templates-assets/myadminweb/ckeditor/js/ckeditor/filemanager/connectors/php/upload.php?Type=Flash')}}"
   });
</script>
@endsection
