<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Report;
use App\Models\Absence_request;
use App\Models\Timesheet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;


class RequestController extends Controller
{
    //ADD REQUEST
    function save_request(Request $request, $id)
    {
        $absence = new Absence_request();
        $absence->user_id = $id;
        $absence->absence_date = $request->date;
        $absence->type = $request->type;
        $absence->reason = $request->reason;
        $absence->save();
    }
    function add_request(Request $request)
    {
        $user = Auth::user();



        //check holiday permission
        
        $dayofweek = date('l', strtotime($request->date));
                    if ($dayofweek == "Sunday" || $dayofweek == 'Saturday') {
                        return redirect() ->back()->withErrors(['Fail,unavalable absence day']);
                    }
        //check absence date

        $last_req = Absence_request::where('user_id', $user->id)
            ->whereDate('absence_date', '=', $request->date)->get();

        if (count($last_req) == 0) {
            // no req existed
            $this->save_request($request, $user->id);
           // return view('fresher.request', ['mess' => 'Add request successfully']);
           return redirect() ->back()->withErrors([ 'Add request successfully']);
        } else {
            if (count($last_req) == 1) {

                if ($last_req[0]['status'] == 'Reject') {
                    $this->save_request($request,$user->id);
                    return redirect() ->back()->withErrors([ 'Add request successfully']);
                } else {
                    if ($last_req[0]['type'] == 'Full') {
                        return redirect() ->back()->withErrors(['Fail,you ve already had day off request ']);
                    }
                    if ($last_req[0]['type'] == 'Morning') {
                        //accept: Afternoon, Leave early
                        if ($request->type == 'Afternoon' || $request->type == 'Leave early') {
                            $this->save_request($request,$user->id);
                            return redirect() ->back()->withErrors([ 'Add request successfully']);
                        } else {
                            return redirect() ->back()->withErrors([ 'Fail,request type conflic']);
                        }
                    }
                    if ($last_req[0]['type'] == 'Afternoon') {
                        //accept: Morning late, Morning
                        if ($request->type == 'Morning' || $request->type == 'Morning late') {
                            $this->save_request($request,$user->id);
                            return redirect() ->back()->withErrors([ 'Add request successfully']);
                        } else {
                            return redirect() ->back()->withErrors([ 'Fail,request type conflic']);
                        }
                    }
                    if ($last_req[0]['type'] == 'Leave early') {
                        //accept: Morning late, Morning
                        if ($request->type == 'Morning' || $request->type == 'Morning late') {
                            $this->save_request($request,$user->id);
                            return redirect() ->back()->withErrors([ 'Add request successfully']);
                        } else {
                            return redirect() ->back()->withErrors([ 'Fail,request type conflic']);
                        }
                    }
                    if ($last_req[0]['type'] == 'Morning late') {
                        //accept: Afternoon, Leave early
                        if ($request->type == 'Afternoon' || $request->type == 'Leave early') {
                            $this->save_request($request,$user->id);
                            return redirect() ->back()->withErrors(['Add request successfully']);
                        } else {
                            return redirect() ->back()->withErrors([ 'Fail,request type conflic']);
                        }
                    }
                }
            }else{
                //no more
                return redirect() ->back()->withErrors(['Fail,you ve already had 2 requests']);
            }
        }
    }
    //load request table
    function display_list_request(Request $request)
    {
        $user = Auth::user();
        $output = '';
        if (1 == 1) {
            $m = $request->search;
            $req_type = $request->req_type;
            $req_order = $request->req_order;

            $deleteid = $request->deleteid;
            Absence_request::where('id', $deleteid)
                ->delete();

            if ($req_type == '') {
                $data1 = Absence_request::where('user_id', $user->id)
                    ->whereMonth('absence_date', '=', $m)
                    ->orderBy('created_at', $req_order)
                    ->get();

                // return response()->json(
                //     array('msg' => $data1),
                //     200
                // );
            } else {
                $data1 = Absence_request::where('user_id', $user->id)
                    ->whereMonth('absence_date', '=', $m)
                    ->where('status', $req_type)
                    ->orderBy('created_at', $req_order)
                    ->get();
            }

            //}


            for ($t = 0; $t < count($data1); $t++) {
                // if (isset($detail_id[$t])) {
                $output .= '<tr id="abc">';
                $output .= '
                    <td>' . $data1[$t]['id'] . '</td>
                    <td>' . $data1[$t]['absence_date'] . '</td>
                    <td>' . $data1[$t]['type'] . '</td>
                    <td>' . $data1[$t]['created_at'] . '</td>
                    <td>' . $data1[$t]['status'] . '</td>
                   
                    <td>';
                if ($data1[$t]['status'] == 'Pending') {
                    $output .= '<a href="" onclick="deleteFresher(' . $data1[$t]['id'] . ')">Delete</a>
                </td></tr> ';
                }



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



    //load request table admin
    function display_list_request_admin(Request $request)
    {
        $output = '';
        if (1 == 1) {
            $m = $request->search;
            $req_type = $request->req_type;
            $req_order = $request->req_order;
            $search = $request->search_txt;
            $status_id = $request->status_id;
            $status_value = $request->status_value;

            if ($status_id != -1 && $status_value != '') {
                //update status
                $ud = Absence_request::find($status_id);
                $ud->status = $status_value;
                $ud->save();
            }

            if ($req_type == '') {
                if($req_order==''){
                    $data1 = User::where('name', 'like', '%' . $search . '%')

                    ->join('requests', function ($join) use ($m, $req_order) {
                        $join->on('users.id', '=', 'requests.user_id');
                        $join->whereMonth('requests.absence_date', '=', $m);
                    })
                    ->get();
                }else{
                    $data1 = User::where('name', 'like', '%' . $search . '%')

                    ->join('requests', function ($join) use ($m, $req_order, $req_type) {
                        $join->on('users.id', '=', 'requests.user_id');
                        $join->whereMonth('requests.absence_date', '=', $m);
                        $join->where('requests.status', '=', $req_order);
                       
                    })
                    ->get();
                }
            } else {
                if($req_order==''){
                    $data1 = User::where('name', 'like', '%' . $search . '%')

                    ->join('requests', function ($join) use ($m, $req_order, $req_type) {
                        $join->on('users.id', '=', 'requests.user_id');
                        $join->whereMonth('requests.absence_date', '=', $m);
                        $join->where('requests.type', '=', $req_type);
                    })
                    ->get();
                }else{
                    $data1 = User::where('name', 'like', '%' . $search . '%')

                    ->join('requests', function ($join) use ($m, $req_order, $req_type) {
                        $join->on('users.id', '=', 'requests.user_id');
                        $join->whereMonth('requests.absence_date', '=', $m);
                        $join->where('requests.type', '=', $req_type);
                        $join->where('requests.status', '=', $req_order);
                        
                    })
                    ->get();
                }
                
            }

            //}


            for ($t = 0; $t < count($data1); $t++) {
                // if (isset($detail_id[$t])) {
                $output .= '<tr id="abc">';
                $output .= '
                    <td>' . $data1[$t]['id'] . '</td>
                    <td>' . $data1[$t]['user_id'] . '</td>
                    <td>' . $data1[$t]['name'] . '</td>
                    <td>' . $data1[$t]['absence_date'] . '</td>
                    <td>' . $data1[$t]['type'] . '</td>
                    <td>' . $data1[$t]['created_at'] . '</td>
                   
                    <td>';


                if ($data1[$t]['status'] == 'Pending') {
                    $output .= ' <select name="order" id="' . $data1[$t]['id'] . '" onclick="set_status_id(' . $data1[$t]['id'] . ')" class="form-control">';
                    $output .= '<option value="Pending">Pending</option>
                        <option value="Approve">Approve</option>
                        <option value="Reject">Reject</option>';
                } else {
                    $output .= ' <select name="order" id="change_status"  class="form-control">';
                    $output .= '<option value="' . $data1[$t]['status'] . '"> ' . $data1[$t]['status'] . '</option>';
                }


                $output .= '   
                </select>
                </td></tr> ';




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
}
