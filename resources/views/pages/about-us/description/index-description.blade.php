@extends('layouts.main')
@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
@endsection
@section('content')
    <div class="container my-4">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card shadow-sm">
            <div class="card-body">
                <h4 class="card-title mb-1">{{ $section ? 'Edit' : 'Tambah' }}</h4>
                <form
                    action="{{ $section ? route('section.about.description.put', $section->id) : route('section.about.description.store') }}"
                    method="POST" enctype="multipart/form-data">
                    @csrf
                    @if ($section)
                        @method('PUT')
                    @endif

                    <div class="row mb-4">
                        @if ($section && $section->img)
                            <div class="col-md-12 text-center">
                                <img src="{{ asset('storage/' . $section->img) }}" class="img-thumbnail"
                                    alt="Gambar Pertama">
                                <p class="text-muted mt-1">Image</p>
                            </div>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label for="img" class="form-label">Upload Gambar</label>
                        <input type="file" name="img" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="subtitle" class="form-label">Headline</label>
                        <textarea name="subtitle1" id="subtitle1" class="form-control mb-3">
                            {{ old('subtitle1', $section->subtitle1 ?? '') }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        {{ $section ? 'Perbarui Data' : 'Simpan Data' }}
                    </button>
                </form>
            </div>
        </div>

    </div>
@endsection

@section('js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#subtitle1').summernote({
                height: 250,
                tabsize: 2,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline', 'clear']],
                    ['fontname', ['fontname']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });
        });
    </script>
@endsection
