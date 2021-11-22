@extends('layouts.app')

@section('title')
    Joborder | Settings
@endsection

@section('content')
    <div class="row banner-text justify-content-center">
        <div class="col-md-8 m-t-20 text-center">
            <h3>Profile Settings</h3>

            @if(Session::get('success'))
                <div class="alert alert-success">{{ Session::get('success') }}</div>
            @endif
            @if(Session::get('error'))
                <div class="alert alert-danger">{{ Session::get('error') }}</div>
            @endif
            
            <a href="{{ url('settings/ubah') }}" class="btn btn-sm btn-primary">
                <i class="fas fa-cog"></i> Ubah
            </a>
            <a href="{{ url('settings/upload') }}" class="btn btn-sm btn-success">
                <i class="fas fa-upload"></i> Upload Tanda Tangan
            </a>
            <br><br>
            <table class="table table-bordered">
                <tr>
                    <td>Username</td>
                    <td>{{ Auth::user()->username }}</td>
                </tr>
                <tr>
                    <td>Fullname</td>
                    <td>{{ Auth::user()->fullname }}</td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td>{{ Auth::user()->email }}</td>
                </tr>
                <tr>
                    <td>Position</td>
                    <td>{{ Auth::user()->position }}</td>
                </tr>
                <tr>
                    <td>Signature</td>
                    <td><img style="width: 200px;" src="{{ url('new_joborder/public/signature/'.Auth::user()->signature) }}" alt=""></td>
                </tr>
            </table>
        </div>
    </div>
@endsection