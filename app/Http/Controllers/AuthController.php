<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Traits\ApiResponses;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use ApiResponses;

    public function login(Request $request): UserResource
    {
        $validated = $request->validate([
            'username' => 'required|max:255',
            'password' => 'required|max:255'
        ]);

        if (! Auth::attempt($validated)) {
            $this->error('username or password incorrect', 401);
        }

        $user = User::where('username', $validated['username'])->first();

        $user['token'] = $user->createToken('admin token for', ['*']);

        if($user['role'] == '2'){
            $user['token'] = $user->createToken('standard');
        }

        return new UserResource($user);
    }

    public function register(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'phone_number' => 'required|max:15',
        ]);

        $username = User::generateUsername();
        $password = User::generatePassword();
        $user = User::create([
            'username' => $username,
            'password' => $password,
            'name' => $validated['name'],
            'phone_number' => $validated['phone_number'],
            'role' => UserRole::User->value
        ]);
        
        $user['token'] = $user->createToken('standard');
        return (new UserResource($user))->response()->setStatusCode(201);
    }

    public function logout(Request $request) {
        $request->user()->currentAccessToken()->delete();

        return $this->ok('Success logout!');
    }

    public function change_password(Request $request) {
        $validated = $request->validate([
            'new_password' => 'required|max:255'
        ]);

        $user = $request->user();
        $user->password = Hash::make($validated['new_password']);
        $user->save();

        return $this->success('Success change password!', new UserResource($user), 200);
    }

    public function reset_password(Request $request) {
        $validated = $request->validate([
            'user_id' => 'required',
            'current_password' => 'required|max:255'
        ]);

        $user = $request->user();

        if(! Hash::check($validated['current_password'], $user->password) ){
            return $this->error('Wrong Password!', 401);
        }

        if($user['role'] != '2'){
            return $this->error('Unauthorized', 401);
        }

        $guestUser = User::find($validated['user_id']);
        $password = User::generatePassword();
        $guestUser->password = $password;
        $guestUser->save();

        return $this->success('Berhasil mereset password dari user ' . $guestUser->name, $guestUser, 200);


    }
}
