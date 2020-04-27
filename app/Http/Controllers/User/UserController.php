<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\ApiController;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $users = User::all();
        return $this->showAll($users);

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

        $rules = [

            'name' =>'required',
            'email' => 'required|email|unique:users',
            'password' =>'required|min:6|confirmed'
        ];


        $this->validate($request,$rules);
//
//        $validator = Validator::make($request->all(),$rules);
//
//        if ($validator->fails())
//        {
//            return $this->errorResponse($validator->errors(),422);
////                response()->json(['errors'=>$validator->errors()]);
//        }

        $data = $request->all();
        $data['password'] = bcrypt($request->password);
        $data['verified'] = User::UnVerified_USER;
        $data['verification_token'] = User::generateVerificationCode();
        $data['admin'] = User::REGULAR_USER;

        $user = User::create($data);

        return response()->json(['data'=>$user],201);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //dgg

        return $this->showOne($user);

    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //

        $user = User::findOrFail($id);

        $rules = [

            'email' => 'email|unique:users,email,' .$user->id,
            'password' =>'min:6|confirmed',
            'admin' => 'in:' . User::Verified_USER. ',' . User::UnVerified_USER,
        ];
        $validator = Validator::make($request->all(),$rules);

        if ($validator->fails())
        {
            return $this->errorResponse($validator->errors(),422);
        }

        if ($request->has('name'))
        {
            $user->name = $request->name;
        }
        if ($request->has('email') && $user->email != $request->email)
        {
            $user->verified = User::UnVerified_USER;
            $user->verification_token = User::generateVerificationCode();
            $user->email = $request->email;
        }

        if ($request->has('password'))
        {
            $user->password = bcrypt($request->password);
        }
        if ($request->has('admin'))
        {
            if (!$user->isVerified())
            {

                return $this->errorResponse('Only verified user can change admin user',409);
            }
            $user->admin = $request->admin;
        }
        if (!$user->isDirty())
        {
            return $this->errorResponse('You need to specify a different value',422);

        }
        $user->save();
        return response()->json(['data'=>$user],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
        $user->delete();
        return response()->json(['data'=>$user],200);
    }
}
