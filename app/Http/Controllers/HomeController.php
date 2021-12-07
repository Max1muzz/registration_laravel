<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserRegistrationLog;
use Illuminate\Http\Request;

class HomeController extends Controller
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
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $this->createLog();
        return view('home');
    }

    public function createLog(){
        if(!empty(auth())){
            $id = auth()->id();
            if(empty(UserRegistrationLog::where('user_id', $id)->get()->modelKeys())){
                $date = User::find($id)->created_at;
                $logs = [
                    'user_id' => $id,
                    'date' => $date,
                ];
                UserRegistrationLog::create($logs);
            }

        }
        return true;
    }
}
