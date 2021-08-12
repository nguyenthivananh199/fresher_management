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
        $in_time = date('17:45:00');

        $output = '';
        if ($request->has('m')) {
            $m = $request->m;
            $d = $request->d;
            $max_day = $d + 1;
            // return response()->json(
            //     array('msg' => date("m")),
            //     200
            // );
            if ($m > date("m")) {
                return response()->json(
                    array('msg' => ''),
                    200
                );
            }
            if ($m == date("m")) {
                $max_day = date("d") + 1;
            }

            //   $data="<td>rgyyege</td><td>rgyyege</td><td>rgyyege</td>";

            //    return response()->json($search);
            if (isset($request->search)) {
                $search = $request->search;
                $users = User::where('name', 'like', '%' . $search . '%')
                    ->whereHas(
                        'roles',
                        function ($q) {
                            $q->where('name', 'fresher');
                        }
                    )

                    ->where('status', 'Active')
                    ->get();
            } else {
                $users = User::whereHas(
                    'roles',
                    function ($q) {
                        $q->where('name', 'fresher');
                    }
                )

                    ->where('status', 'Active')
                    ->get();
                // return response()->json(
                //     array('msg' => $data1),
                //     200
                // );
            }






            // $user_list = array();
            // $user_id = array();
            // $tests = array();


            // $user_list[] = $data1[0]['user_id'];
            // $user_id[] = $data1[0]['name'];

            // // get distint user in a month
            // for ($i = 0; $i < count($data1); $i++) {
            //     $kt = 1;
            //     for ($j = 0; $j < count($user_list); $j++) {
            //         if ($data1[$i]['user_id'] == $user_list[$j]) {
            //             $kt = 0;
            //             break;
            //         }
            //     }
            //     if ($kt == 1) {
            //         $user_list[] = $data1[$i]['user_id'];
            //         $user_id[] = $data1[$i]['name'];
            //     }
            // }


            //main thing
            for ($i = 0; $i < count($users); $i++) {
                $count_work = 0;
                $detail_id = array_fill(0, $d + 2, -1);
                $row = array_fill(0, $d + 2, "N/A");
                $row[1] = $users[$i]['name'];
                $row[0] = $users[$i]['id'];



                for ($j = 2; $j < count($row); $j++) {
                    //get day
                    $t1 = $j - 1;
                    $tmp = date("Y") . '-' . $m . '-' . $t1;
                    $date = date($tmp);
                    $dayofweek = date('l', strtotime($date));
                    if ($dayofweek == "Sunday" || $dayofweek == 'Saturday') {
                        $row[$j] = '_';
                    } else {
                        $data1 = Report::whereDate('created_at', '=', $date)
                            ->where('user_id', $row[0])->first();
                        if (isset($data1)) {

                            $detail_id[$j] = $data1['id'];
                            $hour = date_create_from_format("Y-m-d H:i:s", $data1['created_at'])->format("H:i:s");

                            if ($in_time < $hour) {
                                $row[$j]  = 'O/T';
                            } else {
                                $count_work++;
                                $row[$j] = 'I/T';
                            }
                        } else {
                            // return response()->json(
                            //     array('msg' => 'yeah'),
                            //     200
                            // );
                        }
                        // return response()->json(
                        //     array('msg' => $row),
                        //     200
                        // );



                    }
                }
                // return response()->json(
                //             array('msg' => $row),
                //             200
                //         );
                $output .= '<tr id="abc">';
                for ($t = 0; $t < count($row); $t++) {
                    if ($t <= $max_day) {
                        if (isset($detail_id[$t])) {
                            if ($row[$t] == "N/A") {
                                $output .= '<td  onclick="detail(' . $detail_id[$t] . ');" class="report_missing" data-toggle="modal" data-target="#myModal">' . $row[$t] . '</td>';
                            } else {
                                if ($row[$t] == "O/T") {
                                    $output .= '<td  onclick="detail(' . $detail_id[$t] . ');" class="report_out_time" data-toggle="modal" data-target="#myModal">' . $row[$t] . '</td>';
                                } else {
                                    if ($row[$t] == "I/T") {
                                        $output .= '<td  onclick="detail(' . $detail_id[$t] . ');" class="report_in_time" data-toggle="modal" data-target="#myModal">' . $row[$t] . '</td>';
                                    } else {
                                        $output .= '<td  onclick="detail(' . $detail_id[$t] . ');"  data-toggle="modal" data-target="#myModal">' . $row[$t] . '</td>';
                                    }
                                }
                            }
                        } else {
                        }
                    } else {
                        $output .= '<td  "> </td>';
                    }
                }
                $output .= '<td>' . $count_work . '</td>';
                $output .= '</tr>';
            }


            return response()->json(
                array('msg' => $output),
                200
            );
        } else {
            if ($request->has('id')) {
                $id = $request->id;
                $data1 = Report::where('id', '=', $id)
                    ->first();
                $output .= '
                <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Fresher name</label>
                                    <p class="form-control">' . $data1->user->name .  '</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Submitted time</label>
                                <p class="form-control">' . $data1['created_at'] .  '</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Today plan</label>
                            <textarea rows="2" class="form-control" name="note" style="width: 100%;">' . $data1->today_plan . '</textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Actual</label>
                        <textarea rows="2" class="form-control" name="note" style="width: 100%;">' . $data1->actual . '</textarea>
                    </div>
                </div>
            </div>
            <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="exampleInputEmail1">Tomorrow plan</label>
                    <textarea rows="2" class="form-control" name="note" style="width: 100%;">' . $data1->tomorrow_plan . '</textarea>
                </div>
            </div>
        </div>
        <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="exampleInputEmail1">Issues</label>
                <textarea rows="2" class="form-control" name="note" style="width: 100%;">' . $data1->issues . '</textarea>
            </div>

        </div>
      
  </div>
  <div class="row">
  <div class="col-md-12">
      <div class="form-group">
          <label for="exampleInputEmail1">Action</label>
          <textarea rows="2" class="form-control" name="note" style="width: 100%;">' . $data1->action . '</textarea>
      </div>

  </div>

</div>
<div class="row">
<div class="col-md-12">
    <div class="form-group">
        <label for="exampleInputEmail1">Note</label>
        <textarea rows="2" class="form-control" name="note" style="width: 100%;">' . $data1->note . '</textarea>
    </div>

</div>

</div>
               ';
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
                $output = '';
                $day = $request->detail_day;
                $month = $request->month;
                $data1 = Report::whereMonth('created_at', '=', $month)
                    ->whereDay('created_at', '=', $day)
                    ->where('user_id', $user->id)
                    ->first();


                $output .= '

                <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Fresher name</label>
                                    <p class="form-control">' . $user->name .  '</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Submitted time</label>
                                <p class="form-control">' . $data1['created_at'] .  '</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Today plan</label>
                            <textarea rows="2" class="form-control" name="note" style="width: 100%;">' . $data1->today_plan . '</textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Actual</label>
                        <textarea rows="2" class="form-control" name="note" style="width: 100%;">' . $data1->actual . '</textarea>
                    </div>
                </div>
            </div>
            <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="exampleInputEmail1">Tomorrow plan</label>
                    <textarea rows="2" class="form-control" name="note" style="width: 100%;">' . $data1->tomorrow_plan . '</textarea>
                </div>
            </div>
        </div>
        <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="exampleInputEmail1">Issues</label>
                <textarea rows="2" class="form-control" name="note" style="width: 100%;">' . $data1->issues . '</textarea>
            </div>

        </div>
      
  </div>
  <div class="row">
  <div class="col-md-12">
      <div class="form-group">
          <label for="exampleInputEmail1">Action</label>
          <textarea rows="2" class="form-control" name="note" style="width: 100%;">' . $data1->action . '</textarea>
      </div>

  </div>

</div>
<div class="row">
<div class="col-md-12">
    <div class="form-group">
        <label for="exampleInputEmail1">Note</label>
        <textarea rows="2" class="form-control" name="note" style="width: 100%;">' . $data1->note . '</textarea>
    </div>

</div>

</div>
                ';

                return response()->json(
                    array('msg' => $output),
                    200
                );
            }
        }
    }
    function add_report(Request $request)
    {   date_default_timezone_set('Asia/Ho_Chi_Minh');
        $user = Auth::user();
        $report = new Report();
        $report->user_id = $user->id;
        $report->today_plan = strip_tags($request->today_plan);
        $report->actual = strip_tags($request->actual);
        $report->tomorrow_plan = strip_tags($request->tomorrow_plan);
        $report->issues = strip_tags($request->issues);
        $report->action = strip_tags($request->action);
        $report->note = strip_tags($request->note);

        $report->save();
        return redirect()->route('report');
    }
    function edit_report(Request $request)
    {
        $user = Auth::user();
        $report = Report::find($request->id);
        $report->user_id = $user->id;
        $report->today_plan = $request->today_plan;
        $report->actual = $request->actual;
        $report->tomorrow_plan = $request->tomorrow_plan;
        $report->issues = $request->issues;
        $report->action = $request->action;
        $report->note = $request->note;

        $report->save();
        return redirect()->route('report');
    }
    function check_today_report()
    {

        if (Session::has('check_report')) {
            Session::forget('check_report');
        }
        $today = date("Y-m-d");
        $today_report = Report::whereDate('created_at', '=', $today)->first();

        if (!empty($today_report)) {

            return view('fresher.report', ['daily_report' => $today_report])->with('check_report', 'true');
        } else {
            //add avalable
            $today_report = new Report();
            return view('fresher.report', ['daily_report' => $today_report])->with('check_report', 'false');
        }
    }
}
