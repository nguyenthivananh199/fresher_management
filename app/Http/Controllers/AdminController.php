<?php

namespace App\Http\Controllers;
use App\Models\Absence_request;
use App\Models\User;
use App\Models\Report;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
class AdminController extends Controller
{
    //
    function data_prepare(){
        $roles=Role::where('name','!=','Super_Admin')
        ->where('name','!=','fresher')->get();
        return view('super_admin.admin_management',['roles'=>$roles]);
    }

    function update_admin(Request $request){
        
        
        $dob = $request->dob;
        $dob = $this->Formed_date_input($dob);
        $user =User::find($request->id);

        $user->roles()->detach();
        $user->permissions()->detach();

        $user->name = $request->name;
        $user->email = $request->email;
        $user->part = $request->part;
        $user->dob = $request->dob;
        $user->phone = $request->phone;
        $user->save();

        $user->assignRole($request->role);
    
        if(isset($request->Fresher_management)){
            $user->givePermissionTo($request->Fresher_management);
        }
        if(isset($request->Timesheet_management)){
            $user->givePermissionTo($request->Timesheet_management);
        }
        if(isset($request->Report_management)){
            $user->givePermissionTo($request->Report_management);
        }
        return redirect()->back()->with('mess', 'oki');
    }
    function add_admin(Request $request){
     


        $dob = $request->dob;
        $dob = $this->Formed_date_input($dob);
        $status = 'Active';
        // form dob
        // $part=$request->part;
        // $class=$request->class;
        $pass = Hash::make($dob);
        // $phone=$request->phone;

        //add to db
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->part = $request->part;
        $user->dob = $request->dob;
        $user->status = $status;
        $user->password = $pass;
        $user->phone = $request->phone;
        $user->save();

        $user->assignRole($request->role);
        $user->assignRole('admin_default');
        if(isset($request->Fresher_management)){
            $user->givePermissionTo($request->Fresher_management);
        }
        if(isset($request->Timesheet_management)){
            $user->givePermissionTo($request->Timesheet_management);
        }
        if(isset($request->Report_management)){
            $user->givePermissionTo($request->Report_management);
        }
        // return redirect()->back()->with('add_success','ok');
        // Session::put('mess', 'ok');
        return redirect()->back()->with('mess', 'oki');

    }
    function Formed_date_input($date)
    {
        $dates = explode("-", $date);
        $result = $dates[2] . $dates[1] . $dates[0];
        return $result;
    }

    function display_list_admin( Request $request){
        $output = '';
        if (1 == 1) {
            $search = $request->search;
            $class1 = $request->class1;
            $class2 = $request->class2;
            $class3 = $request->class3;
            $deleteid = $request->deleteid;
            User::where('id', $deleteid)
                ->update(['status' => 'Inactive']);

            if ($class1 == '' && $class2 == '' && $class3 == '') {
                $data1 = User::whereHas('roles', function ($q) {
                        $q->where('name','!=','fresher')
                        ->where('name','!=','Super_Admin');
                    })
                    ->where('name', 'like', '%' . $search . '%')
                    ->where('status', 'Active')
                    ->get();

                    

            } else {
                $data1 = User::select('id', 'name', 'email', 'phone', 'part', 'class')
                    ->whereHas(
                        'roles',
                        function ($q) {
                            $q->where('name', 'fresher');
                        }
                    )
                    ->where('name', 'like', '%' . $search . '%')
                    ->where(function ($query) use ($class1, $class2, $class3) {
                        $query->orWhere('class',  $class1)
                            ->orWhere('class',  $class2)
                            ->orWhere('class',  $class3);
                    })

                    ->where('status', 'Active')
                    ->get();
            }

            //}


            for ($t = 0; $t < count($data1); $t++) {
                // if (isset($detail_id[$t])) {
                $output .= '<tr id="abc">';
                $output .= '
                    <td>' . $data1[$t]['id'] . '</td>
                    <td>' . $data1[$t]['name'] . '</td>
                    <td>' . $data1[$t]['email'] . '</td>
                    <td>' . $data1[$t]['part'] . '</td>
                   
                    <td>
                    <a href="/detail_admin/' . $data1[$t]['id'] . '">Detail</a>
                    <a href="" onclick="deleteFresher(' . $data1[$t]['id'] . ')">Delete</a>
                    </td>
                    ';
                $output .= '</tr> ';
            }
            // $output .= '<td>' . $count_work . '</td>';

        } else {
        }

        return response()->json(
            array('msg' => $output),
            200
        );
    }

    function view_detail($id){
        $user = User::find($id);
        $role = $user->getRoleNames();
        $permission=$user->getPermissionNames();
        $role_list=Role::select('name')
        ->where('name','!=','Super_Admin')
        ->where('name','!=','fresher')->get();
     
       
        return view('super_admin.admin_detail', ['user' => $user,'role'=> $role,'role_list'=>$role_list,'permission'=>$permission]);
    }
    function dashboard_data(){
        // active admin
        $admin = User::whereHas('roles', function ($q) {
            $q->where('name','!=','fresher')
            ->where('name','!=','Super_Admin');
        })
        ->where('status', 'Active')
        ->count();

        $fresher = User::whereHas('roles', function ($q) {
            $q->where('name','=','fresher');
            
        })
        ->where('status', 'Active')
        ->count();
        $report=Report::whereDate('created_at','=',date("Y-m-d"))->count();
        
        $request=Absence_request::where('status','Pending')->count();

        $list=array();
        $list[]=-1;
        for($i=1;$i<=12;$i++){
            $fresher_per_month=User::whereHas('roles', function ($q) {
                $q->where('name','=','fresher');
                
            })
            ->where('status','Active')
           ->whereMonth('created_at','=',$i)
           ->whereYear('created_at','=',date('Y'))
            ->count();

            $list[]=$fresher_per_month;
        }
        //list fresher each month
  
        return view('admin.dashboard', ['report' => $report, 'request' => $request,'admin'=>$admin,'fresher'=>$fresher,'list'=>$list]);}
}
