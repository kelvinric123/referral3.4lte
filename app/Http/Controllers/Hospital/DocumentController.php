<?php

namespace App\Http\Controllers\Hospital;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\Hospital;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'role:hospital-admin']);
    }

    /**
     * Download a document.
     */
    public function download(Document $document)
    {
        // Get hospital associated with the logged-in user
        $hospital = Hospital::where('email', Auth::user()->email)->firstOrFail();
        
        // Check if the document's referral belongs to this hospital
        if ($document->referral->hospital_id !== $hospital->id) {
            abort(403, 'Unauthorized action.');
        }
        
        // Check if the file exists
        if (!Storage::exists($document->path)) {
            abort(404, 'File not found.');
        }
        
        // Return the file for download
        return Storage::download($document->path, $document->original_name);
    }
} 