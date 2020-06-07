<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CompanyLoginController extends Controller
{
	public function __construct() {

		$this->middleware('guest:company');
	}


    public function showLoginForm() {

    	return view('auth.company-login');
    }

 
    public function login(Request $request) {

    	// validate form

    	$this->validate($request, [

    		'email' => 'required:email',
    		'password' => 'required:min:6'
    	]);

    	//attempt to log user in
    	if(\Auth::guard('company')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {

    		//if successful, redirect to intended
    		return redirect()->intended(route('company.index'));
    	}

    	

    	//if unsucessful
    	return redirect()->back()->withInput($request->only('email', 'remember'));
    }
}
