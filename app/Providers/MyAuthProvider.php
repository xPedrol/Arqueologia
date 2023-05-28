<?php

namespace App\Providers;


use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;

class MyAuthProvider implements UserProvider
{
    public function retrieveById($identifier)
    {
        // This method is called from subsequent calls until the session expires.
        //
        // As you don't have a local users database we are going
        // to assume the identifier saved into the session is fine.
        //
        // Session cookies are encrypted by default
        //
        // This avoid calling the external service on every navigation.
        //
        // The downside is that if the user is not authorized anymore
        // in the external service, you won't know until their session expires.
        //
        // Ideally you should set a lower session duration so user
        // gets logged out quickier.
        //
        // An alternative is to save encrypted the user's credentials
        // and call the external service every time.
        //
        // But that would make a external API call on every request,
        // making your app slower. But is the most secure way.
        //
        // If you want I can make an modified version exemplifying
        // how you could do this.

        return User::where('email', $identifier)->first();
    }

    public function retrieveByToken($identifier, $token)
    {
        return null;
    }

    public function updateRememberToken(Authenticatable $user, $token)
    {
    }

    public function retrieveByCredentials(array $credentials): ?Authenticatable
    {
        $user = User::where('email', $credentials['email'])->first();
        if ($user) {
            if ($user->password == sha1($credentials['password'])) {
                return $user;
            }
        }
        return null;
    }

    public function validateCredentials(Authenticatable $user, array $credentials): bool
    {
        $user = User::where('email', $credentials['email'])->first();
        if ($user) {
            if ($user->password == sha1($credentials['password'])) {
                return true;
            }
        }
        return false;
    }
}
