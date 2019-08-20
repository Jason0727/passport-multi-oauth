<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RevokeAccessToken
{
    /**********************************该类主要用于清除旧的 Access Token ***********************************************/

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param object $event
     * @return void
     */
    public function handle($event)
    {
        // PS: 每生成一个Access Token 都生成一个新的Refresh Token
        Log::info('清除Access Token', json_decode(json_encode($event), true));

        $accessTokenQuery = DB::table('oauth_access_tokens')->where([
            ['id', '<>', $event->tokenId],
            ['user_id', '=', $event->userId],
            ['client_id', '=', $event->clientId]
        ]);
        $accessTokenIdArr = $accessTokenQuery->pluck('id')->toArray();

        # 清除Refresh Token
        DB::table('oauth_refresh_tokens')->whereIn('access_token_id',$accessTokenIdArr)->delete(); // 直接删除 或者 设置revoked = 1 同样可以达到清除的效果

        # 清除Access Token
        $accessTokenQuery->delete(); // 直接删除 或者 设置revoked = 1 同样可以达到清除的效果
    }
}
