<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RequestInspection;
use App\Inspection;
use App\DeviceToken;
use App\Users;
use Auth;
use App\LastLogin;

class SrManagerController extends Controller
{
    // READ


    public function index(){
        $request = [
            'hold' => count(RequestInspection::where(['managerapprove' => 1, 'area' => 2])->get()),
            'accept' => count(RequestInspection::where(['managerapprove' => 2, 'area' => 2])->get()),
            'reject' => count(RequestInspection::where(['managerapprove' => 0, 'area' => 2])->get()),
        ];
        $inspection = [
            'hold' => count(Inspection::where(['managerapprove' => 1])->get()),
            'accept' => count(Inspection::where(['managerapprove' => 2])->get()),
            'reject' => count(Inspection::where(['managerapprove' => 0])->get()),
        ];
        $lastlogin = LastLogin::where('user_id',Auth::user()->id)->first();

        // Insert/Update Last Login
        if(count(LastLogin::where('user_id', Auth::user()->id)->get()) == 0){
            $last = new LastLogin;
            $last->user_id = Auth::user()->id;
            $last->timestamp = date("d-m-Y H:i:s");
            $last->save();
        }else{
            LastLogin::where('user_id', Auth::user()->id)->update(['timestamp' => date("d-m-Y H:i:s")]);
        }
        return view('manager.index' ,compact('request','inspection','lastlogin'));
    }
    public function request($approval){
        if($approval == 'index'){
            // Menampilkan Semua
            $data = [
                'request' => RequestInspection::where(['area' => 2])->get(),
                'title' => 'Request Inspection From User'
            ];
            return view('manager.request', compact('data'));
        }elseif($approval == 'hold'){
            // Menampilkan Hold SPD
            $data = [
                'request' => RequestInspection::where(['managerapprove' => 1, 'area' => 2])->get(),
                'title' => 'Hold Request'
            ];
            return view('manager.request', compact('data'));
        }elseif($approval == 'accept'){
            // Menampilkan Accept SPD
            $data = [
                'request' => RequestInspection::where(['managerapprove' => 2, 'area' => 2])->get(),
                'title' => 'Accept Request'
            ];
            return view('manager.request', compact('data'));
        }elseif($approval == 'reject'){
            // Menampilkan Reject SPD
            $data = [
                'request' => RequestInspection::where(['managerapprove' => 0, 'area' => 2])->get(),
                'title' => 'Reject Request'
            ];
            return view('manager.request', compact('data'));
        }else{
            // Jika URL Tidak Sesuai
            abort(404);
        }
    }
    public function inspection($approval){
        if($approval == 'index'){
            // Menampilkan Semua
            $data = [
                'inspection' => Inspection::all(),
                'title' => 'Inspection From Leader'
            ];
            return view('manager.inspection', compact('data'));
        }elseif($approval == 'hold'){
            // Menampilkan Hold SPD
            $data = [
                'inspection' => Inspection::where('managerapprove', 1)->get(),
                'title' => 'Hold Inspection'
            ];
            return view('manager.inspection', compact('data'));
        }elseif($approval == 'accept'){
            // Menampilkan Accept SPD
            $data = [
                'inspection' => Inspection::where('managerapprove', 2)->get(),
                'title' => 'Accept inspection'
            ];
            return view('manager.inspection', compact('data'));
        }elseif($approval == 'reject'){
            // Menampilkan Reject SPD
            $data = [
                'inspection' => Inspection::where('managerapprove', 0)->get(),
                'title' => 'Reject inspection'
            ];
            return view('manager.inspection', compact('data'));
        }else{
            // Jika URL Tidak Sesuai
            abort(404);
        }
    }
    // READ DETAIL
    public function view($id){
        // View request from user 
        $request = RequestInspection::find($id);
        return view('manager.view', compact('request'));
    }
    public function view_ins($id){
        // view inspection from leader
        $inspection = Inspection::find($id);
        return view('manager.viewins', compact('inspection'));
    }
    // END READ


    public function approval($id){
        if(RequestInspection::where('id', $id)->update(['managerapprove' => request()->managerapprove])){
            // Mengirim Notifikasi
            $token = DeviceToken::all();
            $user_id = RequestInspection::find($id)->user_id;
            if(request()->managerapprove == 0){
                $message = 'SPD Request From '.Users::find($user_id)->fullname.' Rejected By Manager';
            }else{
                $message = 'SPD Request From '.Users::find($user_id)->fullname.' Approved By Manager';
            }
            foreach($token as $target){
                if($target->user->level == 2 || $target->user_id == $user_id){
                    $this->sendNotif('Approval Request', $message, $target->token);
                }
            }
            return redirect('/manager/view/'.$id)->with('success', 'Berhasil Menetapkan Approval');
        }
    }
    public function approval_ins($id){
        if(Inspection::where('id', $id)->update(['managerapprove' => request()->managerapprove])){
             // Mengirim Notifikasi
             $token = DeviceToken::all();
             $inspection = Inspection::find($id);
             $user_id = RequestInspection::find($inspection->requestinspection_id)->user_id;
             if(request()->managerapprove == 0){
                 $message = 'SPD Agenda For '.$inspection->inspector_name.' Rejected By Manager';
             }else{
                 $message = 'SPD Agenda For '.$inspection->inspector_name.' Approved By Manager';
             }
             foreach($token as $target){
                 if($target->user->level == 2 || $target->user_id == $inspection->inspector_id || $target->user_id == $user_id){
                     $this->sendNotif('Approval Inspection', $message, $target->token);
                 }
             }
            return redirect('/manager/view/ins/'.$id)->with('success', 'Berhasil Menetapkan Approval');
        }
    }
}
