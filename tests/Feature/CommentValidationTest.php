<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CommentValidationTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testValidationNoComment(): void
    {
        $response = $this->postJson('comments/50', [
            'comment' => '',
        ]);

        $response->assertStatus(422);

        $response->assertJsonValidationErrors('comment');
    }

    /**
     * コメントが入力されている場合、バリデーションが通る
     */
    public function testValidationComment()
    {
        $response = $this->postJson('comments/50', [
            'comment' => 'comment comment',
        ]);

        $response->assertStatus(302);
    }
}
