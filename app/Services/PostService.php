<?php

namespace App\Services;

use App\Models\Post;
use App\Repositories\PostRepository;
use Illuminate\Support\Facades\Auth;

class PostService
{
    public function __construct(
        private PostRepository $postRepository
    ) {}

    public function create(array $data): Post
    {
        $data['user_id'] = Auth::id();

        return $this->postRepository->create($data);
    }

    public function update(Post $post, array $data): bool
    {
        return $this->postRepository->update($post, $data);
    }

    public function delete(Post $post): bool
    {
        return $this->postRepository->delete($post);
    }
}
