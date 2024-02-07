<?php

namespace App\Http\Controllers\UsersPanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Users_detail;

class ProfileControllor extends Controller
{
    public function index()
    {
        return view('users.profile.index');
    }

    public function get_profile($id)
    {
        $profile = User::find($id);
        $profile =  $profile->user_detail;
        return response()->json([
            'profile' => $profile
        ], 200);
    }
}
