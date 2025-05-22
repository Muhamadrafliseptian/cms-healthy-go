@extends('layouts.main')

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
@endsection

@section('content')
    <div class="container my-4">
        <h3 class="mb-4">Milestone Data</h3>

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
                                <input type="text" class="form-control" id="year" name="year" required>
                            </div>
                            <div class="mb-3">
                                <label for="title_milestone" class="form-label">Title</label>
                                <input type="text" class="form-control" id="title_milestone" name="title_milestone"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="content_milestone" class="form-label">Content</label>
                                <textarea name="content_milestone" id="content_milestone" rows="5"
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
                                <input type="text" class="form-control" id="edit_year" name="year"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="edit_title_milestone" class="form-label">Title</label>
                                <input type="text" class="form-control" id="edit_title_milestone" name="title_milestone"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="edit_content_milestone" class="form-label">Content</label>
                                <textarea class="form-control" name="content_milestone" id="edit_content_milestone"
                                    rows="5"></textarea>
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


        <table id="milestone" class="table table-striped table-bordered w-100">
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
                @foreach ($data as $item)
                    <tr class="alignMiddle">
                        <td class="text-center">
                            1
                        </td>
                        <td class="text-center" style="">
                            {{$item->year}}
                        </td>
                        <td class="text-center" style="">
                            {{$item->title_milestone}}
                        </td>
                        <td>
                            {!! $item->content_milestone !!}
                        </td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-primary btn-edit" data-id="{{ $item->id }}"
                                data-year="{{$item->year}}"
                                data-title="{{ $item->title_milestone }}" data-content="{{ $item->content_milestone }}"
                                data-bs-toggle="modal" data-bs-target="#editMilestoneModal">
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
        $(document).ready(function () {
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

        $('.btn-edit').on('click', function () {
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
