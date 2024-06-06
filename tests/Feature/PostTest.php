<?php

declare(strict_types=1);

use App\Models\Post;
use Symfony\Component\HttpFoundation\Response;

it('returns post list', function () {
    // Arrange
    $postCount = 5;
    Post::factory()->count($postCount)->create();

    // Act
    $response = $this->getJson('/api/posts');

    // Assert
    $response->assertStatus(Response::HTTP_OK)
        ->assertJsonCount($postCount, 'data');
});

it('returns a post', function () {
    // Arrange
    $post = Post::factory()->create();

    // Act
    $response = $this->getJson(sprintf('/api/posts/%d', $post->id));

    // Assert
    $response->assertStatus(Response::HTTP_OK)
        ->assertJsonFragment([
            'id' => $post->id,
            'title' => $post->title,
            'body' => $post->body,
        ]);
});

it('creates a post', function () {
    // Arrange
    $postData = ['title' => 'Test Title', 'body' => 'Dummy Content From Test'];

    // Act
    $response = $this->postJson('/api/posts', $postData);

    // Assert
    $response->assertStatus(Response::HTTP_CREATED)
        ->assertJsonFragment($postData);
    $this->assertDatabaseHas('posts', $postData);
});

it('updates a post', function () {
    // Arrange
    $post = Post::factory()->create();
    $data = ['title' => 'Updated Title', 'body' => 'Updated Dummy Content From Test'];

    // Act
    $response = $this->putJson('/api/posts/' . $post->id, $data);

    // Assert
    $response->assertStatus(Response::HTTP_OK)
        ->assertJsonFragment($data);
    $this->assertDatabaseHas('posts', $data);
});

it('deletes a post', function () {
    // Arrange
    $post = Post::factory()->create();

    // Act
    $response = $this->deleteJson('/api/posts/' . $post->id);

    // Assert
    $response->assertStatus(Response::HTTP_NO_CONTENT);
    $this->assertDatabaseMissing('posts', ['id' => $post->id]);
});
