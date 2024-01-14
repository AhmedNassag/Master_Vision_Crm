<?php
namespace App\Helpers;
use Imagick;

class ThumbnailCreator
{
    public static function createThumbnail($sourcePath, $destinationPath, $width, $height)
    {
        $extension = strtolower(pathinfo($sourcePath, PATHINFO_EXTENSION));

        if ($extension === 'pdf') {
            self::createPdfThumbnail($sourcePath, $destinationPath, $width, $height);
        } elseif (in_array($extension, ['jpg', 'jpeg', 'png', 'gif'], true)) {
            self::createImageThumbnail($sourcePath, $destinationPath, $width, $height);
        } else {
            // Unsupported file type
            throw new \Exception('Unsupported file type: ' . $extension);
        }
    }

    private static function createImageThumbnail($sourcePath, $destinationPath, $width, $height)
    {
        list($srcWidth, $srcHeight) = getimagesize($sourcePath);

        $srcImage = self::createImageResource($sourcePath);

        $thumbWidth = $srcWidth;
        $thumbHeight = $srcHeight;

        if ($srcWidth > $width) {
            $thumbWidth = $width;
            $thumbHeight = intval($srcHeight * ($width / $srcWidth));
        }

        if ($srcHeight > $height) {
            $thumbHeight = $height;
            $thumbWidth = intval($srcWidth * ($height / $srcHeight));
        }

        $thumbImage = imagecreatetruecolor($thumbWidth, $thumbHeight);

        imagecopyresampled($thumbImage, $srcImage, 0, 0, 0, 0, $thumbWidth, $thumbHeight, $srcWidth, $srcHeight);

        self::saveImageResource($thumbImage, $destinationPath);

        imagedestroy($srcImage);
        imagedestroy($thumbImage);
    }

    private static function createPdfThumbnail($sourcePath, $destinationPath, $width, $height)
    {
        $imagick = new Imagick();
        $imagick->setResolution(72, 72);
        $imagick->readImage($sourcePath . '[0]'); // Read the first page of the PDF

        $imagick->thumbnailImage($width, $height, true);

        $imagick->writeImage($destinationPath);

        $imagick->clear();
        $imagick->destroy();
    }

    private static function createImageResource($path)
    {
        $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));

        if ($extension === 'jpg' || $extension === 'jpeg') {
            return imagecreatefromjpeg($path);
        } elseif ($extension === 'png') {
            return imagecreatefrompng($path);
        } elseif ($extension === 'gif') {
            return imagecreatefromgif($path);
        } else {
            throw new \Exception('Unsupported image type: ' . $extension);
        }
    }

    private static function saveImageResource($resource, $path)
    {
        $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));

        if ($extension === 'jpg' || $extension === 'jpeg') {
            imagejpeg($resource, $path);
        } elseif ($extension === 'png') {
            imagepng($resource, $path);
        } elseif ($extension === 'gif') {
            imagegif($resource, $path);
        } else {
            throw new \Exception('Unsupported image type: ' . $extension);
        }
    }
}