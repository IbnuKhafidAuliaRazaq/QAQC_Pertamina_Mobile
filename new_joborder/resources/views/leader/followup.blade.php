@extends('layouts.app')

@section('title')
    Joborder | Manager
@endsection

@section('content')
    <div class="row banner-text justify-content-center">
        <div class="col-md-10 m-t-20 text-center">
        @if(Session::get('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
        @endif
        <a href="{{ url('print_request/'.$request->id) }}" onclick="fire_load()" class="btn print btn-block btn-danger mb-2"><i class="fas fa-print"></i> Print</a>
        <table class="table table-striped">
                <tr>
                    <th>Request Number</th>
                    <td><?= $request->requestnumber ?></td>
                </tr>
                <tr>
                    <th>Order Date</th>
                    <td><?= date('d-m-Y', strtotime($request->orderdate))  ?></td>
                </tr>
                <tr>
                    <th>Service Company</th>
                    <td><?= $request->sercom ?></td>
                </tr>
                <tr>
                    <th>Wellname</th>
                    <td><?= $request->wellname ?></td>
                </tr>
                <tr>
                    <th>Inspection For</th>
                    <td><?= $request->inspection ?></td>
                </tr>
                <tr>
                    <th>Purpose</th>
                    <td><?= $request->purpose ?></td>
                </tr>
                <tr>
                    <th>Area</th>
                    <td>@if($request->area == 1) <div class="badge badge-primary">SIJ</div> @else($request->area == 2) <div class="badge badge-success">SPD</div> @endif</td>
                </tr>
                <tr>
                    <th>Approval</th>
                    <td>
                        <?php if($request->managerapprove == 1){ ?>
                            <div class="badge badge-warning">Hold</div>
                        <?php  } ?>
                        <?php if($request->managerapprove == 2){ ?>
                            <div class="badge badge-success">Accept</div>
                        <?php  } ?>
                        <?php if($request->managerapprove == 0){ ?>
                            <div class="badge badge-danger">Reject</div>
                        <?php  } ?>
                    </td>
                </tr>
            </table>
            @if($request->managerapprove == 2)
            <div class="card card-bordered">
                <div class="card-header font-weight-bold">Follow Up</div>
                <div class="card-body">
                <form action="{{ route('followup', $request->id) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label class="float-left" for="">Pilih Inspector</label>
                        <select class="form-control" name="inspector_id" id="">
                            <?php foreach($inspector as $inspector): ?>
                                <option value="<?= $inspector->id ?>"><?= $inspector->fullname ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="float-left" for="">Date Inspection</label>
                        <input required type="date" value="<?= date('Y-m-d') ?>" class="form-control" name="date_inspection">
                    </div>
                    <div class="form-group">
                        <label class="float-left" for="">Date Release</label>
                        <input required type="date" class="form-control" name="date_release">
                        <input type="hidden" value="<?= $request->user_id ?>" class="form-control" name="user_id">
                    </div>
                    <div class="form-group">
                        <label class="float-left" for="">Job Inspection/Job Order From</label>
                        <input required type="text" class="form-control" name="job_inspect">
                    </div>
                    <div class="form-group">
                        <label class="float-left" for="">Dari</label>
                        <input required type="text" class="form-control" name="dari">
                    </div>
                    <div class="form-group">
                        <label class="float-left" for="">Tujuan</label>
                        <input required type="text" class="form-control" name="tujuan">
                    </div>
                    <div class="form-group">
                        <label class="float-left" for="">Keperluan</label>
                        <input required type="text" class="form-control" name="keperluan">
                    </div>
                    <div class="form-group">
                        <label class="float-left" for="">Berkendaraan</label>
                        <input required type="text" class="form-control" name="vehicle">
                        <input type="hidden" class="form-control" value="{{ $request->area }}" name="area">
                    </div>
                    @if($request->area == 2)
                    <div class="form-group">
                        <label class="float-left" for="">Biaya Ditanggung Oleh</label>
                        <input required type="text" class="form-control" name="biaya_dari">
                    </div>
                    
                    @endif
                    <div class="form-group">
                        <label class="float-left" for="">Atas Dasar/No. Oas/Kontrak</label>
                        <select name="atas_dasar" class="form-control" id="">
                            @foreach($oas as $oas)
                            <option value="{{ $oas->oas_code }}">{{ $oas->oas_code }} || {{ $oas->oas_title }} || {{ $oas->oas_description }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="float-left" for="">Response</label>
                        <Textarea rows="10" name="response_email" class="form-control">Dengan Hormat,
Bersama ini kami sampaikan terkait permintaan tersebut kami agendakan pada tanggal diatas dengan inspector yang telah kami cantumkan,
untuk dokumen pendukungnya kan kami koordinasikan langsung oleh personil kepada service company yang bersangkuan,
Demikian yang dapat kami sampaikan atas kerjasamanya kami ucapkan terimakasih.

salam,
Team Leader.</Textarea>
                    </div>
                    
                    
                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="multiple-inspection" name="multiple" id="multiple">
                            <label class="form-check-label float-left" for="multiple">
                                Tambah Inspection Selanjutnya
                            </label>
                        </div>
                    </div>
                </div>
            <div class="card-footer">
                <button class="btn btn-primary btn-sm">Save</button>
            </div>
            </form>
            </div>
            @endif
            <a href="{{ url('/leader/newrequest') }}" class="btn btn-danger mb-3">Kembali</a>
        </div>
    </div>

@endsection

@section('js')
    <script>
        function modalApprove(){
            $('#modalApprove').modal('show')
        }
    </script>
@endsection