<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Session\Store;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Storage;

class LoginRegisterController extends Controller
{
    public  function __construct()
    {
        $this->middleware('guest')->except(['logout', 'dashboard']);
    }

    public function register()
    {
        return view('auth.register');
    }

    public function Store (Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'photo'=>'image|nullable|max:1999'
        ]);

        if($request->hasFile('photo')){
            $filenameWithExt = $request->file('photo')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('photo')->getClientOriginalExtension();
            $filenameSimpan = $filename . '_' . time() . '.' . $extension;
            $path = $request->file('photo')->storeAs('photos', $filenameSimpan);

            $thumbnailPath = 'thumbnails/' . $filenameSimpan;
            $thumbnail = Image::make(Storage::get($path));
            $thumbnail->fit(100, 100); // Adjust the size as needed
            Storage::put($thumbnailPath, (string) $thumbnail->encode());
         }else{
                dd("fail");
         }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password'=> hash::make($request->password),
            'photo'=>$path
        ]);

        $credentials = $request->only('email','password');
        Auth::attempt($credentials);
        $request->session()->regenerate();
        return redirect()->route('dashboard')
        ->withSuccess("Welcome! You have Successfully loggedin");
    }

   public function login(){
         return view('auth.login');
   } 

   public function authenticate(Request $request){
         $credentials = $request->validate([
                'email' => 'required', 'email',
                'password' => 'required',
         ]);


         if(Auth::attempt($credentials)){
              $request->session()->regenerate();
              return redirect()->route('dashboard')
              ->withSuccess("Welcome! You have Successfully loggedin");
         }
         return back()->withErrors([
              'email' => 'The provided credentials do not match our records',
         ]);
   }

    public function dashboard(){
        
        if (Auth::check()) {
            return view('auth.dashboard');
        }
        return redirect()->route('login')
        ->withErrors(['You are not allowed to access',]);

    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')
        ->withSuccess("You have logged out");
    }

}