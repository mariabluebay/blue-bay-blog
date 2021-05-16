<?php

namespace App\Helpers;
use Illuminate\Support\Facades\Storage;

class Helper
{
    /**
     * Removing a file
     *
     * @param $image
     * @param $path
     */
    public static function deleteFile($image, $path)
    {
        if(isset($image))
        {
            $path = $path . $image;
            if (Storage::disk('public')->exists($path))
            {
                Storage::disk('public')->delete($path);
            }
        }
    }
}

