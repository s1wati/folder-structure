<?php

namespace App\Http\Controllers;

use App\Models\Folder;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class FolderController extends Controller
{
    public function create()
    {
        return view('front.folders.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $newFolder = Folder::create([
            'parent_id' => $request->parent_id,
            'name' => $request->input('name'),
            // 'project_id' => $folder->project_id,
        ]);

        return redirect()
            ->route('folders.index', [$newFolder])
            ->withStatus('New folder has been created');
    }

    public function show($id)
    {
        $folder = Folder::findOrFail($id);

        return view('front.folders.show', compact('folder'));
    }

    public function index()
    {
        $folder = Folder::first();
        return view('front.folders.index', compact('folder'));

    }

    public function upload()
    {
        return view('front.folders.upload');
    }

    public function storeMedia(Request $request)
    {
        // Validates file size
        if (request()->has('size')) {
            $this->validate(request(), [
                'file' => 'max:' . request()->input('size') * 1024,
            ]);
        }

        // If width or height is preset - we are validating it as an image
        if (request()->has('width') || request()->has('height')) {
            $this->validate(request(), [
                'file' => sprintf(
                    'image|dimensions:max_width=%s,max_height=%s',
                    request()->input('width', 100000),
                    request()->input('height', 100000)
                ),
            ]);
        }

        $path = storage_path('tmp/uploads');

        try {
            if (!file_exists($path)) {
                mkdir($path, 0755, true);
            }
        } catch (\Exception $e) {
        }

        $file = $request->file('file');

        $name = uniqid() . '_' . trim($file->getClientOriginalName());

        $file->move($path, $name);

        return response()->json([
            'name'          => $name,
            'original_name' => $file->getClientOriginalName(),
        ]);
    }

    public function postUpload(Request $request)
    {
        $folder = Folder::findOrFail($request->folder_id);

        foreach ($request->input('files', []) as $file) {
            $folder->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('files');
        }

        return redirect()->route('folders.show', $folder)->withStatus('Files has been uploaded');
    }

    public function delete(Request $request, $id)
    {
        $media = Media::find($id);
        $media->delete();

        return redirect()->back();
    }

    public function deleteFolder(Request $request, $id)
    {
        $folder = Folder::find($id);
        $media = Media::where('model_id', $folder->id)->delete();
        $folder->delete();

        return redirect()->back();
    }
}
