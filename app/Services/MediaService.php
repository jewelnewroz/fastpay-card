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
        $this->dir = 'uploads/files/' . date('Y') . '/' . date('m');
    }

    public function upload($file): ?Model
    {
        if($file) {
            $imageName = time() . '.' . $file->extension();
            $file->storeAs(public_path($this->dir), $imageName);
            return $this->repository->create([
                'attachment' => $this->dir . '/' . $imageName,
                'extension' => $file->extension()
            ]);
        }
        return null;
    }
}
