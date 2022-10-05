<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User; 
use Illuminate\Foundation\Auth\AuthenticatesUsers; 
use Illuminate\Http\{RedirectResponse, Request, Response};
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;  

class SocialController extends Controller
{
    use AuthenticatesUsers; 
    /**
     * 사용자를 주어진 공급자의 OAuth 서비스로 리디렉션합니다.
     *
     * @param string $provider
     * @return RedirectResponse
     */
    protected function redirectToProvider(string $provider): RedirectResponse
    {
        //Log::info("소셜로그인하러 출발하자"  );  
        return Socialite::driver($provider)->redirect();
    }

    /**
     * 소셜에서 인증을 받은 후 응답입니다.
     *
     * @param Request $request
     * @param string  $provider
     * @return RedirectResponse|Response
     */
    protected function handleProviderCallback(Request $request, string $provider)
    {
        $socialUser = Socialite::driver($provider)->user();
        $user = $this->findOrCreateUser($socialUser);
        Auth::login($user, false); 
        return redirect('/home'); 
    }


    public function findOrCreateUser($socialUser){
        $existUser = User::where('email',$socialUser->email)->first();
        if($existUser){
            if($socialUser->refreshToken===null){
                User::where('email', $existUser->email)
                    ->update(['name' => $socialUser->getName()],['email' => $socialUser->getEmail()]);
            }
            else{
                User::where('email', $existUser->email)
                    ->update(['name' => $socialUser->getName()],['email' => $socialUser->getEmail()],['rememt_token'=> $socialUser->refreshToken]);
            }
            // 그전꺼로 로그인 되어있는 정보로 로그인해야함
            return $existUser;
        }
        else{
            $user = User::firstOrCreate([
                'name'  => $socialUser->getName(),   
                'email' => $socialUser->getEmail(),  
                'social_id'=>$socialUser->getId(),
                'social_provider'=>'naver', 
            ]);
            return $user;
        }
    }

 
}