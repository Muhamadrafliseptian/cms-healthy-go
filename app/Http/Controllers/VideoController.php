<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VideoHome;
use Exception;

class VideoController
{
    public function index()
    {
        $video = VideoHome::first();
        if (request()->wantsJson()) {
            return response()->json([
                'status' => "success",
                "section" => $video
            ]);
        }
        return view('pages.home.video.index-video', compact('video'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'video_home' => [
                    'required',
                    'url',
                    'regex:/^(https?:\/\/)?(www\.)?(youtube\.com|youtu\.be)\/.+$/'
                ],
            ]);

            $embedUrl = $this->convertToEmbedUrl($request->video_home);

            if (VideoHome::exists()) {
                return redirect()->back()->with('error', 'Video sudah ada. Anda hanya bisa mengupdate.');
            }

            VideoHome::create([
                'video_home' => $embedUrl,
            ]);

            return redirect()->back()->with('success', 'Link video berhasil ditambahkan.');
        } catch (Exception $err) {
            return redirect()->back()->with('error', $err->getMessage());
        }
    }


    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'video_home' => [
                    'required',
                    'url',
                    'regex:/^(https?:\/\/)?(www\.)?(youtube\.com\/(watch\?v=|embed\/|shorts\/)|youtu\.be\/)[\w-]{11}($|[&?])/'
                ],
            ]);
            $embedUrl = $this->convertToEmbedUrl($request->video_home);
            $video = VideoHome::findOrFail($id);
            $video->video_home = $embedUrl;
            $video->save();

            return redirect()->back()->with('success', 'Link video berhasil diupdate.');
        } catch (Exception $err) {
            return redirect()->back()->with('error', $err->getMessage());
        }
    }


    public function destroy($id)
    {
        $video = VideoHome::findOrFail($id);
        $video->delete();

        return redirect()->back()->with('success', 'Video berhasil dihapus.');
    }
    private function convertToEmbedUrl($url)
    {
        preg_match('/(?:youtu\.be\/|youtube\.com\/(?:watch\?v=|embed\/|v\/|shorts\/))([a-zA-Z0-9_-]{11})/', $url, $matches);
        return isset($matches[1]) ? "https://www.youtube.com/embed/" . $matches[1] : $url;
    }
}
