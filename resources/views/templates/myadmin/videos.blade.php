@if (Session::has('AccessToken'))
    <?php $value = Session::get('AccessToken'); ?>
@else
    <script>
        window.location.href = "MyDashboard";
    </script>
@endif

@extends('templates.myadmin.layout')

@section('content')
    <div class="content mt-3">

        <div class="animated fadeIn">

            <div class="row">

                <div class="col-md-12">

                    <div class="card">

                        <div class="card-header">

                            <strong class="card-title">Training Videos</strong>

                            <a href="{{ url('add-video') }}" class="right"><i class="fa fa-plus-square"></i> Add New</a>

                        </div>

                        <div class="card-body">

                            <div class="col-md-12 col-lg-12">

                                <div class="card">
                                    
                                    <div class="card-body">
                                        @include('templates.myadmin.messages')

                                        <!-- Videos Table -->
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Thumbnail</th>
                                                        <th>Video Name</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($videos as $index => $video)
                                                        <tr>
                                                            <!-- Index -->
                                                            <td>{{ $index + 1 }}</td>

                                                            <!-- Video Thumbnail -->
                                                            <td>
                                                                <img src="https://img.icons8.com/ios-filled/50/000000/video-thumbnail.png"
                                                                    alt="Thumbnail" width="80" height="80"
                                                                    style="cursor: pointer;" data-toggle="modal"
                                                                    data-target="#videoModal"
                                                                    onclick="showVideo('{{ asset('videos/training/' . $video->video) }}')">
                                                            </td>

                                                            <!-- Video Name -->
                                                            <td>{{ $video->video }}</td>

                                                            <!-- Actions -->
                                                            <td>
                                                                <form action="{{ url('delete-video', $video->id) }}"
                                                                    method="POST"
                                                                    onsubmit="return confirm('Are you sure you want to delete this video?');">
                                                                    @csrf
                                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                                        <i class="fa fa-trash"></i> Delete
                                                                    </button>
                                                                </form>
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="4" class="text-center">No videos uploaded yet.
                                                            </td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>

                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>


    <!-- Video Modal -->
    <div class="modal fade" id="videoModal" tabindex="-1" aria-labelledby="videoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Video Preview</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <video id="modalVideo" width="100%" controls>
                        <source src="" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </div>
            </div>
        </div>
    </div>

    <!-- Video Preview Script -->
    <script>
        function showVideo(videoUrl) {
            const video = document.getElementById('modalVideo');
            video.src = videoUrl;
            video.load();
        }
    </script>
@endsection
