<?php
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use Modules\AuthSocialite\Http\Controllers\SocialiteController;

Route::get('/auth/redirect', function () {

    return Socialite::driver('google')->redirect();
});

Route::get('/login/google/callback', [SocialiteController::class, 'checkOrCreateUser']);
