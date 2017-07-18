<?php

namespace App\Http\Controllers\Auth;

use App\Facades\UserCode;
use App\Models\ExternalUser;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:external_users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {

        $user = User::create([
            'user_code' => UserCode::getNextExternalUserCode(),
            'type' => User::TYPE_EXTERNAL,
            'approved' => 0

        ]);
        ExternalUser::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'user_id' => $user->id,
        ]);
    }

    public function showRegister() {
        return View('auth.register');
    }

    public function doRegister(Request $request) {
        $validator = $this->validator($request->all());
        if ($validator->fails()) {
            return View('auth.register')->with(['errors' => $validator->errors()]);
        }

        $this->create($request->all());
        // TODO: send email with comment and return some kind of feedback to the user
        return redirect()->to('/');
    }
}
