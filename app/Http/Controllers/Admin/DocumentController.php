<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    /**
     * Download a document.
     *
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function download(Document $document)
    {
        // Check if file exists
        if (!Storage::exists($document->path)) {
            return back()->with('error', 'File not found.');
        }

        return Storage::download($document->path, $document->original_name);
    }

    /**
     * Remove the specified document from storage.
     *
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function destroy(Document $document)
    {
        // Delete the file from storage
        if (Storage::exists($document->path)) {
            Storage::delete($document->path);
        }

        // Delete the record from the database
        $document->delete();

        return response()->json(['success' => true]);
    }
}
