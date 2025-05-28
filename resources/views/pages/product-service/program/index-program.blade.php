@extends('layouts.main')

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
@endsection

@section('content')
    <div class="container my-4">
        <h3 class="mb-4">Program Data</h3>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <button class="btn btn-sm btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addProgramModal">Tambah Program
            +</button>

        {{-- Modal Tambah --}}
        <div class="modal fade" id="addProgramModal" tabindex="-1" aria-labelledby="addProgramModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <form action="{{ route('programProduct.store') }}" method="POST" enctype="multipart/form-data"
                    class="modal-content">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addProgramModalLabel">Tambah Program</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @include('pages.home.program.form-program', ['prefix' => ''])
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="modal fade" id="editProgramModal" tabindex="-1" aria-labelledby="editProgramModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <form id="editForm" method="POST" enctype="multipart/form-data" class="modal-content">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Program</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @include('pages.home.program.form-program', ['prefix' => 'edit_'])
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

        <table id="program" class="">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Program</th>
                    <th>Kalori</th>
                    <th>Protein</th>
                    <th>Image</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $index => $item)
                    <tr class="alignMiddle">
                        <td>{{ $index + 1 }}</td>
                        <td>
                            {!! $item->program_title !!}
                        </td>
                        <td>
                            {!! $item->program_subtitle !!}
                        </td>
                        <td>{!! $item->program_subtitle_2 !!}</td>
                        <td>{!! $item->content_program_2 !!}</td>
                        <td><img src="{{ asset('storage/' . $item->content_program) }}" alt="Program Image" width="150">
                        </td>
                        <td>
                            <button class="btn btn-sm btn-primary btn-edit" data-id="{{ $item->id }}"
                                data-title="{{ $item->program_title }}" data-subtitle="{{ $item->program_subtitle }}"
                                data-subtitle2="{{ $item->program_subtitle_2 }}" data-image="{{ $item->content_program }}"
                                data-content-program2="{{ $item->content_program_2 }}"
                                data-bs-toggle="modal" data-bs-target="#editProgramModal">
                                Edit
                            </button>

                            <form action="{{ route('programProduct.destroy', $item->id) }}" method="POST"
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
                scrollX: true,
                responsive: true
            });

            initCKEditor('#program_title', 'program_title');
            initCKEditor('#program_subtitle', 'program_subtitle');
            initCKEditor('#program_subtitle_2', 'program_subtitle_2');

            initCKEditor('#edit_program_title', 'edit_program_title');
            initCKEditor('#edit_program_subtitle', 'edit_program_subtitle');
            initCKEditor('#edit_program_subtitle_2', 'edit_program_subtitle_2');
            initCKEditor('#edit_content_program_2', 'edit_content_program_2');

            $(document).on('click', '.btn-edit', function() {
                const id = $(this).data('id');
                const title = $(this).data('title');
                const subtitle = $(this).data('subtitle');
                const subtitle2 = $(this).data('subtitle2');
                const content2 = $(this).data('content-program2');
                const image = $(this).data('image');

                editors['edit_program_title'].setData(title);
                editors['edit_program_subtitle'].setData(subtitle);
                editors['edit_program_subtitle_2'].setData(subtitle2);
                editors['edit_content_program_2'].setData(content2);
                $('#previewImg').attr('src', '/storage/' + image);

                const actionUrl = `/dashboard/home/program/put/${id}`;
                $('#editForm').attr('action', actionUrl);
            });
        });
    </script>
@endsection
