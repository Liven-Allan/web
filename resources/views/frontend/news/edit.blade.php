@extends('frontend.master')

@section('content')
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10">
                <div class="card shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h4 class="mb-0 text-primary">Edit News Item</h4>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('news.update', $news) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-8">
                                    <div class="mb-4">
                                        <label for="title" class="form-label fw-bold">Title</label>
                                        <input type="text"
                                            class="form-control form-control-lg @error('title') is-invalid @enderror"
                                            id="title" name="title" value="{{ old('title', $news->title) }}" required>
                                        @error('title')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-4">
                                        <label for="description" class="form-label fw-bold">Description</label>
                                        <textarea class="form-control @error('description') is-invalid @enderror"
                                            id="description" name="description" rows="6"
                                            required>{{ old('description', $news->description) }}</textarea>
                                        @error('description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-4">
                                                <label for="date" class="form-label fw-bold">Date</label>
                                                <input type="date" class="form-control @error('date') is-invalid @enderror"
                                                    id="date" name="date"
                                                    value="{{ old('date', $news->date->format('Y-m-d')) }}" required>
                                                @error('date')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-4">
                                                <label for="url" class="form-label fw-bold">URL (Optional)</label>
                                                <input type="url" class="form-control @error('url') is-invalid @enderror"
                                                    id="url" name="url" value="{{ old('url', $news->url) }}">
                                                @error('url')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-4">
                                        <label for="image" class="form-label fw-bold">Image (Optional)</label>
                                        <div class="image-upload-container border rounded p-3 text-center">
                                            <div id="image-preview" class="mb-3">
                                                <img src="{{ $news->image ? asset('storage/' . $news->image) : asset('images/default-news.jpg') }}"
                                                    alt="Preview" class="img-fluid rounded"
                                                    style="max-height: 200px; width: 100%; object-fit: cover;">
                                            </div>
                                            <input type="file" class="form-control @error('image') is-invalid @enderror"
                                                id="image" name="image" accept="image/*" onchange="previewImage(this)">
                                            @error('image')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end gap-2 mt-4">
                                <a href="{{ route('news.index') }}" class="btn btn-light px-4">Cancel</a>
                                <button type="submit" class="btn btn-primary px-4">Update News Item</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .form-control {
            border-radius: 0.5rem;
        }

        .form-control:focus {
            box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
            border-color: #28a745;
        }

        .image-upload-container {
            background-color: #f8f9fa;
            border-radius: 0.5rem;
        }

        .btn {
            border-radius: 0.5rem;
            font-weight: 500;
        }

        .btn-primary {
            background-color: #28a745;
            border-color: #28a745;
        }

        .btn-primary:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }
    </style>

    <script>
        function previewImage(input) {
            const preview = document.querySelector('#image-preview img');
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    preview.src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection