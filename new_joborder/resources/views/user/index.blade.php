@extends('layouts.app')

@section('title')
    Joborder | User
@endsection

@section('content')
    <div class="row banner-text justify-content-center">
        <div class="col-md-8 m-t-20 text-center">
            <h1>Selamat Datang <span class="text-info">{{ Auth::user()->fullname }}</span> (User)</h1>
            <p class="subtext">Login Terakhir Anda Pada, 
                @if(empty($lastlogin))
                    <span class="font-medium">(Anda Baru Pertama Kali Login)</span>
                @else
                    <span class="font-medium">{{ $lastlogin->timestamp }}</span>
                @endif
            </p>
            <div class="down-btn">
                <a href="{{ url('user/add') }}" style="width: 250px" class="btn btn-primary m-b-10">Add Request Inspection</a> 
                <a href="{{ url('user/listinspection') }}" style="width: 250px" class="btn btn-primary m-b-10">List Inspection</a> 
            </div>
        </div>
    </div>
@endsection