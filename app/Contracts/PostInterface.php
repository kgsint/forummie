<?php

namespace App\Contracts;

use App\Models\Post;

interface PostInterface
{
    public function getAll();

    public function store(array $data);

    public function update(Post $post, array $data);

    public function delete(Post $post);
}
