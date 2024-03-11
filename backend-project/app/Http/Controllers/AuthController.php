<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Contracts\Providers\Auth;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        
        if($request->email == null || $request->password == null || $request->birthday == null){
            return response()->json(['error' => "Há campos obrigatórios não preenchidos"], 400);
        }

        $isEmail = filter_var($request->email, FILTER_VALIDATE_EMAIL);
        if($isEmail == false){
            return response()->json(['error' => "E-mail inválido"], 400);
        }

        $request['username'] = preg_replace("/[\[\]´_+=!.;,\/\\\\|@#\$%&*()'\{\}\-]/", '', $request->username);
        $request['birthday'] = preg_replace("/[\[\]´_+=!.;,\/\\\\|@#\$%&*()'\{\}]/", '', $request->birthday);
        $request['birthday'] = date('Y-m-d', strtotime($request->birthday));

        try{
            if(User::whereemail($request->email)->first()){
                return response()->json(['error' => "Este e-mail já está cadastrado."], 400);
            }

            $userCreated = User::create([
                'name'      => $request->username,
                'password'  => Hash::make($request->password),
                'email'     => $request->email,
                'birthday'  => $request->birthday,
            ]);

        } catch (\Exception $e){
            return response()->json(['error' => "Falha desconecida ao salvar os dados" . $e->getMessage()], 400);
        }

        $credentials = ['email' => $request->email, 'password' => $request->password];
        $token = auth()->attempt($credentials);
        return $this->respondWithToken($token);

    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

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
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}