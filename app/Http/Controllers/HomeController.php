<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    public function __invoke()
    {
        $fb_url = 'https://www.facebook.com/dialog/oauth';
        $parameters = [
            'client_id'=> env('OAUTH_FB_APP_ID'),
            'redirect_uri'=>env('OAUTH_FB_CALLBACK_URI'),
            'response_type' => 'code',
            'scope'         => 'email,user_birthday'
        ];
        $fb_url .= '?'.http_build_query($parameters);

        return view('home',['fb_url'=>$fb_url]);
    }
    public function fb_callback()
    {
        $url = 'https://graph.facebook.com/oauth/access_token';
        $responce = \Illuminate\Support\Facades\Http::withHeaders(['Accept'=>'application/json'])
            ->post($url,[
                'client_id'=>env('OAUTH_FB_APP_ID'),
                'redirect_uri'=>env('OAUTH_FB_CALLBACK_URI'),
                'client_secret'=>env('OAUTH_FB_APP_SECRET'),
                'code'=>request()->get('code')
            ]);

        $url2 = 'https://graph.facebook.com/me?access_token='.$responce['access_token'];
        $responce2 = \Illuminate\Support\Facades\Http::get($url2);
        //dd($responce2->body());
        //print $responce2['name']."<br>";
        //print $responce2['id'];
        //print "<hr>";
        $url3 = 'https://graph.facebook.com/'.$responce2['id'].'?fields=birthday,email&access_token='.$responce['access_token'];
        $responce3 = \Illuminate\Support\Facades\Http::get($url3);

        //Find this user and login register
        //print $responce3['birthday']."<br>";
        //print $responce3['email']."<br>";
        //print $responce3['id']."<br>";

        $user = \App\User::where('email','=',$responce3['email'])->first();
        if ($user===null)
        {
            $user=new \App\User;
            $user->name=$responce2['name'];
            $user->email=$responce3['email'];
            $user->email_verified_at=now();
            $user->password=\Illuminate\Support\Facades\Hash::make(Str::random(30));
            //$user->remember_token=Str::random(10);
            $user->save();
        }
        //dd($user);

        \Illuminate\Support\Facades\Auth::login($user);
//    dd(request()->user());
        return back();
    }
}
