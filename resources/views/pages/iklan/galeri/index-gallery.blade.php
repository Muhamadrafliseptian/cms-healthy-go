@extends('layouts.main')

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
@endsection

@section('content')
    <div class="container my-4">
        <h3 class="mb-4">Galeri Testimoni</h3>

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
        <button class="btn btn-sm btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addCarouselModal">
            Tambah +
        </button>

        <div class="modal fade" id="addCarouselModal" tabindex="-1" aria-labelledby="addCarouselModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <form action="{{ route('galeri.store') }}" method="POST" enctype="multipart/form-data"
                    class="modal-content">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addCarouselModalLabel">Tambah Data</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="img_testimoni" class="form-label">Pilih Gambar</label>
                            <input type="file" class="form-control" name="img_testimoni" accept="image/*" required>
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
                        <h5 class="modal-title" id="editCertificateModalLabel">Edit Data</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="edit-id">
                        <div class="mb-3">
                            <label for="img_testimoni" class="form-label">Pilih Gambar Baru (opsional)</label>
                            <input type="file" class="form-control" name="img_testimoni" accept="image/*">
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


        <table id="certificate" class="table table-bordered table-stripped w-100">
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
                            <img src="{{ asset('storage/' . $item->img_testimoni) }}" alt="Certificate Image"
                                class="img-fluid" width="150">
                        </td>
                        <td>
                            <button class="btn btn-sm btn-primary btn-edit" data-id="{{ $item->id }}"
                                data-image="{{ $item->img_testimoni }}" data-bs-toggle="modal"
                                data-bs-target="#editCertificateModal">
                                Edit
                            </button>

                            <form action="{{ route('galeri.destroy', $item->id) }}" method="POST"
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
        $(document).ready(function () {
            $('#certificate').DataTable({
                scrollX: true,
                responsive: true
            });

                $(document).on('click', '.btn-edit', function () {
                const id = $(this).data('id');
                const image = $(this).data('image');

                $('#edit-id').val(id);
                $('#previewImg').attr('src', '/storage/' + image);

                const actionUrl = `/dashboard/iklan/galeri/put/${id}`;
                $('#editForm').attr('action', actionUrl);
            });
        });
    </script>

@endsection
