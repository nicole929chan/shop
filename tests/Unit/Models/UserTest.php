<?php

namespace Tests\Unit\Models;

use App\Models\Member;
use App\Models\Point;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_使用者密碼必須編碼過()
    {
        $user = factory(User::class)->create(['password' => 'foo']);

        $this->assertNotEquals('foo', $user->password);
    }

    public function test_使用者能參與多位店家的優惠()
    {
        $user = factory(User::class)->create();
        $member = factory(Member::class)->create();

        $user->plans()->attach($member, ['card' => 'images/cards/xyz.jpg']);

        $this->assertEquals(1, $user->plans->count());

    }

    public function test_使用者有一組兌換隨機碼()
    {
        $user = factory(User::class)->create(['code' => '12345']);

        $this->assertNotEquals('12345', $user->code);
    }

    public function test_使用者有多筆點數增減紀錄()
    {
        $user = factory(User::class)->create();
        $member = factory(Member::class)->create();
        
        $user->points()->save(
            factory(Point::class)->make(['member_id' => $member->id])
        );

        $this->assertInstanceOf(Collection::class, $user->points);
    }

    public function test_使用者擁有各店家的一筆剩餘點數紀錄()
    {
        $user = factory(User::class)->create();
        $member = factory(Member::class)->create();
        
        $user->points()->save(
            factory(Point::class)->make(['member_id' => $member->id, 'points' => 10])
        );

        $this->assertEquals(10, $user->point->first()->pivot->points);
    }
}
