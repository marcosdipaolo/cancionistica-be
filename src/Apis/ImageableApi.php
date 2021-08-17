<?php

namespace Cancionistica\Apis;

use App\Models\Contracts\Imageable;
use Exception;
use Illuminate\Http\UploadedFile;

interface ImageableApi
{
    /**
     * @param Imageable $imageable
     * @param UploadedFile $file
     * @return void
     * @throws Exception
     */
    public function saveImage(Imageable $imageable, UploadedFile $file);

    /**
     * @param Imageable $imageable
     * @return void
     */
    public function deleteImages(Imageable $imageable);
}
