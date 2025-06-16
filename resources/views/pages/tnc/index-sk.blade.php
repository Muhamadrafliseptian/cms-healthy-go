@extends('layouts.main')

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
                <form action="{{ $section ? route('section.tnc.sk.put', $section->id) : route('section.tnc.sk.store') }}"
                    method="POST" enctype="multipart/form-data">
                    @csrf
                    @if ($section)
                        @method('PUT')
                    @endif
                    <h4 class="card-title mb-3">{{ $section ? 'Syarat dan Ketentuan' : 'Syarat dan Ketentuan' }}</h4>

                    <div class="mb-3">
                        <label for="title" class="form-label">Headline</label>
                        <textarea name="title" class="form-control ckeditor">{{ old('title', $section->title ?? '') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="subtitle1" class="form-label">Content</label>
                        <textarea name="subtitle1" class="form-control ckeditor">{{ old('subtitle1', $section->subtitle1 ?? '') }}</textarea>
                    </div>
                    <h4 class="card-title mb-1">{{ $section ? 'Force Majore' : 'Force Majore' }}</h4>

                    <div class="mb-3">
                        <label for="subtitle2" class="form-label">Headline</label>
                        <textarea name="subtitle2" class="form-control ckeditor">{{ old('subtitle2', $section->subtitle2 ?? '') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="subtitle3" class="form-label">Sub Headline</label>
                        <textarea name="subtitle3" class="form-control ckeditor">{{ old('subtitle3', $section->subtitle3 ?? '') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="subtitle4" class="form-label">Content</label>
                        <textarea name="subtitle4" class="form-control ckeditor">{{ old('subtitle4', $section->subtitle4 ?? '') }}</textarea>
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
    <script src="https://cdn.ckeditor.com/ckeditor5/35.0.1/classic/ckeditor.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll('.ckeditor').forEach(function(el) {
                ClassicEditor
                    .create(el)
                    .catch(error => {
                        console.error(error);
                    });
            });
        });
    </script>
@endsection
