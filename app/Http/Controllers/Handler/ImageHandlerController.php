<?php

namespace App\Http\Controllers\Handler;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

use Illuminate\Http\Request;

class ImageHandlerController extends Controller
{
    // Function to upload country image
    public function countryFlag($file, $path = 'country-flags', $previousImagePath = null)
    {
        if ($previousImagePath) {
            $this->deleteImage($previousImagePath);
        }
    
        // Use a shorter random string
        $fileName = time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();

        // Save to storage/app/public/file-opening-image
        $file->storeAs($path, $fileName, 'public');

        return 'storage/' . $path . '/' . $fileName;
    }

    // Function to upload country popular image
    public function countryCoverPhoto($file, $path = 'country-cover-photo', $previousImagePath = null)
    {
        if ($previousImagePath) {
        $this->deleteImage($previousImagePath);
        }
    
        // Use a shorter random string
        $fileName = time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();

        // Save to storage/app/public/file-opening-image
        $file->storeAs($path, $fileName, 'public');

        return 'storage/' . $path . '/' . $fileName;
    }

    // Function to upload company logo
    public function companyPhoto($file, $path = 'company-photo', $previousImagePath = null)
    {
        if ($previousImagePath) {
        $this->deleteImage($previousImagePath);
        }
    
        // Use a shorter random string
        $fileName = time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();

        // Save to storage/app/public/file-opening-image
        $file->storeAs($path, $fileName, 'public');

        return 'storage/' . $path . '/' . $fileName;
    }

    // Function to upload university logo
    public function universityLogo($file, $path = 'university-logo', $previousImagePath = null)
    {
        if ($previousImagePath) {
        $this->deleteImage($previousImagePath);
        }
    
        // Use a shorter random string
        $fileName = time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();

        // Save to storage/app/public/file-opening-image
        $file->storeAs($path, $fileName, 'public');

        return 'storage/' . $path . '/' . $fileName;
    }


    // Function to upload university logo
    public function universityCoverImage($file, $path = 'university-cover-image', $previousImagePath = null)
    {
        if ($previousImagePath) {
        $this->deleteImage($previousImagePath);
        }
    
        // Use a shorter random string
        $fileName = time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();

        // Save to storage/app/public/file-opening-image
        $file->storeAs($path, $fileName, 'public');

        return 'storage/' . $path . '/' . $fileName;
    }

    // Function to upload course photo
    public function coursePhoto($file, $path = 'course-photo', $previousImagePath = null)
    {
        if ($previousImagePath) {
        $this->deleteImage($previousImagePath);
        }
    
        // Use a shorter random string
        $fileName = time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();

        // Save to storage/app/public/file-opening-image
        $file->storeAs($path, $fileName, 'public');

        return 'storage/' . $path . '/' . $fileName;
    }

    // Function to upload profile photo
    public function profilePhoto($file, $path = 'profile-photo', $previousImagePath = null)
    {
        if ($previousImagePath) {
        $this->deleteImage($previousImagePath);
        }
    
        // Use a shorter random string
        $fileName = time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();

        // Save to storage/app/public/file-opening-image
        $file->storeAs($path, $fileName, 'public');

        return 'storage/' . $path . '/' . $fileName;
    }

    // Function to upload company logo
    public function companyLogo($file, $path = 'company-logo', $previousImagePath = null)
    {
        if ($previousImagePath) {
        $this->deleteImage($previousImagePath);
        }
    
        // Use a shorter random string
        $fileName = time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();

        // Save to storage/app/public/file-opening-image
        $file->storeAs($path, $fileName, 'public');

        return 'storage/' . $path . '/' . $fileName;
    }

    // Function to upload favicon photo
    public function faviconPhoto($file, $path = 'favicon-photo', $previousImagePath = null)
    {
        if ($previousImagePath) {
        $this->deleteImage($previousImagePath);
        }
    
        // Use a shorter random string
        $fileName = time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();

        // Save to storage/app/public/file-opening-image
        $file->storeAs($path, $fileName, 'public');

        return 'storage/' . $path . '/' . $fileName;
    }

    // Delete Image Method
    public function deleteImage($filePath)
    {
        $relativePath = str_replace('/storage/', 'public/', $filePath);
        if (Storage::exists($relativePath)) {
        Storage::delete($relativePath);
        }
    }

}
