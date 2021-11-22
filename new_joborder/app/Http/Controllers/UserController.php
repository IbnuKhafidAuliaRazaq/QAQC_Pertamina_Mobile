<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RequestInspection;
use App\Regional;
use App\Zona;
use App\DeviceToken;
use App\Users;
use Auth;
use App\Inspection;
use App\InspectionTopic;
use App\InspectionReport;
use App\BeritaAcara;
use App\LastLogin;
use App\Sercom;

class UserController extends Controller
{
    public function index(){
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
        return view('user.index', compact('lastlogin'));
    }
    public function add(){
        // Menampilkan Halaman Add Request
        $latest = Requestinspection::orderBy('id', 'DESC')->first();
        $regional = Regional::all();
        $zona = Zona::all();
        $sercom = Sercom::all();
        return view('user.add' , compact('regional', 'zona', 'sercom', 'latest'));
    }
    public function listinspection(){
        $requestinspections = RequestInspection::where('user_id', Auth::user()->id)->get();
        return view('user.listinspection', compact('requestinspections'));
    }
    public function create(){
        $validatedData = request()->validate([
            'req_number' => 'required',
            'wellname' => 'required',
            'orderdate' => 'required'
        ]);


        if(request('regional_id') == 0 || request('zona_id') == 0 || request('area') == 0 || request('sercom_id') == 0 || empty(request('sercom')) || empty(request('value1')) || empty(request('value2')) ){
            echo 'Anda Belum Memilih Regional/Zona/Area/Equipment/Chemical';
            return redirect('/user/add')->with('error', 'Anda Belum Memilih Regional/Zona/Area/Equipment/Chemical');
        }else{
            
            // Mengisi Custom Field
                
            $reg = Regional::find(request('regional_id'))->regional_alias;
            $zone = Zona::find(request('zona_id'))->zona_alias;

            // Cek Apakah Request Inspection Ada yang sama di tabel
            if(count(Requestinspection::where('requestnumber', request('req_number').'-'.$reg.'-'.$zone)->get()) <= 0){

                $requestinspection = new RequestInspection;

    
                $inspection = '';
                foreach(request('value1') as $val){ 
                    $inspection .= $val.','; 
                }
                $purpose = '';
                foreach(request('value2') as $val){ 
                    $purpose .= $val.','; 
                }
    
                // Deklarasi Untuk Model
    
                // mengisi approve manager ketika area = sij 
                $requestinspection->user_id = request('user_id');
                $requestinspection->regional_id = request('regional_id');
                $requestinspection->zona_id = request('zona_id');
                $requestinspection->requestnumber = request('req_number').'-'.$reg.'-'.$zone;
                $requestinspection->wellname = request('wellname');
                $requestinspection->sercom_id = request('sercom_id');
                $requestinspection->sercom = request('sercom');
                $requestinspection->orderdate = request('orderdate');
                $requestinspection->inspection = $inspection;
                $requestinspection->purpose = $purpose;
                $requestinspection->managerapprove = 2;
                $requestinspection->area = request('area');
                if($requestinspection->save()){
                    // Mengirim Notifikasi
                    $token = DeviceToken::all();
                    $message = 'Request Inspection By '.Users::find(request('user_id'))->fullname;
                    foreach($token as $target){
                        if($target->user->level == 2){
                            $this->sendNotif('New Request Inspection', $message, $target->token);
                        }
                    }
                    // Redirect
                    return redirect('/user/listinspection')->with('success', 'Berhasil Membuat Request!');
                }
            }else{
                return redirect('/user/add')->with('error', 'Request Number Yang Anda Masukkan Sudah Ada');
            }
        }
    }
    public function view($id){
        // $request = Requestinspection::find($id);
        // return view('user.view',compact('request'));

        $request = RequestInspection::find($id);
        if($request->status == 2){
            $inspection = Inspection::where('RequestInspection_id', $id)->get();
            return view('user.view', compact('request', 'inspection'));
        }else if($request->status == 3){
            $inspection = Inspection::where('RequestInspection_id', $id)->get();
            $inspection_report = InspectionReport::all();
            $inspection_topic = InspectionTopic::all();
            $berita_acara = BeritaAcara::all();
            return view('user.view', compact('request','inspection','inspection_report','inspection_topic','berita_acara'));
        }else{
            return view('user.view', compact('request'));
        }
    }
    public function delete($id){
        if(Requestinspection::find($id)->delete()){
            return redirect('/user/listinspection')->with('success', 'Berhasil Menghapus Request!');
        } 
    }
}
