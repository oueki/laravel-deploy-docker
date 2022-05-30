<?php

namespace App\Services\FileUploader;


use Illuminate\Http\UploadedFile;
use Illuminate\Contracts\Filesystem\Factory;

class FileUploader
{
    const BASE_FOLDER = 'storage';
    const FOLDER_NAME = 'uploads';

    public function __construct(
        public readonly Factory $storage,
        public readonly string $disk = 'public'
    ){
    }

    public function upload(UploadedFile $file): string
    {

       $timestamp = now()->format('Y-m-d-H-i-s');
       $filename = "{$timestamp}-{$file->getClientOriginalName()}";

       $this->storage->disk($this->disk)->putFileAs(self::FOLDER_NAME, $file, $filename);

       return $filename;
    }

    public function generateUrl(string $path): string
    {
        return env('APP_URL') . '/' . self::BASE_FOLDER . '/' . self::FOLDER_NAME . '/' . $path;
    }

    public function remove(string $path): void
    {
        $this->storage->disk($this->disk)->delete(self::FOLDER_NAME . '/' . $path);
    }

}
