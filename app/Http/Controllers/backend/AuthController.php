<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\LoginRequest;


class AuthController extends Controller
{
    public  function getlogin()
    {
        return view('backend.user.login');
    }
    public  function postlogin(Request $request)
    {
        $username = $request->username;
        $password = $request->password;
        if (filter_var($username, FILTER_VALIDATE_EMAIL)) {
            $data = ['email' => $username, 'password' => $password];
        } else {
            $data = ['username' => $username, 'password' => $password];
        }
        if (Auth::attempt($data)) {
            return redirect('admin');
            // echo ('thanh cong');
        } else {
            return redirect('admin/login');
            // echo ('that bai');
            //  echo bcrypt('123456'); //mã hóa 

        }
    }
    public  function logout()
    {
        Auth::logout();
        return redirect('admin/login');
    }
}
