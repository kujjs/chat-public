<?php

namespace Tests\Feature;

use App\Message;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp() : void
    {
        parent::setUp();
        $this->markTestSkipped(
            'Need to update'
        );
    }

    /** @test  */
    public function a_user_guest_can_access_to_write_a_comment()
    {
        $response = $this->get(route('home.comment'));
        $response->assertOk();
    }

    /** @test  */
    public function a_user_guest_can_write_a_comment()
    {

        $data = [
            'name'=>'jon doe',
            'body'=>'Lorem ipsum dolor sit amet, consectetur',
            'media'=>'lorem'
        ];
        $response = $this->post(route('home.comment',$data));
        $response->assertStatus(302)
                 ->assertRedirect(route('home.comment'));

        $this->assertDatabaseHas('comments', [
             'name'=>'jon doe',
             'body'=>'Lorem ipsum dolor sit amet, consectetur',
             ]);
    }
    /** @test  */
    public function a_user_guest_can_view_other_comments()
    {
        factory(Message::class)->create(['body'=>'lorem ipsum lorem']);

        $response = $this->get(route('home.comment'));
        $response->assertOk()
                 ->assertSee('lorem ipsum lorem');
    }
    /** @test  */
    public function a_user_guest_can_send_a_image()
    {
        Storage::fake('public');
        $file = UploadedFile::fake()->image('avatar.jpg');

        $response = $this->post(route('home.comment.upload'), ['file'=>[$file]]);
        $response->assertOk();
        $data = $response->decodeResponseJson();

        $this->assertDatabaseHas('media', ['name'=>$data['name']]);



    }
}
