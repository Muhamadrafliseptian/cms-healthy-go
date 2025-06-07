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

        <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#createModal">+ Tambah Meta Tag</button>

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
                        <td>{!! $item->keywords !!}</td>
                        <td>{!! $item->description !!}</td>
                        <td>
                            <button class="btn btn-sm btn-primary btn-edit" data-id="{{ $item->id }}"
                                data-title="{{ $item->title }}" data-keywords="{{ $item->keywords }}"
                                data-description="{{ $item->description }}" data-menu_id="{{ $item->menu_id }}"
                                data-bs-toggle="modal" data-bs-target="#editModal">Edit</button>

                            <form action="{{ route('meta.destroy', $item->id) }}" method="POST"
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
                    <div class="mb-3">
                        <label for="menu_id">Pilih Menu</label>
                        <select name="menu_id" class="form-control">
                            <option value="">-- Pilih Menu --</option>
                            @foreach ($data as $menu)
                                <option value="{{ $menu->id }}">{{ $menu->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="title">Meta Title</label>
                        <input type="text" name="title" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="keywords">Meta Keywords</label>
                        <textarea name="keywords" rows="3" class="form-control ckeditor"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="description">Meta Description</label>
                        <textarea name="description" rows="3" class="form-control ckeditor"></textarea>
                    </div>
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
                    {{-- <div class="mb-3">
                        <label for="menu_id">Pilih Menu</label>
                        <select name="menu_id" class="form-control">
                            <option value="">-- Pilih Menu --</option>
                            @foreach ($data as $menu)
                                <option value="{{ $menu->id }}">{{ $menu->name }}</option>
                            @endforeach
                        </select>
                    </div> --}}
                    <div class="mb-3">
                        <label for="title">Meta Title</label>
                        <input type="text" name="title" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="keywords">Meta Keywords</label>
                        <textarea name="keywords" rows="3" class="form-control" id="edit-keywords"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="description">Meta Description</label>
                        <textarea name="description" rows="3" class="form-control" id="edit-description"></textarea>
                    </div>
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
    <script src="https://cdn.ckeditor.com/ckeditor5/35.0.1/classic/ckeditor.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/35.0.1/classic/ckeditor.js"></script>
    <script>
        let editors = {};

        function initEditors() {
            document.querySelectorAll('.ckeditor').forEach(function(el) {
                const name = el.getAttribute('name');

                if (editors[name]) {
                    editors[name].destroy().then(() => {
                        createEditor(el, name);
                    });
                } else {
                    createEditor(el, name);
                }
            });
        }

        function createEditor(el, name) {
            ClassicEditor
                .create(el)
                .then(editor => {
                    editors[name] = editor;
                })
                .catch(error => {
                    console.error(error);
                });
        }

        let editorKeywords, editorDescription;

        function initEditEditors() {
            if (editorKeywords) editorKeywords.destroy().catch(() => {});
            if (editorDescription) editorDescription.destroy().catch(() => {});

            ClassicEditor
                .create(document.querySelector('#edit-keywords'))
                .then(editor => {
                    editorKeywords = editor;
                });

            ClassicEditor
                .create(document.querySelector('#edit-description'))
                .then(editor => {
                    editorDescription = editor;
                });
        }

        $(document).ready(function() {
            $('#metaTable').DataTable();
            initEditors();

            $('.btn-edit').on('click', function() {
                const id = $(this).data('id');
                const title = $(this).data('title');
                const keywords = $(this).data('keywords');
                const description = $(this).data('description');
                const menuId = $(this).data('menu_id');

                const action = "{{ route('meta.put', ':id') }}".replace(':id', id);
                $('#editForm').attr('action', action);
                $('#editForm select[name="menu_id"]').val(menuId);
                $('#editForm input[name="title"]').val(title);

                $('#editModal').modal('show');

                setTimeout(function() {
                    initEditEditors();

                    setTimeout(() => {
                        if (editorKeywords) editorKeywords.setData(keywords);
                        if (editorDescription) editorDescription.setData(description);
                    }, 300);
                }, 300);
            });
        });
    </script>
@endsection
