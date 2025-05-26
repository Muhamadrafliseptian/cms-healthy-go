@extends('layouts.main')

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
@endsection

@section('content')
    <div class="container my-4">

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        <h3 class="mb-4">Statistic Section</h3>

        <form action="{{ $section ? route('statistic.putContent', $section->id) : route('statistic.storeContent') }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @if ($section)
                @method('PUT')
            @endif

            <div class="row mb-4">
                @if ($section && $section->img)
                    <div class="col-md-12 text-center">
                        <img src="{{ asset('storage/' . $section->img) }}" class="img-thumbnail" alt="Gambar Pertama">
                        <p class="text-muted mt-1">Gambar Pertama</p>
                    </div>
                @endif
            </div>

            <div class="mb-3">
                <label for="img" class="form-label">Upload Hero Lokasi</label>
                <input type="file" name="img" class="form-control">
            </div>

            <div class="mb-3">
                <label for="title" class="form-label">Judul</label>
                <textarea name="title" class="form-control ckeditor" rows="3">{{ old('title', $section->title ?? '') }}</textarea>
            </div>

            <div class="mb-3">
                <label for="subtitle1" class="form-label">Subjudul</label>
                <textarea name="subtitle1" class="form-control ckeditor" rows="3">{{ old('subtitle1', $section->subtitle1 ?? '') }}</textarea>
            </div>

            <button type="submit" class="btn btn-sm mb-4 btn-primary">
                {{ $section ? 'Perbarui Data' : 'Simpan Data' }}
            </button>

        </form>
        <h3 class="mb-4">Statistic Data</h3>
        <button class="btn btn-sm btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addServiceModal">
            Add Statistic +
        </button>

        <div class="modal fade" id="addServiceModal" tabindex="-1" aria-labelledby="addServiceModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <form action="{{ route('statistic.store') }}" method="POST">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addServiceModalLabel">Add New Service</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="title_statistic" class="form-label">Title</label>
                                <input type="text" class="form-control" id="title_statistic" name="title_statistic"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="content_statistic" class="form-label">Content</label>
                                <textarea name="content_statistic" id="content_statistic" rows="5" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Save</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="modal fade" id="editServiceModal" tabindex="-1" aria-labelledby="editServiceModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <form id="editServiceForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Service</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="edit_title_statistic" class="form-label">Title</label>
                                <input type="text" class="form-control" id="edit_title_statistic" name="title_statistic"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="edit_content_statistic" class="form-label">Content</label>
                                <textarea class="form-control" name="content_statistic" id="edit_content_statistic" rows="5"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>


        <table id="certificate" class="table table-striped table-bordered w-100">
            <thead class="text-center">
                <tr>
                    <th>
                        No
                    </th>
                    <th>
                        Title
                    </th>
                    <th>
                        Content
                    </th>
                    <th>
                        Aksi
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $item)
                    <tr class="alignMiddle">
                        <td class="text-center">
                            1
                        </td>
                        <td class="text-center" style="">
                            {{ $item->title_statistic }}
                        </td>
                        <td>
                            {!! $item->content_statistic !!}
                        </td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-primary btn-edit" data-id="{{ $item->id }}"
                                data-title="{{ $item->title_statistic }}" data-content="{{ $item->content_statistic }}"
                                data-bs-toggle="modal" data-bs-target="#editServiceModal">
                                Edit
                            </button>

                            <form action="{{ route('statistic.destroy', $item->id) }}" method="POST"
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
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#certificate').DataTable({
                scrollX: true,
                responsive: true
            });
        });
    </script>
    <script src="https://cdn.ckeditor.com/ckeditor5/35.0.1/classic/ckeditor.js"></script>
    <script>
        ClassicEditor
            .create(document.querySelector('#content_statistic'))
            .catch(error => {
                console.error(error);
            });
    </script>
    <script>
        ClassicEditor
            .create(document.querySelector('#edit_content_statistic'))
            .then(editor => {
                window.editEditor = editor;
            })
            .catch(error => {
                console.error(error);
            });

        $('.btn-edit').on('click', function() {
            const id = $(this).data('id');
            const title = $(this).data('title');
            const content = $(this).data('content');

            $('#edit_title_statistic').val(title);
            window.editEditor.setData(content);

            const formAction = `{{ url('dashboard/master/konten/statistic') }}/put/${id}`;
            $('#editServiceForm').attr('action', formAction);
        });
    </script>
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
