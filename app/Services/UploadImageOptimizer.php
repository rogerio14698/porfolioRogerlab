<?php

namespace App\Services;

use ErrorException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use RuntimeException;

class UploadImageOptimizer
{
    public function store(UploadedFile $upload, string $directory, string $field): string
    {
        if (! extension_loaded('gd') || ! function_exists('imagewebp')) {
            throw ValidationException::withMessages([$field => __('blog.optimization_unavailable')]);
        }

        $size = getimagesize($upload->getPathname());
        $limit = ini_parse_quantity(ini_get('memory_limit'));
        if (! $size || ($limit > 0 && memory_get_usage(true) + $size[0] * $size[1] * 8 + 32 * 1024 * 1024 > $limit)) {
            throw ValidationException::withMessages([$field => __('blog.optimization_failed')]);
        }

        try {
            $source = imagecreatefromstring($upload->get());
        } catch (ErrorException $exception) {
            report($exception);
            throw ValidationException::withMessages([$field => __('blog.optimization_failed')]);
        }
        if ($source === false) {
            throw ValidationException::withMessages([$field => __('blog.optimization_failed')]);
        }

        $target = null;
        $temporary = null;
        try {
            if ($size[2] === IMAGETYPE_JPEG && function_exists('exif_read_data')) {
                $exif = exif_read_data($upload->getPathname());
                $orientation = (int) ($exif['Orientation'] ?? 1);
                if (in_array($orientation, [2, 4, 5, 7], true)) {
                    imageflip($source, IMG_FLIP_HORIZONTAL);
                }
                $angle = match ($orientation) {
                    3, 4 => 180,
                    6, 7 => -90,
                    5, 8 => 90,
                    default => 0,
                };
                if ($angle !== 0) {
                    $rotated = imagerotate($source, $angle, 0);
                    if ($rotated === false) {
                        throw new RuntimeException('Unable to orient uploaded image.');
                    }
                    imagedestroy($source);
                    $source = $rotated;
                }
            }

            $scale = min(1, 1600 / max(imagesx($source), imagesy($source)));
            $width = max(1, (int) round(imagesx($source) * $scale));
            $height = max(1, (int) round(imagesy($source) * $scale));
            $target = imagecreatetruecolor($width, $height);
            if ($target === false) {
                throw new RuntimeException('Unable to allocate optimized image.');
            }
            imagealphablending($target, false);
            imagesavealpha($target, true);
            imagecopyresampled($target, $source, 0, 0, 0, 0, $width, $height, imagesx($source), imagesy($source));

            $temporary = tempnam(sys_get_temp_dir(), 'rogerlab-image-');
            if ($temporary === false) {
                throw new RuntimeException('Unable to create image optimization temporary file.');
            }
            for ($quality = 78; $quality >= 60; $quality -= 6) {
                if (! imagewebp($target, $temporary, $quality)) {
                    throw new RuntimeException('Unable to encode uploaded image as WebP.');
                }
                clearstatcache(true, $temporary);
                if (filesize($temporary) <= 300 * 1024) {
                    break;
                }
            }
            $bytes = file_get_contents($temporary);
            if ($bytes === false || $bytes === '') {
                throw new RuntimeException('Optimized image is empty or unreadable.');
            }
            $path = $directory.'/'.Str::uuid().'.webp';
            Storage::disk('blog')->put($path, $bytes);

            return $path;
        } finally {
            imagedestroy($source);
            if ($target !== null && $target !== false) {
                imagedestroy($target);
            }
            if (is_string($temporary)) {
                unlink($temporary);
            }
        }
    }
}
