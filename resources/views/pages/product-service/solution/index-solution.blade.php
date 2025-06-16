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
                <h4 class="card-title mb-3">{{ $section ? 'Edit Tag' : 'Tambah Tag' }}</h4>
                <form
                    action="{{ $section ? route('section.product.solution.put', $section->id) : route('section.product.solution.store') }}"
                    method="POST">
                    @csrf
                    @if ($section)
                        @method('PUT')
                    @endif

                    <div class="mb-3">
                        <label for="title" class="form-label">Headline</label>
                        <textarea name="title" id="title" class="form-control" rows="3">
                            {{ old('title', $section->title ?? '') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="subtitle1" class="form-label">Sub Headline</label>
                        <textarea name="subtitle1" id="subtitle1" class="form-control" rows="3">
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
        const editors = ['title', 'subtitle1'];
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
