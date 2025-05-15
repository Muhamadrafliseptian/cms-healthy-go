@extends('layouts.main')

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
@endsection

@section('content')
    <div class="container my-4">
        <h3 class="mb-4">Batch Menu Data</h3>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <button class="btn btn-sm btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addBatchMenu">Tambah Testimoni
            +</button>

        <div class="modal fade" id="addBatchMenu" tabindex="-1" aria-labelledby="addBatchMenuLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form action="{{ route('batch-menu.store') }}" method="POST" enctype="multipart/form-data"
                    class="modal-content">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addBatchMenuLabel">Tambah Testimoni</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @include('pages.food.batch.form-batch', ['prefix' => ''])
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="modal fade" id="editBatchMenu" tabindex="-1" aria-labelledby="editBatchMenuLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form id="editForm" method="POST" enctype="multipart/form-data" class="modal-content">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Testimoni</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @include('pages.food.batch.form-batch', ['prefix' => 'edit_'])
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

        <table id="program" class="table table-striped table-bordered text-center">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Hari</th>
                    <th>Lunch Menu</th>
                    <th>Dinner Menu</th>
                    <th>Image</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $index => $item)
                    <tr class="alignMiddle">
                        <td>{{ $index + 1 }}</td>
                        <td>
                            {!! $item->day !!}
                        </td><td>
                            {!! $item->dinner_menu !!}
                        </td>
                        <td>
                            {!! $item->lunch_menu !!}
                        </td>
                        <td><img src="{{ asset('storage/' . $item->img_menu) }}" alt="Program Image" width="150"></td>
                        <td>
                            <button class="btn btn-sm btn-primary btn-edit" data-id="{{ $item->id }}"
                                data-dinner="{{ $item->dinner_menu }}" data-lunch="{{ $item->lunch_menu }}"
                                data-day="{{$item->day}}"
                                data-img-menu="{{ $item->img_menu }}" data-bs-toggle="modal" data-bs-target="#editBatchMenu">
                                Edit
                            </button>

                            <form action="{{ route('batch-menu.destroy', $item->id) }}" method="POST"
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

        function initCKEditor(id, key) {
            ClassicEditor
                .create(document.querySelector(id))
                .then(editor => {
                    editors[key] = editor;
                })
                .catch(error => console.error(error));
        }

        $(document).ready(function () {
            $('#program').DataTable();

            $('.btn-edit').on('click', function () {
                const id = $(this).data('id');
                const dinner = $(this).data('dinner');
                const lunch = $(this).data('lunch');
                const image = $(this).data('img-menu');
                const day = $(this).data('day');

                $('#edit_dinner_menu').val(dinner);
                $('#edit_lunch_menu').val(lunch);
                $('#edit_day_menu').val(day);
                $('#previewImg').attr('src', '/storage/' + image);

                const actionUrl = `/dashboard/food/batch-menu/put/${id}`;
                $('#editForm').attr('action', actionUrl);
            });

        });
    </script>

@endsection