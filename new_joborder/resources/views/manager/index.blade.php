@extends('layouts.app')

@section('title')
    Joborder | Sr Manager
@endsection

@section('content')
    <div class="row banner-text justify-content-center">
        <div class="col-md-8 m-t-20 text-center">
            <h1>Selamat Datang <span class="text-info">{{ Auth::user()->fullname }}</span> (Senior)</h1>
            <p class="subtext">Login Terakhir Anda Pada,
                @if(empty($lastlogin))
                    <span class="font-medium">(Anda Baru Pertama Kali Login)</span>
                @else
                    <span class="font-medium">{{ $lastlogin->timestamp }}</span>
                @endif
            </p>
            <div class="down-btn">
                <a href="{{ url('manager/inspection/index') }}" style="width: 300px" class="btn btn-primary m-b-10">Inspection(From Leader)
                    <span class="badge badge-warning">{{ $inspection['hold'] }}</span>
                    <span class="badge badge-success">{{ $inspection['accept'] }}</span>
                    <span class="badge badge-danger">{{ $inspection['reject'] }}</span>
                </a>
            </div>
        </div>
    </div>
@endsection