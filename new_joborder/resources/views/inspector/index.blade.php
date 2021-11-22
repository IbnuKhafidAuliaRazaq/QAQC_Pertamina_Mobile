@extends('layouts.app')

@section('title')
    Joborder | Verificator
@endsection

@section('content')
    <div class="row banner-text justify-content-center">
        <div class="col-md-8 m-t-20 text-center">
            <h1>Selamat Datang <span class="text-info">{{ Auth::user()->fullname }}</span> (Verificator)</h1>
            <p class="subtext">Login Terakhir Anda Pada, 
                @if(empty($data['lastlogin']))
                    <span class="font-medium">(Anda Baru Pertama Kali Login)</span>
                @else
                    <span class="font-medium">{{ $data['lastlogin']->timestamp }}</span>
                @endif
            </p>
            <div class="down-btn">
                <a href="{{ url('inspector/newrequest') }}" class="btn btn-danger m-b-10"><span class="badge badge-light">{{ $data['new'] }}</span> New Request</a> 
                <a href="{{ url('inspector/onprogress') }}" class="btn btn-warning m-b-10"><span class="badge badge-light">{{ $data['progress'] }}</span> On Progress</a> 
                <a href="{{ url('inspector/completed') }}" class="btn btn-xs btn-success m-b-10"><span class="badge badge-light">{{ $data['complete'] }}</span> Completed</a> 
            </div>
        </div>
    </div>
@endsection