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

                            <strong class="card-title">Jobs</strong>

                            <a href="{{ url('add-job') }}" class="right"><i class="fa fa-plus-square"></i> Add Job</a>

                        </div>

                        @if (Session::has('success'))
                            <div class="alert alert-success">{{ Session::get('success') }}</div>
                        @endif

                        @if (Session::has('error'))
                            <div class="alert alert-danger">{{ Session::get('error') }}</div>
                        @endif

                        <div class="card-body">

                            <table class="table table-striped table-bordered">

                                <thead>

                                    <tr>

                                        <th>No</th>

                                        <th>Job Role</th>
                                        <th>Job Type</th>
                                        <th>Location(s)</th>
                                        <th>Recruiter Contact</th>
                                        <th>Status</th>
                                        <th>Actions</th>

                                    </tr>

                                </thead>

                                <tbody>

                                    @if (!empty($jobs))
                                        @php $i = 0 @endphp

                                        @foreach ($jobs as $job)
                                            @php $i++; @endphp

                                            <tr>

                                                <td>{{ $i }}</td>

                                                <td>{{ $job->job_role }}</td>
                                                <td>{{ $job->job_type }}</td>
                                                <td>
                                                    @foreach (explode(',', $job->job_location) as $loc)
                                                        <span class="badge badge-info">{{ trim($loc) }}</span>
                                                    @endforeach
                                                </td>
                                                <td>
                                                    {{ $job->recruiter_email }}
                                                    <br>
                                                    {{ $job->recruiter_contact_no }}
                                                </td>
                                                <td>
                                                    <span
                                                        class="badge badge-{{ $job->active_status == 'Active' ? 'success' : 'secondary' }}">
                                                        {{ $job->active_status }}
                                                    </span>
                                                </td>

                                                <td>

                                                    <a href="{{ url('edit-job', $job->id) }}" class="btn btn-primary"
                                                        title="" data-toggle="tooltip" data-original-title="Edit"><i
                                                            class="fa fa-edit"></i></a>
                                                    <a onclick="return confirm('Are You Sure, to delete selected data?')"
                                                        href="{{ url('delete-job') }}/{{ $job->id }}"
                                                        class="btn btn-danger" title="" data-toggle="tooltip"
                                                        data-original-title="Delete"><i class="fa fa-close"></i></a>

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
