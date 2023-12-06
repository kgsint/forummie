<?php

namespace App\Contracts;

use App\Models\Topic;

interface TopicInterface
{
    public function getAll();

    public function getPaginatedCollection();

    public function store(array $data);

    public function update(Topic $topic, array $data);

    public function delete(Topic $topic);
}
