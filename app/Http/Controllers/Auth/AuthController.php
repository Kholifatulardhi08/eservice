<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Penyewa;
use App\Models\Penyedia;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register', 'registerpenyewa', 'loginpenyewa']]);
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

    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'min:3', 'max:150'],
            'email' => ['required', 'string', 'email', 'max:50', 'unique:users'],
            'password' => ['required', 'string', 'min:6']
        ]);

        //response error validation
        if ($validator->fails()) {
            return response()->json(["message" => $validator->errors()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        //save to database
        $users = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'message' => 'User successfully registered',
            'user' => $users
        ], 201);
    }

    public function logout(Request $request) {
        auth()->logout();
        return response()->json(['message' => 'User successfully signed out']);
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

    public function loginpenyewa(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email|max:50',
            'password' => 'required|string|min:6'
        ]);

        if ($token = Auth::attempt($credentials)) {
            $penyewa = Penyewa::where('email', $request['email'])
            ->select('id', 'email')->first()->toArray();


            $penyewa += ['jwt_token' => $token];

            return response()->json($penyewa, Response::HTTP_CREATED);
        }
        return response()->json(["status" => Response::HTTP_UNAUTHORIZED, "message" => "email/password wrong"], Response::HTTP_UNAUTHORIZED);
    }

    public function registerpenyewa(Request $request) 
    {
        $validator = Validator::make($request->all(), [
            'nama_penyewa' => ['required'],
            'email' => ['required'],
            'password' => ['required'],
            'provinsi' => ['required'],
            'kabupaten' => ['required'],
            'kecamatan' => ['required'],
            'detail_alamat' => ['required'],
            'no_hp' => ['required']
        ]);

        //response error validation
        if ($validator->fails()) {
            return response()->json(["message" => $validator->errors()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $input = $request->all();
        $input['password'] = bcrypt($request->password);
        $penyewa = Penyewa::create($input);
        return response()->json([
            'message' => 'Penyewa successfully registered',
            'penyewa' => $penyewa
        ], 201);
    }
}
