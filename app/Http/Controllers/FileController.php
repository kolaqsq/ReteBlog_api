<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;

class FileController
{
    public function showFile($filename)
    {
//        return 'amo';
//        return response()->file('app/public/article/$2y$10$8MQ8P4Dnv5qixZ7P7oS0M.a6.7UnX5bMMc807YTfYTdkvBasZB49W.png');
//        return Storage::disk('public')->get('article/$2y$10$8MQ8P4Dnv5qixZ7P7oS0M.a6.7UnX5bMMc807YTfYTdkvBasZB49W.png');
//        return response(asset('article/$2y$10$8MQ8P4Dnv5qixZ7P7oS0M.a6.7UnX5bMMc807YTfYTdkvBasZB49W.png'));
        return redirect()->away(asset('storage/' . $filename));
    }
}
