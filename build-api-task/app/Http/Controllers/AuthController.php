<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Traits\ResponseTrait;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
	use ResponseTrait;
	
	public function register(Request $request)
	{
		$input = [
			'name' => $request->name,
			'email' => $request->email,
			'password' => Hash::make($request->password),
		];

		$user = User::create($input);

		$response = [
			'message' => 'Register is successfully',
		];

		return response()->json($response, 200);
	}

	public function login(Request $request)
	{
		$input = [
			'email' => $request->email,
			'password' => $request->password,
		];

		// $checkEmail = $input['email'] == $user->email;
		// $checkPassword = Hash::check($input['password'], $user->password);

		if (Auth::attempt($input)) {
			// $user = User::where('email', $input['email'])->first();

			// $token = $user->createToken('auth_token');
			$token = Auth::user()->createToken('auth_token');

			return $this->responseSuccess(
				['token' => $token->plainTextToken], 
				'Login is successfully',
			);
		}

		return $this->responseFail('Login is invalid', 401);
	}
}
