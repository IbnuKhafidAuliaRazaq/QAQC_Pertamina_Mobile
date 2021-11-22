<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Users;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SettingController extends Controller
{
    public function index(){
        return view('auth.setting');
    }
    
    public function ubah(){
        return view('auth.ubah');
    }
    public function updateprofile(){
        // Ubah Profile
        $user = Users::find(Auth::user()->id);
        $user->username = request('username');
        $user->fullname = request('fullname');
        $user->email = request('email');
        $user->position = request('position');
        if($user->level == 3){
            $user->kode = request('kode');
        }
        $user->save();
        return redirect('/settings/ubah')->with('success', 'Berhasil Mengubah Profile!');
    }
    public function updatepassword(){
        // Cek Apakah Password Lama Benar
        if(password_verify(request('old_password'), Auth::user()->password)){
            // Cek Apakah Password Baru Terkonfirmasi
            if(request('new_password') == request('confirm_password')){
                // Ubah Password
                $new_pass = password_hash(request('confirm_password'), PASSWORD_BCRYPT);
                $user = Users::find(Auth::user()->id);
                $user->password = $new_pass;
                $user->save();
                return redirect('/settings/ubah')->with('success', 'Password Berhasil Diubah!');
            }else{
                return redirect('/settings/ubah')->with('error', 'Password Tidak Sama!');
            }
        }else{
            return redirect('/settings/ubah')->with('error', 'Password Salah!');
        }
    }

    public function upload(){
        // Cek Apakah File Berekstensi PNG
        if(Request()->file('signature')->getClientOriginalExtension() == 'png'){
            // Beri Nama
            $signature = Str::random(5).'-'.Auth::user()->username.'-signature.'.Request()->file('signature')->getClientOriginalExtension();
            // Update Database
            $user = Users::find(Auth::user()->id);
            $user->signature = $signature;
            $user->save();
            // Pindah File Ke Server
            request()->file('signature')->move(public_path('/signature/'), $signature);
            return redirect('/settings')->with('success', 'Berhasil Mmeperbarui Tanda Tangan!');
        }else{
            return redirect('/settings/upload')->with('error', 'File Harus PNG!');
        }
    }
}
