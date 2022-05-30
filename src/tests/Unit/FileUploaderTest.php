<?php

namespace Tests\Unit;

use App\Services\FileUploader\FileUploader;
use Carbon\Carbon;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Filesystem\FilesystemManager;
use Illuminate\Http\UploadedFile;
use League\Flysystem\Filesystem;
use League\Flysystem\InMemory\InMemoryFilesystemAdapter;
use Tests\TestCase;


class FileUploaderTest extends TestCase
{

    private UploadedFile $file;
    private FilesystemManager $storage;

    protected function setUp(): void
    {
        parent::setUp();

        $this->travelTo(Carbon::make('2022-01-01 00:00:00'));

        $this->file = UploadedFile::fake()->image('test.jpg');

        $adapter = new InMemoryFilesystemAdapter();
        $filesystemAdapter = new FilesystemAdapter(new Filesystem($adapter), $adapter);
        $storage = new FilesystemManager($this->createApplication());
        $storage->extend('memory', function() use ($filesystemAdapter) {
            return $filesystemAdapter;
        });

        $this->storage = $storage;

    }


    /** @test */
    public function test_upload_file()
    {

        $fileUploader = new FileUploader($this->storage, 'inmemory');
        $fileName = $fileUploader->upload($this->file);

        $this->storage->disk('inmemory')->assertExists('/uploads/2022-01-01-00-00-00-test.jpg');

        $this->assertEquals('2022-01-01-00-00-00-test.jpg', $fileName);
    }

    /** @test */
    public function test_upload_file_generate_url()
    {

        $fileUploader = new FileUploader($this->storage, 'inmemory');
        $slugImage = $fileUploader->upload($this->file);

        $urlImage = $fileUploader->generateUrl($slugImage);

        $url = env('APP_URL') . '/storage/uploads/' . $slugImage;

        $this->assertEquals($url, $urlImage);

    }

    /** @test */
    public function test_upload_file_remove_file()
    {

        $fileUploader = new FileUploader($this->storage, 'inmemory');
        $fileUploader->upload($this->file);

        $this->storage->disk('inmemory')->assertExists('/uploads/2022-01-01-00-00-00-test.jpg');

        $fileUploader->remove('/uploads/2022-01-01-00-00-00-test.jpg');

        $this->storage->disk('inmemory')->assertExists('/uploads/2022-01-01-00-00-00-test.jpg');

    }
}
