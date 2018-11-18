<?php
/**
 * Created by PhpStorm.
 * User: roydekleijn
 * Date: 30/07/2017
 * Time: 19:59
 */

namespace TestApi\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use TestApi\User;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller

{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required'
        ]);

        $credentials = $request->only(['email', 'password']);

        if (!$token = Auth::attempt($credentials)) {
            return response()->json(['errorcode' => 'INVALID_CREDENTIALS'], 401);
        }

        return $this->respondWithToken($token);
//        exit;

//        $user = User::where('email', $request->email)->first();
//        if ($user && Hash::check($request->password, $user->password)) {
//            $apikey = base64_encode(str_random(40));
//            User::where('email', $request->email)->update(['api_key' => "$apikey"]);
//            return response()->json(['status' => 'success', 'api_key' => $apikey]);
//        } else {
//            return response()->json(['errorcode' => 'INVALID_CREDENTIALS'], 401);
//        }
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        Auth::logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function register(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'firstname' => 'required|string|min:3',
            'lastname' => 'required',
            'username' => 'required',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();
        if (!isset($user)) {
            $user = new User;
            $user->email = $request->email;
            $user->firstname = $request->firstname;
            $user->lastname = $request->lastname;
            $user->username = $request->username;
            $user->password = Hash::make($request->password);
        } else if ($user->password && $user->uid) {
            return response()->json(['errorcode' => 'ACCOUNT_EXISTS'], 422);
        } else if ($user->password) {
            return response()->json(['errorcode' => 'ACCOUNT_EXISTS'], 422);
        } else if ($user->uid) {
            $user->firstname = $request->firstname;
            $user->lastname = $request->lastname;
            $user->username = $request->username;
            $user->password = Hash::make($request->password);
        }
        try {
            $user->save();

            $credentials = $request->only(['email', 'password']);

            if (!$token = Auth::attempt($credentials)) {
                return response()->json(['errorcode' => 'INVALID_CREDENTIALS'], 401);
            }

            return response()->json(['status' => 'success']);
//            return response()->json(['status' => 'success', 'api_key' => $apikey]);
        } catch (QueryException $e) {
            // return errorCode
            return response()->json(['status' => $e]);
        }
    }

    public function getInfo()
    {
        $res = Auth::user();
//        $currentUser['id'] = $res->id;
//        $currentUser['email'] = $res->email;
//        $currentUser['firstname'] = $res->firstname;
//        $currentUser['lastname'] = $res->lastname;
//        $currentUser['hash'] = $res->hash;
//        $currentUser['subscription'] = $res->subscription;
//        $currentUser['mocksPerDomain'] = $res->mocksPerDomain;
//        $currentUser['mockDomains'] = $res->mockDomains;
//        $currentUser['log'] = $res->log;
//        $currentUser['proxyurl'] = $res->proxyurl;
        return response()->json($res);
    }

//    public function update(Request $request)
//    {
//        $input = array();
//        foreach ($request->all() as $key => $value) {
//            if ($key === 'log') {
//                $input[$key] = $value;
//            } else {
//                return response()->json(['error' => 'Can\'t update value'], 404);
//            }
//        }
//        $mock = Auth::user()->update($input);
//        return response()->json(['status' => 'success', 'result' => $mock]);
//    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60
        ]);
    }

}