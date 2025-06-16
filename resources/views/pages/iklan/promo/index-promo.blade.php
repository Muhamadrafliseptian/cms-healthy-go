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
                <h4 class="card-title mb-4">{{ $section ? 'Edit Data' : 'Tambah Promo' }}</h4>

                <form action="{{ $section ? route('promoIklan.put', $section->id) : route('promoIklan.store') }}"
                    method="POST" enctype="multipart/form-data">
                    @csrf
                    @if ($section)
                        @method('PUT')
                    @endif

                    <div class="row mb-4">
                        {{-- Preview Gambar --}}
                        @if ($section && $section->img)
                            <div class="col-md-6 text-center">
                                <img src="{{ asset('storage/' . $section->img) }}" class="img-thumbnail"
                                    alt="Gambar Pertama">
                                <p class="text-muted mt-1">Gambar Pertama</p>
                            </div>
                        @endif

                        @if ($section && $section->img2)
                            <div class="col-md-6 text-center">
                                <img src="{{ asset('storage/' . $section->img2) }}" class="img-thumbnail"
                                    alt="Gambar Kedua">
                                <p class="text-muted mt-1">Gambar Kedua</p>
                            </div>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label for="img" class="form-label">Upload Gambar Pertama</label>
                        <input type="file" name="img" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="img2" class="form-label">Upload Gambar Kedua</label>
                        <input type="file" name="img2" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="title" class="form-label">Headline</label>
                        <textarea name="title" id="title" class="form-control ckeditor" rows="3">{{ old('title', $section->title ?? '') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="subtitle1" class="form-label">Sub Headline</label>
                        <textarea name="subtitle1" id="subtitle1" class="form-control ckeditor" rows="3">{{ old('subtitle1', $section->subtitle1 ?? '') }}</textarea>
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
