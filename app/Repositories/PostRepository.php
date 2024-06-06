<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\RepositoryInterface;
use App\Models\Post;
use Illuminate\Support\Collection;

class PostRepository implements RepositoryInterface
{
    public function all(): Collection
    {
        return Post::all();
    }

    public function find(int $id): Post
    {
        return Post::query()->findOrFail($id);
    }

    public function create(array $attributes): Post
    {
        return Post::query()->create($attributes);
    }

    public function update(int $id, array $attributes): Post
    {
        $post = $this->find($id);
        $post->update($attributes);

        return $post;
    }

    public function delete(int $id): bool
    {
        $post = $this->find($id);

        return $post->delete();
    }
}
