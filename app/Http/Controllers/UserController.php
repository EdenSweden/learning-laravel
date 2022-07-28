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

    //  Logout user:
    public function logout(Request $request) {
        //removes authentication info from user's session:
        auth()->logout();
        //invalidate user session and regenerate csrf token:
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('message', 'You have been logged out.');
    }

    // show login form:
        public function login() {
            return view('users.login');
        }

    // Authenticate/log in user:
        public function authenticate(Request $request) {
            $formFields = $request->validate([
                'email' => ['required', 'email'],
                'password' => 'required'
            ]);

            // auth helper w/ attempt method:
            if(auth()->attempt($formFields)) {
                // regenerate session id:
                $request->session()->regenerate();

                return redirect('/')->with('message', 'You are now logged in.');
            }
            //If fails:
            return back()->withErrors(['email' => 'Invalid Credentials.'])->onlyInput('email');
            //  YOU DON'T WANT TO SPECIFY WHETHER EMAIL EXISTS B/C THAT CAN BE A SECURITY RISK. So just show 'invalid credentials' error message if either email or password fails.
        }

}
