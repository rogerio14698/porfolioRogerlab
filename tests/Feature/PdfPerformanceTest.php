<?php

namespace Tests\Feature;

use App\Http\Controllers\PdfCvController;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Tests\TestCase;

class PdfPerformanceTest extends TestCase
{
    public function test_both_cvs_are_inline_cacheable_and_do_not_start_a_session(): void
    {
        foreach (['english', 'spanish'] as $language) {
            $response = $this->get('/pdf-cv/'.$language)
                ->assertOk()
                ->assertHeader('Content-Type', 'application/pdf')
                ->assertHeader('Accept-Ranges', 'bytes')
                ->assertHeaderMissing('Set-Cookie');

            $this->assertStringContainsString('inline;', $response->headers->get('Content-Disposition'));
            $this->assertStringContainsString('max-age=3600', $response->headers->get('Cache-Control'));
            $this->assertStringContainsString('public', $response->headers->get('Cache-Control'));
            $this->assertNotEmpty($response->headers->get('ETag'));
            $this->assertNotEmpty($response->headers->get('Last-Modified'));
            $this->assertGreaterThan(0, (int) $response->headers->get('Content-Length'));
        }
    }

    public function test_unchanged_cvs_return_304_for_etag_and_last_modified(): void
    {
        foreach (['english', 'spanish'] as $language) {
            $url = '/pdf-cv/'.$language;
            $original = $this->get($url)->assertOk();

            $this->get($url, ['If-None-Match' => $original->headers->get('ETag')])
                ->assertStatus(304)->assertHeaderMissing('Set-Cookie');
            $this->get($url, ['If-Modified-Since' => $original->headers->get('Last-Modified')])
                ->assertStatus(304)->assertHeaderMissing('Set-Cookie');
            $this->get($url, [
                'If-None-Match' => '"outdated-document"',
                'If-Modified-Since' => $original->headers->get('Last-Modified'),
            ])->assertOk();
        }
    }

    public function test_pdf_viewers_can_request_ranges_and_head(): void
    {
        foreach (['english', 'spanish'] as $language) {
            $url = '/pdf-cv/'.$language;
            $original = $this->get($url)->assertOk();
            $length = (int) $original->headers->get('Content-Length');

            $this->get($url, ['Range' => 'bytes=0-1023'])
                ->assertStatus(206)
                ->assertHeader('Content-Range', 'bytes 0-1023/'.$length)
                ->assertHeader('Content-Length', '1024');
            $this->get($url, ['Range' => 'bytes=0-1023', 'If-Range' => $original->headers->get('ETag')])
                ->assertStatus(206);
            $this->get($url, ['Range' => 'bytes=0-1023', 'If-Range' => '"outdated-document"'])
                ->assertOk()->assertHeader('Content-Length', (string) $length);
            $this->get($url, ['Range' => 'bytes='.$length.'-'.($length + 1024)])
                ->assertStatus(416);
            $this->head($url)->assertOk()
                ->assertHeader('Content-Length', (string) $length)
                ->assertHeaderMissing('Set-Cookie');
        }
    }

    public function test_unknown_language_returns_404_instead_of_a_fallback_document(): void
    {
        $this->expectException(NotFoundHttpException::class);
        app(PdfCvController::class)(Request::create('/pdf-cv/french'), 'french');
    }
}
