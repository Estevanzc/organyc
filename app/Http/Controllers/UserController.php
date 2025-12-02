<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\PasswordRecover;
use App\Models\Password_token;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\Password;
use Inertia\Inertia;

class UserController extends Controller {
    public function index() {
        return [
            "user" => User::find(Auth::user()->id),
        ];
    }
    public function logon() {
        return Inertia::render("Logon");
    }
    public function login() {
        return Inertia::render("Login");
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
        if (session("intended")) {
            $redirect_info = session("intended");
            session()->forget("intended");
            return redirect()->route($redirect_info[0], $redirect_info[1]);
        }
        return redirect()->route("index");
    }
    public function auth_logon(UserRequest $request) {
        $request_data = $request->validated();
        $user = User::create($request_data);
        Auth::login($user);
        if (session("intended")) {
            $redirect_info = session("intended");
            session()->forget("intended");
            return redirect()->route($redirect_info[0], $redirect_info[1]);
        }
        return redirect()->route("index");
    }
    public function show(string $id) {
    }
    public function edit(User $user) {
        return ["user" => $user];
    }
    public function update(UserRequest $request) {
        $request_data = $request->validated();
        $user = User::find($request_data["id"]);
        $user->update($request_data);
        return;// return to the user profile
    }
    public function password_recover($email) {
        $user = User::where("email", $email)->first();
        if (empty($user)) {
            return;//return to the home
        }
        $token = Password_token::create([
            "name" => (string) Str::uuid(),
            "user_id" => $user->id,
        ]);
        Mail::to($user->email)->send(new PasswordRecover($user, route("user.password.reseter", $token->name)));
        return; //return the page with warning or just a notification of it
    }
    public function password_reseter($token) {
        $token = Password_token::where("name", $token)->first();
        if (empty($token) || Carbon::parse($token->created_at)->diffInMinutes(Carbon::now()) > 60) {
            return; // return to the home
        }
        return [
            "token" => $token->name,
            "user" => $token->user,
        ];
    }
    public function password_update(Request $request) {
        $request_data = $request->validate([
            "id" => ["required", "exists:users,id"],
            "password" => ["required", Password::min(8)->letters()->numbers()],
            "token" => ["required", "exists:password_tokens,name"],
        ]);
        $token = Password_token::where("name", $request_data["token"])->first();
        $user = User::find($request_data["id"]);
        $user->update(["password" => $request_data["password"]]);
        return;//return to the user profile
    }
    public function destroy(User $user) {
        $user->delete();
        return;// return to the home
    }
}
