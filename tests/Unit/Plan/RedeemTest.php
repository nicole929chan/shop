<?php

namespace Tests\Unit\Plan;

use App\Models\Member;
use App\Models\User;
use App\Plan\Redeem;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class RedeemTest extends TestCase
{
    use RefreshDatabase;

    public function test_兌換的API網址()
    {
        $user = factory(User::class)->make();

        $redeem = new Redeem();

        $url = $redeem->getPointsURL($user);

        $this->assertEquals(config('app.url') . "/redeem/{$user->code}", $url);
    }

    public function test_產生兌換的QRCode圖檔()
    {
        $user = factory(User::class)->make();
        $member = factory(Member::class)->create();
        
        QrCode::shouldReceive('format->size->merge->generate')->once();
        
        $redeem = new Redeem();
        $redeem->generate($user, $member);
    }
}
