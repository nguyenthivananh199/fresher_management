<?php

namespace App\Http\Controllers;

use App\Models\Student_test;
use App\Models\User;
use App\Models\Timesheet;
use App\Models\Absence_request;
use App\Http\Requests\AddFresherRequest;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DemoController extends Controller
{

    //update ava
    function update_ava(Request $request)
    {
        if (!$request->hasFile('pic')) {
            // Nếu không thì in ra thông báo
            return "Mời chọn file cần upload";
        }

        // Nếu có thì thục hiện lưu trữ file vào public/images
        $image = $request->file('pic');
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $pic_name = $request->id . date("YmdHis") . '.jpg';
        $storedInPath = $image->move('img', $pic_name);

        //update in db
        $user = User::find($request->id);
        $user->img = '/img/' . $pic_name;
        $user->save();
        //delete old one direct in public
        $image_path = '/home/vananh/final/public' . $request->pre_img;  // Value is not URL but directory file path
        if (File::exists($image_path)) {
            File::delete($image_path);
        }

        return redirect()->route('fresher_detail', ['id' => $request->id])->withErrors(['Update avatar successfully']);
    }

    //update fresher
    function update_fresher(AddFresherRequest $request)
    {
        $user = User::find($request->id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->part = $request->part;
        $user->class = $request->class;
        $user->dob = $request->dob;
        $user->phone = $request->phone;
        $user->save();

        return redirect()->route('fresher_detail', ['id' => $request->id])->withErrors(['Update fresher successfully']);
    }
    //check mail
    function mail_ajax(Request $request)
    {
        $data1 = 1;
        $prev_mail = '';
        if (isset($request->search) && !empty($request->search)) {
            $search = $request->search;
            if (isset($request->prev_mail)) {
                $prev_mail = $request->prev_mail;
            }

            $data1 = User::where('email', $search)
                ->where('email', '!=', $prev_mail)
                ->count();
        }

        return response()->json(
            array('msg' => $data1),
            200
        );
    }

    function view_detail($id)
    {
        $user = User::find($id);
        return view('admin.fresher_detail', ['user' => $user]);
    }
    function fresher_management_data()
    {
        $mess = '';
        if (Session::has('mess')) {
            $mess = "add successfully";
            Session::forget('mess');
        }
        $classes = User::orderBy("class", "desc")->whereNotNull('class')->distinct('class')->select('class')->paginate(3);
        // $parts=User::whereNotNull('part')->select('part')->distinct()->get();
        return view('admin.fresher_management', ['classes' => $classes], ['mess' => $mess]);
        // return $classes;
    }

    function display_list_fresher(Request $request)
    {
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
                $data1 = User::select('id', 'name', 'email', 'phone', 'part', 'class')
                    ->whereHas('roles', function ($q) {
                        $q->where('name', 'fresher');
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
                    <td>' . $data1[$t]['class'] . '</td>
                    <td>
                    <a href="/detail/' . $data1[$t]['id'] . '">Detail</a>
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
    public function add_fresher(AddFresherRequest $request)
    {

        $image = $request->file('pic');

        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $pic_name = date("YmdHis") . '.jpg';
        $storedInPath = $image->move('img', $pic_name);



        // Will return only validated data
        // $name=$request->name;
        // $emai=$request->email;
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
        $user->img = '/img/' . $pic_name;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->part = $request->part;
        $user->class = $request->class;
        $user->dob = $request->dob;
        $user->status = $status;
        $user->password = $pass;
        $user->phone = $request->phone;
        $user->save();
        $user->assignRole('fresher');
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
    function spatie_demo()
    {

        $user = User::find(2);
        $user->givePermissionTo('manage timesheet');
        return "ok ok ok";
    }

    public function registerOrLoginUser($user1)
    {
        $user = User::where('email', $user1->email)->first();
        Auth::login($user);
    }
    function logindemo()
    {
        $user = Socialite::driver('google')->user();
        // Auth::login($user);
        session()->put('user', $user);
        $this->registerOrLoginUser($user);
        if (Auth::check()) {
            return redirect()->route('report');
        } else {
            return "Nghong";
        }
        // return redirect()->route('demo');
        //return "done";
    }
    function readtable()
    {
        $test = Timesheet::all();
        $check = array();
        // $date = new DateTime('2021-05-03 16:32:31');
        $in_time = date('08:35:00');
        for ($i = 0; $i < count($test); $i++) {
            // $d=date($test[$i]['date']);
            $d = date_create_from_format("Y-m-d H:i:s", $test[$i]['time_in'])->format("H:i:s");
            $time_checkin = $d;
            if ($in_time < $time_checkin) {
                $check[] = '-';
            } else {
                $check[] = '+';
            }
        }

        return view('admin.timesheet', ['datastuff' => $test, 'check' => $check]);
    }

    function getData(Request $request)
    {
        $in_time = date('08:35:00');

        $output = '';
        if ($request->has('m')) {
            $m = $request->m;

            $d = $request->d;

            if ($m > date("m")) {
                return response()->json(
                    array('msg' => ''),
                    200
                );
            }
            //   $data="<td>rgyyege</td><td>rgyyege</td><td>rgyyege</td>";

            //    return response()->json($search);
            if (isset($request->search)) {
                $search = $request->search;
                $data1 = User::where('name', 'like', '%' . $search . '%')

                    ->whereHas(
                        'roles',
                        function ($q) {
                            $q->where('name', 'fresher');
                        }
                    )

                    ->where('status', 'Active')
                    ->get();
                // $op='<p>'.$data1[0]['id'].'</p>';
                // return response()->json(
                //     array('msg' => $data1),
                //     200
                // );
            } else {
                // $data1 = User::join('timesheets', function ($join) use ($m) {
                //     $join->on('users.id', '=', 'timesheets.user_id');
                //     $join->whereMonth('timesheets.time_in', '=', $m);
                // })
                //     ->get();
                $data1 = User::whereHas(
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






            $user_list = array();
            $user_id = array();



            // $user_list[] = $data1[0]['user_id'];
            // $user_id[] = $data1[0]['name'];
            // // $a=$m;
            // // return response()->json(
            // //     array('msg' =>  $d),
            // //     200
            // // );
            // // get distint user in a month
            // //
            for ($i = 0; $i < count($data1); $i++) {
                //     $kt = 1;
                //     for ($j = 0; $j < count($user_list); $j++) {
                //         if ($data1[$i]['user_id'] == $user_list[$j]) {
                //             $kt = 0;
                //             break;
                //         }
                //     }
                //     if ($kt == 1) {
                $user_list[] = $data1[$i]['id'];
                $user_id[] = $data1[$i]['name'];
                //     }
            }


            //main thing
            for ($i = 0; $i < count($user_list); $i++) {
                $count_work = 0;
                $detail_id = array_fill(0, $d + 1, -1);
                $row = array_fill(0, $d + 2, 'Full');
                //get sunday & saturday
                for ($t = 2; $t < count($row); $t++) {

                    $t1 = $t - 1;
                    $tmp = date("Y") . '-' . $m . '-' . $t1;
                    $date = date($tmp);
                    $dayofweek = date('l', strtotime($date));
                    if ($dayofweek == "Sunday" || $dayofweek == 'Saturday') {
                        $row[$t] = '_';
                    }
                }

                $row[1] = $user_id[$i];

                $row[0] = $user_list[$i];

                //FOR ALL DAY IN M
                for ($t = 2; $t < count($row); $t++) {

                    if ($row[$t] != '_') {

                        $tmp_day = $t - 1;

                        $permit = Absence_request::whereMonth('absence_date', '=', $m)
                            ->whereDay('absence_date', '=', $tmp_day)
                            ->where('user_id', $user_list[$i])
                            ->where('status', 'Approve')
                            ->get();
                        // return response()->json(
                        //     array('msg' => $user_list[$i]),
                        //     200
                        // );
                        $tmp = '';
                        if (count($permit) != 0) {
                            $count_work++;
                            $tmp = 'A/P';
                            $row[$t] = $tmp;
                        } else {

                            //     //k co permit
                            //     //hoi xem co timesheet k
                            $data = Timesheet::whereMonth('time_in', '=', $m)
                                ->whereDay('time_in', '=', $tmp_day)
                                ->where('user_id', $user_list[$i])->get();
                            if (count($data) != 0) {
                                $check_in = date_create_from_format("Y-m-d H:i:s", $data[0]['time_in'])->format("H:i:s");
                                $check_out = date_create_from_format("Y-m-d H:i:s", $data[0]['time_out'])->format("H:i:s");
                                $kt1 = 0;

                                $work = 1;
                                //dung gio lam
                                if (date('08:35:00') >= $check_in && $check_out >= date('17:30:00')) {
                                    $kt1 = 2;
                                    $count_work++;
                                }
                                //check muon sang
                                if (date('08:36:00') < $check_in && $check_in < date('09:46:00')) {
                                    $kt1 = 1;
                                    $work -= 0.25;
                                }
                                //nghi sang
                                if (date('09:46:00') < $check_in && $check_in < date('14:46:00')) {
                                    $kt1 = 1;
                                    $work -= 0.5;
                                }
                                //nghi chieu
                                if (date('14:46:00') < $check_in || $check_out < date('14:46:00')) {
                                    $kt1 = 1;
                                    $work -= 0.5;
                                }
                                //ve som chieu
                                if (date('14:46:00') < $check_out && $check_out < date('17:29:00')) {
                                    $kt1 = 1;
                                    $work -= 0.25;
                                }
                                if ($kt1 == 1) {
                                    $tmp = 'A/N';
                                    $row[$t] = $tmp;
                                    $count_work = $count_work + $work;
                                }
                                if ($kt1 == 2) {
                                    $tmp = 'Full';
                                    $row[$t] = $tmp;
                                }
                            } else {

                                $tmp = 'A/N';
                                $row[$t] = $tmp;
                            }
                        }
                    }
                }

                $output .= '<tr id="abc">';
                for ($t = 0; $t < count($row); $t++) {
                    $n = $t - 1;
                    if ($t <= $request->upto_date + 1) {
                        if ($row[$t] == 'A/N') {
                            $output .= '<td class="report_missing" onclick="detail(' . $user_list[$i] . ',' . $n . ',' . $m . ');"  data-toggle="modal" data-target="#myModal">' . $row[$t] . '</td>';
                        } else {
                            if ($row[$t] == 'A/P') {
                                $output .= '<td class="report_out_time" onclick="detail(' . $user_list[$i] . ',' . $n . ',' . $m . ');"  data-toggle="modal" data-target="#myModal">' . $row[$t] . '</td>';
                            } else {
                                if ($row[$t] == 'Full') {
                                    $output .= '<td class="report_in_time" onclick="detail(' . $user_list[$i] . ',' . $n . ',' . $m . ');"  data-toggle="modal" data-target="#myModal">' . $row[$t] . '</td>';
                                } else {

                                    $output .= '<td  >' . $row[$t] . '</td>';
                                }
                            }
                        }
                    } else {
                        $output .= '<td  > </td>';
                    }
                }
                $output .= '<td>' . $count_work . '</td>';
                $output .= '</tr>';
            }
        } else {
            if ($request->has('id')) {
                $id = $request->id;
                $user = User::find($id);
                $date1 = $request->date1;
                $month1 = $request->month1;
                $year1 = date("Y");
                $output .= '
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Fresher ID</label>
                            <p class="form-control">' . $user->id . '</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Fresher name</label>
                            <p class="form-control">' . $user->name . '</p>
                        </div>
                    </div>
                </div>
            ';
                $data1 = Timesheet::whereMonth('time_in', '=', $month1)
                    ->whereYear('time_in', '=', $year1)
                    ->whereDay('time_in', '=', $date1)
                    ->where('user_id', $id)
                    ->first();
                if (isset($data1)) {
                    $output .= '
                    <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Check in</label>
                            <p class="form-control">' .  $data1['time_in'] . '</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Check out</label>
                            <p class="form-control">' .  $data1['time_out'] . '</p>
                        </div>
                    </div>
                </div>
            ';
                }



                $permit = Absence_request::whereMonth('absence_date', '=', $month1)
                    ->whereYear('absence_date', '=', $year1)
                    ->whereDay('absence_date', '=', $date1)
                    ->where('user_id', $id)
                    ->where('status', 'Approve')
                    ->get();

                if (count($permit) != 0) {
                    for ($k = 0; $k < count($permit); $k++) {
                        $output .= '
                        <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Abcense approved</label>
                            <p class="form-control">' . $permit[$k]['type'] . '</p>
                        </div>
                    </div>
                </div>
                   ';
                    }
                } else {
                    if (isset($data1['time_in'])) {
                        $result = $this->check_absence($data1['time_in'], $data1['time_out']);
                        if ($result == 'Full') {
                        } else {

                            $result = rtrim($result, ", ");
                            $output .= '
                            <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Abcense no permission</label>
                                    <p class="form-control">' .$result . '</p>
                                </div>
                            </div>
                        </div>

                            ';
                        }
                    } else {
                        $output .= '
                        <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Abcense no permission</label>
                                <p class="form-control">Full day absence</p>
                            </div>
                        </div>
                    </div>
';
                    }
                }
            }
        }

        return response()->json(
            array('msg' => $output),
            200
        );
    }
    function check_absence($time_in, $time_out)
    {
        $check_in = date_create_from_format("Y-m-d H:i:s", $time_in)->format("H:i:s");
        $check_out = date_create_from_format("Y-m-d H:i:s", $time_out)->format("H:i:s");
        $kt1 = '';
        //dung gio lam
        if (date('08:35:00') >= $check_in && $check_out >= date('17:30:00')) {
            $kt1 = 'Full';
        }
        //check muon sang
        if (date('08:36:00') < $check_in && $check_in < date('09:46:00')) {
            $kt1 .= "Morning late,";
        }
        //nghi sang
        if (date('09:46:00') < $check_in && $check_in < date('14:46:00')) {
            $kt1 .= "Morning absence,";
        }
        //nghi chieu
        if (date('14:46:00') < $check_in || $check_out < date('14:46:00')) {
            $kt1 .= "Afternoon absence,";
        }
        //ve som chieu
        if (date('14:46:00') < $check_out && $check_out < date('17:29:00')) {
            $kt1 .= "Leave early,";
        }
        return $kt1;
    }
}
