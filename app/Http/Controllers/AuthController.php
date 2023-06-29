<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth/login');
    }

    public function register()
    {
        return view('auth/register');
    }

    public function logining(Request $request)
    {
        try {
            $user = User::query()->where("email", $request->get('email'))
                ->firstOrFail();
            if (!Hash::check($request->get('password'), $user->password)) {
                throw new \Exception('Invalid password');
            } else {
                Auth::login($user);
                if ($user->role === UserRole::ADMIN) {
                    return redirect()->route('list_book');
                }
                return redirect()->route('user.index');
            }
        } catch (ModelNotFoundException $e) {
            return redirect()->route('login')->with('error', "sai email hoặc mật khẩu");
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', "sai email hoặc mật khẩu");
        }
//        return view('auth/login');
    }

    public function registering(Request $request)
    {
        try {
            $password = Hash::make($request->get('password'));
            $user = User::query()->where('email', $request->get('email'))
                ->first();
            if (isset($user)) {
                return redirect()->route('register')->with('error', "email " . $request->email . " đã tồn tại");
            }
            $avatar ="";
            if($request->file("avatar") !== null){
                $avatar = Storage::disk('public')->putFile('avatar', $request->file('avatar'));
            }
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $password,
                'avatar'=>$avatar,
                'role' => UserRole::USER,
            ]);
            Auth::login($user);
            return redirect()->route('user.index');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', "lỗi server");
            dd($e);
        }
    }

    public function logout()
    {
        Auth::logout();
        return view('auth/login');
    }
    //
}
