@extends('layouts.main')

@section('css')
    <link href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" rel="stylesheet" />
    <style>
        .dropzone {
            border: 2px dashed #6c757d;
            padding: 30px;
            text-align: center;
            background-color: #f8f9fa;
        }

        .dz-preview {
            margin-top: 15px;
        }

        .dz-preview video {
            width: 100%;
            max-width: 500px;
            margin-top: 15px;
        }

        @media (max-width: 576px) {
            video {
                width: 100% !important;
            }
        }
    </style>
@endsection

@section('content')
    <div class="container mt-4">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <h3 class="mb-4">Manajemen Video</h3>

        @if ($video)
            <div class="mb-3">
                <video width="100%" controls class="mb-3">
                    <source src="{{ asset('storage/' . $video->video_home) }}" type="video/mp4">
                    Browser tidak mendukung tag video.
                </video>
            </div>

            <form action="{{ route('video.put', $video->id) }}" method="POST" enctype="multipart/form-data" class="dropzone"
                  id="video-dropzone-update">
                @csrf
                @method('PUT')
            </form>

            <form action="{{ route('video.destroy', $video->id) }}" method="POST"
                  onsubmit="return confirm('Yakin ingin menghapus video ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger mt-3">Hapus Video</button>
            </form>
        @else
            <form action="{{ route('video.store') }}" method="POST" enctype="multipart/form-data" class="dropzone"
                  id="video-dropzone-store">
                @csrf
                <button type="submit" id="submitBtn" class="btn btn-success mt-3">Upload Video</button>
            </form>
        @endif
    </div>
@endsection

@section('js')
    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
    <script>
        const videoPreviewTemplate = `
            <div class="dz-preview dz-file-preview">
                <div class="dz-details">
                    <div class="dz-filename"><span data-dz-name></span></div>
                    <div class="dz-size" data-dz-size></div>
                </div>
                <video controls class="mt-3" id="previewVideo"></video>
                <div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></div>
                <div class="dz-error-message"><span data-dz-errormessage></span></div>
            </div>`;

        Dropzone.options.videoDropzoneStore = {
            paramName: "video_home",
            autoProcessQueue: false,
            maxFilesize: 50,
            acceptedFiles: "video/*",
            previewTemplate: videoPreviewTemplate,
            dictDefaultMessage: "Drag & drop video di sini atau klik untuk memilih",
            init: function () {
                let myDropzone = this;

                this.on("addedfile", function (file) {
                    const videoElement = this.previewsContainer.querySelector("#previewVideo");
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        videoElement.src = e.target.result;
                    };
                    reader.readAsDataURL(file);
                });

                document.getElementById("submitBtn").addEventListener("click", function (e) {
                    e.preventDefault();
                    if (myDropzone.getQueuedFiles().length > 0) {
                        myDropzone.processQueue();
                    }
                });

                this.on("success", function () {
                    location.reload();
                });
            }
        };

        Dropzone.options.videoDropzoneUpdate = {
            paramName: "video_home",
            maxFilesize: 50,
            acceptedFiles: "video/*",
            previewTemplate: videoPreviewTemplate,
            dictDefaultMessage: "Drag & drop video baru untuk update",
            init: function () {
                this.on("addedfile", function (file) {
                    const videoElement = this.previewsContainer.querySelector("#previewVideo");
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        videoElement.src = e.target.result;
                    };
                    reader.readAsDataURL(file);
                });

                this.on("success", function () {
                    location.reload();
                });
            }
        };
    </script>
@endsection
