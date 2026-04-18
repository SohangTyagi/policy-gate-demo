<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostPolicyTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected User $user1;
    protected User $user2;
    protected Post $post;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create([
            'is_admin' => true,
        ]);

        $this->user1 = User::factory()->create([
            'is_admin' => false,
        ]);

        $this->user2 = User::factory()->create([
            'is_admin' => false,
        ]);

        $this->post = Post::factory()->create([
            'user_id' => $this->user1->id,
            'title' => 'Original Title',
        ]);
    }

    /** @test */
    public function test_admin_can_update_any_post(): void
    {
        $this->actingAs($this->admin);

        $response = $this->putJson("/api/posts/{$this->post->id}", [
            'title' => 'Updated by admin',
            'content' => 'Updated content',
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('posts', [
            'id' => $this->post->id,
            'title' => 'Updated by admin',
        ]);
    }

    /** @test */
    public function test_user_can_update_own_post(): void
    {
        $this->actingAs($this->user1);

        $response = $this->putJson("/api/posts/{$this->post->id}", [
            'title' => 'Updated by owner',
            'content' => 'Updated content',
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('posts', [
            'id' => $this->post->id,
            'title' => 'Updated by owner',
        ]);
    }

    /** @test */
    public function test_user_cannot_update_others_post(): void
    {
        $this->actingAs($this->user2);

        $response = $this->putJson("/api/posts/{$this->post->id}", [
            'title' => 'Hacked attempt',
            'content' => 'Hacked content',
        ]);

        $response->assertStatus(403);
    }

    /** @test */
    public function test_guest_can_view_posts(): void
    {
        $response = $this->getJson("/api/posts");

        $response->assertStatus(200);
    }

    /** @test */
    public function test_guest_cannot_create_post(): void
    {
        $response = $this->postJson("/api/posts", [
            'title' => 'Guest Post',
            'content' => 'Guest content',
        ]);

        $response->assertStatus(401);
    }
}
