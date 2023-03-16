<?php

namespace App\Http\Controllers\API;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function logout(Request $request){
        // $user = auth()->user();
        // $user(->tokens()->delete();
        $request->user()->tokens()->delete();
        // auth()->user()->tokens()->delete();

        return [
            'message'=>'u have logout '
        ];


    }
    
    public function loginUser(Request $request){
        $validator = Validator::make($request->all(), [
            'unitId' => 'required',
            'password' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'validation_error' => $validator->messages(),
            ]);
        }
        else{
            $user = User::where('unitId', $request->unitId)->first();
            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json([
                    'status' => 401,
                    'message_back' => 'invaild credentials'
                ]);
            }else{
                 $token_user =  $user->createToken('mytoken')->plainTextToken;
                return response()->json([
                    'status' => 200,
                    'token'=>$token_user,
                    'message' => 'welcome'
                ]);
            }
        }
    }
    public function UserAuth(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:users',
            'email' => 'required|unique:users',
            'unitId' => 'required',
            'password' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'validation_error' => $validator->messages(),
            ]);
        }else{
            $user = User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'unitId' => $request->input('unitId'),
                'password' => Hash::make($request->input('password'))
            ]);
            $token_user =  $user->createToken($user->email . '_Token',)->plainTextToken;
            return response()->json([
                'status' => 200,
                'token_name' => $user->name,
                'token' => $token_user,
                'message' => 'Registerd '
            ]);
        }
        }
    }

