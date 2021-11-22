@extends('layouts.app')

@section('title')
    Joborder | Leader
@endsection

@section('content')
    <div class="row banner-text justify-content-center">
        <div class="col-md-8 m-t-20">
            <h1><span class="text-primary mb-2">{{ $title }}</span></h1>
            @if(Session::get('success'))
                <div class="alert alert-success">{{ Session::get('success') }}</div>
            @endif
            <div class="btn-group mb-2">
                <a href="{{ url('leader/newrequest') }}" class="btn btn-sm btn-primary">New Request</a>
                <a href="{{ url('leader/onprogress') }}" class="btn btn-sm btn-warning">On Progress</a>
                <a href="{{ url('leader/complete') }}" class="btn btn-sm btn-danger">Completed</a>
                <a href="{{ url('leader/agenda') }}" class="btn btn-sm btn-secondary"><i class="fas fa-calendar-week"></i></a>
            </div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Req Number</th>
                        <th>Person Request</th>
                        <th>Approval</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($request as $req)
                        <tr>
                            <td>@if($req->status == 1)<a href="{{ url('/leader/followup/'.$req->id) }}">{{ $req->requestnumber }}</a> @else <a href="{{ url('/leader/view/'.$req->id) }}">{{ $req->requestnumber }}</a> @endif</td>
                            <td>{{ $req->user->fullname }}</td>
                            <td>@if($req->managerapprove == 2) <div class="badge badge-success">Accept</div> @elseif($req->managerapprove == 1) <div class="badge badge-warning">Hold</div> @elseif($req->managerapprove == 0) <div class="badge badge-danger">Reject</div> @endif</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <a href="{{ url('leader') }}" class="btn btn-sm btn-danger mt-1"><i class="fas fa-arrow-left"></i> Back</a>
        </div>
    </div>
@endsection