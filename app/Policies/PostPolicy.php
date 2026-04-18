<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;

class PostPolicy
{
    /**
     * Anyone (including guest) can view posts
     */
    public function viewAny(?User $user): bool
    {
        return true;
    }

    /**
     * Anyone can view a single post
     */
    public function view(?User $user, Post $post): bool
    {
        return true;
    }

    /**
     * Only authenticated users can create
     */
    public function create(User $user): bool
    {
        return $user->is_admin === false;
    }

    /**
     * Owner OR admin can update
     */
    public function update(User $user, Post $post): bool
    {
        return $user->id === $post->user_id || $user->is_admin === true;
    }

    /**
     * Owner OR admin can delete
     */
    public function delete(User $user, Post $post): bool
    {
        return $user->id === $post->user_id || $user->is_admin === true;
    }
}
