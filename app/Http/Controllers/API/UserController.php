<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserController extends BaseController
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'birthday' => 'required|date',
            'phone' => 'required|min:10',
            'email' => 'required|email',
            'password' => 'required|min:6',
            'c_password' => 'required|same:password',
            'img' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $fileName = $request->img->getClientOriginalName();
        $request->img->move(public_path('uploads'), $fileName);
        $user = User::create([
            "name" => $request->name,
            "birthday" => $request->birthday,
            "phone" => $request->phone,
            "email" => $request->email,
            "password" => bcrypt($request->password),
            "img" => $fileName,
        ]);
        $success['token'] =  $user->createToken('MyApp')->plainTextToken;
        $success['name'] =  $user->name;

        return $this->sendResponse($success, 'User register successfully.', 201);
    }

    public function login(Request $request)
    {

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $success['token'] =  $user->createToken('MyApp')->plainTextToken;
            $success['name'] =  $user->name;
            $success['id'] =  $user->id;

            return $this->sendResponse($success, 'User login successfully.', 200);
        } else {
            return $this->sendError('Invalid credentials.', ['error' => 'Email or password invalid']);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return $this->sendResponse($request, 'User logged out successfully.', 200);
    }
}
