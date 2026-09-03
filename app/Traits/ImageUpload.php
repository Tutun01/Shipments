<?php

namespace  App\Traits;

use App\Http\Requests\NewAvatarRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

trait ImageUpload
{

    public function uploadImage($file, $path)
    {
        $name = uniqid().".webp";
        $gd = new Driver();
        $manager = new ImageManager($gd);
        $image = $manager->read($file)->toWebp(90);
        Storage::disk('public')->put("$path/$name", (string) $image);
        return $name;
    }

    public function deleteImage(?string $name, string $folder): void
    {
        if ($name !== null) {
            Storage::disk('public')->delete("$folder/$name");
        }
    }


}
