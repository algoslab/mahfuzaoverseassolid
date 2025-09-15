<?php

namespace App\Traits;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

trait FileUpload{
    public function uploadFile($disk = 'candidate', $file, $folder = 'documents')
    {
        if ($file) {
            $currentDate = Carbon::now()->format('d-m-Y');
            $directory = "uploads/{$folder}/{$currentDate}";

            if (!File::isDirectory(public_path($directory))) {
                File::makeDirectory(public_path($directory), 0777, true, true);
            }

            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();

            $path = Storage::disk($disk)->putFileAs($directory, $file, $filename);

            return $path;
        }

        return null;
    }
    
    public static function deleteImage($url)
    {
        if (isset($url) && File::exists($url)) {
            File::delete($url);
            return true;
        }
        return false;
    }
}