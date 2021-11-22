@extends('layouts.app')

@section('title')
    Joborder | User
@endsection

@section('content')
    <div class="row banner-text justify-content-center">
        <div class="col-md-8 m-t-20">
            <h1 class="text-center"><span class="text-primary">List Inspection</span></h1>
            @if(Session::get('success'))
                <div class="alert alert-success">{{ Session::get('success') }}</div>
            @endif
            <table id="datatables" class="table table-bordered">
                <thead>
                    <tr>
                        <th>Req Number</th>
                        <th>Approval</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($requestinspections as $req)
                        <tr>
                            <td><a href="{{ url('/user/view/'.$req->id) }}">{{ $req->requestnumber }}</a></td>
                            <td>@if($req->managerapprove == 1) <div class="badge badge-warning">Hold</div> @elseif($req->managerapprove == 2) <div class="badge badge-success">Approve</div> @else <div class="badge badge-danger">Reject</div> @endif</td>
                            <td>@if($req->status == 1) <div class="badge badge-danger">Waiting</div> @elseif($req->status == 2) <div class="badge badge-warning">On Progress</div> @else <div class="badge badge-success">Complete</div> @endif</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <a href="{{ url('user') }}" class="btn btn-sm btn-danger mt-2"><i class="fas fa-arrow-left"></i> Back</a>
        </div>
    </div>
@endsection