@extends('layout')
@section('title','Home - Page')
@section('content')
    @guest
        <a href="{{ $fb_url }}">
            <img class="img" src="https://scontent.fods1-1.fna.fbcdn.net/v/t39.2365-6/17639236_1785253958471956_282550797298827264_n.png?_nc_cat=105&amp;_nc_sid=ad8a9d&amp;_nc_ohc=Ft9mZNRLWisAX9kKJmV&amp;_nc_ht=scontent.fods1-1.fna&amp;oh=5171e506d29f72e7af81a48b6c200d46&amp;oe=5F792416" width="200" alt="">
        </a>
    @endguest
    @auth
        Hi, {{ Auth::user()->name }}<br>
        <a href="/logout">Logout</a>
    @endauth
@endsection
