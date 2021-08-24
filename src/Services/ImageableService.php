<?php

namespace Cancionistica\Services;
use App\Models\Contracts\Imageable;
use App\Models\Image;
use Cancionistica\Apis\ImageableApi;
use Cancionistica\ValueObjects\ImageSize;
use Exception;
use Faker\Provider\Uuid;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Constraint;
use Intervention\Image\Image as InterventionImage;

class ImageableService implements ImageableApi
{
    /**
     * {@inheritDoc}
     */
    public function saveImage(Imageable $imageable, UploadedFile $file)
    {
        ImageSize::listAll()->each(function (ImageSize $imageSize) use ($file, $imageable) {
            /** @var InterventionImage $interventionImage */
            $interventionImage = \Image::make($file);
            $this->resizeImage($imageSize, $interventionImage);
            logger()->debug($imageSize->getSize());
            $this->createImagesFolder();
            $path = "images/blog/" . Uuid::uuid() . '.' . $file->getClientOriginalExtension();
            $interventionImage->save(Storage::disk('public')->path($path));
            $this->saveImageModel($imageSize, $path, $imageable);
        });
    }

    private function saveImageModel(ImageSize $size, string $path, Imageable $imageable) {
        $imageable->images()->create(["path" => $path, "size" => $size->getSize()]);
    }

    /**
     * @param ImageSize $imageSize
     * @param InterventionImage $interventionImage
     * @throws Exception
     */
    private function resizeImage(ImageSize $imageSize, InterventionImage $interventionImage)
    {
        if ($interventionImage->width() > $imageSize->getImageWidth()) {
            if ($imageSize->getImageHeight()) {
                $interventionImage->fit(
                    $imageSize->getImageWidth(), $imageSize->getImageHeight()
                );
                return;
            }
            $interventionImage->resize(
                $imageSize->getImageWidth(), null, function (Constraint $constraint) {
                $constraint->aspectRatio();
            });
        }
    }

    private function createImagesFolder(): void
    {
        if (!Storage::disk('public')->exists('images/blog')) {
            Storage::disk('public')->makeDirectory('images/blog');
        }
        if (!Storage::disk('public')->exists('images/courses')) {
            Storage::disk('public')->makeDirectory('images/courses');
        }
    }

    /**
     * {@inheritDoc}
     */
    public function deleteImages(Imageable $imageable)
    {
        $imageable->images->each(function(Image $image){
            Storage::disk('public')->delete($image->path);

        });
        $imageable->images()->delete();
    }
}
