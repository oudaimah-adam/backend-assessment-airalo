<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Post;
use App\Repositories\PostRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;
use Throwable;

/**
 * There might be an argument that this abstraction layer is not needed but imagine the scenario where
 * saving the post requires us to do modify/insert another entity
 * So instead of injecting multiple repositories into the Controller, it's better to do it here
 */
final class PostService
{
    public function __construct(
        private PostRepository $postRepository,
    ) {
    }

    public function getAllPosts(): Collection
    {
        return $this->postRepository->all();
    }

    public function getPost(int $id): ?Post
    {
        try {
            return $this->postRepository->find($id);
        } catch (ModelNotFoundException|Throwable) {
            return null;
        }
    }

    public function createPost(array $attributes): ?Post
    {
        try {
            return $this->postRepository->create($attributes);
        } catch (\Throwable) {
            return null;
        }
    }

    public function updatePost(int $id, array $attributes): ?Post
    {
        try {
            return $this->postRepository->update($id, $attributes);
        } catch (ModelNotFoundException|Throwable) {
            return null;
        }
    }

    public function deletePost(int $id): ?bool
    {
        try {
            return $this->postRepository->delete($id);
        } catch (ModelNotFoundException|Throwable) {
            return null;
        }
    }
}
