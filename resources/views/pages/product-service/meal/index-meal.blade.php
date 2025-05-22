@extends('layouts.main')

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
@endsection

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

        <div class="card shadow-sm mb-3">
            <div class="card-body">
                <h3 class="card-title mb-4">Section Meal</h3>

                <form action="{{ $section ? route('meal.update.content', $section->id) : route('meal.store.content') }}"
                    enctype="multipart/form-data" method="POST">
                    @csrf
                    @if ($section)
                        @method('PUT')
                    @endif
                    @if ($section && $section->img)
                        <div class="mb-3 text-center">
                            <img src="{{ asset('storage/' . $section->img) }}" alt="Program Image" class="img-thumbnail"
                                >
                            <p class="text-muted mt-2">Gambar saat ini</p>
                        </div>
                    @endif
                    <div class="mb-3">
                        <label for="title" class="form-label">Judul</label>
                        <input type="text" name="title" class="form-control"
                            value="{{ old('title', $section->title ?? '') }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="img" class="form-label">Upload Gambar</label>
                        <input type="file" name="img" class="form-control">
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        {{ $section ? 'Perbarui Data' : 'Simpan Data' }}
                    </button>
                </form>
            </div>
        </div>

        <h3 class="mb-4">Meal Data</h3>
        <button class="btn btn-sm btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addMealModal">
            Add Meal +
        </button>

        <div class="modal fade" id="addMealModal" tabindex="-1" aria-labelledby="addMealModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form action="{{ route('meal.store') }}" method="POST">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addMealModalLabel">Add New Service</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="meal_title" class="form-label">Title</label>
                                <input type="text" class="form-control" id="meal_title" name="meal_title" required>
                            </div>
                            <div class="mb-3">
                                <label for="meal_content" class="form-label">Content</label>
                                <textarea name="meal_content" id="meal_content" rows="5" class="form-control"></textarea>
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
                                <label for="edit_meal_title" class="form-label">Title</label>
                                <input type="text" class="form-control" id="edit_meal_title" name="meal_title"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="edit_meal_content" class="form-label">Content</label>
                                <textarea class="form-control" name="meal_content" id="edit_meal_content" rows="5"></textarea>
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
                            {{ $item->meal_title }}
                        </td>
                        <td>
                            {!! $item->meal_content !!}
                        </td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-primary btn-edit" data-id="{{ $item->id }}"
                                data-title="{{ $item->meal_title }}" data-content="{{ $item->meal_content }}"
                                data-bs-toggle="modal" data-bs-target="#editServiceModal">
                                Edit
                            </button>

                            <form action="{{ route('meal.destroy', $item->id) }}" method="POST"
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
            .create(document.querySelector('#meal_content'))
            .catch(error => {
                console.error(error);
            });
    </script>
    <script>
        ClassicEditor
            .create(document.querySelector('#edit_meal_content'))
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

            $('#edit_meal_title').val(title);
            window.editEditor.setData(content);

            const formAction = `{{ url('dashboard/product-service/meal') }}/put/${id}`;
            $('#editServiceForm').attr('action', formAction);
        });
    </script>
@endsection
