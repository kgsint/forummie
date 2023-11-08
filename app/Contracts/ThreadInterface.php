<?php

namespace App\Contracts;

use App\Models\Thread;

interface ThreadInterface
{
    public function getFilterablePaginatedCollection();

    public function relatedPosts(Thread $thread);

    public function findById(string|int $id);

    public function store(array $data);
}
