@extends('layouts.app')

@section('title')
    Joborder | Leader
@endsection

@section('content')
    <div class="row banner-text justify-content-center">
        <div class="col-md-10 m-t-20 text-center">
        @if(Session::get('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
        @endif
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
                <tr>
                    <th>Status</th>
                    <td>
                        <?php if($request->status == 1){ $navigate = 'newrequest'; ?>
                            <div class="badge badge-danger">Waiting</div>
                        <?php  } ?>
                        <?php if($request->status == 2){ $navigate = 'onprogress'; ?>
                            <div class="badge badge-warning">On Progress</div>
                        <?php  } ?>
                        <?php if($request->status == 3){ $navigate = 'complete'; ?>
                            <div class="badge badge-success">Complete</div>
                        <?php  } ?>
                    </td>
                </tr>
                @if($request->status == 2)
                    @foreach($inspection as $inspect)
                    <tr>
                        <td colspan="2">
                            <div class="card card-bordered">
                                <div class="card-body text-left">
                                    <b>Nama Verificator = </b>{{ $inspect->inspector_name }}<br>
                                    <b>Tanggal Inspection = </b>{{ $inspect->dateinspection }}<br>
                                    <b>Release Inspection = </b>{{ $inspect->releaseinspection }}<br>
                                    <b>Manager Inspection Approve = </b> 
                                    <?php if($inspect->managerapprove == 1){ ?>
                                        <div class="badge badge-warning">Hold</div>
                                    <?php  } ?>
                                    <?php if($inspect->managerapprove == 2){ ?>
                                        <div class="badge badge-success">Accept</div>
                                    <?php  } ?>
                                    <?php if($inspect->managerapprove == 0){ ?>
                                        <div class="badge badge-danger">Reject</div>
                                    <?php  } ?><br>
                                    <b>Dokumen = @if($request->area == 1) <a class="print" onclick="fire_load()" href="{{ url('print_surat/'.$inspect->id) }}">Surat Ijin Jalan.pdf</a> @else($request->area == 2) <a class="print" onclick="fire_load()" href="{{ url('print_surat/'.$inspect->id) }}">Surat Perjalanan Dinas.pdf</a>@endif</b>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                @endif
            </table>
            @if($request->status == 3)
                <div id="accordion">
                    @foreach($inspection as $ins)
                    <div class="card">
                        <div class="card-header" id="headingOne">
                        <h5 class="mb-0">
                            <button class="btn btn-link" data-toggle="collapse" data-target="#{{ $ins->inspector_id }}" aria-expanded="true" aria-controls="{{ $ins->inspector_id }}">
                                {{ $ins->inspector_name }} 
                            </button>
                            <!-- Cek Apakah Berita Acara Sudah Dibuat Oleh Inspector -->
                            @foreach($berita_acara as $berita)
                                @if($berita->inspection_id == $ins->id)
                                    <a onclick="fire_load()" href="{{ url('print_berita/'.$berita->id) }}" class="btn print btn-success btn-xs"><i class="fas fa-download"></i> Berita Acara</a>
                                @endif
                            @endforeach
                            <a onclick="fire_load()" href="{{ url('print_endreport/'.$ins->id) }}" class="btn print btn-warning btn-xs"><i class="fas fa-download"></i> End Report</a>
                            <a onclick="fire_load()" href="{{ url('print_surat/'.$ins->id) }}" class="print btn btn-primary btn-xs"><i class="fas fa-download"></i> Surat Jalan (SIJ/SPD)</a>
                        </h5>
                        </div>

                        <div id="{{ $ins->inspector_id }}" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                        <div class="card-body">
                            @foreach($inspection_topic as $topic)
                                @if($topic->inspection_id == $ins->id)
                                    @foreach($inspection_report as $report)
                                        @if($report->inspection_topic_id == $topic->id)
                                        <div class="card">
                                            <div class="card-body text-left">
                                                <div class="row">
                                                    <div class="col-sm-8">
                                                        Inspection Topic : {{ $topic->inspection_topic }} <br>
                                                        Work : {{ $report->equipmentchemical }} <br>
                                                        Refference : {{ $report->refference }} <br>
                                                        Result : {{ $report->result }} <br>
                                                        Document : <a class="print" onclick="fire_load()" href="{{ url('new_joborder/public/documents/'.$report->document) }}">{{ $report->documentname  }}</a><br>
                                                    </div>
                                                    <div class="col-md-4"><img style="width:100px" src="{{ url('new_joborder/public/pictures/'.$report->pictureevidence) }}" alt=""></div>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                    @endforeach
                                @endif
                            @endforeach
                        </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif
            <a href="{{ url('/leader/'.$navigate) }}" class="btn btn-danger mb-3">Kembali</a>
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