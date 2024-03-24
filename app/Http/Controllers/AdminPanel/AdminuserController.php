<?php

namespace App\Http\Controllers\AdminPanel;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Users_detail;
use Illuminate\Support\Facades\Hash;
use App\Models\Course;
use App\Models\Program;

class AdminuserController extends Controller
{
    public function index()
    {
        return view('admin.users.index');
    }
    public function get_all_user()
    {
        $users = User::with('user_detail')->where('user_type', '!=', 1)->where('user_status', 1)->get();

        return response()->json([
            'users' => $users
        ], 200);
    }
    public function insert_user(Request $request)
    {

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'user_type' => $request->name,
            'password' => Hash::make($request->password),
        ]);
        return redirect()->back();
    }
    public function user_detail($id)
    {
        $programs = Program::all();
        $data = User::find($id);
        $data = $data->user_detail;
        // echo $data->user->name;
        // echo $data->user_d_name;

        return view('admin.user_detail', compact('data', 'programs'));
    }
    public function user_insert_check(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|max:50',
                'name2' => 'required|max:50',
                'username' => 'required|max:50',
                'password' => 'required|max:50',
                'email' => 'required|max:50',
                'phone' => 'required|max:50',

            ],
            [

                'name.required' => 'กรุณาป้อนข้อมูล',
                'name2.required' => 'กรุณาป้อนข้อมูล',
                'username.required' => 'กรุณาป้อนข้อมูล',
                'password.required' => 'กรุณาป้อนข้อมูล',
                'email.required' => 'กรุณาป้อนข้อมูล',
                'phone.required' => 'กรุณาป้อนข้อมูล',
            ]
        );

        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // ใช้ id ที่ได้จากการสร้าง User เพื่อสร้าง Users_detail
        $user_detail = Users_detail::create([
            'user_d_name' => $request->name,
            'user_d_name2' => $request->name2,
            'user_d_add' => $request->address,
            'user_d_email' => $request->email,
            'user_d_phone' => $request->phone,
            'id' => $user->id,
            'p_id' => $request->program
        ]);
        return back()->with('status', 'success');
    }
    public function user_edit_check(Request $request, $id)
    {

        $user = User::find($id);



        $user->username = $request->username;
        $user->email = $request->email;
        $user->user_status = $request->status;
        $user->save();


        $user = $user->user_detail;
        $user->user_d_name = $request->name;
        $user->user_d_name2 = $request->name2;
        $user->user_d_email = $request->email;
        $user->user_d_phone = $request->phone;
        $user->user_d_add = $request->address;
        $user->p_id = $request->program;
        $user->save();

        return back()->with('status', 'success');
    }

    public function user_edit_password(Request $request, $id)
    {

        $user = User::find($id);

        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('status', 'success');
    }

    public function delete($id)
    {
        $user = User::where('id', $id)->first();
        $user->delete();

        return back()->with('status', 'Some message here');
    }
    public function user_insert()
    {
        $programs = Program::all();
        return view('admin.user_insert', compact('programs'));
    }
}
