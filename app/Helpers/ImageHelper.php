<?php

namespace App\Helpers;

class ImageHelper
{
    public static function compressImage($source, $destination, $quality)
    {
        // Get image information
        $imageInfo = getimagesize($source);
        $mimeType = $imageInfo['mime'];

        // Create image from source
        switch ($mimeType) {
            case 'image/jpeg':
                $image = imagecreatefromjpeg($source);
                break;
            case 'image/png':
                $image = imagecreatefrompng($source);
                break;
            case 'image/gif':
                $image = imagecreatefromgif($source);
                break;
            default:
                return false;
        }

        // Save compressed image
        if ($mimeType == 'image/jpeg') {
            return imagejpeg($image, $destination, $quality); // For JPEG
        } elseif ($mimeType == 'image/png') {
            return imagepng($image, $destination, 9); // For PNG (compression level from 0 to 9)
        }

        return false;
    }
}
