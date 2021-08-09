<?php

namespace App\Http\Controllers;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Role_has_permissions;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;
use Monolog\Handler\RollbarHandler;

class RoleController extends Controller
{
    //
    function update_role(Request $request){
        $role=Role::find($request->id);
        $role->permissions()->detach();
        if(isset($request->Fresher_management)){
            $role->givePermissionTo('Fresher management');
        }if(isset($request->Timesheet_management)){
            $role->givePermissionTo('Timesheet management');
        }
        if(isset($request->Report_management)){
            $role->givePermissionTo('Report management');
        }
        return redirect()->back();
    }
    function view_role_management(){
        $permission=Permission::all();
        
        return view('super_admin.roles',['permission' => $permission]);
    }
    function add_role(Request $request){
        //create new role
        $role = Role::create(['name' => $request->name]);
        if(isset($request->Fresher_management)){
            $role->givePermissionTo('Fresher management');
        }if(isset($request->Timesheet_management)){
            $role->givePermissionTo('Timesheet management');
        }
        if(isset($request->Report_management)){
            $role->givePermissionTo('Report management');
        }
        return redirect()->back();

    }
    function check_exist_role(Request $request){
        $output='';
        if(!isset($request->isUpdate)){
           
            $role=Role::where('name',$request->name)->get();
            if(count($role)!=0){
                $output="<p>Role's name existed</p>";
            }
        }else{
            $role=Role::where('name',$request->name)
            ->where('name','!=',$request->isUpdate)
            ->get();
            if(count($role)!=0){
                $output="<p>Role's name existed</p>";
            }
        }
        return response()->json(
            array('msg' => $output),
            200
        );
    }
    function display_list_fresher(Request $request)
    {
        $output = '';
        if (1 == 1) {
            $search = $request->search;
            $class1 = $request->class1;
            $class2 = $request->class2;
            $class3 = $request->class3;
            if($request->deleteid!=-1){
                $deleteid = $request->deleteid;
            
                $role = Role::findOrFail($deleteid); 
                
                $role->delete();
            }
            

            if ($class1 == '' && $class2 == '' && $class3 == '') {
                $data1=Role::where('name','!=','fresher')
                ->where('name','!=','Super_Admin')
                ->where('name','!=','admin_default')
                ->where('name', 'like', '%' . $search . '%')
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
                 
                    <td>
                    <a href="/detail_role/' . $data1[$t]['id'] . '">Detail</a>
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
        $role=Role::find($id);
        $permission= $role->permissions()->get();
        // return $permission[0]['name'];
        return view('super_admin.role_detail', ['role' => $role,'permission'=>$permission]);
    }
    
}
