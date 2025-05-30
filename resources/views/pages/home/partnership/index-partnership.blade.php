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
        <div class="card shadow-sm">
            <div class="card-body">
                <form
                    action="{{ $section ? route('section.partnershipHome.put', $section->id) : route('section.partnershipHome.store') }}"
                    method="POST" enctype="multipart/form-data">
                    @csrf
                    @if ($section)
                        @method('PUT')
                    @endif

                    <div class="mb-3">
                        <label for="title" class="form-label">Judul Banner</label>
                        <input type="text" name="title" class="form-control"
                            value="{{ old('title', $section->title ?? '') }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="subtitle1" class="form-label">Subjudul Banner</label>
                        <textarea name="subtitle1" class="form-control ckeditor" rows="3">{{ old('subtitle1', $section->subtitle1 ?? '') }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        {{ $section ? 'Perbarui Data' : 'Simpan Data' }}
                    </button>
                </form>
            </div>
        </div>

        <button class="btn btn-sm btn-primary mb-3 mt-5" data-bs-toggle="modal" data-bs-target="#addCertificateModal">
            Tambah Gambar Partnership +
        </button>

        <div class="modal fade" id="addCertificateModal" tabindex="-1" aria-labelledby="addCertificateModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <form action="{{ route('partnershipHome.store') }}" method="POST" enctype="multipart/form-data"
                    class="modal-content">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addCertificateModalLabel">Tambah Gambar Sertifikat</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
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
                        <h5 class="modal-title" id="editCertificateModalLabel">Edit Gambar Partnership</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="edit-id">
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


        <table id="certificate" class="table table-striped table-bordered text-center w-100">
            <thead>
                <tr>
                    <th>
                        No
                    </th>
                    <th>
                        Image
                    </th>
                    <th>
                        Aksi
                    </th>
                </tr>
            <tbody>
                @foreach ($data as $index => $item)
                    <tr class="alignMiddle">
                        <td>
                            {{ $index + 1 }}
                        </td>
                        <td>
                            <img src="{{ asset('storage/' . $item->img_partnership) }}" alt="Certificate Image"
                                class="img-fluid" width="150">
                        </td>
                        <td>
                            <button class="btn btn-sm btn-primary btn-edit" data-id="{{ $item->id }}"
                                data-image="{{ $item->img_partnership }}" data-bs-toggle="modal"
                                data-bs-target="#editCertificateModal">
                                Edit
                            </button>

                            <form action="{{ route('partnershipHome.destroy', $item->id) }}" method="POST"
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
    <script src="https://cdn.ckeditor.com/ckeditor5/35.0.1/classic/ckeditor.js"></script>
    <script>
        $(document).ready(function() {
            $('#certificate').DataTable({
                scrollX: true,
                responsive: true
            });

            $(document).on('click', '.btn-edit', function() {
                const id = $(this).data('id');
                const image = $(this).data('image');

                $('#edit-id').val(id);
                $('#previewImg').attr('src', '/storage/' + image);

                const actionUrl = `/dashboard/master/konten/partnership/put/${id}`;
                $('#editForm').attr('action', actionUrl);
            });
        });
    </script>
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
