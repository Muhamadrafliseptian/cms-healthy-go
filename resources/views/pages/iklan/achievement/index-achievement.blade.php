@extends('layouts.main')

@section('content')
    <div class="container my-4">
        {{-- Alert Messages --}}
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
                <h3 class="card-title mb-4">Section Achievement</h3>

                <form action="{{ $section ? route('achievement.put', $section->id) : route('achievement.store') }}"
                    method="POST" enctype="multipart/form-data">
                    @csrf
                    @if ($section)
                        @method('PUT')
                    @endif

                    @if ($section && $section->img)
                        <div class="mb-3 text-center">
                            <img src="{{ asset('storage/' . $section->img) }}" alt="Program Image" class="img-thumbnail"
                                style="max-width: 400px;">
                            <p class="text-muted mt-2">Gambar saat ini</p>
                        </div>
                    @endif

                    <div class="mb-3">
                        <label for="img" class="form-label">Upload Gambar</label>
                        <input type="file" name="img" class="form-control">
                    </div>

                    <textarea name="title" class="form-control ckeditor">{{ old('title', $section->title ?? '') }}</textarea>
                    <textarea name="subtitle1" class="form-control ckeditor">{{ old('subtitle1', $section->subtitle1 ?? '') }}</textarea>

                    <button type="submit" class="btn btn-primary mt-3">
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
        document.addEventListener("DOMContentLoaded", function () {
            document.querySelectorAll('.ckeditor').forEach(el => {
                ClassicEditor
                    .create(el)
                    .catch(error => {
                        console.error(error);
                    });
            });
        });
    </script>
@endsection

