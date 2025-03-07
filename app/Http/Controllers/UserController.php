<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Menu;
use App\Models\MenuControl;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class UserController extends Controller
{
    // subAdmins
    public function subAdmins()
    {
        $menus = Menu::all();
        return view('admin.users', compact('menus'));
    }
    // getUsersPageData
    public function getUsersPageData()
    {
        // $data['users_list'] = User::where('role', 3)->latest()->get();
        $query = User::where('role', 3)->latest();
        // name: 
        if(request()->has('name') && request('name') != ''){
            $query->where('name', 'like', '%'.request('name').'%');
        }
        // username: 
        if(request()->has('username') && request('username') != ''){
            $query->where('username', 'like', '%'.request('username').'%');
        }
        // email: 
        if(request()->has('email') && request('email') != ''){
            $query->where('email', 'like', '%'.request('email').'%');
        }
        // created_at
        if(request()->has('created_at') && request('created_at') != ''){
            $query->whereDate('created_at', request('created_at'));
        }
        $data['users_list'] = $query->get();
        return response()->json(['status' => 200, 'data' => $data]);
    }
    // getSpecificUser
    public function getSpecificUser(Request $request)
    {
        $user['user_detail'] = User::with('menus')->find($request->user_id);
        // set image baseurl
        if(is_null($user['user_detail']->image)){
            // $user['user_detail']->image = url('/uploads/users/default.png');
        }else{
            $user['user_detail']->image = url('/',$user['user_detail']->image);
        }
        return response()->json(['status' => 200, 'data' => $user]);
    }
    // saveUser
    public function saveUser(Request $request)
    {
        // validate
        $validated = $request->validate([
            'name' => 'required',
            'status' => 'required',
        ]);
        // dd($request->all());
        // user_id
        if ($request->user_id) {
            // validate
            $validated = $request->validate([
                'email' => 'required|unique:users,email,' . $request->user_id,
                'username' => 'required|unique:users,username,' . $request->user_id,
            ]);
            $user = User::find($request->user_id);
        } else {
            // validate
            $validated = $request->validate([
                'email' => 'required|unique:users',
                'username' => 'required|unique:users',
                'password' => [
                'required',
                'string',
                'min:8',
                'max:20',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/'
            ],
            // c_password
            'c_password' => 'required|same:password',
            ], [
                'password.regex' => 'The password must contain at least one uppercase letter, one lowercase letter, one number, and one special character.',
            ]);
            $user = new User();
        }
        $user->name = $request->name;
        $user->email = $request->email;
        $user->username = $request->username;
        $user->status = $request->status;
        // password
        $user->password = bcrypt($request->password);
        // role 3
        $user->role = 3;
        // Save the thumbnail file
        if ($request->hasFile('thumbnail')) {
            $thumbnailFile = $request->file('thumbnail');
            $thumbnailName = 'thumbnail_' . time() . '_' . trim($thumbnailFile->getClientOriginalName());
            $thumbnailPath = 'uploads/users'; 
            $thumbnailName = str_replace('', '_', $thumbnailName);

            
            $thumbnailFile->move(public_path($thumbnailPath), $thumbnailName);
            
            $user->image = trim($thumbnailPath.'/'.$thumbnailName);
        }
        $user->save();
        // first delete all MenuControl
        MenuControl::where('user_id', $user->id)->delete();
        // menus array check
        if ($request->menus) {
            // insert new MenuControl
            foreach ($request->menus as $menu) {
                $menu_control = new MenuControl();
                $menu_control->user_id = $user->id;
                $menu_control->menu_id = $menu;
                // created_by
                $menu_control->created_by = auth()->user()->id;
                // updated_by
                $menu_control->updated_by = auth()->user()->id;
                $menu_control->save();
            }
        }
        return response()->json(['status' => 200, 'message' => 'User updated successfully']);
    }
    // deleteUser
    public function deleteUser(Request $request)
    {
        User::find($request->user_id)->delete();
        return response()->json(['status' => 200, 'message' => 'User deleted successfully']);
    }
    // saveAdminProfile
    public function saveAdminProfile(Request $request)
    {
        // validate
        if($request->old_password != ''){
            $user = auth()->user();
            if (!Hash::check($request->old_password, $user->password)) {
                return response()->json(['status' => 402, 'message' => 'The old password is incorrect.']);
            }
            $validated = $request->validate([
                'name' => 'required',
                'email' => 'required',
                'username' => 'required',
                'email' => 'required|unique:users,email,' . auth()->user()->id,
                'username' => 'required|unique:users,username,' . auth()->user()->id,
                'old_password' => 'required',
                'password' => [
                    'required',
                    'string',
                    'min:8',
                    'max:20',
                    'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/',
                    'confirmed'
                ],
                'password_confirmation' => 'same:password',
            ], [
                'password_confirmation.regex' => 'The new password must contain at least one uppercase letter, one lowercase letter, one number, and one special character.',
            ]);
        }else{
            $validated = $request->validate([
                'name' => 'required',
                'email' => 'required',
                'username' => 'required',
                'email' => 'required|unique:users,email,' . auth()->user()->id,
                'password' => 'nullable|min:6',
                'username' => 'required|unique:users,username,' . auth()->user()->id,
            ]);
        }
        
        $user = User::find(auth()->user()->id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->username = $request->username;
        // password
        if($request->password != ''){
            $user->password= bcrypt($request->password);
        }
        // Save the thumbnail file profile_thumbnail_file
        if ($request->hasFile('thumbnail')) {
            $thumbnailFile = $request->file('thumbnail');
            $thumbnailName = 'thumbnail_' . time() . '_' . $thumbnailFile->getClientOriginalName();
            $thumbnailPath = 'uploads/users'; 
            $thumbnailFile->move(public_path($thumbnailPath), $thumbnailName);
            $user->image = $thumbnailPath . '/' . $thumbnailName;
        }
        $user->save();
        return response()->json(['status' => 200, 'message' => 'Profile updated successfully']);
    }
}
