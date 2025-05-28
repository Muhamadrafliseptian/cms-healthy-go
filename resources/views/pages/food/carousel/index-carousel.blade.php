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
        <h3 class="mb-4">Section Carousel</h3>

        <div class="card shadow-sm mb-3">
            <div class="card-body">
                <form
                    action="{{ $section ? route('section.carousel.put', $section->id) : route('section.carousel.store') }}"
                    method="POST" enctype="multipart/form-data">
                    @csrf
                    @if ($section)
                        @method('PUT')
                    @endif

                    <div class="mb-3">
                        <label for="title" class="form-label">Content</label>
                        <textarea type="text" name="title" class="form-control" id="title" rows="3">
                            {{ old('title', $section->title ?? '') }}
                        </textarea>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        {{ $section ? 'Perbarui Data' : 'Simpan Data' }}
                    </button>
                </form>
            </div>
        </div>
        <h3 class="mb-4">Carousel Data</h3>

        <button class="btn btn-sm btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addCarouselModal">
            Tambah Gambar +
        </button>

        <div class="modal fade" id="addCarouselModal" tabindex="-1" aria-labelledby="addCarouselModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <form action="{{ route('carousel.store') }}" method="POST" enctype="multipart/form-data"
                    class="modal-content">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addCarouselModalLabel">Tambah Gambar Sertifikat</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="img_carousel" class="form-label">Pilih Gambar</label>
                            <input type="file" class="form-control" name="img_carousel" accept="image/*" required>
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
                            <label for="img_carousel" class="form-label">Pilih Gambar Baru (opsional)</label>
                            <input type="file" class="form-control" name="img_carousel" accept="image/*">
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
                            <img src="{{ asset('storage/' . $item->img_carousel) }}" alt="Certificate Image"
                                class="img-fluid" width="150">
                        </td>
                        <td>
                            <button class="btn btn-sm btn-primary btn-edit" data-id="{{ $item->id }}"
                                data-image="{{ $item->img_carousel }}" data-bs-toggle="modal"
                                data-bs-target="#editCertificateModal">
                                Edit
                            </button>

                            <form action="{{ route('carousel.destroy', $item->id) }}" method="POST"
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
    <script src="https://cdn.ckeditor.com/ckeditor5/35.0.1/classic/ckeditor.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#certificate').DataTable({
                scrollX: true
            });

            const editors = ['title'];
            editors.forEach(id => {
                const el = document.querySelector(`#${id}`);
                if (el) {
                    ClassicEditor
                        .create(el)
                        .catch(error => console.error(`CKEditor init failed for ${id}:`, error));
                }
            });

                $(document).on('click', '.btn-edit', function () {
                const id = $(this).data('id');
                const image = $(this).data('image');

                $('#edit-id').val(id);
                $('#previewImg').attr('src', '/storage/' + image);

                const actionUrl = `/dashboard/food/carousel/put/${id}`;
                $('#editForm').attr('action', actionUrl);
            });
        });
    </script>
@endsection
