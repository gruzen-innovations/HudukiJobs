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
                    <div class="card-header"><strong>Upload Video</strong></div>

                    <div class="card-body">
                        @include('templates.myadmin.messages')

                        <!-- Display Validation Errors -->
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Video Upload Form -->
                        <form action="{{ url('store-video') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group">
                                <label for="video">Select Video File</label>
                                <input type="file" name="video" id="video" class="form-control" accept="video/*" required>
                            </div>

                            <div class="form-group">
                                <label for="video">Select Thumbnail Image File</label>
                                <input type="file" name="thumbnail" id="thumbnail" class="form-control" accept="image/*" required>
                            </div>

                            <button type="submit" class="btn btn-primary">Upload Video</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>

@endsection
