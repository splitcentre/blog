<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comics;

class ComicsController extends Controller{
    public function index(){
        $data_comic = Comics::all();

        return view('comic',compact('data_comic'));
    }
    public function create(){
        return view('addcomic');
    }
    public function store(Request $request){
        $comics= new Comics;
        $comics->comic_name=$request->comic_name;
        $comics->comic_price=$request->comic_price;
        $comics->save();
        return redirect('/comics');
    }
    
    public function destroy($id_comic){
        $comics= Comics::where('id_comic', $id_comic);
        $comics->delete();
        return redirect('/comics');
    }
}