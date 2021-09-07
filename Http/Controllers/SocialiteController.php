<?php

namespace Modules\AuthSocialite\Http\Controllers;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Hash;
use Laravel\Fortify\Fortify;
use Laravel\Socialite\Facades\Socialite;
use Modules\BaseCore\Contracts\Repositories\PersonneRepositoryContract;
use Modules\BaseCore\Contracts\Repositories\UserRepositoryContract;
use Modules\BaseCore\Models\User;

class SocialiteController extends Controller
{
    public function checkOrCreateUser(UserRepositoryContract $repUser, PersonneRepositoryContract $repPersonne): Redirector|Application|RedirectResponse
    {
        $userGoogle = Socialite::driver('google')->user();

        $user = $repUser->fetchByEmail($userGoogle->email);

        if (!is_object($user)) {
            $personne = $repPersonne->createPersonneForRegister($userGoogle->user['given_name'], $userGoogle->email);
            $user = $repUser->create($personne, config('authsocialite.role_default'), $userGoogle->id);
        }

        Auth::loginUsingId($user->id, true);

        return redirect(route(config('basecore.route_default')));

    }
}
