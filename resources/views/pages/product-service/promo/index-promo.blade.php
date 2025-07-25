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
        <h3 class="mb-4">Section Promo</h3>

        <div class="card shadow-sm mb-3">
            <div class="card-body">
                <h4 class="card-title mb-3">{{ $section ? 'Edit' : 'Tambah' }}</h4>
                <form action="{{ $section ? route('section.promo.put', $section->id) : route('section.promo.store') }}"
                    method="POST">
                    @csrf
                    @if ($section)
                        @method('PUT')
                    @endif

                    <div class="mb-3">
                        <label for="title" class="form-label">Headline</label>
                        <input type="text" name="title" id="title" class="form-control"
                            value="{{ old('title', $section->title ?? '') }}" />
                    </div>

                    <div class="mb-3">
                        <label for="subtitle1" class="form-label">Sub Headline</label>
                        <textarea name="subtitle1" id="subtitle1" class="form-control" rows="3">
                        {{ old('subtitle1', $section->subtitle1 ?? '') }}</textarea
                        >
                    </div>

                     <div class="mb-3">
                        <label for="subtitle2" class="form-label">Content</label>
                         <textarea name="subtitle2" id="subtitle2" class="form-control" rows="3">
                        {{ old('subtitle2', $section->subtitle2 ?? '') }}</textarea
                        >
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        {{ $section ? 'Perbarui Data' : 'Simpan Data' }}
                    </button>
                </form>
            </div>
        </div>
        <h3 class="mb-4">Promo Data</h3>

        <button class="btn btn-sm btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addMealModal">
            Add Promo +
        </button>

        <div class="modal fade" id="addMealModal" tabindex="-1" aria-labelledby="addMealModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <form action="{{ route('promo.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addMealModalLabel">Add Data</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                <label for="img" class="form-label">Pilih Gambar</label>
                                <input type="file" class="form-control" name="img" accept="image/*">
                            </div>
                            <div class="mb-3">
                                <label for="title_promo" class="form-label">Title</label>
                                <input type="text" class="form-control" id="title_promo" name="title_promo">
                            </div>
                            <div class="mb-3">
                                <label for="content_promo" class="form-label">Content</label>
                                <textarea name="content_promo" id="content_promo" rows="5"
                                    class="form-control"></textarea>
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

    <div class="modal fade" id="editPromoModal" tabindex="-1" aria-labelledby="editPromoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="editPromoForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Data</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit_img" class="form-label">Img</label>
                            <input type="file" class="form-control" id="edit_img" name="img">
                        </div>
                        <div class="mb-3">
                            <label for="edit_title_promo" class="form-label">Title</label>
                            <input type="text" class="form-control" id="edit_title_promo" name="title_promo">
                        </div>
                        <div class="mb-3">
                            <label for="edit_content_promo" class="form-label">Content</label>
                            <textarea class="form-control" name="content_promo" id="edit_content_promo" rows="5"></textarea>
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
                    Image
                </th>
                <th>
                    Aksi
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $index => $item)
                <tr class="alignMiddle">
                    <td class="text-center">
                        {{ $index + 1 }}
                    </td>
                    <td class="text-center" style="">
                        {{ $item->title_promo }}
                    </td>
                    <td>
                        {!! $item->content_promo !!}
                    </td>
                    <td>
                        <img src="{{ asset('storage/' . $item->img) }}" alt="Certificate Image" class="img-fluid"
                            width="150">
                    </td>
                    <td class="text-center">
                        <button class="btn btn-sm btn-primary btn-edit" data-id="{{ $item->id }}"
                            data-image="{{ $item->img }}" data-title="{{ $item->title_promo }}"
                            data-content="{{ $item->content_promo }}" data-bs-toggle="modal"
                            data-bs-target="#editPromoModal">
                            Edit
                        </button>

                        <form action="{{ route('promo.destroy', $item->id) }}" method="POST"
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
            .create(document.querySelector('#content_promo'))
            .catch(error => {
                console.error(error);
            });
    </script>
    <script>
        const editorss = ['subtitle2', 'subtitle1'];
        editorss.forEach(id => {
            const el = document.querySelector(`#${id}`);
            if (el) {
                ClassicEditor
                    .create(el)
                    .catch(error => console.error(`CKEditor init failed for ${id}:`, error));
            }
        });
    </script>
    <script>
        ClassicEditor
            .create(document.querySelector('#edit_content_promo'))
            .then(editor => {
                window.editEditor = editor;
            })
            .catch(error => {
                console.error(error);
            });

        $(document).on('click', '.btn-edit', function() {
            const id = $(this).data('id');
            const title = $(this).data('title');
            const content = $(this).data('content');
            const img = $(this).data('image');

            $('#edit_title_promo').val(title);
            window.editEditor.setData(content);

            const formAction = `{{ url('dashboard/product-service/promo') }}/put/${id}`;
            $('#editPromoForm').attr('action', formAction);
        });
    </script>
@endsection
