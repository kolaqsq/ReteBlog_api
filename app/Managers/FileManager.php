<?php

namespace App\Managers;

use App\Models\File;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class FileManager
{
    public function save(array $params): File
    {
        $extension = $params['file']->clientExtension();
        $filename = $params['path'] . "/" . str_replace(
                '/',
                '',
                Hash::make($params['file']->getFilename() . microtime(true))
            ) . "." . $extension;

        $file = app(File::class);
        $file->filename = $filename;
        $file->extension = $extension;
        $file->size = $params['file']->getSize();
        $file->disk = $params['disk'];
        $file->user_id = $params['user_id'];
        $file->save();

        Storage::disk($params['disk'])->put($file->filename, $params['file']->getContent());

        return $file;
    }

    /**
     * @throws ValidationException
     */
    public function delete(User $user, string $filename)
    {
        $fileEntry = File::where('filename', $filename)->first();

        if ($user->id != $fileEntry->user_id && !$user->hasRole('admin')) {
            throw ValidationException::withMessages([
                                                        "user" => 'Пользователь не может удалить не свой файл.',
                                                    ]);
        }

        $fileEntry->delete();
        Storage::disk($fileEntry->disk)->delete($filename);
    }
}
