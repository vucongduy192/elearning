<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Storage;

trait UploadTrait
{
    /**
     * Generic file upload method.
     */
    public function uploadSlide($file, $course_id, $module_id, $folder = 'slide')
    {
        if (!is_file($file)) {
            return '';
        }
        $storage_dir = storage_path() . '/app/public/';
        $location = $storage_dir . $folder . '/' . $course_id . '/' . $module_id;
        if (!file_exists($location)) {
            mkdir($location, 0755, true);
        }
        $path = Storage::putFileAs('public/' . $folder . '/' . $course_id . '/' . $module_id, $file, time() . $file->getClientOriginalName());
        return '/storage/' . str_replace('public/', '', $path);
    }

    /**
     * Generic file upload method.
     * 
     * @param  ImageRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadImage(Request $request, $image_name = 'image', $folder = 'category', $w = 1024, $h = 768)
    {
        # Return path in public location. 
        # Public location contains link to storage location
        # ---------------Public--------------------||-----------------Storage---------------------
        # '/storage/category/computer_science.png' || '/storage/app/public/category/computer_science.png' 
        if (!$request->hasFile($image_name)) {
            return '';
        }

        $image = $request->$image_name;
        $path = $folder . '/' . time() . $image->getClientOriginalName();
        $storage_dir = storage_path() . '/app/public/';

        $location = $storage_dir . $folder;
        if (!file_exists($location)) {
            mkdir($location, 0755, true);
        }

        Image::make($image->getRealPath())
            ->resize($w, $h)
            ->save($storage_dir . $path);

        return '/storage/' . $path;
    }

    /**
     * Delete the file.
     * 
     */
    public function removeFile($path)
    {
        # Check exist in storage location
        # '/storage/app/public/category/computer_science.png'
        $file = storage_path(str_replace('/storage/', 'app/public/', $path));
        if ($path && file_exists($file))
            unlink($file);
    }

    /**
     * Delete the folder.
     * 
     */
    public function removeFolder($dir)
    {
        Storage::deleteDirectory($dir);
    }
}
