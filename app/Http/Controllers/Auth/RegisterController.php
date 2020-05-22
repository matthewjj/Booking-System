<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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
    //protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }


    protected function redirectTo()
    {
        /* generate URL dynamicaly */
        $parentID = \Auth::user()->parent_id;
        $parent = User::where('id', $parentID)->first();

        return \Auth::user()->type == 1 ? RouteServiceProvider::HOME : "/bookings/customer/{$parent->customer_link}";
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        if(isset($data['type']) && $data['type'] == 1) {
            $fields = [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'company_name' => ['required', 'string', 'max:255'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ];
        }
        else {
             $fields = [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
                'parent_id' => ['required', 'integer'],
            ];
        }

        return Validator::make($data, $fields);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {   
        $customerLink = null;

        if(isset($data['type']) && $data['type'] == 1) {
            $customerLink = "{$data['company_name']}" . '_' . time();
        }

        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'type' => $data['type'],
            'company_name' => isset($data['company_name']) ? $data['company_name'] : null,
            'parent_id' => isset($data['parent_id']) ? $data['parent_id'] : null,
            'customer_link' => $customerLink,
            'password' => Hash::make($data['password']),
        ]);
    }
}
