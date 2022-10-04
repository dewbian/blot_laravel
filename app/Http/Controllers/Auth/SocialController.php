<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Str;
use Illuminate\Http\{RedirectResponse, Request, Response};
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\User as SocialUser;
use Log;   

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

        

        //Log::info("333333333333333"  );              
        $socialUser = Socialite::driver($provider)->user();
  
        //Log::info("소셜에서 받아온 이메일 주소 ===>[".$socialUser->getEmail()."]"  );    
        //dump("소셜에서 받아온 이메일 주소 ===>[".$socialUser->getEmail()."]"  );   
       // $user2 = User::where('email', $socialUser->getEmail())->first();

       // Log::info( "현재유저는===>[".$user2."]"   );    
       // dump( "현재유저는===>[".$user2."]"  );    
        
        // 구글로그인한 유저의 정보를 가져올 수 있습니다.(허용한 한도 내에서)
        //dd($socialUser);
            
        // 유저가 이미 회원인지 확인하는 메서드입니다.
        $user = $this->findOrCreateUser($socialUser);
        Auth::login($user, false);

        //토큰을 활용하기위해 로컬에 저장해도 되고 세션에 저장하거나 쿠키에 저장해서 활용할 수 있겠습니다.
        return redirect('/');
    //     $userToLogin = User::where([
    //         'social_provider' => 'naver',
    //         'social_id'       => $socialUser->getId(),  
    //     ])->first();    
        
    //      if (!$userToLogin) {
            
    //         dump( "없어요 없어. ===>[]"  );    
    //         event(new Registered($userToLogin = User::create($socialUser->getRaw())));
    //         $userToLogin->email_verified_at = date('Y-m-d H:i:s'); //Date::now();
    //         $userToLogin->remember_token = Str::random(60); 
    //         $userToLogin->social_id = $socialUser -> getId();
    //         $userToLogin->social_provider = 'naver'; 
    //         $userToLogin->save();
    //     }else{
    //         dump( "있어요 있어  ===>[".$userToLogin."]"  );      
    //     }
    //     if (!$userToLogin) {    
            
    //         dump( "111111111111111111"  );   
    //     }else{
    //         dump( "222222222222"  );   
    //     }


    //     //\Auth::login($userToLogin);

    //     Auth::login($userToLogin, false);
    //     $name = Auth::user()['name'];

    //     dump( "로그인 되었습니다.===>[".$name."]"  );    
        
        
        
    //     //Auth::login($userToLogin);
    //    return redirect('/home');


        // if ($user = User::where('email', $socialUser->getEmail())->first()) {
        //     $this->guard()->login($user, true);
        //     return $this->sendLoginResponse($request);
        // }

        // return $this->register($request, $socialUser);
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
               // 'remember_token'=>Str::random(60)  
            ]);
            return $user;
        }
    }


    /**
     * 주어진 소셜 회원을 응용 프로그램에 등록합니다.
     *
     * @param Request    $request
     * @param SocialUser $socialUser
     * @return mixed
     */
    protected function register(Request $request, SocialUser $socialUser)
    {
        event(new Registered($user = User::create($socialUser->getRaw())));
        $user->email_verified_at = date('Y-m-d H:i:s'); //Date::now();
        $user->remember_token = Str::random(60); 
        $user->social_id = $socialUser -> getId();
        $user->social_provider = 'naver'; 
        $user->save();

        // $this->guard()->login($user, true);
        // return $this->sendLoginResponse($request);
    }

    /**
     * 사용자 인증을 받았습니다.
     *
     * @param Request $request
     * @param User    $user
     */
    protected function authenticated(Request $request, User $user): void
    {
       // flash()->success(__('auth.welcome', ['name' => $user->name]));

        //$request->session()->flash('status', 'Task was successful!');

    }

    /**
     * 지원하지 않는 소셜 공급자에 대한 응답입니다.
     *
     * @param string $provider
     * @return RedirectResponse
     */
    protected function sendNotSupportedResponse(string $provider): RedirectResponse
    {
        //flash()->error(trans('auth.social.not_supported', ['provider' => $provider]));

        return back();
    }
}