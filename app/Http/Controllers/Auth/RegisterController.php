<?php

namespace App\Http\Controllers\Auth;

use App\Company;
use App\Admin;
use App\User;
use Auth;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
        $this->middleware('guest:company');
        $this->middleware('guest:admin');
        $this->middleware('guest:user');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data, $table)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.$table.''],   //unique:$table (check the $table table for email uniqueness)
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ],
         [
            'name.required' => 'Name is required',
            'name.min' => 'Name must be at least 2 characters.',
            'name.max' => 'Name should not be greater than 50 characters.',

            'email.required' => 'Name is required',
            'email.min' => 'Email must be at least 2 characters.',
            'email.max' => 'Email should not be greater than 50 characters.',
            'email.unique' => 'Email already Registered',

            'password.required' => 'Password is required',
            'password.min' => 'Password must be at least 6 characters.',
            'password.confirmed' => 'Password must be same',
         ]);
    }

    public function RegisterLogic(Request $request)
    {
        $validator = $this->validator($request->all(),  'users');  //Second Parameter is TableName we sent to Validator
        if ($validator->fails())
        {
            return back()->withInput($request->only('email', 'name'))->withErrors($validator);
        }
        else
        {
            $model = User::create([
                    'name' => $request['name'],
                    'email' => $request['email'],
                    'email_verified_at' => Carbon::now(),
                    'password' => Hash::make($request['password']),
                ]);

            //After user is created, it auto logins, but we will directly logout after user is created.
            Auth::logout();
            
            return redirect('/register')->withErrors(["success" => "Registration Sucessfull"]);
        }
    }


    public function RegisterLogicAdmin(Request $request)
    {
        $validator = $this->validator($request->all(),  'admins');  //Second Parameter is TableName we sent to Validator
        if ($validator->fails())
        {
            return back()->withInput($request->only('email', 'name'))->withErrors($validator);
        }
        else
        {
            $model = Admin::create([
                    'name' => $request['name'],
                    'email' => $request['email'],
                    'password' => Hash::make($request['password']),
                ]);

            //After user is created, it auto logins, but we will directly logout after user is created.
            Auth::logout();
            
            return redirect('/register/admin')->withErrors(["success" => "Please wait, while superUser Verify you."]);
        }
    }


    protected function showRegisterForm()
    {
        return view('register');
    }


    protected function showRegisterFormAdmin()
    {
        return view('registerAdmin');
    }
}
