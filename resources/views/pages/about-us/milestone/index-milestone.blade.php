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
        <h3 class="mb-4">Section Milestone</h3>

        <div class="card shadow-sm mb-5">
            <div class="card-body">
                <h4 class="card-title mb-3">{{ $section ? 'Edit Description' : 'Tambah Description' }}</h4>
                <form
                    action="{{ $section ? route('section.milestone.put', $section->id) : route('section.milestone.store') }}"
                    method="POST" enctype="multipart/form-data">
                    @csrf
                    @if ($section)
                        @method('PUT')
                    @endif

                    <div class="mb-3">
                        <label for="title" class="form-label">Judul Banner</label>
                        <input type="text" name="title" class="form-control"
                            value="{{ old('title', $section->title ?? '') }}">
                    </div>

                    <div class="mb-3">
                        <label for="subtitle" class="form-label">Judul Banner 2</label>
                        <textarea name="subtitle1" id="subtitle1" class="form-control mb-3">
{{ old('subtitle1', $section->subtitle1 ?? '') }}</textarea
>
                    </div>

                    <div class="mb-3">
                        <label for="subtitle" class="form-label">Judul Banner 3</label>
                        <textarea name="subtitle2" id="subtitle2" class="form-control mb-3">
                        {{ old('subtitle2', $section->subtitle2 ?? '') }}</textarea
                        >
                    </div>

                    <div class="mb-3">
                        <label for="subtitle" class="form-label">Judul Banner 4</label>
                        <textarea name="subtitle3" id="subtitle3" class="form-control mb-3">
                        {{ old('subtitle3', $section->subtitle3 ?? '') }}</textarea
                        >
                    </div>
                    <button type="submit" class="btn btn-primary w-100">
                        {{ $section ? 'Perbarui Data' : 'Simpan Data' }}
                    </button>
                </form>
            </div>
        </div>
        <h3 class="mb-4">Milestone Data</h3>

        <button class="btn btn-sm btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addMilestoneModal">
            Add Milestone +
        </button>

        <div class="modal fade" id="addMilestoneModal" tabindex="-1" aria-labelledby="addMilestoneModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <form action="{{ route('milestone.store') }}" method="POST">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addMilestoneModalLabel">Add New Service</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="year" class="form-label">Year</label>
                                <input type="text" class="form-control" id="year" name="year">
                            </div>
                            <div class="mb-3">
                                <label for="title_milestone" class="form-label">Title</label>
                                <input type="text" class="form-control" id="title_milestone" name="title_milestone"
                                >
                            </div>
                            <div class="mb-3">
                                <label for="content_milestone" class="form-label">Content</label>
                                <textarea name="content_milestone" id="content_milestone" rows="5" class="form-control"></textarea>
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

    <div class="modal fade" id="editMilestoneModal" tabindex="-1" aria-labelledby="editMilestoneModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <form id="editMilestoneForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Service</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit_year" class="form-label">Year</label>
                            <input type="text" class="form-control" id="edit_year" name="year">
                        </div>
                        <div class="mb-3">
                            <label for="edit_title_milestone" class="form-label">Title</label>
                            <input type="text" class="form-control" id="edit_title_milestone" name="title_milestone"
                            >
                        </div>
                        <div class="mb-3">
                            <label for="edit_content_milestone" class="form-label">Content</label>
                            <textarea class="form-control" name="content_milestone" id="edit_content_milestone" rows="5"></textarea>
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


    <table id="milestone" class="table table-striped table-bordered text-center w-100">
        <thead class="text-center">
            <tr>
                <th>
                    No
                </th>
                <th>
                    Year
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
                        {{ $item->year }}
                    </td>
                    <td class="text-center" style="">
                        {{ $item->title_milestone }}
                    </td>
                    <td>
                        {!! $item->content_milestone !!}
                    </td>
                    <td class="text-center">
                        <button class="btn btn-sm btn-primary btn-edit" data-id="{{ $item->id }}"
                            data-year="{{ $item->year }}" data-title="{{ $item->title_milestone }}"
                            data-content="{{ $item->content_milestone }}" data-bs-toggle="modal"
                            data-bs-target="#editMilestoneModal">
                            Edit
                        </button>

                        <form action="{{ route('milestone.destroy', $item->id) }}" method="POST"
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
            $('#milestone').DataTable({
                responsive: true,
                scrollX: true
            });
        });
    </script>
    <script src="https://cdn.ckeditor.com/ckeditor5/35.0.1/classic/ckeditor.js"></script>
    <script>
        ClassicEditor
            .create(document.querySelector('#content_milestone'))
            .catch(error => {
                console.error(error);
            });
        const editors = ['subtitle1', 'subtitle2', 'subtitle3'];
        editors.forEach(id => {
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
            .create(document.querySelector('#edit_content_milestone'))
            .then(editor => {
                window.editEditor = editor;
            })
            .catch(error => {
                console.error(error);
            });

            $(document).on('click', '.btn-edit', function () {
            const id = $(this).data('id');
            const year = $(this).data('year');
            const title = $(this).data('title');
            const content = $(this).data('content');

            $('#edit_year').val(year);
            $('#edit_title_milestone').val(title);
            window.editEditor.setData(content);

            const formAction = `{{ url('dashboard/about-us/milestone') }}/put/${id}`;
            $('#editMilestoneForm').attr('action', formAction);
        });
    </script>
@endsection
