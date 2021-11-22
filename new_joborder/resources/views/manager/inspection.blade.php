@extends('layouts.app')

@section('title')
    Joborder | Manager
@endsection

@section('content')
    <div class="row banner-text justify-content-center">
        <div class="col-md-8 m-t-20">
            <h1><span class="text-primary mb-2">{{ $data['title'] }}</span></h1>
            <div class="btn-group mb-2">
                <a href="{{ url('manager/inspection/index') }}" class="btn btn-sm btn-primary">All</a>
                <a href="{{ url('manager/inspection/hold') }}" class="btn btn-sm btn-warning">Hold</a>
                <a href="{{ url('manager/inspection/accept') }}" class="btn btn-sm btn-success">Accept</a>
                <a href="{{ url('manager/inspection/reject') }}" class="btn btn-sm btn-danger">Reject</a>
            </div>
            @if(Session::get('success'))
                <div class="alert alert-success">{{ Session::get('success') }}</div>
            @endif
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Req Number</th>
                        <th>Verificator</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($data['inspection'] as $ins)
                    <tr>
                        <td><a href="{{ url('/manager/view/ins/'.$ins->id) }}">{{ $ins->requestnumber->requestnumber }}</a></td>
                        <td>{{ $ins->inspector_name }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <a href="{{ url('manager') }}" class="btn btn-sm btn-danger mt-1"><i class="fas fa-arrow-left"></i> Back</a>
        </div>
    </div>
@endsection