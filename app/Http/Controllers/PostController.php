<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Services\PostService;
use Illuminate\Http\JsonResponse;

class PostController extends Controller
{
    public function __construct(
        private PostService $postService
    ) {}

    public function index(): JsonResponse
    {
        $this->authorize('viewAny', Post::class);

        $posts = $this->postService->getAll();

        return response()->json([
            'success' => true,
            'message' => 'Posts fetched successfully',
            'data' => PostResource::collection($posts),
        ]);
    }

    public function store(StorePostRequest $request): JsonResponse
    {
        $this->authorize('create', Post::class);

        $post = $this->postService->create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Post created successfully',
            'data' => new PostResource($post),
        ], 201);
    }

    public function show(Post $post): JsonResponse
    {
        $this->authorize('view', $post);

        return response()->json([
            'success' => true,
            'message' => 'Post fetched successfully',
            'data' => new PostResource($post),
        ]);
    }

    public function update(UpdatePostRequest $request, Post $post): JsonResponse
    {
        $this->authorize('update', $post);

        $this->postService->update($post, $request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Post updated successfully',
            'data' => new PostResource($post),
        ]);
    }

    public function destroy(Post $post): JsonResponse
    {
        $this->authorize('delete', $post);

        $this->postService->delete($post);

        return response()->json([
            'success' => true,
            'message' => 'Post deleted successfully',
            'data' => null,
        ]);
    }
}
