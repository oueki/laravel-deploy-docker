<?php

namespace Tests\Feature\Http\Controllers;

use App\Http\Controllers\OpenApi\FileController;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class FileControllerTest extends TestCase
{
    /** @test */
    public function test_upload_file()
    {
        $this->travelTo(Carbon::make('2022-01-01 00:00:00'));

        Storage::fake('public');

        $file = UploadedFile::fake()->image('test.jpg');

        $this
            ->post(action([FileController::class, 'upload']), [
                'file' => $file,
            ])
            ->assertSuccessful();

        Storage::disk('public')->assertExists('/uploads/2022-01-01-00-00-00-test.jpg');
    }
}
