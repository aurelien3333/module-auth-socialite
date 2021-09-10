<?php

namespace Modules\AuthSocialite\Http\Controllers;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Laravel\Socialite\Facades\Socialite;
use Modules\BaseCore\Contracts\Repositories\EmailRepositoryContract;
use Modules\BaseCore\Contracts\Repositories\PersonneRepositoryContract;
use Modules\BaseCore\Contracts\Repositories\UserRepositoryContract;

class SocialiteController extends Controller
{
    public function checkOrCreateUser(UserRepositoryContract $repUser, PersonneRepositoryContract $repPersonne, EmailRepositoryContract $repEmail): Redirector|Application|RedirectResponse
    {
        $userGoogle = Socialite::driver('google')->user();

        $user = $repUser->fetchByEmail($userGoogle->email);

        if (!is_object($user)) {

            $personne = $repPersonne->createForRegister($userGoogle->user['given_name']);
            $email = $repEmail->create( $userGoogle->email);
            $repPersonne->makeRelation($personne->emails(), $email);

            $user = $repUser->create($personne, config('authsocialite.role_default'), $userGoogle->id);
        }

        Auth::loginUsingId($user->id, true);

        return redirect()->route(config('basecore.route_default'));

    }
}
