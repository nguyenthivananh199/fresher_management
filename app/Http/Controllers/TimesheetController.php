<?php

namespace App\Http\Controllers;

use App\Models\Absence_request;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Report;
use App\Models\Timesheet;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

use function PHPUnit\Framework\isEmpty;

class TimesheetController extends Controller
{
    //
    function timesheet_fresher(Request $request){
        $user = Auth::user();
        if ($request->has('m')) {
            $in_time = date('08:36:00');
            $month = date('m');
            $date = date('d');
            $check = array();
            if ($request->m == $month) {
                $check = array_fill(0, $date + 1, -1);
            } else {
                $check = array_fill(0, $request->d + 1, -1);
            }


            // $data = Timesheet::whereMonth('time_in', '=', $request->m)
            //     ->where('user_id', $user->id)->get();

            // $permit=Absence_request::whereMonth('absence_date', '=', $request->m)
            // ->where('user_id', $user->id)
            // ->get();

            //nap mang check 

            // for ($i = 0; $i < count($data); $i++) {
            //     $day = substr($data[$i]['time_in'],  8, 2);
            //     $day = $day + 0;
            //     $check_in= date_create_from_format("Y-m-d H:i:s", $data[$i]['time_in'])->format("H:i:s");
            //     $check_out= date_create_from_format("Y-m-d H:i:s", $data[$i]['time_out'])->format("H:i:s");
                // if (date('08:36:00') > $hour) {
                //     $check[$day]  = '+';
                // } else {

                //     $check[$day] = '-';
                // }
                

           // }
           
            for($i=1;$i<=count($check);$i++){
                // lay data ngay hom do
                $permit=Absence_request::whereMonth('absence_date', '=', $request->m)
                ->whereDay('absence_date','=',$i)
                ->where('user_id', $user->id)
                ->where('status', 'Approve')
                ->get();

                $tmp='';
                if(count($permit)!=0){
                    for($j=0;$j<count($permit);$j++){
                        $tmp.=''.$permit[$j]['type'].'_'.$permit[$j]['status'].'/';
                    }
                    $check[$i]=$tmp.'Y';
                }else{
                    
                //     //k co permit
                //     //hoi xem co timesheet k
                    $data = Timesheet::whereMonth('time_in', '=', $request->m)
                    ->whereDay('time_in','=',$i)
                    ->where('user_id', $user->id)->get();
                    if(count($data)!=0){
                        $check_in= date_create_from_format("Y-m-d H:i:s", $data[0]['time_in'])->format("H:i:s");
                        $check_out= date_create_from_format("Y-m-d H:i:s", $data[0]['time_out'])->format("H:i:s");
                        
                        //dung gio lam
                        if(date('08:35:00')>=$check_in && $check_out>=date('17:30:00')){
                            $tmp.='Full/';
                            
                        }
                        //check muon sang
                        if(date('08:36:00')<$check_in && $check_in<date('09:46:00')){
                            $tmp.='Morning late: No permission/';
                        }
                        //nghi sang
                        if(date('09:46:00')<$check_in && $check_in<date('14:46:00')){
                            $tmp.='Morning absence: No permission/';
                        }
                        //nghi chieu
                        if(date('14:46:00')<$check_in || $check_out<date('14:46:00')){
                            $tmp.='Afternoon absence: No permission/';
                        }
                        //ve som chieu
                        if(date('14:46:00')<$check_out && $check_out<date('17:29:00')){
                            $tmp.='Leave early: No permission/';
                        }
                        $check[$i]=$tmp.'N';
                    }
                   
                    
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
                $data1 = Timesheet::whereMonth('time_in', '=',$month )
                ->whereDay('time_in', '=',$day)
                ->where('user_id',$user->id)
                ->first();

                $output .= '
                <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Fresher name</label>
                        <p class="form-control">' .$user->name. '</p>
                    </div>
                </div>
            </div>';
                if(empty($data1)){
                    $output .= '
                   
                    <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Check in</label>
                            <p class="form-control">No information</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Check out</label>
                        <p class="form-control">No information</p>
                    </div>
                </div>
            </div>';
                }else{
                    $output .= '
                    <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Check in</label>
                            <p class="form-control">' . $data1->time_in . '</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Check out</label>
                        <p class="form-control">' . $data1->time_out . '</p>
                    </div>
                </div>
            </div>
                    
                     ';
                }
                   
               

                return response()->json(
                    array('msg' => $output),
                    200
                );
            }
        }
    }
}
