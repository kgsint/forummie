<?php

namespace App\Repositories;

use App\Contracts\TopicInterface;
use App\Http\Controllers\Admin\TopicsController;
use App\Models\Topic;

class TopicRepository implements TopicInterface
{
    public function getAll()
    {
        return Topic::get();
    }

    public function getPaginatedCollection()
    {
        return Topic::
                    searchByName()
                    ->latest()
                    ->paginate(Topic::PAGINATION_COUNT);
    }

    public function store(array $data)
    {
        return Topic::create([
            'name' => $data['name'],
            'slug' => $data['slug'],
        ]);
    }

    public function update(Topic $topic, array $data)
    {
        $topic->update([
            'name' => $data['name'],
            'slug' => $data['slug'],
        ]);
    }

    public function delete(Topic $topic)
    {
        $topic->delete();
    }
}
