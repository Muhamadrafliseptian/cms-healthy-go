@extends('layouts.main')

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
@endsection

@section('content')
    <div class="container my-4">
        <h3 class="mb-4">Partnership Data</h3>

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
        <button class="btn btn-sm btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addCertificateModal">
            Tambah +
        </button>

        <div class="modal fade" id="addCertificateModal" tabindex="-1" aria-labelledby="addCertificateModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <form action="{{ route('partnership.store') }}" method="POST" enctype="multipart/form-data"
                    class="modal-content">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addCertificateModalLabel">Tambah Gambar Sertifikat</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="title_partnership" class="form-label">Title</label>
                            <input type="text" class="form-control" id="title_partnership" name="title_partnership"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="program_partnership" class="form-label">Title</label>
                            <input type="text" class="form-control" id="program_partnership" name="program_partnership"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="content_program_partnership" class="form-label">Title</label>
                            <input type="text" class="form-control" id="content_program_partnership"
                                name="content_program_partnership" required>
                        </div>
                        <div class="mb-3">
                            <label for="img_partnership" class="form-label">Pilih Gambar</label>
                            <input type="file" class="form-control" name="img_partnership" accept="image/*" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="modal fade" id="editCertificateModal" tabindex="-1" aria-labelledby="editCertificateModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <form id="editForm" method="POST" enctype="multipart/form-data" class="modal-content">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title" id="editCertificateModalLabel">Edit Gambar Sertifikat</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="edit-id">
                        <div class="mb-3">
                            <label for="edit_title_partnership" class="form-label">Title</label>
                            <input type="text" class="form-control" id="edit_title_partnership" name="title_partnership"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_program_partnership" class="form-label">Title</label>
                            <input type="text" class="form-control" id="edit_program_partnership"
                                name="program_partnership" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_content_program_partnership" class="form-label">Title</label>
                            <input type="text" class="form-control" id="edit_content_program_partnership"
                                name="content_program_partnership" required>
                        </div>
                        <div class="mb-3">
                            <label for="img_partnership" class="form-label">Pilih Gambar Baru (opsional)</label>
                            <input type="file" class="form-control" name="img_partnership" accept="image/*">
                        </div>
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


        <table id="certificate" class="table table-striped table-bordered w-100">
            <thead>
                <tr>
                    <th>
                        No
                    </th>
                    <th>
                        Title
                    </th>
                    <th>
                        Subtitle
                    </th>
                    <th>
                        Subtitle2
                    </th>
                    <th>
                        Image
                    </th>
                    <th>
                        Aksi
                    </th>
                </tr>
            <tbody>
                @foreach ($data as $item)
                    <tr class="alignMiddle">
                        <td>
                            1
                        </td>
                        <td>
                            {{ $item->title_partnership }}
                        </td>
                        <td>
                            {{ $item->program_partnership }}

                        </td>
                        <td>
                            {{ $item->content_program_partnership }}

                        </td>
                        <td>
                            <img src="{{ asset('storage/' . $item->img_partnership) }}" alt="Certificate Image"
                                class="img-fluid" width="150">
                        </td>
                        <td>
                            <button class="btn btn-sm btn-primary btn-edit" data-id="{{ $item->id }}"
                                data-image="{{ $item->img_partnership }}" data-bs-toggle="modal"
                                data-title1="{{ $item->title_partnership }}"
                                data-title2="{{ $item->program_partnership }}"
                                data-title3="{{ $item->content_program_partnership }}"
                                data-bs-target="#editCertificateModal">
                                Edit
                            </button>

                            <form action="{{ route('partnership.destroy', $item->id) }}" method="POST"
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
            </thead>
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

            $('.btn-edit').on('click', function() {
                const id = $(this).data('id');
                const image = $(this).data('image');
                const title1 = $(this).data('title1');
                const title2 = $(this).data('title2');
                const title3 = $(this).data('title3');

                $('#edit-id').val(id);
                $('#previewImg').attr('src', '/storage/' + image);
                $('#edit_title_partnership').val(title1);
                $('#edit_program_partnership').val(title2);
                $('#edit_content_program_partnership').val(title3);

                const actionUrl = `/dashboard/partnership/main/put/${id}`;
                $('#editForm').attr('action', actionUrl);
            });
        });
    </script>
@endsection
