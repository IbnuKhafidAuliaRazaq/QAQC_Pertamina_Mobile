<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Sij_spd;
use App\BeritaAcara;
use App\Users;
use App\Inspection;
use App\RequestInspection;
use App\InspectionTopic;
use PDF;
use App\Sercom;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function sendNotif($title, $body, $to){
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://exp.host/--/api/v2/push/send',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => array(
            'title' => $title,
            'body' => $body,
            'to' => $to),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;
    }
    public function print_surat($id){
        $surat = Sij_spd::where('inspection_id', $id)->first();
        $inspector = Users::find($surat->inspection->inspector_id);
        $ttd_manager = Users::find(56);
        $logo_sercom = Sercom::find($surat->inspection->requestnumber->sercom_id)->sercom_logo;
        if(empty($logo_sercom)){
            $logo_sercom = 'no-image.png';
        }
        if($surat->area == 1){
            $pdf = PDF::loadView('dokumen.sij',  compact('surat','inspector', 'ttd_manager', 'logo_sercom'));
            return $pdf->download('SIJ-'.$inspector->fullname.'.pdf');
            return redirect()->back();
        }else if($surat->area == 2){
            $pdf = PDF::loadView('dokumen.spd',  compact('surat','inspector', 'ttd_manager' , 'logo_sercom'));
            return $pdf->download('SPD-'.$inspector->fullname.'.pdf');
            return redirect()->back();
        }
    }
    public function print_berita($id){
        $berita = BeritaAcara::find($id);
        $inspection = Inspection::find($berita->inspection_id);
        $inspector = Users::find($inspection->inspector_id);
        $data = [
            'berita' => BeritaAcara::find($id),
            'inspection' => Inspection::find($berita->inspection_id),
            'inspector' => Users::find($inspection->inspector_id),
        ];
        $pdf = PDF::loadView('dokumen.berita_acara', compact('data'));
        
        return $pdf->download('Berita_Acara-'.$inspector->fullname.'-'.$inspection->requestnumber->requestnumber.'.pdf');
    }
    public function print_report($id){
        $inspection = Inspection::find($id);
        $inspection_topic = InspectionTopic::where('inspection_id', $id)->get();
        $inspector = Users::find($inspection->inspector_id);
        $ttd_leader = Users::find(30)->signature;
        $pdf = PDF::loadView('dokumen.end_report',compact('inspection', 'inspection_topic', 'inspector', 'ttd_leader'))->setPaper('a4', 'landscape');
        return $pdf->download('End-Report-'.$inspection->inspector_name.'-'.$inspection->requestnumber->requestnumber.'.pdf');
        // return view('dokumen.end_report',compact('inspection', 'inspection_topic'));
        
    }
    public function print_request($id){
        $request = RequestInspection::find($id);
        $pdf = PDF::loadView('dokumen.request',compact('request'))->setPaper('a4', 'portrait');
        return $pdf->download('Request-'.$request->requestnumber.'.pdf');
        // return view('dokumen.request',compact('request'));
        
    }

    public function print_surat_v2()
    {
        return 1;
    }
}
