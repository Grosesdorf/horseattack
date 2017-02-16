<?php

namespace App\Http\Controllers;

use App\AttackPlan;
use App\Theme;
use Illuminate\Http\Request;

class AdminPanelController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $attackPlans = AttackPlan::all();
        $attackThems = Theme::all();
        return view('adminattackplans', ['attackPlans' => $attackPlans,
                                         'attackThems' => $attackThems]);
    }
}
