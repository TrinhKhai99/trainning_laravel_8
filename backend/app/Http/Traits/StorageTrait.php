<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

trait StorageTrait {
    /* Execute upload file.
     *
     * @param object $file, $path
     * @return string
     */
    function uploadFile($file, $path)
    {
        $file->store($path, 'public');
        $fileName = $file->hashName();

        return $fileName;
    }
}
