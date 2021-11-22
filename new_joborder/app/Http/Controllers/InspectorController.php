<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Inspection;
use App\InspectionTopic;
use App\InspectionReport;
use App\RequestInspection;
use Auth;
use App\DeviceToken;
use App\Users;
use App\BeritaAcara;
use App\LastLogin;
use App\DocumentReport;
use Illuminate\Support\Facades\Storage;

class InspectorController extends Controller
{
    public function index(){
        $data = [
            'new' => count(Inspection::where(['status_inspection' => 1, 'managerapprove' => 2,'inspector_id' => Auth::user()->id])->get()),
            'progress' => count(Inspection::where(['status_inspection' => 2, 'managerapprove' => 2,'inspector_id' => Auth::user()->id])->get()),
            'complete' => count(Inspection::where(['status_inspection' => 3, 'managerapprove' => 2,'inspector_id' => Auth::user()->id])->get()),
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

        return view('inspector.index', compact('data'));
    }
    public function inspection($status){
        // Menampilkan List Inspection
        if($status == 'newrequest'){
            $title = 'New Request';
            $inspection = Inspection::where(['status_inspection' => 1, 'managerapprove' => 2,'inspector_id' => Auth::user()->id])->get();
            return view('inspector.inspection', compact('inspection', 'title'));
        }elseif($status == 'onprogress'){
            $title = 'On Progress';
            $inspection = Inspection::where(['status_inspection' => 2,'managerapprove' => 2, 'inspector_id' => Auth::user()->id])->get();
            return view('inspector.inspection', compact('inspection', 'title'));
        }elseif($status == 'completed'){
            $title = 'Completed';
            $inspection = Inspection::where(['status_inspection' => 3,'managerapprove' => 2, 'inspector_id' => Auth::user()->id])->get();
            return view('inspector.inspection', compact('inspection', 'title'));
        }else{
            abort(404);
        }
    }
    public function view($id){
        $inspection = Inspection::find($id);
        $inspection_topic = InspectionTopic::where('inspection_id', $id)->get();
        $inspection_report = InspectionReport::all();
        if(!empty(BeritaAcara::where('inspection_id', $id)->first())){
            $berita_acara = BeritaAcara::where('inspection_id', $id)->first();
            return view('inspector.view', compact('inspection', 'inspection_topic', 'inspection_report', 'berita_acara'));
        }else{
            return view('inspector.view', compact('inspection', 'inspection_topic', 'inspection_report'));
        }
    }
    public function add_topic($id){
        // Menambah kan topic

        // Cek Jika Kolom Kosong || Required
        if(empty(Request('equipmentchemical'))){
            return redirect('/inspector/view/'.$id)->with('error', 'Masukkan Value Terlebih Dahulu');
        }else{
            $inspection_topic = new InspectionTopic;
            $inspection_topic->inspection_id = $id;
            $inspection_topic->inspection_topic = Request('equipmentchemical');
            if($inspection_topic->save()){
                Inspection::where('id', $id)->update(['status_inspection' => 2]);
                return redirect('/inspector/view/'.$id)->with('success', 'Berhasil Menambahkan Topic Equipment/Chemical');
            }
        }
    }
    public function add_report(){

        // Untuk Redirect Ke Halaman Sesuai ID Inspection
        $navigate = InspectionTopic::where('id', Request('topic_id'))->first()->inspection_id;

        //Menginisialisasi File
        $extdoc = Request()->file('document')->getClientOriginalExtension();
        $extpic = Request()->file('pictureevidence')->getClientOriginalExtension();
        $docname = Str::random(5).'-'.time().'.'.$extdoc;
        $picname = Str::random(5).'-'.time().'.'.$extpic;

        // Cek Apakah Dokumen Ekstensi doc, docx, pdf
        if($extdoc == 'doc' || $extdoc == 'docx' || $extdoc == 'pdf'){
            // Cek Apakah Picture Ekstensi JPG, JPEG, PNG
            if($extpic == 'png' || $extpic == 'jpg' || $extpic == 'jpeg'){
                if(Request()->file('document')->getClientSize() / 2000){
                    if(Request()->file('pictureevidence')->getClientSize() / 2000){
                        request()->file('document')->move(public_path('/documents/'), $docname);
                        request()->file('pictureevidence')->move(public_path('/pictures/'), $picname);
                        $report = new InspectionReport;
                        $report->inspection_topic_id = Request('topic_id');
                        $report->equipmentchemical = Request('equipmentchemical');
                        $report->refference = Request('refference');
                        $report->result = Request('result');
                        $report->followup = Request('followup');
                        $report->sn = Request('sn');
                        $report->ok_note = Request('ok_note');
                        $report->comment = Request('comment');
                        $report->pic = Request('pic');
                        $report->type = Request('type');
                        if(Request('type') != 0){
                            $report->documenttype = Request('documenttype');
                            $dok = new DocumentReport;
                            $dok->type =  Request('type');
                            $dok->oas = Inspection::find($navigate)->oas;
                            $dok->name = Request('equipmentchemical');
                            $dok->document_type = Request('documenttype');
                            $dok->document_name = $docname;
                            $dok->save();
                        }
                        $report->document = $docname;
                        $report->documentname = Request()->file('document')->getClientOriginalName();
                        $report->equipmentchemical = Request('equipmentchemical');
                        $report->pictureevidence = $picname;
                        $report->save();

                        

                        return redirect('/inspector/view/'.$navigate)->with('success', 'Berhasil Menambahkan Report');
                    }else{
                        return redirect('/inspector/view/'.$navigate)->with('error', 'Size Gambar Harus dibawah 2MB');
                    }
                }else{
                    return redirect('/inspector/view/'.$navigate)->with('error', 'Size Document Harus dibawah 2MB');
                }
            }else{
                return redirect('/inspector/view/'.$navigate)->with('error', 'Ekstensi Gambar Harus JPG,JPEG,PNG');
            }
        }else{
            return redirect('/inspector/view/'.$navigate)->with('error', 'Ekstensi Dokumen Harus PDF,DOC,DOCX');
        }

        
    }
    // Finish Inspection
    public function finish($id){
        $ins_req_id = Inspection::find($id)->requestinspection_id;
        $req = RequestInspection::find($ins_req_id);

        // Cek Apakah Inspection Punya Inspection Topic Yang Dikerjakan, Jika Tidak Maka Tidak Dapat Mark Finish
        if(count(InspectionTopic::where('inspection_id', $id)->get()) > 0){
            // Update Status Inspection Menjadi Complete
            Inspection::where('id', $id)->update(['status_inspection' => 3, 'keterangan' => Request('keterangan')]);
            // Mengirim Notifikasi
            $token = DeviceToken::all();
            $message = Inspection::find($id)->inspector_name.' Menyelesaikan Tugas Inspeksi';
            foreach($token as $target){
                if($target->user->level == 2 || $target->user_id == $req->user_id){
                    $this->sendNotif('Inspection Finished', $message, $target->token);
                }
            }
            // Cek Apakah Semua Inspection Dari Request Inspection Bernilai Complete
            // Jika Iya Maka Update Request Inspection Menjadi Complete Juga
            $count_ins = count(Inspection::where('requestinspection_id', $ins_req_id)->get());
            $count_ins_complete = count(Inspection::where(['requestinspection_id' => $ins_req_id, 'status_inspection' => 3])->get());
            if($count_ins_complete == $count_ins){
                RequestInspection::where('id', $ins_req_id)->update(['status' => 3]);
                foreach($token as $target){
                    if($target->user->level == 2 || $target->user_id == $req->user_id){
                        $this->sendNotif('All Inspection Finished', 'Seluruh Inspection '.$req->requestnumber.' Telah Selesai', $target->token);
                    }
                }
            }
            return redirect('/inspector/view/'.$id)->with('success', 'Berhasil Finish Inspection');
        }else{
            return redirect('/inspector/view/'.$id)->with('error', 'Isi Progress Terlebih Dahulu');
        }
    }
    // Buat Berita Acara
    public function berita_acara(Request $request, $id){

        $request->validate([
            'judul' => 'required',
            'up_sercom' => 'required',
            'wakil_sercom' => 'required',
            'jabatan_sercom' => 'required',
            'rincian_pekerjaan' => 'required',
            'ringkasan_pekerjaan' => 'required',
            'lokasi_milik' => 'required',
        ]);

        $berita = new BeritaAcara;
        $berita->inspection_id = $id;
        $berita->judul = $request->judul;
        $berita->up_sercom = $request->up_sercom;
        $berita->wakil_sercom = $request->wakil_sercom;
        $berita->jabatan_sercom = $request->jabatan_sercom;
        $berita->rincianpekerjaan = $request->rincian_pekerjaan;
        $berita->ringkasanpekerjaan = $request->ringkasan_pekerjaan;
        $berita->lokasi_milik = $request->lokasi_milik;
        $berita->save();

        return redirect('inspector/view/' . $id);
    }
}
