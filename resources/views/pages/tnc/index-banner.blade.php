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
                <h4 class="card-title mb-1">{{ $section ? 'Edit Banner' : 'Tambah Banner' }}</h4>
                <form
                    action="{{ $section ? route('section.tnc.banner.put', $section->id) : route('section.tnc.banner.store') }}"
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
                                <p class="text-muted mt-1">Image Banner</p>
                            </div>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label for="img" class="form-label">Upload Gambar Banner</label>
                        <input type="file" name="img" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="title" class="form-label">Judul Banner</label>
                        <textarea type="text" name="title" class="form-control ckeditor">{{ old('title', $section->title ?? '') }}
                        </textarea>
                    </div>
                    <div class="mb-3">
                        <label for="subtitle1" class="form-label">Subjudul Banner</label>
                        <textarea type="text" name="subtitle1" class="form-control ckeditor">{{ old('subtitle1', $section->subtitle1 ?? '') }}
                        </textarea>
                    </div>
                    <div class="mb-3">
                        <label for="subtitle2" class="form-label">Subjudul Banner 2</label>
                        <textarea type="text" name="subtitle2" class="form-control ckeditor">{{ old('subtitle2', $section->subtitle2 ?? '') }}
                        </textarea>
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
