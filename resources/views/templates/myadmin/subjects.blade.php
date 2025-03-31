@extends('templates.myadmin.layout')
@section('content')

    <style>
        @media (min-width: 576px) {
            .navbar-expand-sm {
                flex-wrap: wrap !important;
                justify-content: flex-start;
            }

            a {
                text-decoration: none !important;
            }
        }
    </style>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <div class="container-">
        <h4>Subjects</h4>

        <!-- Trigger Offcanvas for Adding Catalogue -->
        <div class="my-4 text-start">


            <button type="button" class="btn btn-primary text-white ms-2" data-bs-toggle="offcanvas"
                data-bs-target="#addCategoryCanvas" aria-controls="addCategoryCanvas">
                <i class="fa fa-plus" title="Add Subject"></i> Add Subject
            </button>
        </div>

        <!-- Alert Messages -->
        @include('templates.myadmin.messages')

        <!-- Categories Table -->
        <div class="table-responsive">
            <table class="table table-striped table-bordered" id="data-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>PDF</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($catalogues->isNotEmpty())
                        @foreach ($catalogues as $index => $catalogue)
                            <tr>
                                <th>{{ $index + 1 }}</th>
                                <td>{{ $catalogue->subject }}</td>
                                <td>{{ $catalogue->description }}</td>
                                <td>
                                    @if ($catalogue->pdf->isNotEmpty())
                                        @foreach ($catalogue->pdf as $sub_index => $pdf)
                                            {{ $sub_index + 1 }})
                                            <a href="{{ asset('images/pdf/' . $pdf->pdf) }}" target="_blank"
                                                class="btn btn-info btn-sm">
                                                <i class="fa fa-file-pdf"></i> View PDF
                                            </a>

                                            <!-- Delete PDF Button -->
                                            <a href="{{ url('delete-subject-pdf/' . $pdf->id) }}"
                                                onclick="return confirm('Are you sure you want to delete this PDF? This action cannot be undone.');"
                                                style="display:inline;">
                                                <button type="button" class="btn btn-danger btn-sm" title="Delete PDF">
                                                    <i class="fa fa-trash"></i> Delete PDF
                                                </button>
                                            </a>

                                            <hr>
                                        @endforeach
                                    @endif
                                    <div class="pt-2">
                                        <!-- Simple Add PDF Form -->
                                        <form action="{{ url('add-subject-pdf') }}" method="POST"
                                            enctype="multipart/form-data" style="display:inline;">
                                            @csrf
                                            <input type="hidden" name="subject_id" value="{{ $catalogue->id }}">

                                            <div class="mb-2">
                                                <input type="file" name="pdf" class="form-control"
                                                    accept="application/pdf" required>
                                            </div>
                                            <button type="submit" class="btn btn-warning btn-sm">
                                                <i class="fa fa-upload"></i> Add PDF
                                            </button>
                                        </form>
                                    </div>

                                </td>
                                <td>
                                    <!-- Update catalogue Button -->
                                    <button class="btn btn-warning btn-sm" data-bs-toggle="offcanvas"
                                        data-bs-target="#editCategoryCanvas{{ $catalogue->id }}"
                                        aria-controls="editCategoryCanvas{{ $catalogue->id }}" title="Edit Catalogue">
                                        <i class="fa fa-edit"></i> Edit
                                    </button>

                                    <!-- Delete catalogue Button -->
                                    <a href="{{ url('delete-subject/' . $catalogue->id) }}"
                                        onclick="return confirm('Are you sure you want to delete this catalogue? This action cannot be undone.');">
                                        <button class="btn btn-danger btn-sm" title="Delete Catalogue">
                                            <i class="fa fa-trash"></i> Delete
                                        </button>
                                    </a>

                                </td>
                            </tr>

                            <!-- Offcanvas Edit Category -->
                            <div class="offcanvas offcanvas-end mt-5 rounded" id="editCategoryCanvas{{ $catalogue->id }}"
                                tabindex="-1" aria-labelledby="editCategoryCanvasLabel{{ $catalogue->id }}">
                                <div class="offcanvas-header">
                                    <h5 id="editCategoryCanvasLabel{{ $catalogue->id }}">Edit Subject</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas"
                                        aria-label="Close"></button>
                                </div>
                                <div class="offcanvas-body">
                                    <form action="{{ url('update-subject') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="subject_id" value="{{ $catalogue->id }}">

                                        <div class="mb-3">
                                            <label for="subject" class="form-label">Subject Name</label>
                                            <input type="text" name="subject" id="subject" class="form-control"
                                                required placeholder="Enter Subject Name"
                                                value="{{ old('subject', $catalogue->subject) }}">

                                            <label for="description" class="form-label">Description</label>
                                            <textarea name="description" id="description" class="form-control" required placeholder="Enter Description"
                                                rows="4">{{ old('description', $catalogue->description) }}</textarea>
                                        </div>
                                        <div class="d-grid">
                                            <button type="submit" class="btn btn-primary btn-sm">Update</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>

        <!-- Offcanvas Add Category -->
        <div class="offcanvas offcanvas-end mt-5 rounded" id="addCategoryCanvas" tabindex="-1"
            aria-labelledby="addCategoryCanvasLabel">
            <div class="offcanvas-header">
                <h5 id="addCategoryCanvasLabel">Add Subject</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <form action="{{ url('/add-subject') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="subject" class="form-label">Subject Name</label>
                        <input type="text" name="subject" id="subject" class="form-control" required
                            placeholder="Enter Subject Name">

                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" id="description" class="form-control" required placeholder="Enter Description"
                            rows="4"></textarea>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-sm">Save</button>
                    </div>
                </form>
            </div>
        </div>

    </div>

    <!-- Ensure Bootstrap is Properly Initialized -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Auto-hide success message after 5 seconds
            const successMessage = document.getElementById('success');
            if (successMessage) {
                setTimeout(() => {
                    successMessage.remove();
                }, 5000);
            }

            // Close the offcanvas after successful submission
            @if (Session::has('success'))
                const offcanvasEl = document.getElementById('addCategoryCanvas');
                const bsOffcanvas = bootstrap.Offcanvas.getInstance(offcanvasEl);
                if (bsOffcanvas) {
                    bsOffcanvas.hide();
                }
            @endif
        });
    </script>

@endsection
