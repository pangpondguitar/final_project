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
use Illuminate\Support\Str;

class AdminuserController extends Controller
{
    public function index()
    {
        return view('admin.users.index');
    }
    public function get_all_user()
    {
        $users = User::with('user_detail.program')->where('user_type', '!=', 1)->get();

        return response()->json([
            'users' => $users
        ], 200);
    }
    public function update_user_pass(Request $request, $id)
    {
        $password = Hash::make($request->password);
        $user = User::where('id', $id)->first();
        $user->password = $password;
        $user->save();
        return response()->json(['message' => 'Password updated successfully'], 200);
    }
    public function add_user(Request $request)
    {
        $user = new User();
        $user_check = User::where('username', $request->username)->exists();

        if ($user_check) {
            return response()->json(['message_err' => 'ชื่อผู้ใช้งานนี้มีอยู่แล้ว'], 400);
        }

        $user->username = $request->username;
        $user->email = $request->email;
        $user->user_type = $request->user_type;
        $user->user_status = '1';
        $user->password = Hash::make($request->password);

        $user->save();
        $last_userid = $user->id;

        $user_d = new Users_detail();
        $user_d->user_d_name = $request->name;
        $user_d->user_d_name2 = $request->name2;
        $user_d->user_d_add = $request->address;
        $user_d->user_d_email = $request->email;
        $user_d->user_d_phone = $request->phone;
        if ($request->hasFile('file')) {
            $uploadedFile = $request->file('file');
            $extension = $uploadedFile->getClientOriginalExtension(); // รับนามสกุลของไฟล์

            $randomFileName = uniqid() . '_' . Str::random(10) . '.' . $extension;
            $filePath = 'uploads/profile_pic' . '/' . $randomFileName;
            if (move_uploaded_file($uploadedFile, $filePath)) {
                $filePaths[] = $filePath;
                $user_d->user_d_pic = $randomFileName;
            } else {
                // return response()->json(['message' => 'Failed to upload file'], 500);
            }
        } else {
            $user_d->user_d_pic = 'user.png';
        }

        $user_d->id = $last_userid;
        $user_d->p_id = $request->program;
        $user_d->save();

        return response()->json(['success' => 'user_add_success'], 200);
    }

    public function update_users(Request $request, $id)
    {
        $user = User::find($id);
        if ($user->username != $request->username) {
            $user_check = User::where('username', $request->username)->exists();

            if ($user_check) {
                return response()->json(['message_err' => 'ชื่อผู้ใช้งานนี้มีอยู่แล้ว'], 400);
            }
        }


        $user->username = $request->username;
        $user->email = $request->email;
        $user->user_type = $request->user_type;

        // return response()->json(['message_err' =>  $request->status]);
        if ($request->status == "true") {
            $user->user_status = '1';
        } elseif ($request->status == "false") {
            $user->user_status = '0';
        }
        $user->save();

        $user_d = Users_detail::where('id', $id)->first();
        $user_d->user_d_name = $request->name;
        $user_d->user_d_name2 = $request->name2;
        $user_d->user_d_add = $request->address;
        $user_d->user_d_email = $request->email;
        $user_d->user_d_phone = $request->phone;

        if ($request->hasFile('file')) {
            $uploadedFile = $request->file('file');
            $extension = $uploadedFile->getClientOriginalExtension();

            $randomFileName = uniqid() . '_' . Str::random(10) . '.' . $extension;
            $filePath = 'uploads/profile_pic' . '/' . $randomFileName;
            if ($user_d->user_d_pic != '') {
                $fileDir = 'uploads/profile_pic/';
                $fileToDelete = $fileDir . $user_d->user_d_pic;
                if (file_exists($fileToDelete)) {
                    unlink($fileToDelete);
                }
            }
            if (move_uploaded_file($uploadedFile, $filePath)) {
                $filePaths[] = $filePath;
                $user_d->user_d_pic = $randomFileName;
            } else {
            }
        } else {
        }

        $user_d->p_id = $request->program;
        $user_d->save();

        return response()->json(['success' => 'user_add_success'], 200);
    }


    public function delete_user($id)
    {
        $user = User::find($id);
        $user_detail = Users_detail::where('id', $id);
        $user_detail->delete();
        $user->delete();
    }
    public function get_single_user($id)
    {
        $user = User::where('id', $id)->with('user_detail')->first();
        return response()->json([
            'user' => $user
        ]);
    }


    public function update_user($id)
    {
        $user = User::find($id);
        $user->delete();
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
