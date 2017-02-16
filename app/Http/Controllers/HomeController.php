<?php

namespace App\Http\Controllers;

use App\AttackPlan;
use App\Theme;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    // /**
    //  * Create a new controller instance.
    //  *
    //  * @return void
    //  */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){

        $id = Theme::where('selected', 1)->value('id');
        $pathImg = Theme::where('selected', 1)->value('path_img');
        $attackThemes = Theme::all();
        $attackPlans = AttackPlan::where('theme_id', $id)->get();
        
        return view('home', ['attackThemes' => $attackThemes, 
                             'attackPlans' => $attackPlans,
                             'pathImg' => $pathImg,
                             'idSelected' => $id]);
    }

    public function showPlan($id){

        $id = Theme::where('id', $id)->value('id');
        $pathImg = Theme::where('id', $id)->value('path_img');
        $attackThemes = Theme::all();
        $attackPlans = AttackPlan::where('theme_id', $id)->get();
        // dd($pathImg);
        return view('home', ['attackThemes' => $attackThemes, 
                             'attackPlans' => $attackPlans,
                             'pathImg' => $pathImg,
                             'idSelected' => $id]);
    }
}
