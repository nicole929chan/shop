<?php

namespace Tests\Feature\Plan;

use App\Models\Member;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class PlanStoreTest extends TestCase
{
    use RefreshDatabase;

    public function test_非登入的使用者不能加入店家積點()
    {
        $this->json('POST', 'api/plan')
            ->assertStatus(401);
    }

    public function test_使用者成為店家的積點會員()
    {
        Storage::fake('public');

        $user = factory(User::class)->create();
        $member = factory(Member::class)->create();

        $this->jsonAs($user, 'POST', 'api/plan', [
            'member_id' => $member->id,
            'image' => $image = UploadedFile::fake()->image('photo1.jpg')
        ]);

        $card = $image->hashName();

        Storage::disk('public')->assertExists('images/cards', $card);
        
        $this->assertDatabaseHas('user_plan', [
            'user_id' => $user->id,
            'member_id' => $member->id,
            'card' => "images/cards/{$card}"
        ]);
    }

    public function test_成為積點會員時店家代號必填()
    {
        $user = factory(User::class)->create();
        
        $this->jsonAs($user, 'POST', 'api/plan')
            ->assertJsonValidationErrors(['member_id']);
    }

    public function test_成為積點會員時必須上傳圖像()
    {
        $user = factory(User::class)->create();
        
        $this->jsonAs($user, 'POST', 'api/plan')
            ->assertJsonValidationErrors(['image']);
    }

    public function test_成為積點會員上傳圖像須為圖檔()
    {
        $user = factory(User::class)->create();
        
        $this->jsonAs($user, 'POST', 'api/plan', ['image' => 'photo.docx'])
            ->assertJsonValidationErrors(['image']);
    }
}
