<?php

namespace App\Http\Controllers;
use Auth;
use Illuminate\Http\Request;
use App\User;
use App\Staff;
use App\Announcement;
class AdminController extends Controller
{
    public function __construct()
    {
    	$this->middleware(function ($request, $next) {
    		if(Auth::check()){
    			if(Auth::user()->user_type_id == 3){
					return $next($request);
				}
    		}
    		else{
    			return redirect('/');
    		}
		});
    }
    public function dashboard()
    {

        $params['navbar_active'] = 'account';
    	$params['sidebar_active'] = 'dashboard';
    	return view('admin.dashboard', $params);
    }

    public function addaccount()
    {
        $params['navbar_active'] = 'account';
        $params['sidebar_active'] = 'addstaffaccount';
        return view('admin.addaccount', $params);
    }

    public function createstaffaccount(Request $request)
    {
        $staff = new User();
        $staff->user_id = $request->staff_id;
        $staff->user_type_id = 2;
        $staff->password = bcrypt($request->staff_password);
        $staff->save();
        $staff_info = new Staff;
        $staff_info->staff_id = $request->staff_id;
        $staff_info->staff_type_id = $request->staff_type_id;
        $staff_info->staff_first_name = $request->staff_first_name;
        $staff_info->staff_middle_name = $request->staff_middle_name;
        $staff_info->staff_last_name = $request->staff_last_name;
        $staff_info->save();
        return redirect('admin/addaccount');
    }

    public function postannouncement(Request $request)
    {
        $announcement = new Announcement;
        $announcement->announcement_title = $request->announcement_title;
        $announcement->announcement_body = $request->announcement_body;
        $announcement->save();
        return redirect('announcements')->with('status', 'Announcement posted!');
    }
}
