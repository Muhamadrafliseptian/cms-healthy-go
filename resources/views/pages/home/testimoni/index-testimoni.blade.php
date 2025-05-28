@extends('layouts.main')

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
@endsection

@section('content')
    <div class="container my-4">
        <h3 class="mb-4">Section Testimoni</h3>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form
            action="{{ $section ? route('testimoni.updateContentTestimoni', $section->id) : route('testimoni.storeContentTestimoni') }}"
            method="POST">
            @csrf
            @if ($section)
                @method('PUT')
            @endif

            <div>
                <label for="title" class="form-label">Title</label>
                <input type="text" name="title" class="form-control mb-3"
                    value="{{ old('title', $section->title ?? '') }}" required>

                <label for="subtitle1" class="form-label">Subtitle</label>
                <textarea name="subtitle1" id="subtitle1" class="form-control mb-3">{{ old('subtitle1', $section->subtitle1 ?? '') }}</textarea>

            </div>

            <button type="submit" class="btn btn-sm btn-primary mt-3 mb-3">
                {{ $section ? 'Update' : 'Simpan' }}
            </button>
        </form>

        <h3 class="mb-4">Data Testimoni</h3>

        <button class="btn btn-sm btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addTestimoniModal">Tambah
            Testimoni
            +</button>

        {{-- Modal Tambah --}}
        <div class="modal fade" id="addTestimoniModal" tabindex="-1" aria-labelledby="addTestimoniModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <form action="{{ route('testimoni.store') }}" method="POST" enctype="multipart/form-data"
                    class="modal-content">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addTestimoniModalLabel">Tambah Testimoni</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @include('pages.home.testimoni.form-testimoni', ['prefix' => ''])
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="modal fade" id="editTestimoniModal" tabindex="-1" aria-labelledby="editTestimoniModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <form id="editForm" method="POST" enctype="multipart/form-data" class="modal-content">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Testimoni</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @include('pages.home.testimoni.form-testimoni', ['prefix' => 'edit_'])
                        <div class="mb-3">
                            <label>Preview Gambar</label><br>
                            <img id="previewImg" src="" alt="Preview" width="150">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Perbarui</button>
                    </div>
                </form>
            </div>
        </div>

        <table id="program" class="table table-striped table-bordered text-center w-100">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Customer</th>
                    <th>Nama Program</th>
                    <th>Review customer</th>
                    <th>Image Customer</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $index => $item)
                    <tr class="alignMiddle">
                        <td>{{ $index + 1 }}</td>
                        <td>
                            {!! $item->name !!}
                        </td>
                        <td>
                            {!! $item->program_name !!}
                        </td>
                        <td>{!! $item->content !!}</td>
                        <td><img src="{{ asset('storage/' . $item->ava_testimoni) }}" alt="Program Image" width="150">
                        </td>
                        <td>
                            <button class="btn btn-sm btn-primary btn-edit" data-id="{{ $item->id }}"
                                data-name="{{ $item->name }}" data-program-name="{{ $item->program_name }}"
                                data-content="{{ $item->content }}" data-ava-testimoni="{{ $item->ava_testimoni }}"
                                data-bs-toggle="modal" data-bs-target="#editTestimoniModal">
                                Edit
                            </button>

                            <form action="{{ route('testimoni.destroy', $item->id) }}" method="POST"
                                style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"
                                    onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('js')
    <script src="https://cdn.ckeditor.com/ckeditor5/35.0.1/classic/ckeditor.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script>
        let editors = {};

        ClassicEditor
            .create(document.querySelector('#subtitle1'))
            .catch(error => console.error(error));

        function initCKEditor(id, key) {
            ClassicEditor
                .create(document.querySelector(id))
                .then(editor => {
                    editors[key] = editor;
                })
                .catch(error => console.error(error));
        }

        $(document).ready(function() {
            $('#program').DataTable({
                scrollX: true,
                responsive: true
            });

            initCKEditor('#content', 'content');
            initCKEditor('#edit_content', 'edit_content');

                $(document).on('click', '.btn-edit', function () {
                const id = $(this).data('id');
                const name = $(this).data('name');
                const programName = $(this).data('program-name');
                const content = $(this).data('content');
                const image = $(this).data('ava-testimoni');

                $('#edit_name').val(name);
                $('#edit_program_name').val(programName);
                editors['edit_content'].setData(content);

                $('#previewImg').attr('src', '/storage/' + image);

                const actionUrl = `/dashboard/master/konten/testimoni/put/${id}`;
                $('#editForm').attr('action', actionUrl);
            });
        });
    </script>
@endsection
