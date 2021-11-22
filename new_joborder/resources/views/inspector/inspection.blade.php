@extends('layouts.app')

@section('title')
    Joborder | Verificator
@endsection

@section('content')
    <div class="row banner-text justify-content-center">
        <div class="col-md-8 m-t-20">
            <h1><span class="text-primary mb-2">{{ $title }}</span></h1>
            @if(Session::get('success'))
                <div class="alert alert-success">{{ Session::get('success') }}</div>
            @endif
            <div class="btn-group mb-2">
                <a href="{{ url('inspector/newrequest') }}" class="btn btn-sm btn-primary">New Request</a>
                <a href="{{ url('inspector/onprogress') }}" class="btn btn-sm btn-warning">On Progress</a>
                <a href="{{ url('inspector/completed') }}" class="btn btn-sm btn-danger">Completed</a>
            </div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Req Number</th>
                        <th>Date Release</th>
                        <th>Area</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($inspection as $ins)
                        <tr>
                            <td><a href="{{ url('inspector/view/'.$ins->id) }}">{{ $ins->requestnumber->requestnumber }}</a></td>
                            <td>{{ $ins->releaseinspection }}</td>
                            <td>@if($ins->requestnumber->area == 1) <div class="badge badge-warning">SIJ</div> @elseif($ins->requestnumber->area == 2) <div class="badge badge-success">SPD</div> @endif</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <a href="{{ url('inspector') }}" class="btn btn-sm btn-danger mt-1"><i class="fas fa-arrow-left"></i> Back</a>
        </div>
    </div>
@endsection