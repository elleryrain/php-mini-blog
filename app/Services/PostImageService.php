<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostImageService
{
    public function uploadAndCrop(UploadedFile $file, ?string $oldPath = null): string
    {
        $raw = file_get_contents($file->getRealPath());
        $source = @imagecreatefromstring($raw);

        if (! $source) {
            throw new \RuntimeException('Невозможно обработать изображение.');
        }

        $srcW = imagesx($source);
        $srcH = imagesy($source);

        $targetW = 1200;
        $targetH = 630;
        $targetRatio = $targetW / $targetH;
        $srcRatio = $srcW / $srcH;

        if ($srcRatio > $targetRatio) {
            $cropH = $srcH;
            $cropW = (int) round($srcH * $targetRatio);
            $cropX = (int) round(($srcW - $cropW) / 2);
            $cropY = 0;
        } else {
            $cropW = $srcW;
            $cropH = (int) round($srcW / $targetRatio);
            $cropX = 0;
            $cropY = (int) round(($srcH - $cropH) / 2);
        }

        $canvas = imagecreatetruecolor($targetW, $targetH);
        imagecopyresampled($canvas, $source, 0, 0, $cropX, $cropY, $targetW, $targetH, $cropW, $cropH);

        ob_start();
        imagejpeg($canvas, null, 85);
        $jpeg = ob_get_clean();

        imagedestroy($source);
        imagedestroy($canvas);

        $path = 'posts/'.date('Y/m').'/'.Str::uuid().'.jpg';
        Storage::disk('public')->put($path, $jpeg);

        if ($oldPath) {
            Storage::disk('public')->delete($oldPath);
        }

        return $path;
    }

    public function delete(?string $path): void
    {
        if ($path) {
            Storage::disk('public')->delete($path);
        }
    }
}
