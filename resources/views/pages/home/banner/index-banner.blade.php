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
                <form action="{{ $section ? route('section.home.put', $section->id) : route('section.home.store') }}"
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
                        <label for="img" class="form-label">Upload Background Banner</label>
                        <input type="file" name="img" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="title" class="form-label">Judul Banner</label>
                        <input type="text" name="title" class="form-control"
                            value="{{ old('title', $section->title ?? '') }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="subtitle1" class="form-label">Judul Banner 2</label>
                        <textarea name="subtitle1" id="subtitlee" class="form-control" rows="3">{{ old('subtitle1', $section->subtitle1 ?? '') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="subtitle2" class="form-label">Judul Banner 3</label>
                        <textarea name="subtitle2" id="subtitlee1" class="form-control" rows="3">{{ old('subtitle2', $section->subtitle2 ?? '') }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        {{ $section ? 'Perbarui Data' : 'Simpan Data' }}
                    </button>
                </form>
            </div>
        </div>

        <div class="card shadow-sm mt-5">
            <div class="card-body">
                <h4 class="card-title mb-3">{{ $section2 ? 'Edit Description' : 'Tambah Description' }}</h4>
                <form
                    action="{{ $section2 ? route('section.description.put', $section2->id) : route('section.description.store') }}"
                    method="POST" enctype="multipart/form-data">
                    @csrf
                    @if ($section2)
                        @method('PUT')
                    @endif

                    <div class="mb-3">
                        <label for="title" class="form-label">Judul Banner</label>
                        <input type="text" name="title" class="form-control"
                            value="{{ old('title', $section2->title ?? '') }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="subtitle1" class="form-label">Judul Banner 2</label>
                        <textarea name="subtitle1" id="subtitle1" class="form-control" rows="3">{{ old('subtitle1', $section2->subtitle1 ?? '') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="subtitle2" class="form-label">Judul Banner 3</label>
                        <textarea name="subtitle2" id="subtitle2" class="form-control" rows="3">{{ old('subtitle2', $section2->subtitle2 ?? '') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="subtitle3" class="form-label">Judul Banner 4</label>
                        <textarea name="subtitle3" id="subtitle3" class="form-control" rows="3">{{ old('subtitle3', $section2->subtitle3 ?? '') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="subtitle4" class="form-label">Judul Banner 5</label>
                        <textarea name="subtitle4" id="subtitle4" class="form-control" rows="3">{{ old('subtitle4', $section2->subtitle4 ?? '') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="subtitle5" class="form-label">Judul Banner 6</label>
                        <textarea name="subtitle5" id="subtitle5" class="form-control" rows="3">{{ old('subtitle5', $section2->subtitle5 ?? '') }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        {{ $section2 ? 'Perbarui Data' : 'Simpan Data' }}
                    </button>
                </form>
            </div>
        </div>


    </div>
@endsection

@section('js')
    <script src="https://cdn.ckeditor.com/ckeditor5/35.0.1/classic/ckeditor.js"></script>
    <script>
        const editors = ['title', 'subtitle1', 'subtitle2', 'subtitle3', 'subtitle4', 'subtitle5', 'subtitlee', 'subtitlee1'];
        editors.forEach(id => {
            const el = document.querySelector(`#${id}`);
            if (el) {
                ClassicEditor
                    .create(el)
                    .catch(error => console.error(`CKEditor init failed for ${id}:`, error));
            }
        });
    </script>
@endsection
