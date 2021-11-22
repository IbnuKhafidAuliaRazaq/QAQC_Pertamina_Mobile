<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RequestInspection;
use App\Users;
use App\Inspection;
use App\InspectionReport;
use App\InspectionTopic;
use App\DeviceToken;
use Auth;
use App\Sij_spd;
use App\BeritaAcara;
use App\LastLogin;
use PDF;
use App\OAS;

class LeaderController extends Controller
{
    public function index(){
        $data = [
            'new' => count(RequestInspection::where('status', 1)->get()),
            'progress' => count(RequestInspection::where('status', 2)->get()),
            'complete' => count(RequestInspection::where('status', 3)->get()),
            'lastlogin' => LastLogin::where('user_id',Auth::user()->id)->first()
        ];
        // Insert/Update Last Login
        if(count(LastLogin::where('user_id', Auth::user()->id)->get()) == 0){
            $lastlogin = new LastLogin;
            $lastlogin->user_id = Auth::user()->id;
            $lastlogin->timestamp = date("d-m-Y H:i:s");
            $lastlogin->save();
        }else{
            LastLogin::where('user_id', Auth::user()->id)->update(['timestamp' => date("d-m-Y H:i:s")]);
        }
        return view('leader.index', compact('data'));
    }
    public function request($status){
        if($status == 'newrequest'){
            $title = 'New Request';
            $request = RequestInspection::where('status', 1)->get();
            return view('leader.request', compact('request', 'title'));
        }elseif($status == 'onprogress'){
            $title = 'On Progress';
            $request = RequestInspection::where('status', 2)->get();
            return view('leader.request', compact('request', 'title'));
        }elseif($status == 'complete'){
            $title = 'Complete';
            $request = RequestInspection::where('status', 3)->get();
            return view('leader.request', compact('request', 'title'));
        }else{
            abort(404);
        }
    }
    public function followup($id){
        // View Followup
        $request = RequestInspection::find($id);
        $inspector = Users::where('level' , 3)->get();
        $oas = OAS::all();
        return view('leader.followup', compact('request', 'inspector', 'oas'));
    }
    public function view($id){
        // View On Progress and Complete
        $request = RequestInspection::find($id);
        if($request->status == 2){
            $inspection = Inspection::where('RequestInspection_id', $id)->get();
            return view('leader.view', compact('request', 'inspection'));
        }else if($request->status == 3){
            $inspection = Inspection::where('RequestInspection_id', $id)->get();
            $inspection_report = InspectionReport::all();
            $inspection_topic = InspectionTopic::all();
            $berita_acara = BeritaAcara::all();
            return view('leader.view', compact('request','inspection','inspection_report','inspection_topic', 'berita_acara'));
        }else{
            return view('leader.view', compact('request'));
        }
    }
    public function createinspection($id){
        $inspector_id = request('inspector_id');
        $inspectorname = Users::find($inspector_id)->fullname;
        $inspection = new Inspection;
        $area = RequestInspection::find($id)->area;
        
        $inspection->RequestInspection_id = $id;
        $inspection->dateinspection = request('date_inspection');
        $inspection->releaseinspection = request('date_release');
        $inspection->response_email = request('response_email');
        $inspection->inspector_name = $inspectorname;
        $inspection->user_id = request('user_id');
        $inspection->inspector_id = $inspector_id;
        $inspection->job_inspect = request('job_inspect');
        $inspection->lokasi = request('tujuan');
        $inspection->oas = request('atas_dasar');
        if($area == 1){
            $inspection->managerapprove = 2;
        }

        if($inspection->save()){
            // Insert SIJ/SPD 
            $sij_spd = new Sij_spd;
            $sij_spd->inspection_id = $inspection->id;
            $sij_spd->dari = request('dari');
            $sij_spd->tujuan = request('tujuan');
            $sij_spd->keperluan = request('keperluan');
            $sij_spd->vehicle = request('vehicle');
            if($area == 2){
                $sij_spd->biaya_dari = request('biaya_dari');
                $sij_spd->atas_dasar = request('atas_dasar');
            }
            $sij_spd->area = $area;
            $sij_spd->save();
            // Mengirim Notifikasi
            $token = DeviceToken::all();
            if($area == 1){
                $message = 'SIJ Approve, '.$inspectorname.', Ditugaskan';
                $user_id = RequestInspection::find($id)->user_id;
                foreach($token as $target){
                    if($target->user_id = $user_id || $target->user_id = $inspector_id){
                        $this->sendNotif('Inspection', $message, $target->token);
                    }
                }
            }else{
                $message = 'SPD Approve By Leader, '.$inspectorname.' Ditugaskan, Waiting Approval Manager!';
                $user_id = RequestInspection::find($id)->user_id;
                foreach($token as $target){
                    if($target->user->level = 4 ||$target->user_id = $user_id || $target->user_id = $inspector_id){
                        $this->sendNotif('Inspection', $message, $target->token);
                    }
                }
            }
            
            
            if(request('multiple') != "multiple-inspection"){
                if(RequestInspection::where('id', $id)->update(['status' => '2'])){
                    return redirect('/leader/onprogress')->with('success', 'Berhasil FollowUp Inspection!');
                }
            }else{
                return redirect()->back()->with('success', 'Berhasil FollowUp Inspection!');
            }
            
        }
    }
    public function agenda(){
		$agenda = Inspection::whereIn('status_inspection',[1,2])->get();
		return view('leader.agenda', compact('agenda'));
    }
    
}
