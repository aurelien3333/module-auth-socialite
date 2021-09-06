<?php
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

Route::get('/auth/redirect', function () {

    return Socialite::driver('google')->redirect();
});

Route::get('/login/google/callback', function () {
    $user = Socialite::driver('google')->user();

    dd($user);
    // $user->token
});
