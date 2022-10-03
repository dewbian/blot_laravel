<?php

namespace App\SocialiteProviders\Naver;

use SocialiteProviders\Manager\OAuth2\User;
use SocialiteProviders\Naver\NaverProvider as BaseNaverProvider;

class NaverProvider extends BaseNaverProvider
{
    /**
     * Map the raw user array to a Socialite User instance.
     *
     * @param array $user
     * @return User
     */
    protected function mapUserToObject(array $user): User
    {
        return (new User())->setRaw($user)->map([
            'id' => $user['id'],
            'name' => $user['name'],
            'email' => $user['email'],
        ]);
    }
}