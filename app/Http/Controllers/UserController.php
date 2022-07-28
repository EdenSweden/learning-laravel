<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    // Show Register/Create Form
    public function create() {
        return view('users.register');
    }

    // Create new user
    public function store(Request $request) {
        //FORM VALIDATION:
        $formFields = $request->validate([
            'name' => ['required', 'min:3'],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            //how to confirm that two fields match:
            'password' => 'required|confirmed|min:6',
            //^ then make sure in the view file that the input name is the same name as the first one, + '_confirmation'.
        ]);
        
        // ALWAYS HASH THE PW:
        
        //Hash password and set pw to the hashed value
        $formFields['password'] = bcrypt($formFields['password']);

        //create user:
        $user = User::create($formFields);

        // LOGIN
        //auth helper fn. Pass in user that was just created:
        auth()->login($user);
        return redirect('/')->with('message', 'User created and logged in.');
    }
}
