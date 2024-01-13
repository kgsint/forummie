<?php

namespace App\Contracts;

use App\Models\Post;
use App\Models\Thread;

interface PostInterface
{
    public function getAll();

    public function getByThread(Thread $thread);

    public function store(array $data);

    public function update(Post $post, array $data);

    public function delete(Post $post);
}
