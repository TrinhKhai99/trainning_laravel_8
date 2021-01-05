<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;

trait StorageTrait {
    /* Execute upload file.
     *
     * @param object $file
     * @return string
     */
    function uploadFile($file, $path)
    {

        $current_date_time = Carbon::now()->toDateTimeString();

        if(!Storage::disk('public')->exists($path)) {
            if(!Storage::disk('public')->exists(dirname($path))) {
                Storage::disk('public')->makeDirectory($path);
            }
        }

        $file->store($path, 'public');
        $fileName = $file->hashName();

        $moveFilePath = "./public/static/uploads/";

        $isComplete = Storage::disk('public')->move($path, $moveFilePath);

        return $isComplete;
    }

}
