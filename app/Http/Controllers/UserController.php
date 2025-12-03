<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\PasswordRecover;
use App\Models\Password_token;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller {
    public function index(User $user) {
        if (Gate::denies("view", $user)) {
            return redirect()->route("index")->withErrors([
                "Access denied" => "You do not have the permission to do this action"
            ]);
        }
        return [
            "user" => $user,
        ];
    }
    public function login() {
        return Inertia::render("Auth/Login");
    }
    public function logon() {
        return Inertia::render("Auth/Register");
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
        if (Gate::denies("update", $user)) {
            return redirect()->route("index")->withErrors([
                "Access denied" => "You do not have the permission to do this action"
            ]);
        }
        return ["user" => $user];
    }
    public function update(UserRequest $request) {
        $request_data = $request->validated();
        $user = User::find($request_data["id"]);
        if (Gate::denies("update", $user)) {
            return redirect()->route("index")->withErrors([
                "Access denied" => "You do not have the permission to do this action"
            ]);
        }
        $user->update($request_data);
        return redirect()->route("user.profile", ["user" => $user->id])->with([
            "Success" => "Your account has been updated"
        ]);
    }
    public function password_recover($email) {
        $user = User::where("email", $email)->first();
        if (empty($user)) {
            return redirect()->route("index")->withErrors([
                "No user finded" => "There is no user with this email"
            ]);
        }
        if (Gate::denies("recover", $user)) {
            return redirect()->route("index")->withErrors([
                "Access denied" => "You do not have the permission to do this action"
            ]);
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
            return redirect()->route("index")->withErrors([
                "Access denied" => "Your token is invalid or expired"
            ]);
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
        return redirect()->route("user.profile", ["user" => $user->id])->with([
            "Success" => "Your password has been updated"
        ]);
    }
    public function destroy(User $user) {
        if (Gate::denies("delete", $user)) {
            return redirect()->route("index")->withErrors([
                "Access denied" => "You do not have the permission to do this action"
            ]);
        }
        $user->delete();
        return redirect()->route("index")->with([
            "Success" => "Your user account has been deleted."
        ]);
    }
}
