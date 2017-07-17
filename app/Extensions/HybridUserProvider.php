<?php
namespace App\Extensions;

use App\Models\ExternalUser;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;
use \Firebase\JWT\JWT;

class HybridUserProvider implements UserProvider {

    protected $websiteToken;

    public function __construct($websiteToken)
    {
        $this->websiteToken = $websiteToken;
    }

    /**
     * Retrieve a user by their unique identifier.
     *
     * @param  mixed $identifier
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveById($identifier)
    {
        return User::find($identifier);
    }

    /**
     * Retrieve a user by their unique identifier and "remember me" token.
     *
     * @param  mixed $identifier
     * @param  string $token
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveByToken($identifier, $token)
    {
        // TODO: Implement retrieveByToken() method.
    }

    /**
     * Update the "remember me" token for the given user in storage.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable $user
     * @param  string $token
     * @return void
     */
    public function updateRememberToken(Authenticatable $user, $token)
    {
        // TODO: Implement updateRememberToken() method.
    }

    /**
     * Retrieve a user by the given credentials.
     *
     * @param  array $credentials
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveByCredentials(array $credentials)
    {
        if (isset($credentials['user_code'])) {
            return User::where(['user_code' => $credentials['user_code']])->first();
        }

        if (isset($credentials['email'])) {
            $externalUser = ExternalUser::where(['email' => $credentials['email']])->first();
            if ($externalUser !== null) {
                return $externalUser->user;
            }
        }

        if (isset($credentials['jwt_token'])) {
            try {
                $decoded = JWT::decode($credentials['jwt_token'], $this->websiteToken, ['HS256']);
                return User::where(['user_code' => $decoded['lidnr']])->first();
            } catch (\UnexpectedValueException $e) {
                return null;
            }
        }

        return null;
    }

    /**
     * Validate a user against the given credentials.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable $user
     * @param  array $credentials
     * @return bool
     */
    public function validateCredentials(Authenticatable $user, array $credentials)
    {
        // Website user
        if (isset($credentials['jwt_token'])) {
            try {
                $decoded = JWT::decode($credentials['jwt_token'], $this->websiteToken, ['HS256']);
                return $decoded['lidnr'] == $user->user_code;
            } catch (\UnexpectedValueException $e) {
                return null;
            }
        }

        // External users
        if (isset($credentials['password']) && $user->externalUserData !== null) {
            return Hash::check($credentials['password'], $user->externaluserData->password);
        }
    }
}