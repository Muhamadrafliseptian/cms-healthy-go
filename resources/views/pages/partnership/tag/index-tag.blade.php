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
                <div class="row">
                    <div class="col-6">
                        <h4 class="card-title mb-3">{{ $section ? 'Edit Tag' : 'Tambah Tag' }}</h4>
                    </div>
                    <div class="col-6 text-end">
                        <p class="card-title mb-3">
                            Example
                            <i class="fas fa-image text-primary"
                                onclick="window.open('https://imagekit.io/blog/content/images/2019/12/image-optimization.jpg')"></i>
                        </p>
                    </div>
                </div>
                <form
                    action="{{ $section ? route('section.partnership.tag.put', $section->id) : route('section.partnership.tag.store') }}"
                    method="POST">
                    @csrf
                    @if ($section)
                        @method('PUT')
                    @endif

                    <div class="mb-3">
                        <label for="title" class="form-label">Headline</label>
                        <input type="text" name="title" class="form-control"
                            value="{{ old('title', $section->title ?? '') }}">
                    </div>

                    <div class="mb-3">
                        <label for="subtitle" class="form-label">Sub Headline</label>
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
    <script src="https://cdn.ckeditor.com/ckeditor5/35.0.1/classic/ckeditor.js"></script>
    <script>
        const editors = ['subtitle1'];
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
