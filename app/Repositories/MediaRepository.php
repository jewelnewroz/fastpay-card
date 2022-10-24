<?php

namespace App\Repositories;

use App\Models\Media;
use App\Repositories\Interfaces\MediaRepositoryInterface;

class MediaRepository extends BaseRepository implements MediaRepositoryInterface
{
    public function __construct(Media $model)
    {
        parent::__construct($model);
    }
}
