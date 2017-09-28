<?php

namespace App\Http\Helpers;

class ImageHelper
    {
    /**
     * Helper => Upload File
     * @param  [string] $key  [Key of parameter POST]
     * @param  [string] $path [Destination path]
     * @return [string]       [Full image path]
     */
    // TODO Helper for upload files
    // TODO For use Helper:
    // TODO 1. Include path on composer.JsonSerializable
    // TODO 2. run "php artisan dump-autoload"
    public static function uploadFile ($key, $path)
    {
        request()->file($key)->store($path);
    	return request()->file($key)->hashName();
    }
}
