<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Report;
use App\Models\Timesheet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    //

    function report_data()
    {
        return view('admin.report');
    }
    function getData(Request $request)
    {
        $in_time = date('08:35:00');

        $output = '';
        if ($request->has('m')) {
            $m = $request->m;
            $d = $request->d;
            //   $data="<td>rgyyege</td><td>rgyyege</td><td>rgyyege</td>";

            //    return response()->json($search);
            if (isset($request->search)) {
                $search = $request->search;
                $data1 = User::where('name', 'like', '%' . $search . '%')

                    ->join('reports', function ($join) use ($m) {
                        $join->on('users.id', '=', 'reports.user_id');
                        $join->whereMonth('reports.created_at', '=', $m);
                    })
                    ->get();

                // $op='<p>'.$data1[0]['id'].'</p>';
                // return response()->json(
                //     array('msg' => $op),
                //     200
                // );
            } else {
                $data1 = User::join('reports', function ($join) use ($m) {
                    $join->on('users.id', '=', 'reports.user_id');
                    $join->whereMonth('reports.created_at', '=', $m);
                })
                    ->get();
             
            }






            $user_list = array();
            $user_id = array();


            $user_list[] = $data1[0]['user_id'];
            $user_id[] = $data1[0]['name'];
            // get distint user in a month
            for ($i = 0; $i < count($data1); $i++) {
                $kt = 1;
                for ($j = 0; $j < count($user_list); $j++) {
                    if ($data1[$i]['user_id'] == $user_list[$j]) {
                        $kt = 0;
                        break;
                    }
                }
                if ($kt == 1) {
                    $user_list[] = $data1[$i]['user_id'];
                    $user_id[] = $data1[$i]['name'];
                }
            }


            //main thing
            for ($i = 0; $i < count($user_list); $i++) {
                $count_work = 0;
                $detail_id = array_fill(0, $d + 1, -1);
                $row = array_fill(0, $d + 2, 0);
                $row[1] = $user_id[$i];
                $row[0] = $user_list[$i];
                for ($j = 0; $j < count($data1); $j++) {
                    if ($data1[$j]['user_id'] == $user_list[$i]) {
                        // get day


                        $day = substr($data1[$j]['created_at'],  8, 2);
                        $day = $day + 1;

                        $detail_id[$day] = $data1[$j]['id'];
                        $hour = date_create_from_format("Y-m-d H:i:s", $data1[$j]['created_at'])->format("H:i:s");
                        if ($in_time < $hour) {
                            $row[$day]  = '-';
                        } else {
                            $count_work++;
                            $row[$day] = '+';
                        }
                    }
                }
                $output .= '<tr id="abc">';
                for ($t = 0; $t < count($row); $t++) {
                    if (isset($detail_id[$t])) {

                        $output .= '<td  onclick="detail(' . $detail_id[$t] . ');"  data-toggle="modal" data-target="#myModal">' . $row[$t] . '</td>';
                    } else {
                        $output .= '<td onclick="detail(-1);"  data-toggle="modal" data-target="#myModal">' . $row[$t] . '</td>';
                    }
                }
                $output .= '<td>' . $count_work . '</td>';
                $output .= '</tr>';
            }


            // return response()->json(
            //     array('msg' => $output),
            //     200
            // );


        } else {
            if ($request->has('id')) {
                $id = $request->id;
                $data1 = Report::where('id', '=', $id)
                    ->first();
                $output .= '
                <h5>Name :' . $data1->user->name . '</h5>
                <h5>Time in :' . $data1['created_at'] . '</h5>';
            }
        }

        return response()->json(
            array('msg' => $output),
            200
        );
    }

    //fresher
    function report_fresher(Request $request)
    {
        $user = Auth::user();
        if ($request->has('m')) {
            $in_time = date('17:46:00');
            $month = date('m');
            $date = date('d');
            $check = array();
            if ($request->m == $month) {
                $check = array_fill(0, $date + 1, -1);
            } else {
                $check = array_fill(0, $request->d + 1, -1);
            }


            $data = Report::whereMonth('created_at', '=', $request->m)
                ->where('user_id', $user->id)->get();





            for ($i = 0; $i < count($data); $i++) {
                $day = substr($data[$i]['created_at'],  8, 2);
                $day = $day + 0;
                $hour = date_create_from_format("Y-m-d H:i:s", $data[$i]['created_at'])->format("H:i:s");
                if ($in_time > $hour) {
                    $check[$day]  = '+';
                } else {

                    $check[$day] = '-';
                }
            }

            return response()->json(
                array('msg' => $check),
                200
            );
        } else {
            if ($request->has('detail_day')) {
                $output='';
                $day = $request->detail_day;
                $month=$request->month;
                $data1 = Report::whereMonth('created_at', '=',$month )
                ->whereDay('created_at', '=',$day)
                ->where('user_id',$user->id)
                ->first();

                   
                $output .= '
                <h5>Name :' . $user->name . '</h5>
                <h5>Today plan :' . $data1->today_plan . '</h5>
                <h5>Actual :' . $data1->actual . '</h5>
                <h5>Issues :' . $data1->issues . '</h5>
                <h5>Action :' . $data1->action . '</h5>
                <h5>Note :' . $data1->note . '</h5>';
               
                return response()->json(
                    array('msg' => $output),
                    200
                );
            }
        }
    }
    function add_report(Request $request){
        $user = Auth::user();
        $report= new Report();
        $report->user_id=$user->id;
        $report->today_plan=strip_tags($request->today_plan);
        $report->actual=strip_tags($request->actual);
        $report->tomorrow_plan=strip_tags($request->tomorrow_plan) ;
        $report->issues=strip_tags($request->issues) ;
        $report->action=strip_tags($request->action) ;
        $report->note=strip_tags($request->note) ;

        $report->save();
        return redirect()->route('report');
    }
    function edit_report(Request $request){
        $user = Auth::user();
        $report=Report::find($request->id);
        $report->user_id=$user->id;
        $report->today_plan=$request->today_plan;
        $report->actual=$request->actual;
        $report->tomorrow_plan=$request->tomorrow_plan;
        $report->issues=$request->issues;
        $report->action=$request->action;
        $report->note=$request->note;

        $report->save();
        return redirect()->route('report');

    }
    function check_today_report(){
        
        if (Session::has('check_report')) {
            Session::forget('check_report');
            
        }
        $today= date("Y-m-d");
        $today_report= Report::whereDate('created_at','=',$today)->first();
       
        if(!empty($today_report)){
          
            return view('fresher.report',['daily_report'=>$today_report])->with('check_report', 'true');
        }else{
            //add avalable
            $today_report=new Report();
            return view('fresher.report',['daily_report'=>$today_report])->with('check_report', 'false');
        }
        
    }
}
