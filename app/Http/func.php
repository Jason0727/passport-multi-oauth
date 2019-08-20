<?php

if (!function_exists('hashMake')) {
    /**
     * Hash加密
     *
     * @param $value
     * @return string
     */
    function hashMake($value)
    {
        return \Illuminate\Support\Facades\Hash::make($value);
    }
}

if (!function_exists('clearUserToken')) {
    /**
     * 清除用户信息(测试使用，实际使用请放置模型或控制器中)
     *
     * @param $userId
     * @param $clientId
     */
    function clearUserToken($userId, $clientId)
    {
        $accessTokenQuery = \Illuminate\Support\Facades\DB::table('oauth_access_tokens')->where([
            ['user_id','=',$userId],
            ['client_id','=',$clientId]
        ]);

        $accessTokenIdArr = $accessTokenQuery->pluck('id')->toArray();

        # 清除Refresh Token
        \Illuminate\Support\Facades\DB::table('oauth_refresh_tokens')->whereIn('access_token_id',$accessTokenIdArr)->delete(); // 直接删除 或者 设置revoked = 1 同样可以达到清除的效果

        # 清除Access Token
        $accessTokenQuery->delete(); // 直接删除 或者 设置revoked = 1 同样可以达到清除的效果
    }
}