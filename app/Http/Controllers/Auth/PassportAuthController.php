<?php

namespace App\Http\Controllers\Auth;

use App\Enums\Api\HttpResponseCodes;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PassportAuthController extends Controller
{
  /**
   * Log in the user and generate an access token.
   *
   * @param \App\Http\Requests\UserLoginRequest $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function login(UserLoginRequest $request): JsonResponse
  {
    if (auth()->attempt(['email' => $request->email, 'password' => $request->password])) {

      /** @var \App\Models\User $user **/
      $user = auth()->user();

      $token = $user->createToken('API Token')->accessToken;

      $result = [
        'user' => UserResource::make($user),
        'token' => $token
      ];

      return response()->json($result, HttpResponseCodes::HttpOK->value);
    } else {
      return response()->json(['error' => 'Unauthorized'], HttpResponseCodes::HttpUnauthorized->value);
    }
  }

  /**
   * Register a new user and generate an access token.
   *
   * @param \App\Http\Requests\UserRegisterRequest $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function register(UserRegisterRequest $request): JsonResponse
  {
    $encryptedPassword = bcrypt($request->input('password'));
    try {

      $user = User::create([
        'name' => $request->input('name'),
        'email' => $request->input('email'),
        'password' => $encryptedPassword
      ]);

      $token = $user->createToken('KEEPR Token')->accessToken;

      $result = [
        'user' => $user,
        'token' => $token
      ];

      return response()->json($result, HttpResponseCodes::HttpCreated->value);
    } catch (Exception $e) {
      return response()->json(['error'  => 'server error'], HttpResponseCodes::HttpInternalServerError->value);
    }
  }

  /**
   * Logout the user and revoke the access token.
   *
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function logout(Request $request): JsonResponse
  {
    $user = $request->user();

    if ($user) {
      $user->token()->revoke();
      return response()->json(['message' => 'Successfully logged out'], HttpResponseCodes::HttpOK->value);
    }

    return response()->json(['error' => 'Unauthorized'], HttpResponseCodes::HttpUnauthorized->value);
  }

  /**
   * Authenticate the user.
   *
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function auth(Request $request): JsonResponse
  {
    $user = $request->user();
    return response()->json(UserResource::make($user), HttpResponseCodes::HttpOK->value);
  }
}
