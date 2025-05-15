<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VideoHome;

class VideoController
{
    public function index()
    {
        $video = VideoHome::first(); // hanya ambil 1 video pertama
        return view('pages.home.video.index-video', compact('video'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'video_home' => 'required|file|mimetypes:video/mp4,video/x-msvideo,video/quicktime|max:51200', // max 50MB
        ]);

        if (VideoHome::exists()) {
            return redirect()->back()->with('error', 'Video sudah ada. Anda hanya bisa mengupdate.');
        }

        $file = $request->file('video_home');
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('video_home', $filename, 'public');

        VideoHome::create([
            'video_home' => $path,
        ]);

        return redirect()->back()->with('success', 'Video berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'video_home' => 'nullable|file|mimetypes:video/mp4,video/x-msvideo,video/quicktime|max:51200',
        ]);

        $video = VideoHome::findOrFail($id);

        if ($request->hasFile('video_home')) {
            $file = $request->file('video_home');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('video_home', $filename, 'public');

            // Hapus file lama jika ada
            if ($video->video_home && \Storage::disk('public')->exists($video->video_home)) {
                \Storage::disk('public')->delete($video->video_home);
            }

            $video->video_home = $path;
        }

        $video->save();

        return redirect()->back()->with('success', 'Video berhasil diupdate.');
    }


    public function destroy($id)
    {
        $video = VideoHome::findOrFail($id);
        $video->delete();

        return redirect()->back()->with('success', 'Video berhasil dihapus.');
    }
}
