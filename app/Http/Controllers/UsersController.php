<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Rules\FilterRule;
use App\Rules\ValidateEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    protected $rules = [
        'name' => ['required', 'string', 'godFilter'],
        'email' => ['required','email'], 
        'password' => 'required | string | between: 6,20'
    ];

    protected $messages = [
        'required' => 'the :attribute field is mandatory...!',
        'name' => [
            'string' => ':attribute must me string...!'
        ],
    ];

    /**
     * Display a listing of the resource.
     */
    public function index(){
        $data = User::get();
        return view('users.index', compact('data'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create(){
        $user = new User;
        return view('users.add', compact('user'));
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request){
        $clean = $request->validate($this->rules());

        $user = new User;
        $user->name = $clean['name'];
        $user->email = $clean['email'];
        $user->password = $clean['password'];
        $user->save();

        return redirect()->route('index')->with('success', 'user added successfully.');
    }

    /**
     * This is the old way to implement details functionality...
     */
    /*
    public function show($id){
        $user = User::findOrFail($id);
        return view('users.details', compact('user'));
    }
    */

    /**
     * Details business logic but, this time by using Model-Route Binding concept...
     */
    public function show (User $user) {
        return view('users.details', compact('user'));
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit($id){
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id){
        $user = User::findOrFail($id);
        $clean = $request->validate($this->rules);

        $user->name = $clean['name'];
        $user->email = $clean['email'];
        $user->password = $clean['password'];
        $user->save();

        return redirect()->route('index')->with('info', 'user updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id){
        $user = User::findOrFail($id);
        User::destroy($id);
        return redirect()->route('index')->with('danger', 'user removed successfully.');
    }

    /**
     * Here is a custome Rule to validate user's name & email.
     */
    protected function rules() {
        $rules = $this->rules;
        // $rules['name'][] = function ($attribute, $value, $fail) {
        //     $pattern = '/\bgod\b/i';
        //     if ($value == 'god') {
        //         $fail('This word is not allawed...!');
        //     }
        // };
        $rules['name'][] = new FilterRule();
        $rules['email'][] = new ValidateEmail();

        return $rules;
    }
}
