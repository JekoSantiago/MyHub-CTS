<?php

namespace App\Services;

use Google\Cloud\Storage\StorageClient;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GoogleCloudServices
{
    protected $storage;
    protected $bucket;

    public function __construct()
    {
        $this->storage = new StorageClient([
            'keyFilePath' => config('filesystems.disks.gcs.key_file'),
            'projectId' => config('filesystems.disks.gcs.project_id'),
        ]);
        $this->bucket = $this->storage->bucket(config('filesystems.disks.gcs.bucket'));
    }

    public function uploadFile($filePath, $fileName)
    {
        $file = fopen($filePath, 'r');
        $object = $this->bucket->upload($file, [
            'name' => $fileName,
        ]);

        return $object->info()['mediaLink']; // Return public URL
    }



    public function getTemporaryLink($fileName, $expirationMinutes = 15)
    {
        $bucket = $this->bucket;
        $object = $bucket->object($fileName);

        $url = $object->signedUrl(
            new \DateTime('+' . $expirationMinutes . ' minutes'), // Expiration time
            ['version' => 'v4']
        );

        return $url;
    }

    public function fetchFileAsBase64($url)
    {
        try {
            // Fetch the file from the URL
            $response = Http::get($url);

            if ($response->ok()) {
                $content = $response->body();
                $mimeType = $response->header('Content-Type'); // Get the MIME type

                // Convert the file content to Base64
                $base64 = 'data:' . $mimeType . ';base64,' . base64_encode($content);

                return [
                    'base64' => $base64,
                    'mimeType' => $mimeType // Return the MIME type
                ];
            }

            throw new \Exception('Failed to fetch file: ' . $response->status());
        } catch (\Exception $e) {
            throw new \Exception('Error retrieving file: ' . $e->getMessage());
        }
    }

    public function deleteFile($fileName)
    {
        // dd($fileName);
        try {
            $object = $this->bucket->object($fileName);
            $object->delete();
            return true;
        } catch (\Exception $e) {
            Log::warning('Failed to delete file from bucket: ' . $e->getMessage());
            return false;
        }
    }

    public function folderExists($folderName)
    {
        $objects = $this->bucket->objects(['prefix' => $folderName]);
        return !empty($objects); // Returns true if the folder exists, false otherwise
    }

    public function listFilesInFolder($folder)
    {
        // dd($folder);
        $objects = $this->bucket->objects(['prefix' => $folder]);
        $fileNames = [];
        foreach ($objects as $object) {
            $fileNames[] = $object->name(); // Collect the names of the files
        }
        return $fileNames;
    }

    public function fileExists($fileName)
    {
        $object = $this->bucket->object($fileName);
        return $object->exists(); // Returns true if the file exists, false otherwise
    }
}
