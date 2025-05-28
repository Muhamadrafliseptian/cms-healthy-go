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

        <h3 class="mb-4">FAQ Section</h3>
        <form action="{{ $section ? route('faq.updateContentFaq', $section->id) : route('faq.storeContentFaq') }}" method="POST">
            @csrf
            @if ($section)
                @method('PUT')
            @endif

            <div>
                <label for="title" class="form-label">Title</label>
                <input type="text" name="title" class="form-control mb-3"
                    value="{{ old('title', $section->title ?? '') }}" required>

                <div class="mb-3">
                    <label for="subtitle1" class="form-label">Subtitle</label>
                <textarea class="form-control ckeditor" id="subtitle1" name="subtitle1" rows="3">
                        {{ old('subtitle1', $section->subtitle1 ?? '') }}
                    </textarea>
                </div>

                <label for="subtitle2" class="form-label">Subtitle</label>
                <textarea class="form-control ckeditor" id="subtitle2" name="subtitle2" rows="3">
                        {{ old('subtitle2', $section->subtitle2 ?? '') }}
                    </textarea>
            </div>

            <button type="submit" class="btn btn-sm btn-primary mt-3 mb-3">
                {{ $section ? 'Update' : 'Simpan' }}
            </button>
        </form>

        <h3 class="mb-4">FAQ Data</h3>


        <button class="btn btn-sm btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addMealModal">
            Add FAQ +
        </button>

        <div class="modal fade" id="addMealModal" tabindex="-1" aria-labelledby="addMealModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form action="{{ route('faq.store') }}" method="POST">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addMealModalLabel">Add New Promo</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="ask_title" class="form-label">Title</label>
                                <input type="text" class="form-control" id="ask_title" name="ask_title" required>
                            </div>
                            <div class="mb-3">
                                <label for="answer_content" class="form-label">Content</label>
                                <textarea name="answer_content" id="answer_content" rows="5" class="form-control"></textarea>
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
                <form id="editPromoForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Promo</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="edit_ask_title" class="form-label">Title</label>
                                <input type="text" class="form-control" id="edit_ask_title" name="ask_title" required>
                            </div>
                            <div class="mb-3">
                                <label for="edit_answer_content" class="form-label">Content</label>
                                <textarea class="form-control" name="answer_content" id="edit_answer_content" rows="5"></textarea>
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
                        <td class="text-center">
                            1
                        </td>
                        <td class="text-center" style="">
                            {{ $item->ask_title }}
                        </td>
                        <td>
                            {!! $item->answer_content !!}
                        </td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-primary btn-edit" data-id="{{ $item->id }}"
                                data-title="{{ $item->ask_title }}" data-content="{{ $item->answer_content }}"
                                data-bs-toggle="modal" data-bs-target="#editPromoModal">
                                Edit
                            </button>

                            <form action="{{ route('faq.destroy', $item->id) }}" method="POST"
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
                responsive: true,
                scrollX: true
            });
        });
    </script>
    <script src="https://cdn.ckeditor.com/ckeditor5/35.0.1/classic/ckeditor.js"></script>
    <script>
        ClassicEditor
            .create(document.querySelector('#answer_content'))
            .catch(error => {
                console.error(error);
            });
    </script>
    <script>
        ClassicEditor
            .create(document.querySelector('#edit_answer_content'))
            .then(editor => {
                window.editEditor = editor;
            })
            .catch(error => {
                console.error(error);
            });

            $(document).on('click', '.btn-edit', function () {
            const id = $(this).data('id');
            const title = $(this).data('title');
            const content = $(this).data('content');

            $('#edit_ask_title').val(title);
            window.editEditor.setData(content);

            const formAction = `{{ url('dashboard/etc/faq/section/main') }}/put/${id}`;
            $('#editPromoForm').attr('action', formAction);
        });
    </script>
    <script src="https://cdn.ckeditor.com/ckeditor5/35.0.1/classic/ckeditor.js"></script>
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
