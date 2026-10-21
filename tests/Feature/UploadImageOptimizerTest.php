<?php

namespace Tests\Feature;

use App\Services\UploadImageOptimizer;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class UploadImageOptimizerTest extends TestCase
{
    public function test_large_image_is_reduced_to_webp_without_cropping(): void
    {
        Storage::fake('blog');
        $upload = new UploadedFile(public_path('img/cv-foto.jpeg'), 'portrait.jpg', 'image/jpeg', null, true);
        $path = app(UploadImageOptimizer::class)->store($upload, 'images', 'uploads.0.file');
        $bytes = Storage::disk('blog')->get($path);
        $size = getimagesizefromstring($bytes);

        $this->assertStringEndsWith('.webp', $path);
        $this->assertSame(IMAGETYPE_WEBP, $size[2]);
        $this->assertSame(1600, max($size[0], $size[1]));
        $this->assertEqualsWithDelta(1170 / 2080, $size[0] / $size[1], 0.001);
        $this->assertLessThan($upload->getSize() / 2, strlen($bytes));
    }

    public function test_small_transparent_images_are_not_enlarged_and_keep_alpha(): void
    {
        Storage::fake('blog');
        $image = imagecreatetruecolor(40, 20);
        imagealphablending($image, false);
        imagesavealpha($image, true);
        imagefill($image, 0, 0, imagecolorallocatealpha($image, 0, 0, 0, 127));
        ob_start();
        imagepng($image);
        $upload = UploadedFile::fake()->createWithContent('transparent.png', ob_get_clean());
        imagedestroy($image);

        $path = app(UploadImageOptimizer::class)->store($upload, 'projects', 'uploads.0');
        $result = imagecreatefromstring(Storage::disk('blog')->get($path));
        $this->assertSame(40, imagesx($result));
        $this->assertSame(20, imagesy($result));
        $this->assertSame(127, imagecolorsforindex($result, imagecolorat($result, 0, 0))['alpha']);
        imagedestroy($result);
    }

    public function test_insufficient_memory_is_an_explicit_validation_error_without_storing_files(): void
    {
        Storage::fake('blog');
        $previous = ini_get('memory_limit');
        ini_set('memory_limit', (string) (memory_get_usage(true) + 1024 * 1024));
        try {
            $upload = new UploadedFile(public_path('img/cv-foto.jpeg'), 'portrait.jpg', 'image/jpeg', null, true);
            app(UploadImageOptimizer::class)->store($upload, 'images', 'uploads.0.file');
            $this->fail('Expected an explicit validation error.');
        } catch (ValidationException $exception) {
            $this->assertArrayHasKey('uploads.0.file', $exception->errors());
            $this->assertSame([], Storage::disk('blog')->allFiles());
        } finally {
            ini_set('memory_limit', $previous);
        }

    }

    public function test_corrupt_image_is_rejected_without_storing_an_original(): void
    {
        Storage::fake('blog');
        $upload = UploadedFile::fake()->createWithContent('broken.png', base64_decode(
            'iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8/x8AAwMCAO+a6XcAAAAASUVORK5CYII='
        ));
        try {
            app(UploadImageOptimizer::class)->store($upload, 'images', 'uploads.0.file');
            $this->fail('Expected a decoding error.');
        } catch (ValidationException $exception) {
            $this->assertArrayHasKey('uploads.0.file', $exception->errors());
            $this->assertSame([], Storage::disk('blog')->allFiles());
        }
    }
}
