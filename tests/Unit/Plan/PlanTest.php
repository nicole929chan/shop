<?php

namespace Tests\Unit\Plan;

use App\Models\Activity;
use App\Models\Member;
use App\Models\User;
use App\Plan\Card;
use App\Plan\Plan;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Mockery;

class PlanTest extends TestCase
{
    use RefreshDatabase;

    public function test_店家的優惠活動計畫被參加()
    {
        $user = factory(User::class)->create();       
        $member = factory(Member::class)->create();
        $image = UploadedFile::fake()->image('photo.jpg');

        $card = Mockery::mock(Card::class);
        app()->instance(Card::class, $card);
        
        $card->shouldReceive('generate')->once();

        $plan = new Plan($user, $card);
        $plan->add($member->id, $image);

        $this->assertEquals($member->id, $user->fresh()->plans->first()->id);
    }
}
