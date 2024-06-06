<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostResource;
use App\Services\PostService;
use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class PostController extends Controller
{
    public function __construct(
        private PostService $postService,
    ) {
    }

    public function index(): JsonResponse
    {
        try {
            return $this->json(
                data: PostResource::collection($this->postService->getAllPosts()),
                message: 'Posts retrieved successfully.',
            );
        } catch (Exception $exception) {
            return $this->json(
                success: false,
                code: Response::HTTP_INTERNAL_SERVER_ERROR,
                message: $exception->getMessage(),
            );
        }
    }

    public function store(CreatePostRequest $request): JsonResponse
    {
        $post = $this->postService->createPost($request->validated());

        if (! $post) {
            return $this->json(
                success: false,
                code: Response::HTTP_INTERNAL_SERVER_ERROR,
                message: 'Post could not be created.',
            );
        }

        return $this->json(
            code: Response::HTTP_CREATED,
            data: new PostResource($post),
            message: 'Post created successfully.',
        );
    }

    public function show(int $id): JsonResponse
    {
        $post = $this->postService->getPost($id);
        if (! $post) {
            return $this->json(
                success: false,
                code: Response::HTTP_NOT_FOUND,
                message: sprintf('Post with id %d not found.', $id),
            );
        }

        return $this->json(
            data: new PostResource($post),
            message: 'Post retrieved successfully.',
        );
    }

    public function update(UpdatePostRequest $request, int $id): JsonResponse
    {
        $post = $this->postService->updatePost($id, $request->validated());
        if (! $post) {
            return $this->json(
                success: false,
                code: Response::HTTP_NOT_FOUND,
                message: sprintf('Post with id %d not found.', $id),
            );
        }

        return $this->json(
            data: $post,
            message: 'Post updated successfully.',
        );
    }

    public function destroy(int $id): JsonResponse
    {
        if (! $this->postService->deletePost($id)) {
            return $this->json(
                success: false,
                code: Response::HTTP_NOT_FOUND,
                message: sprintf('Post with id %d not found.', $id),
            );
        }

        return $this->json(
            code: Response::HTTP_NO_CONTENT,
            message: sprintf('Post with id %d deleted successfully.', $id),
        );
    }
}
