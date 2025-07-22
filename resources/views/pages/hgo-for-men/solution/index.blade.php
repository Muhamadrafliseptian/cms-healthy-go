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

        <form action="{{ route('hgfm.sections.store', ['id' => '5']) }}" method="POST" enctype="multipart/form-data">
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

            <div class="mb-3">
                <label for="subheadline" class="form-label">Subheadline</label>
                <textarea class="form-control summernote" id="subheadline" name="subheadline">{{ old('subheadline', $section['subheadline'] ?? '') }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary mb-5">Simpan</button>
        </form>

        <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addModal">
            <i class="bi bi-plus-circle me-1"></i> Tambah Solution
        </button>

        <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <form action="{{ route('hgfm.sections.solution.store') }}" method="POST" enctype="multipart/form-data"
                    class="modal-content">
                    @csrf
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title" id="addModalLabel">Tambah Solution</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body px-4 py-3">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Judul</label>
                            <input type="text" name="title" class="form-control" placeholder="Masukkan judul" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Konten</label>
                            <textarea name="content" class="form-control summernote" placeholder="Isi konten..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer px-4">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button class="btn btn-success">Simpan</button>
                    </div>
                </form>
            </div>
        </div>

        @foreach ($data as $row)
            <div class="modal fade" id="editModal{{ $row->id }}" tabindex="-1"
                aria-labelledby="editModalLabel{{ $row->id }}" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <form action="{{ route('hgfm.sections.solution.put', $row->id) }}" method="POST"
                        enctype="multipart/form-data" class="modal-content">
                        @csrf
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title" id="editModalLabel{{ $row->id }}">Edit Solution</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body px-4 py-3">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Judul</label>
                                <input type="text" name="title" class="form-control" value="{{ $row->title }}"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Konten</label>
                                <textarea name="content" class="form-control summernote" id="content-{{ $row->id }}">{{ $row->content }}</textarea>
                            </div>
                        </div>
                        <div class="modal-footer px-4">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        @endforeach


        <hr class="my-4">

        <table id="solutionTable" class="table table-striped">
            <thead>
                <tr>
                    <th>Judul</th>
                    <th>Konten</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $row)
                    <tr>
                        <td>{{ $row->title }}</td>
                        <td>{!! $row->content !!}</td>
                        <td>
                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                data-bs-target="#editModal{{ $row->id }}">
                                Edit
                            </button>

                            <form action="{{ route('hgfm.sections.solution.destroy', $row->id) }}" method="POST"
                                class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>
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
        <script>
        $(document).ready(function() {
            $('#solutionTable').DataTable();

            $('.summernote').summernote({
                height: 150,
                tabsize: 2
            });
        });
    </script>
@endsection
