<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SuspectInfomation;
use Illuminate\Support\Facades\Validator;

class FormController extends Controller
{
    public function suspect(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'firstname' => 'required',
            'lastname' => 'required',
            'unitId' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages(),
            ]);
        } else {
            $user = User::where('unitId', $request->unitId)->first();
            if (!$user) {
                return response()->json([
                    'status' => 401,
                    'message_back' => 'invaild credentials unitId'
                ]);
            } else {
                SuspectInfomation::create([
                    'firstname'=>$request->firstname,
                    'lastname'=>$request->lastname,
                    'unitId'=>$request->unitId
                ]);
                return response()->json([
                    'status' => 200,
                    'message' => 'U have successfully create a suspect in the system'
                ]);
            }
        }
    }
}
