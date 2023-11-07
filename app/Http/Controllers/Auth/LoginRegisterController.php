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
    public function updateProfile(Request $request, $id)
{
    $user = User::find($id);

    $request->validate([
        'name' => 'required|string',
        'email' => 'required|email|unique:users,email,' . $id,
        'password' => 'nullable|string|min:6',
        'photo' => 'image|nullable|max:1999'
    ]);

    $user->name = $request->input('name');
    $user->email = $request->input('email');

    if ($request->has('password')) {
        $user->password = Hash::make($request->input('password'));
    }

    if ($request->hasFile('photo')) {
        $fileName = time() . '.' . $request->file('photo')->getClientOriginalExtension();
        $request->file('photo')->storeAs('storage/photos/', $fileName);

        // Resize dan simpan gambar asli
        $image = Image::make($request->file('photo')->getRealPath());
        $image->stream();
        $image->save(public_path('storage/photos/' . $fileName));

        $thumbnail = Image::make($request->file('photo')->getRealPath());
        $thumbnail->resize(150, 100); // Ubah ukuran sesuai kebutuhan
        $thumbnailFileName = time() . '_thumbnail.' . $request->file('photo')->getClientOriginalExtension();
        $thumbnail->save(public_path('storage/photos/' . $thumbnailFileName));

        $square = Image::make($request->file('photo')->getRealPath());
        $square->fit(150, 150); // Ubah ukuran sesuai kebutuhan
        $squareFileName = time() . '_square.' . $request->file('photo')->getClientOriginalExtension();
        $square->save(public_path('storage/photos/' . $squareFileName));

        $user->photo = $fileName;
        $user->thumbnail = $thumbnail->basename;
        $user->square = $square->basename;
    }

    $user->save();

    return redirect()->route('dashboard')->withSuccess("Profil berhasil diperbarui");
}

public function deletePhotos($id)
{
    $user = User::find($id);

    if ($user->thumbnail) {
        Storage::delete('storage/photos/' . $user->thumbnail);
        $user->thumbnail = null;
    }


    $user->save();

    return redirect()->back()->with('success', 'Gambar berhasil dihapus.');
}


}