<?php

namespace App\Services;

use App\Team;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Image;
use League\Flysystem\FileNotFoundException;
use RuntimeException;

class PhotoStorageService
{

    /* @var Storage */
    protected $cloudFs;

    /* @var Storage */
    protected $localFs;

    /**
     * @param Team $team
     */
    public function __construct()
    {
        $this->cloudFs = Storage::cloud();
        $this->localFs = Storage::disk();
    }

    public function listSourcePhotos(): array
    {
        return $this->cloudFs->listContents('source-photos');
    }

    public function createTeamDirectory(string $teamName): void
    {
        $success = $this->cloudFs->createDir('teams/'.$teamName);
        if (!$success) {
            throw new RuntimeException('Could not create team directory.');
        }
    }

    /**
     * @param string $filePath
     * @param string [$localPath] - Defaults to same path as $filePath.
     *
     * @return string - local filepath
     * @throws FileNotFoundException
     */
    public function downloadPhoto(string $filePath, ?string $localPath = null): string
    {
        $localPath = $localPath ?? $filePath;

        $stream = $this->cloudFs->readStream($filePath);
        $success = $this->localFs->putStream($localPath, $stream);
        if (!$success) {
            throw new RuntimeException('Could not download file.');
        }

        return $localPath;
    }

    /**
     * @param string $sourcePath
     * @param string $targetPath
     *
     * @return string - target path
     * @throws FileNotFoundException
     */
    public function copyLocalFile(string $sourcePath, string $targetPath): string {
        $stream = $this->localFs->readStream($sourcePath);
        $this->localFs->putStream($targetPath, $stream);

        return $targetPath;
    }

    public function saveLocalImage(Image $img, string $path)
    {
        $this->localFs->put($path, $img->encode()->encoded);
    }

    public function loadPhoto(string $sourcePath): string
    {
        return $this->localFs->get($sourcePath);
    }

}
