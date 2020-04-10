<?php
namespace App\Traits;

use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Storage;

trait UploadTrait {
    /**
     * Generic file upload method.
     * 
     * @param  ImageRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadImage(Request $request, $image_name='image', $folder='category', $w=1024, $h=768)
    {
        if (!$request->hasFile($image_name)) {
            return '';
        }
        
        $image = $request->$image_name;
        $path = $folder.'/'.time().$image->getClientOriginalName();
        $storage_dir = storage_path().'/app/public/';

        Image::make($image->getRealPath())
            ->resize($w, $h)
            ->save($storage_dir.$path);
        
        return '/storage/'.$path;
    }

    /**
     * Delete the file.
     * 
     * @param  Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function removeImage($path)
    {
        unlink(storage_path(str_replace('/storage/', 'app/public/', $path)));
    }
}
