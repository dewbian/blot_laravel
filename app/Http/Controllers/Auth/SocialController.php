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
     * 주어진 provider에 대하여 소셜 응답을 처리합니다.
     *
     * @param Request $request
     * @param string  $provider
     * @return RedirectResponse|Response
     */
    // public function execute(Request $request, string $provider)
    // {

    //     Log::info("C:\blot\app\Http\Controllers\Auth\SocialController.php");    
    //     Log::info("provider===>[".$provider."]"  );   
    //     Log::info("request===>[".$request."]"  );   


    //     if (! array_key_exists($provider, config('services'))) {
             
    //         Log::info("11111111111"  );  
    //         return $this->sendNotSupportedResponse($provider);
    //     }

    //     if (! $request->has('code')) { 
    //         Log::info("222222"  );  
    //         return $this->redirectToProvider($provider);
    //     }

    //     return $this->handleProviderCallback($request, $provider);
    // }

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
                User::where('email', $existUser->uid)
                    ->update(['name' => $socialUser->getName()],['email' => $socialUser->getEmail()],['rememt_token'=> $socialUser->refreshToken]);
            }
            // 그전꺼로 로그인 되어있는 정보로 로그인해야함
            return $existUser;
        }
        else{
            $user = User::firstOrCreate([
                'name'  => $socialUser->getName(),   
                'email' => $socialUser->getEmail(), // 구글 이메일 가져오기 
                'social_id'=>$socialUser->getId(),
                'social_provider'=>'naver', 
            ]);
            return $user;
        }
    }

 
}