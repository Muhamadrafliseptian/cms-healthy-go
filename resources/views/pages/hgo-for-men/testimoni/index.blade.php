@extends('layouts.main')
@section('css')
    @include('components.header-css-hgofm')
@endsection
@section('content')
    <div class="container mt-5">
        <h4 class="mb-4">Form Section</h4>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form action="{{ route('hgfm.sections.store', ['id' => '9']) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                @if (!empty($section['image']))
                    <div class="mt-2">
                        <img src="{{ asset('storage/' . $section['image']) }}" alt="Preview Image"
                            style="max-height: 150px;">
                    </div>
                @endif
                <label for="img" class="form-label">Image</label>
                <input class="form-control" type="file" id="img" name="img" accept="image/*">
            </div>

            <div class="mb-3">
                <label for="headline" class="form-label">Headline</label>
                <textarea class="form-control summernote" id="headline" name="headline">{{ old('headline', $section['headline'] ?? '') }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary mb-5">Simpan</button>
        </form>
    </div>
@endsection

@section('js')
    @include('components.header-js-hgofm')
    <script>
        $(document).ready(function() {
            $('.summernote').summernote({
                height: 100,
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
