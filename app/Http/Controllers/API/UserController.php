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
            'img' => 'required|image',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $image_path = $request->file('img')->store('image', 'public');
        $user = User::create([
            "name" => $request->name,
            "birthday" => $request->birthday,
            "phone" => $request->phone,
            "email" => $request->email,
            "password" => bcrypt($request->password),
            "img" => $image_path,
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
            //$success['name'] =  $user->name;
            //$success['id'] =  $user->id;

            return $this->sendResponse(["user" => $user, "token" => $success], 'User login successfully.', 200);
        } else {
            return $this->sendError('Invalid credentials.', ['error' => 'Email or password invalid']);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return $this->sendResponse($request, 'User logged out successfully.', 200);
    }

    public function getAuthUser()
    {
        $user = Auth::user();
        return $this->sendResponse($user, 'Authenticated user.', 200);
    }

    public function search(Request $request)
    {
        $request->header("Access-Control-Allow-Origin: http://localhost:5173");
        $query = $request->input('q');
        $results = User::where('name', 'like', '%' . $query . '%')->get();
        return $this->sendResponse($results, 'Users.', 200);
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return $this->sendError('User not found.');
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'birthday' => 'required|date',
            'phone' => 'required|min:10',
            'email' => 'required|email',
            'password' => 'required|min:6',
            'c_password' => 'required|same:password',
            'img' => 'image',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $input = $request->all();
        if ($request->hasFile('img')) {
            $image_path = $request->file('img')->store('image', 'public');
            $user->img = $image_path;
        }

        $user->name = $input['name'];
        $user->birthday = $input['birthday'];
        $user->phone = $input['phone'];
        $user->email = $input['email'];
        $user->password = bcrypt($input['password']);
        $user->save();

        $success['token'] =  $user->createToken('MyApp')->plainTextToken;
        $success['name'] =  $user->name;

        return $this->sendResponse($success, 'User updated successfully.', 200);
    }
}
