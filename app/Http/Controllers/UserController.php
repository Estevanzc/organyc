<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller {
    public function index() {
    }
    public function logon() {
    }
    public function login() {
    }
    public function auth_login(Request $request) {
        $request_data = $request->validate([
            "email" => ["required", "exists:users,email"],
            "password" => ["required"],
        ]);
        $user = User::where("email", $request_data["email"])->first();
        if (empty($user)) {
            return redirect()->route("login")->withErrors([
                "Login" => "We did not find a user with this address"
            ])->withInput([
                        "email" => $request_data["email"],
                    ]);
        }
        if (!Hash::check($request_data["password"], $user["password"])) {
            return redirect()->route("login")->withErrors([
                "Password" => "Password incorrect"
            ])->withInput([
                        "email" => $request_data["email"],
                    ]);
        }
        if (Auth::attempt(["email" => $request_data["email"], "password" => $request_data["password"]])) {
            $request->session()->regenerate();
        }
        return redirect()->route("index");
    }
    public function auth_logon(Request $request) {
        $request_data = $request->validate([
            "name" => ["required", "min:5", "max:25"],
            "email" => ["required", "email", "unique:users,email"],
            "password" => ["required", Password::min(8)->letters()->numbers()],
        ]);
        $user = User::create($request_data);
        Auth::login($user);
        return redirect()->route("index");
    }
    public function show(string $id) {
    }
    public function edit(string $id) {
    }
    public function update(Request $request, string $id) {
    }
    public function destroy(string $id) {
    }
}
