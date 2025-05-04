<?php

namespace App\Http\Controllers;

use App\Models\Trader;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    function index(){
        $traders=Trader::all();
        return view('adminblade.traders',compact('traders'));
        
    }
    function approve($id){
        $traders=Trader:: findOrFail($id);
        $traders->status='approved';
        $traders->save();
        return redirect()->back()->with('success','Trader approved');
    }
    function reject($id){
        $traders=Trader:: findOrFail($id);
        $traders->status='rejected';
        $traders->save();
        return redirect()->back()->with('success','Trader rejected');
    }
    function logout(){
        
    }
}
