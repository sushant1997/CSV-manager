<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileController extends Controller
{

    public function __construct()
    {
    }
    public function upload_file(Request $request)
    {
        $validated = $request->validate([
            'csv_file' => 'required|file|mimes:csv|max:' . config('filesystems.size_limit')
        ]);
        $file = $validated['csv_file'];
        $document_name = $file->getClientOriginalName();
        $document_type = $file->extension();
        $document_size = $file->getSize();
        $guid =  Str::uuid();
        $path = $file->storeAs($guid, $document_name);
        $document_checksum = md5_file($file->getRealPath());

        Document::create([
            'guid' => $guid,
            'document_name' => $document_name,
            'document_type' => $document_type,
            'file_path' => $path,
            'document_size' => $document_size,
            'user_id' => Auth::user()->id,
            'document_checksum' => $document_checksum,
        ]);

        $this->csv_to_json($file, $document_name, $guid);
        return redirect()->back()->with(['message' => 'File successfully uploaded']);
    }

    private function csv_to_json($file, $document_name, $guid)
    {
        $csv_data = array_map('str_getcsv', file($file));
        $header = array_shift($csv_data);

        $records = [];

        foreach ($csv_data as $row) {
            $records[] = array_combine($header, $row);
        }

        $json = json_encode($records, JSON_PRETTY_PRINT);
        $json_file_name = pathinfo($document_name, PATHINFO_FILENAME) . '.json';
        $directory = storage_path('app/public/' . $guid); // directory where CSV is to be stored, to get the path of needed directory
        $json_file_path = $directory . '/' . $json_file_name;
        // Save the JSON file in the same directory as the CSV file
        file_put_contents($json_file_path, $json);
    }

    public function delete_file($file_id)
    {
        Document::where('id', '=', $file_id)->delete();

        return redirect()->back()->with(['message' => 'File successfully deleted']);
    }

    public function file_download($file_id)
    {
        $file = Document::where('id', $file_id)->first();
        if (!$file) {
            return redirect()->back()->with(['error' => 'File not found']);
        }

        return Storage::download($file->file_path);
    }
}
