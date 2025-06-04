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

        <button class="btn btn-sm btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addBatchMenu">Tambah Data
            +</button>

        <div class="modal fade" id="addBatchMenu" tabindex="-1" aria-labelledby="addBatchMenuLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form action="{{ route('batch-menu.store') }}" method="POST" enctype="multipart/form-data"
                    class="modal-content">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addBatchMenuLabel">Tambah Data</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="batch_id" class="form-label">Pilih Batch</label>
                            <select name="batch_id" class="form-select">
                                @foreach ($batches as $batch)
                                    <option value="{{ $batch->id }}">
                                        {{ $batch->name }}
                                        ({{ \Carbon\Carbon::parse($batch->start_date)->translatedFormat('d F Y') }} -
                                        {{ \Carbon\Carbon::parse($batch->end_date)->translatedFormat('d F Y') }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @include('pages.food.batch.form-batch', ['prefix' => '', 'menus' => []])
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
                <form id="editForm" method="POST" enctype="multipart/form-data" class="modal-content" action="{{ route('batch-menu.put') }}">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Data</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @include('pages.food.batch.form-edit-batch', [
                            'batches' => $batches ?? [],
                        ])
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
                    <th>Batch</th>
                    <th>Periode</th>
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
                        <td>{{ $item->batch->name }}

                        </td>
                        <td>
                            <br>{{ \Carbon\Carbon::parse($item->batch->start_date)->translatedFormat('d F Y') }} s/d
                            <br>{{ \Carbon\Carbon::parse($item->batch->end_date)->translatedFormat('d F Y') }}
                        </td>
                        <td>
                            {!! $item->day !!}
                        </td>
                        <td>
                            {!! $item->dinner_menu !!}
                        </td>
                        <td>
                            {!! $item->lunch_menu !!}
                        </td>
                        <td><img src="{{ asset('storage/' . $item->img_menu) }}" alt="Program Image" width="150"></td>
                        <td>
                            <button class="btn btn-sm btn-primary btn-edit" data-id="{{ $item->id }}"
                                data-day="{{ $item->day }}" data-lunch="{{ $item->lunch_menu }}"
                                data-dinner="{{ $item->dinner_menu }}" data-bs-toggle="modal"
                                data-bs-target="#editBatchMenu">
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

        $(document).ready(function() {
            $('#program').DataTable({
                responsive: true,
                scrollX: true
            });
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll(".btn-edit").forEach(btn => {
                btn.addEventListener("click", function() {
                    document.getElementById("edit_id").value = this.dataset.id;
                    document.getElementById("edit_day").value = this.dataset.day || '';
                    document.getElementById("edit_lunch_menu").value = this.dataset.lunch || '';
                    document.getElementById("edit_dinner_menu").value = this.dataset.dinner || '';
                });
            });
        });
    </script>
@endsection
