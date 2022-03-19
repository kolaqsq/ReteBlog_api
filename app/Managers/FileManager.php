<?php

namespace App\Managers;

use App\Models\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class FileManager
{
    public function save(UploadedFile $uploadedFile, string $disk): File
    {
        $extension = $uploadedFile->clientExtension();
        $filename = Hash::make($uploadedFile->getFilename() . microtime(true)) . "." . $extension;

        $file = app(File::class);
        $file->filename = $filename;
        $file->extension = $extension;
        $file->size = $uploadedFile->getSize();
        $file->disk = $disk;
        $file->save();

        Storage::disk($disk)->put($file->filename, $uploadedFile->getContent());

        return $file;
    }
}