@extends('layouts.main')

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
@endsection

@section('content')
    <div class="container mt-4">
        <h4>Kelola Meta Tag</h4>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @elseif (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <!-- Tombol Tambah -->
        <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#createModal">+ Tambah Meta Tag</button>

        <!-- Tabel Data -->
        <table id="metaTable" class="table table-striped table-bordered text-center w-100">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Menu</th>
                    <th>Title</th>
                    <th>Keywords</th>
                    <th>Description</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($datas as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->menu->name ?? '-' }}</td>
                        <td>{{ $item->title }}</td>
                        <td>{{ $item->keywords }}</td>
                        <td>{{ $item->description }}</td>
                        <td>
                            <button class="btn btn-sm btn-primary btn-edit"
                                data-id="{{ $item->id }}"
                                data-title="{{ $item->title }}"
                                data-keywords="{{ $item->keywords }}"
                                data-description="{{ $item->description }}"
                                data-menu_id="{{ $item->menu_id }}"
                                data-bs-toggle="modal" data-bs-target="#editModal">
                                Edit
                            </button>

                            <form action="{{ route('meta.destroy', $item->id) }}" method="POST" style="display:inline-block;">
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

    <!-- Modal Tambah -->
    <div class="modal fade" id="createModal" tabindex="-1">
        <div class="modal-dialog">
            <form action="{{ route('meta.store') }}" method="POST" class="modal-content">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Meta Tag</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    @include('pages.meta-tags._form', ['type' => 'create'])
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit -->
    <div class="modal fade" id="editModal" tabindex="-1">
        <div class="modal-dialog">
            <form method="POST" id="editForm" class="modal-content">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Edit Meta Tag</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    @include('pages.meta-tags._form', ['type' => 'edit'])
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#metaTable').DataTable();

            $('.btn-edit').click(function () {
                const id = $(this).data('id');
                $('#editForm').attr('action', `/dashboard/meta/put/${id}`);
                $('#editForm select[name="menu_id"]').val($(this).data('menu_id'));
                $('#editForm input[name="title"]').val($(this).data('title'));
                $('#editForm textarea[name="keywords"]').val($(this).data('keywords'));
                $('#editForm textarea[name="description"]').val($(this).data('description'));
            });
        });
    </script>
@endsection
