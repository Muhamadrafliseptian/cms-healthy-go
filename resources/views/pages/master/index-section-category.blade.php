@extends('layouts.main')

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
@endsection

@section('content')
    <div class="container my-4">
        <h3 class="mb-4">Master Category</h3>

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
        <button class="btn btn-sm btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addMealModal">
            Add Category +
        </button>

        <div class="modal fade" id="addMealModal" tabindex="-1" aria-labelledby="addMealModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <form action="{{ route('scategory.store') }}" method="POST">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addMealModalLabel">Add Data</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Kategori</label>
                                <input type="text" class="form-control" id="name" name="name">
                            </div>
                            <div class="mb-3">
                                <label for="slug" class="form-label">Slug</label>
                                <input type="text" class="form-control" id="slug" name="slug">
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

        <div class="modal fade" id="editPromoModal" tabindex="-1" aria-labelledby="editPromoModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <form id="editPromoForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Data</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="edit_name" class="form-label">Title</label>
                                <input type="text" class="form-control" id="edit_name" name="name">

                            </div>
                            <div class="mb-3">
                                <label for="edit_slug" class="form-label">Title</label>
                                <input type="text" class="form-control" id="edit_slug" name="slug">

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


        <table id="certificate" class="table table-striped table-bordered text-center w-100">
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
                @foreach ($data as $index => $item)
                    <tr class="alignMiddle">
                        <td>
                            {{ $index + 1 }}
                        </td>
                        <td class="text-center">
                            {{$item->name}}
                        </td>
                        <td class="text-center">
                            {{ $item->slug}}
                        </td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-primary btn-edit" data-id="{{ $item->id }}"
                                data-title="{{ $item->name }}" data-content="{{ $item->slug }}"
                                data-bs-toggle="modal" data-bs-target="#editPromoModal">
                                Edit
                            </button>

                            <form action="{{ route('scategory.destroy', $item->id) }}" method="POST"
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
        $(document).ready(function () {
            $('#certificate').DataTable({
                scrollX: true,
                responsive: true
            });
        });
    </script>
    <script src="https://cdn.ckeditor.com/ckeditor5/35.0.1/classic/ckeditor.js"></script>
    <script>
            $(document).on('click', '.btn-edit', function () {
            const id = $(this).data('id');
            const title = $(this).data('title');
            const content = $(this).data('content');

            $('#edit_name').val(title);
            $('#edit_slug').val(content);

            const formAction = `{{ url('dashboard/master/section-category') }}/put/${id}`;
            $('#editPromoForm').attr('action', formAction);
        });
    </script>


@endsection
