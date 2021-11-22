@extends('layouts.app')

@section('title')
    Joborder | Verificator
@endsection

@section('content')
    <div class="row banner-text justify-content-center">
        <div class="col-md-10 m-t-20 text-center">
        @if(Session::get('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
        @endif
        @if(Session::get('error'))
            <div class="alert alert-danger">{{ Session::get('error') }}</div>
        @endif
        
        <a href="{{ url('/inspector/newrequest') }}" class="btn float-left btn-danger btn-sm mb-3"><--</a>
        <table class="table table-striped">
                <tr>
                    <th>Request Number</th>
                    <td><?= $inspection->requestnumber->requestnumber ?></td>
                </tr>
                <tr>
                    <th>Date Release</th>
                    <td><?= $inspection->releaseinspection ?></td>
                </tr>
                <tr>
                    <th>Area</th>
                    <td>@if($inspection->requestnumber->area == 1) <div class="badge badge-primary">SIJ</div> @elseif($inspection->requestnumber->area == 2) <div class="badge badge-success">SPD</div> @endif</td>
                </tr>
                <tr>
                    <th>Dokumen</th>
                    <td>@if($inspection->requestnumber->area == 1) <a class="print" onclick="fire_load()" href="{{ url('print_ onclick="fire_load()"surat/'.$inspection->id) }}">Surat Ijin Jalan.pdf</a> @else($inspection->requestnumber->area == 2) <a class="print" onclick="fire_load()" href="{{ url('print_ onclick="fire_load()"surat/'.$inspection->id) }}">Surat Perjalanan Dinas.pdf</a>@endif</td>
                </tr>
                <tr>
                    <th>Approval</th>
                    <td>
                        <?php if($inspection->managerapprove == 1){ ?>
                            <div class="badge badge-warning">Hold</div>
                        <?php  } ?>
                        <?php if($inspection->managerapprove == 2){ ?>
                            <div class="badge badge-success">Accept</div>
                        <?php  } ?>
                        <?php if($inspection->managerapprove == 0){ ?>
                            <div class="badge badge-danger">Reject</div>
                        <?php  } ?>
                    </td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>
                        <?php if($inspection->status_inspection == 1){ ?>
                            <div class="badge badge-danger">Need Action</div>
                        <?php  } ?>
                        <?php if($inspection->status_inspection == 2){ ?>
                            <div class="badge badge-warning">On Progress</div>
                        <?php  } ?>
                        <?php if($inspection->status_inspection == 3){ ?>
                            <div class="badge badge-success">Complete</div>
                        <?php  } ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <textarea class="form-control" readonly cols="30" rows="10">{{ $inspection->response_email }}</textarea>
                    </td>
                </tr>
               
            </table>
            <div class="">
                @if($inspection->status_inspection == 1 || $inspection->status_inspection == 2)
                    <button onclick="addEqCh()" class="btn btn-primary btn-sm m-2 justify-center">Add Equipment/Chemical</button>
                    <button onclick="markFinish()" class="btn btn-success btn-sm m-2 justify-center">Mark As Finished</button>
                @elseif($inspection->status_inspection == 3)
                    <!-- Berita Acara -->
                    @if(!empty($berita_acara))
                        <a href="{{ url('print_berita/'.$berita_acara->id) }}"  onclick="fire_load()" type="button"  onclick="fire_load()" class="print btn btn-success btn-sm justify-center">Download Berita Acara</a>
                    @else
                        <a href="#" type="button" data-toggle="modal" data-target="#modalBeritaAcara" class="btn btn-warning btn-sm justify-center">Buat Berita Acara</a>
                    @endif
                @endif
            </div>
            
            @foreach($inspection_topic as $topic)
            <div class="card-body">
                <div class="card">
                    <div class="card-header">{{ $topic->inspection_topic }} @if($inspection->status_inspection == 1 || $inspection->status_inspection == 2)<button onclick="addReport(<?= $topic->id ?>)" class="btn btn-primary btn-sm m-2 justify-center">+ Add Report</button>@endif</div>
                    <div class="card-body">
                        @foreach($inspection_report as $report)
                        @if($report->inspection_topic_id == $topic->id)
                        <div class="card">
                            <div class="card-body text-left">
                                <div class="row">
                                    <div class="col-sm-8">
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
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <div class="modal fade" tabindex="-1" id="modalBeritaAcara">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Berita Acara</h5>
                </div>
                <form action="{{ url('inspector/add_beritaacara/'.$inspection->id) }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="judul">Judul Berita Acara</label>
                            <input type="text" name="judul" id="judul" class="form-control" >
                        </div>
                        <div class="form-group">
                            <label for="up_sercom">Up Sercom</label>
                            <input type="text" name="up_sercom" id="up_sercom" class="form-control" >
                        </div>
                        <div class="form-group">
                            <label for="wakil_sercom">Wakil Sercom(Nama)</label>
                            <input type="text" name="wakil_sercom" id="wakil_sercom" class="form-control" >
                        </div>
                        <div class="form-group">
                            <label for="jabatan_sercom">Jabatan Wakil Sercom</label>
                            <input type="text" name="jabatan_sercom" id="jabatan_sercom" class="form-control" >
                        </div>
                        <div class="form-group">
                            <label for="lokasi_milik">Lokasi Milik</label>
                            <input type="text" name="lokasi_milik" id="lokasi_milik" class="form-control" >
                        </div>
                        <div class="form-group">
                            <label for="rincian_pekerjaan">Isi Surat(Rincian )</label>
                            <textarea name="rincian_pekerjaan" cols="50" id="rincian_pekerjaan" class="form-control" ></textarea>
                        </div>
                        <div class="form-group">
                            <label for="ringkasan_pekerjaan">Ringkasan/Simpulan</label>
                            <textarea name="ringkasan_pekerjaan" cols="50" id="ringkasan_pekerjaan" class="form-control" ></textarea>
                        </div>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="submit" class="btn btn-sm btn-primary">Buat Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalAdd" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Equipment/Chemical</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('add_topic', $inspection->id) }}" method="POST">
                    @csrf
                    <input required type="text" class="form-control" name="equipmentchemical" placeholder="Equipment/Chemical">
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
            </div>
        </div>
    </div>

    <div class="modal fade" tabindex="-1" id="modalReport" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                <em class="icon ni ni-cross"></em>
            </a>
            <div class="modal-header">
                <h5 class="modal-title">Add Report</h5>
            </div>
            <form action="{{ route('add_report', $inspection->id) }}" id="addReport" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    @csrf
                    <div class="form-group">
                        <div class="form-control-wrap">
                            <span for="">Equipment/Services/Personel</span>
                            <input hidden type="text" class="form-control" name="topic_id" id="topic_id" value="1">
                            <input required type="text" class="form-control" name="equipmentchemical">
                        </div>
                        
                        <div class="form-control-wrap">
                            <span for="">Refference</span>
                            <input required type="text" class="form-control" name="refference">
                        </div>
                        <div class="form-control-wrap">
                            <span for="">Result</span>
                            <input required type="text" class="form-control" name="result">
                        </div>
                        <div class="form-control-wrap">
                            <span for="">Follow up</span>
                            <input required type="text" class="form-control" name="followup">
                        </div>
                        <div class="form-control-wrap">
                            <span for="">SN</span>
                            <input required type="text" class="form-control" name="sn">
                        </div>
                        <div class="form-control-wrap">
                            <span for="">OK/NOT OK With Note(OK, .....)</span>
                            <input required type="text" class="form-control" name="ok_note">
                        </div>
                        <div class="form-control-wrap">
                            <span for="">Link Document</span><small>(Pilih Untuk Me Link-kan Dokumen)</small>
                            <select name="type" class="form-control" id="tipe">
                                <option value="0">Pilih Type</option>
                                <option value="1">Equipment</option>
                                <option value="2">Chemical</option>
                            </select>
                        </div>
                        <div class="form-control-wrap" id="formtipe">
                            
                        </div>
                        <div class="form-control-wrap">
                            <span for="">Document</span>
                            <input required type="file" class="form-control" name="document">
                        </div>
                        <div class="form-control-wrap">
                            <span for="">Picture/Evidence</span>
                            <input required type="file" class="form-control" name="pictureevidence">
                        </div>
                        <div class="form-control-wrap">
                            <span for="">Comment</span>
                            <input required type="text" class="form-control" name="comment">
                        </div>
                        <div class="form-control-wrap">
                            <span for="">PIC</span>
                            <input required type="text" class="form-control" name="pic">
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="submit" id="edit-simpan" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade" tabindex="-1" id="modalFinish">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                <em class="icon ni ni-cross"></em>
            </a>
            <div class="modal-header">
                <h5 class="modal-title">Mark As Finish || Keterangan</h5>
            </div>
            <form action="{{ url('/inspector/finish/'.$inspection->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <div class="form-control-wrap">
                            <textarea name="keterangan" class="form-control" rows="5"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="submit" id="edit-simpan" class="btn btn-sm btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('js')
    <script>
        function addEqCh(){
            $('#modalAdd').modal('show');
        }
        function addReport(id){
            $('#modalReport').modal('show');
            $('#topic_id').val(id);
        }
        function markFinish(){
            $('#modalFinish').modal('show');
        }
        $('#tipe').change(function(){
            let tipe = $('#tipe').val();
            if(tipe != 0){
                let form = `
                <span for="">Tipe Dokumen</span>
                <select required type="text" class="form-control" id="doctype" name="documenttype">

                </select>`
                $('#formtipe').html(form)
            }
            if(tipe == 1){
                let html = `
                    <option value="COA">COA</option>
                    <option value="COO">COO</option>
                    <option value="Mill Certificate">Mill Certificate</option>
                    <option value="Inspection Report">Inspection Report</option>
                    <option value="Service Report">Service Report</option>
                `
                $('#doctype').html(html)
            }else if(tipe == 2){
                let html = `
                    <option value="COA">COA</option>
                    <option value="COO">COO</option>
                    <option value="PDS">PDS</option>
                    <option value="MSDS">MSDS</option>
                `
                $('#doctype').html(html)
            }
        })
    </script>
@endsection