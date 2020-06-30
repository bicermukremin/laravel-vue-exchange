<?php

namespace App\Http\Controllers\Admin;

use App\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Mail\ResetPasswordMailable;
use Mail;
use App\PasswordReset;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $returnArray = [];
        $returnArray['status'] = false;
        $user = User::where('id', $id)->with('exchanges')->get();


        if ($user) {
            $returnArray['status'] = true;
            $returnArray['user'] = $user;
            return response()->json($returnArray);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateProfile(Request $request, $id)
    {
        $returnArray = [];
        $returnArray['status'] = false;
        $all = $request->only('name', 'username', 'avatar', 'info');

        $update = User::where('id', $id)->update($all);
        if ($update) {

            $user = User::where('id', $id)->get();
            $returnArray['status'] = true;
            $returnArray['user'] = $user;
            $returnArray['message'] = 'Your profile is updated successfully!!!';
            return response($returnArray);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function sendToken(Request $request)
    {

        $returnArray = [];
        $returnArray['status'] = false;
        $all = $request->except('token');

        $user = User::where('email', $all['email'])->firstOrFail();

        if (!$user) {
            $returnArray['message'] = 'Your account is not found with this email!!!';
            return response()->json($returnArray);
        } else {
            $token = Str::random(32);
            Mail::to($user)->send(new ResetPasswordMailable($token));

            PasswordReset::create([
                'email' => $request->email,
                'token' => $token
            ]);


            $returnArray['message'] = 'Your token is sent to your email! Please check your email.';
            return response()->json($returnArray);
        }
    }
    public function validateToken(Request $request)
    {

        $returnArray = [];
        $returnArray['status'] = false;
        $all = $request->all();

        $passwordReset = PasswordReset::where('token', $all['token'])->firstOrFail();

        if (!$passwordReset) {
            $returnArray['message'] = 'Your token is invalid!!!';
            return response()->json($returnArray);
        } else {
            $user = User::where('email', $passwordReset->email)->firstOrFail();


            $returnArray['message'] = 'Your token is validated successfully!.';
            $returnArray['user'] = $user;
            return response()->json($returnArray);
        }
    }
    public function resetPassword(Request $request)
    {

        $returnArray = [];
        $returnArray['status'] = false;
        $all = $request->except('token');
        $user = User::where('id', $all['id'])->firstOrFail();


        $passwordReset = PasswordReset::where('email', $user->email)->firstOrFail();
        $passwordReset->delete();

        $user->password = bcrypt($all['password']);
        $user->save();

        $returnArray['message'] = 'Your password changed successfully!! You can login again to proceed.';
        return response()->json($returnArray);
    }
}