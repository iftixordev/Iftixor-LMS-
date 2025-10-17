<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function index()
    {
        $files = File::with('uploader')->latest()->paginate(20);
        return view('admin.files.index', compact('files'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:10240'
        ]);

        $file = $request->file('file');
        $path = $file->store('uploads', 'public');

        File::create([
            'name' => $file->hashName(),
            'original_name' => $file->getClientOriginalName(),
            'path' => $path,
            'size' => $file->getSize(),
            'mime_type' => $file->getMimeType(),
            'uploaded_by' => auth()->id()
        ]);

        return redirect()->back()->with('success', 'Fayl yuklandi');
    }

    public function destroy(File $file)
    {
        Storage::disk('public')->delete($file->path);
        $file->delete();
        return redirect()->back()->with('success', 'Fayl o\'chirildi');
    }

    public function download(File $file)
    {
        return Storage::disk('public')->download($file->path, $file->original_name);
    }

    public function upload(Request $request)
    {
        $request->validate([
            'files.*' => 'required|file|max:10240'
        ]);

        $uploadedFiles = [];
        
        foreach ($request->file('files') as $file) {
            $path = $file->store('uploads', 'public');
            
            $uploadedFile = File::create([
                'name' => $file->hashName(),
                'original_name' => $file->getClientOriginalName(),
                'path' => $path,
                'size' => $file->getSize(),
                'mime_type' => $file->getMimeType(),
                'uploaded_by' => auth()->id()
            ]);
            
            $uploadedFiles[] = $uploadedFile;
        }

        return response()->json([
            'success' => true,
            'message' => count($uploadedFiles) . ' ta fayl yuklandi',
            'files' => $uploadedFiles
        ]);
    }
}