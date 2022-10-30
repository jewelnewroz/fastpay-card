<?php

namespace App\Services;

use App\Repositories\Interfaces\MediaRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class MediaService
{
    private string $dir;
    private MediaRepositoryInterface $repository;

    public function __construct(MediaRepositoryInterface $repository)
    {
        $this->repository = $repository;
        $this->dir = 'uploads/' . date('Y') . '/' . date('m');
    }

    public function upload($file): ?Model
    {
        if($file) {
            $path = $file->store($this->dir, 'public');
            return $this->repository->create([
                'attachment' => 'storage/' . $path,
                'extension' => $file->extension()
            ]);
        }
        return null;
    }
}
