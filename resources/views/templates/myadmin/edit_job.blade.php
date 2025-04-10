@if (Session::has('AccessToken'))
    <?php $value = Session::get('AccessToken'); ?>
@else
    <script>
        window.location.href = "MyDashboard";
    </script>
@endif

<style>
    select.form-control:not([size]):not([multiple]) {
        height: auto !important;
    }
</style>
@extends('templates.myadmin.layout')
@section('content')
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/css/bootstrap-select.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/js/bootstrap-select.js"></script>

    <div class="content mt-3">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <strong class="card-title"> Jobs</strong>
                        </div>
                        <div class="card-body">
                            <div class="col-md-12 col-lg-12">
                                <div class="card">
                                    <div class="card-header"><strong>Edit Job</strong></div>
                                    <div class="card-body card-block">
                                        {!! Form::open(['method' => 'POST', 'url' => 'update-job', 'enctype' => 'multipart/form-data']) !!}
                                        @csrf

                                        <input type="hidden" name="job_id" value="{{ $job->id }}">


                                        {{-- Job Role --}}
                                        <div class="form-group col-md-6">
                                            <label for="job_role">Job Role <span class="text-danger">*</span></label>
                                            <select name="job_role" class="form-control">
                                                <option value="" disabled {{ $job->job_role ? '' : 'selected' }}>--
                                                    Select Job Role --</option>
                                                @foreach ($professions as $profession)
                                                    <option value="{{ $profession->name }}"
                                                        {{ old('job_role') == $profession->name ? 'selected' : '' }}>
                                                        {{ $profession->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <small class="text-danger">{{ $errors->first('job_role') }}</small>
                                        </div>

                                        {{-- Job Type --}}
                                        <div class="form-group col-md-6">
                                            <label for="job_type">Job Type<span class="text-danger">*</span></label>
                                            <select name="job_type" class="form-control">
                                                <option value="" disabled {{ $job->job_type ? '' : 'selected' }}>--
                                                    Select Job Type --</option>
                                                @foreach (['Full time', 'Part time', 'Internship'] as $type)
                                                    <option value="{{ $type }}"
                                                        {{ $job->job_type == $type ? 'selected' : '' }}>{{ $type }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <small class="text-danger">{{ $errors->first('job_type') }}</small>
                                        </div>

                                        {{-- Job Location --}}
                                        <div class="form-group col-md-12">
                                            <label for="job_location">Job Locations<span
                                                    class="text-danger">*</span></label>
                                            <div class="row">
                                                @foreach ($job_locations as $location)
                                                    <div class="col-md-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="job_location[]" value="{{ $location->location }}"
                                                                id="location_{{ $loop->index }}"
                                                                {{ is_array(explode(',', $job->job_location)) && in_array(trim($location->location), array_map('trim', explode(',', $job->job_location))) ? 'checked' : '' }}>
                                                            <label class="form-check-label pl-4"
                                                                for="location_{{ $loop->index }}">
                                                                {{ $location->location }}
                                                            </label>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <small class="text-danger">{{ $errors->first('job_location') }}</small>
                                            <hr>
                                        </div>

                                        {{-- Required Qualification --}}
                                        <div class="form-group col-md-12">
                                            <label for="required_qualification">Required Qualification<span
                                                    class="text-danger">*</span></label>
                                            <div class="row">
                                                @foreach ($qualifications as $qualification)
                                                    <div class="col-md-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="required_qualification[]"
                                                                value="{{ $qualification->name }}"
                                                                id="qualification_{{ $loop->index }}"
                                                                {{ is_array(explode(',', $job->required_qualification)) && in_array(trim($qualification->name), array_map('trim', explode(',', $job->required_qualification))) ? 'checked' : '' }}>
                                                            <label class="form-check-label pl-4"
                                                                for="qualification_{{ $loop->index }}">
                                                                {{ $qualification->name }}
                                                            </label>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <small
                                                class="text-danger">{{ $errors->first('required_qualification') }}</small>
                                            <hr>
                                        </div>

                                        {{-- Min & Max Salary --}}
                                        <div class="form-group col-md-4">
                                            <label for="min_salary">Min Salary<span class="text-danger">*</span></label>
                                            <input type="number" name="min_salary" class="form-control"
                                                value="{{ $job->min_salary }}">
                                            <small class="text-danger">{{ $errors->first('min_salary') }}</small>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="max_salary">Max Salary<span class="text-danger">*</span></label>
                                            <input type="number" name="max_salary" class="form-control"
                                                value="{{ $job->max_salary }}">
                                            <small class="text-danger">{{ $errors->first('max_salary') }}</small>
                                        </div>

                                        {{-- Hide Salary --}}
                                        <div class="form-group col-md-4">
                                            <label for="hide_salary">Hide Salary?<span class="text-danger">*</span></label>
                                            <select name="hide_salary" class="form-control">
                                                <option value="" selected disabled>
                                                    -- Select --</option>
                                                <option value="yes" {{ $job->hide_salary == 'yes' ? 'selected' : '' }}>
                                                    Yes</option>
                                                <option value="no" {{ $job->hide_salary == 'no' ? 'selected' : '' }}>
                                                    No</option>
                                            </select>
                                            <small class="text-danger">{{ $errors->first('hide_salary') }}</small>
                                        </div>

                                        {{-- Incentives --}}
                                        <div class="form-group col-md-6">
                                            <label for="incentives">Incentives</label>
                                            <input type="text" name="incentives" class="form-control"
                                                value="{{ $job->incentives }}">
                                            <small class="text-danger">{{ $errors->first('incentives') }}</small>
                                        </div>

                                        {{-- Allowances --}}
                                        <div class="form-group col-md-6">
                                            <label for="allowances">Allowances</label>
                                            <input type="text" name="allowances" class="form-control"
                                                value="{{ $job->allowances }}">
                                            <small class="text-danger">{{ $errors->first('allowances') }}</small>
                                        </div>

                                        {{-- Hiring Process --}}
                                        <div class="form-group col-md-6">
                                            <label for="hiring_process">Hiring Process</label>
                                            <div class="row">
                                                @foreach (['Face to Face', 'Telephonic'] as $process)
                                                    <div class="col-md-6">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="hiring_process[]" value="{{ $process }}"
                                                                id="hiring_process_{{ $loop->index }}"
                                                                {{ is_array(explode(',', $job->hiring_process)) && in_array(trim($process), array_map('trim', explode(',', $job->hiring_process))) ? 'checked' : '' }}>
                                                            <label class="form-check-label pl-4"
                                                                for="hiring_process_{{ $loop->index }}">{{ $process }}</label>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <small class="text-danger">{{ $errors->first('hiring_process') }}</small>
                                            <hr>
                                        </div>

                                        {{-- Job Option --}}
                                        <div class="form-group col-md-6">
                                            <label for="job_option">Job Option</label>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="job_option"
                                                            value="This Job is Contract Jobs" id="job_option"
                                                            {{ $job->job_option == 'This Job is Contract Jobs' ? 'checked' : '' }}>
                                                        <label class="form-check-label pl-4" for="job_option">
                                                            This Job is Contract Jobs
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <small class="text-danger">{{ $errors->first('job_option') }}</small>
                                            <hr>
                                        </div>

                                        {{-- Walk-In Interview --}}
                                        <div class="form-group col-md-6">
                                            <label for="walkIn_Interview">Walk-In Interview<span
                                                    class="text-danger">*</span></label>
                                            <select name="walkIn_Interview" class="form-control" id="walkIn_Interview">
                                                <option value="" disabled
                                                    {{ $job->walkIn_Interview ? '' : 'selected' }}>-- Select Interview
                                                    Type --</option>
                                                <option value="Yes"
                                                    {{ $job->walkIn_Interview == 'Yes' ? 'selected' : '' }}>Yes</option>
                                                <option value="No"
                                                    {{ $job->walkIn_Interview == 'No' ? 'selected' : '' }}>No</option>
                                            </select>
                                            <small class="text-danger">{{ $errors->first('walkIn_Interview') }}</small>
                                        </div>

                                        {{-- Walk-In fields (conditionally shown via JS) --}}
                                        @php
                                            $walkInDates = isset($job) ? explode(',', $job->walk_in_date ?? '') : [''];
                                            $walkInTimes = isset($job) ? explode(',', $job->walk_in_time ?? '') : [''];
                                        @endphp

                                        <div id="walkin_fields"
                                            style="display: {{ (old('walkIn_Interview') ?? ($job->walkIn_Interview ?? '')) === 'Yes' ? 'block' : 'none' }};">
                                            <div class="form-group col-md-12">
                                                <label>Walk-In Dates & Times</label>
                                                <div id="walkin_datetime_container">
                                                    @foreach ($walkInDates as $index => $date)
                                                        <div class="row mb-2 walkin-datetime-row">
                                                            <div class="col-md-5">
                                                                <input type="date" name="walk_in_date[]"
                                                                    class="form-control" value="{{ $date }}">
                                                            </div>
                                                            <div class="col-md-5">
                                                                <input type="time" name="walk_in_time[]"
                                                                    class="form-control"
                                                                    value="{{ $walkInTimes[$index] ?? '' }}">
                                                            </div>
                                                            <div class="col-md-2">
                                                                @if ($index == 0)
                                                                    <button type="button"
                                                                        class="btn btn-success add-datetime">+</button>
                                                                @else
                                                                    <button type="button"
                                                                        class="btn btn-danger remove-datetime">-</button>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <small class="text-danger">{{ $errors->first('walk_in_date') }}</small>
                                                <small class="text-danger">{{ $errors->first('walk_in_time') }}</small>
                                            </div>

                                            {{-- Walk-In Location --}}
                                            <div class="form-group col-md-12">
                                                <label for="walkin_location">Walk-In Locations</label>
                                                <div class="row">
                                                    @foreach ($job_locations as $location)
                                                        <div class="col-md-3">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    name="walkin_location[]"
                                                                    value="{{ $location->location }}"
                                                                    id="walkin_{{ $loop->index }}"
                                                                    {{ in_array(trim($location->location), array_map('trim', explode(',', $job->walkin_location ?? ''))) ? 'checked' : '' }}>
                                                                <label class="form-check-label pl-4"
                                                                    for="walkin_{{ $loop->index }}">
                                                                    {{ $location->location }}
                                                                </label>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <small class="text-danger">{{ $errors->first('walkin_location') }}</small>
                                            </div>

                                        </div>

                                        {{-- Additional Information --}}
                                        <div class="col-md-12">
                                            <hr>
                                            <h4 class="text-center h-4">Additional Information</h4>

                                            <div class="row">
                                                {{-- No of Vacancies --}}
                                                <div class="form-group col-md-6">
                                                    <label for="no_of_vacancies">Number of Vacancies</label>
                                                    <input type="text" name="no_of_vacancies" class="form-control"
                                                        value="{{ $job->no_of_vacancies }}">
                                                </div>

                                                {{-- Gender --}}
                                                <div class="form-group col-md-6">
                                                    <label for="gender">Preferred Gender</label>
                                                    <select name="gender" class="form-control">
                                                        <option value="" disabled
                                                            {{ $job->gender ? '' : 'selected' }}>--Select Preferred
                                                            Gender--</option>
                                                        <option value="Male"
                                                            {{ $job->gender == 'Male' ? 'selected' : '' }}>Male
                                                        </option>
                                                        <option value="Female"
                                                            {{ $job->gender == 'Female' ? 'selected' : '' }}>Female
                                                        </option>
                                                    </select>
                                                </div>

                                                {{-- Experience --}}
                                                <div class="form-group col-md-6">
                                                    <label for="experience_from_years">Experience From (Years)</label>
                                                    <input type="text" name="experience_from_years"
                                                        class="form-control" value="{{ $job->experience_from_years }}">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="experience_to_years">Experience To (Years)</label>
                                                    <input type="text" name="experience_to_years" class="form-control"
                                                        value="{{ $job->experience_to_years }}">
                                                </div>

                                                {{-- Percent & CGPA --}}
                                                <div class="form-group col-md-6">
                                                    <label for="percent">Highest Qualification marks</label>
                                                    <input type="text" name="percent" placeholder="%"
                                                        class="form-control" value="{{ $job->percent }}">
                                                </div>

                                                <div class="form-group col-md-12">
                                                    <label for="skills">Skills</label>
                                                    <div class="row">
                                                        @foreach ($job_skills as $skill)
                                                            <div class="col-md-3">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="skills[]" value="{{ $skill->name }}"
                                                                        id="skill_{{ $loop->index }}"
                                                                        {{ is_array(explode(',', $job->skills)) && in_array(trim($skill->name), array_map('trim', explode(',', $job->skills))) ? 'checked' : '' }}>
                                                                    <label class="form-check-label pl-4"
                                                                        for="skill_{{ $loop->index }}">
                                                                        {{ $skill->name }}
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                    @error('skills')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>

                                            </div>
                                            <hr>
                                        </div>

                                        {{-- Job Description --}}
                                        <div class="form-group col-md-6">
                                            <label for="job_description">Job Description<span
                                                    class="text-danger">*</span></label>
                                            <textarea name="job_description" class="form-control" rows="4">{{ $job->job_description }}</textarea>
                                            <small class="text-danger">{{ $errors->first('job_description') }}</small>

                                        </div>

                                        {{-- Benefits --}}
                                        <div class="form-group col-md-6">
                                            <label for="benefits">Benefits (Comma Separated)</label>
                                            <textarea name="benefits" class="form-control" rows="4">{{ $job->benefits }}</textarea>
                                            <small class="text-danger">{{ $errors->first('benefits') }}</small>

                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="recruiter_contact_no">Recruiter Contact No<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="recruiter_contact_no" class="form-control"
                                                value="{{ $job->recruiter_contact_no }}"
                                                placeholder="Official Contact Preffered">
                                            <small
                                                class="text-danger">{{ $errors->first('recruiter_contact_no') }}</small>

                                        </div>

                                        {{-- Recruiter Info --}}
                                        <div class="form-group col-md-6">
                                            <label for="recruiter_email">Recruiter Email<span
                                                    class="text-danger">*</span></label>
                                            <input type="email" name="recruiter_email" class="form-control"
                                                value="{{ $job->recruiter_email }}"
                                                placeholder="Official Email Id Preferred">
                                            <small class="text-danger">{{ $errors->first('recruiter_email') }}</small>

                                        </div>

                                        {{-- Active Status --}}
                                        <div class="form-group col-md-6">
                                            <label for="active_status">Status</label>
                                            <select name="active_status" id="active_status" class="form-control">
                                                <option value="Active"
                                                    {{ old('active_status', $job->active_status ?? '') == 'Active' ? 'selected' : '' }}>
                                                    Active</option>
                                                <option value="Deactive"
                                                    {{ old('active_status', $job->active_status ?? '') == 'Deactive' ? 'selected' : '' }}>
                                                    Deactive</option>
                                            </select>
                                        </div>


                                        {{-- Submit --}}
                                        <div class="card-footer col-md-12 mt-3">
                                            <button type="submit" class="btn btn-success btn-sm">
                                                <i class="fa fa-dot-circle-o"></i> Submit
                                            </button>
                                            <a href="{{ url('jobs') }}" class="btn btn-info btn-sm">
                                                <i class="fa fa-times-circle-o" aria-hidden="true"></i> Cancel
                                            </a>
                                        </div>

                                        {!! Form::close() !!}
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
        document.addEventListener("DOMContentLoaded", function() {
            const walkInSelect = document.getElementById('walkIn_Interview');
            const walkinFields = document.getElementById('walkin_fields');
            const container = document.getElementById('walkin_datetime_container');

            function toggleWalkinFields() {
                walkinFields.style.display = (walkInSelect.value === 'Yes') ? 'block' : 'none';
            }

            // Initial toggle on load (handles old('walkIn_Interview') === 'Yes' or pre-filled values)
            toggleWalkinFields();

            // Toggle on change
            walkInSelect.addEventListener('change', toggleWalkinFields);

            // Add/Remove date-time fields dynamically
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('add-datetime')) {
                    const row = e.target.closest('.walkin-datetime-row');
                    const clone = row.cloneNode(true);

                    clone.querySelector('input[name="walk_in_date[]"]').value = '';
                    clone.querySelector('input[name="walk_in_time[]"]').value = '';

                    const button = clone.querySelector('.add-datetime');
                    button.classList.remove('btn-success', 'add-datetime');
                    button.classList.add('btn-danger', 'remove-datetime');
                    button.textContent = '-';

                    container.appendChild(clone);
                }

                if (e.target.classList.contains('remove-datetime')) {
                    e.target.closest('.walkin-datetime-row').remove();
                }
            });
        });
    </script>
@endsection
