@extends('layouts.app')

@section('title')
    Joborder | Leader
@endsection

@section('content')
    <div class="row banner-text justify-content-center">
        <div class="col-md-8 m-t-20 text-center">
            <h1>Selamat Datang <span class="text-info">{{ Auth::user()->fullname }}</span> (Team leader)</h1>
            <p class="subtext">Login Terakhir Anda Pada, 
                @if(empty($data['lastlogin']))
                    <span class="font-medium">(Anda Baru Pertama Kali Login)</span>
                @else
                    <span class="font-medium">{{ $data['lastlogin']->timestamp }}</span>
                @endif
            </p>
            <div class="down-btn">
                <a href="{{ url('leader/newrequest') }}" class="btn btn-danger m-b-10"><span class="badge badge-light">{{ $data['new'] }}</span> New Request</a> 
                <a href="{{ url('leader/onprogress') }}" class="btn btn-warning m-b-10"><span class="badge badge-light">{{ $data['progress'] }}</span> On Progress</a> 
                <a href="{{ url('leader/complete') }}" class="btn btn-xs btn-success m-b-10"><span class="badge badge-light">{{ $data['complete'] }}</span> Completed</a> 
            </div>
        </div>
    </div>
@endsection