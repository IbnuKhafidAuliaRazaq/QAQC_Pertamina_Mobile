@extends('layouts.app')

@section('title')
    Joborder | Settings
@endsection

@section('content')
    <div class="row banner-text justify-content-center">
    
        <div class="col-md-8 m-t-20">
        
        @if(Session::get('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
        @endif
        @if(Session::get('error'))
            <div class="alert alert-danger">{{ Session::get('error') }}</div>
        @endif
            <div class="row">

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">Ubah Profile</div>
                        <div class="card-body">
                            <form action="{{ url('settings/ubah') }}" method="POST">
                                @csrf
                                <label for="">Username</label>
                                <input type="text" required class="form-control" disabled id="username" name="username" value="{{ Auth::user()->username }}">
                                <label for="">Fullname</label>
                                <input type="text" required class="form-control" disabled id="fullname" name="fullname" value="{{ Auth::user()->fullname }}">
                                <label for="">Email</label>
                                <input type="text" required class="form-control" disabled id="email" name="email" value="{{ Auth::user()->email }}">
                                <label for="">Position</label>
                                <input type="text" required class="form-control" disabled id="position" name="position" value="{{ Auth::user()->position }}">
                                @if(Auth::user()->level == 3 )
                                    <label for="kode">Kode</label>
                                    <input type="text" required class="form-control" disabled name="kode" value="{{ Auth::user()->kode }}" id="kode">
                                @endif
                                <div id="btnUbah" class="btn btn-sm btn-block btn-danger mt-2" onclick="btnUbah()">Ubah</div>
                                <button id="btnSimpan" type="submit" hidden class="btn btn-sm btn-primary mt-2 btn-block">Simpan</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">Ubah Password</div>
                        <div class="card-body">
                            <form action="{{ url('settings/ubahpassword') }}" method="POST">
                                @csrf
                                <label for="">Password Lama</label>
                                <input required type="password" class="form-control" name="old_password">
                                <label  for="">Password Baru</label>
                                <input required type="password" class="form-control" name="new_password">
                                <label for="">Konfirmasi Password Baru</label>
                                <input required type="password" class="form-control" name="confirm_password">
                                

                                <button type="submit" class="btn btn-sm btn-primary mt-2 btn-block">Simpan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script>
    function btnUbah(){
        $('#username').attr('disabled', false);
        $('#fullname').attr('disabled', false);
        $('#email').attr('disabled', false);
        $('#position').attr('disabled', false);
        $('#btnUbah').attr('hidden', true);
        $('#btnSimpan').attr('hidden', false);
        $('#kode').attr('disabled', false);
    }
</script>
@endsection