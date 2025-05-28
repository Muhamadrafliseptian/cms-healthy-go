@extends('layouts.main')

@section('content')
    <div class="container mt-4">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <h3 class="mb-4">Manajemen Video</h3>

        @if ($video)
            <div class="mb-3">
                <div class="ratio ratio-16x9 mb-3">
                    <iframe src="{{ $video->video_home }}" frameborder="0" allowfullscreen></iframe>
                </div>
            </div>

            <form action="{{ route('video.put', $video->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="video_home" class="form-label">Link YouTube Baru</label>
                    <input type="url" name="video_home" id="video_home" class="form-control"
                        value="{{ $video->video_home }}" required>
                </div>
                <button type="submit" class="btn btn-primary">Update Video</button>
            </form>

            <form action="{{ route('video.destroy', $video->id) }}" method="POST"
                onsubmit="return confirm('Yakin ingin menghapus video ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger mt-3">Hapus Video</button>
            </form>
        @else
            <form action="{{ route('video.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="video_home" class="form-label">Link YouTube</label>
                    <input type="url" name="video_home" id="video_home" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-success">Simpan Video</button>
            </form>
        @endif
    </div>
@endsection
