<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>
    <div class="row">
        <div class="col-12">
            <img src="{{ asset('/new_joborder/public/surat/logo.png') }}" class="float-left" style="width:75px; height:75px;" alt="">
            <img src="http://qaqcdwipertamina.com/uploads/{{ $logo_sercom }}" class="float-right" style="height:75px; width:100px;" alt="">
        </div>
    </div>
    <h5 class="text-center">Surat Ijin Jalan</h5>
    <h6 class="text-center">No.  {{ $surat->inspection->requestnumber->requestnumber.'/'.date("Y") }}</h6>
    <br><br>
    <strong>Tanggal : {{ date( "d-m-Y", strtotime($surat->inspection->dateinspection)) }}</strong><br><br>
    <strong>Dengan Ini Menugaskan</strong><br><br>
    <table style="border: none;">
        <tr>
            <td>Nama</td>
            <td>:</td>
            <td>{{ $surat->inspection->inspector_name }}</td>
        </tr>
        <tr>
            <td>Jabatan</td>
            <td>:</td>
            <td>{{ $inspector->position }}</td>
        </tr>
        <tr>
            <td>Dari</td>
            <td>:</td>
            <td>{{ $surat->dari }}</td>
        </tr>
        <tr>
            <td>Tujuan</td>
            <td>:</td>
            <td>{{ $surat->tujuan }}</td>
        </tr>
        <tr>
            <td>Keperluan</td>
            <td>:</td>
            <td>{{ $surat->keperluan }}</td>
        </tr>
        <tr>
            <td>Mulai Tanggal</td>
            <td>:</td>
            <td>{{ date( "d-m-Y", strtotime($surat->inspection->dateinspection)) }}</td>
        </tr>
        <tr>
            <td>Kembali Tanggal</td>
            <td>:</td>
            <td>{{ date( "d-m-Y", strtotime($surat->inspection->releaseinspection)) }}</td>
        </tr>
        <tr>
            <td>Kendaraan</td>
            <td>:</td>
            <td>{{ $surat->vehicle }}</td>
        </tr>
    </table><br>
    
    
    <table class="table table-bordered">
        <tr>
            <td rowspan="2" style="width: 175px;">Keterangan</td>
            <td colspan="3">Tujuan</td>
        </tr>
        <tr>
            <td>I</td>
            <td>II</td>
            <td>III</td>
        </tr>
        <tr>
            <td>Tanggal Tiba</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>Tanggal Kembali</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>Lokasi Sumur</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr style="height: 150px">
            <td>Pejabat Yang Dikunjungi</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    </table>
    <table class="table table-borderless mb-2">
        <tr>
            <td>
                <div>
                    <div style="background-image: url('{{ url('new_joborder/public/signature/'.$inspector->signature) }}');
                                background-size: cover;
                                background-repeat: no-repeat;
                                width: 150px;" class="text-center">
                        <strong>Ybs,</strong>
                        <br><br><br><br>
                        <strong>{{ $surat->inspection->inspector_name }}</strong><br>
                        {{ $inspector->position }}
                    </div>
                </div>
            </td>
            <td>
                <div>
                    <div style="background-image: url('{{ url('new_joborder/public/signature/'.$ttd_manager->signature) }}');
                                background-size: cover;
                                background-repeat: no-repeat;
                                width: 150px;" class="text-center">
                        <strong>PT. Pertamina EP</strong>
                        <br><br><br><br>
                        <strong>{{ $ttd_manager->fullname }}</strong><br>
                        {{ $ttd_manager->position }}
                    </div>
                </div>
            </td>
            <td>
                <div>
                    <div class="text-center">
                        <strong>{{ $surat->inspection->requestnumber->sercom }}</strong>
                        <br><br><br><br>
                        <strong>______________</strong><br>
                        Perwakilan
                    </div>
                </div>
            </td>
        </tr>
    </table>
    <small>Copyright &copy; <i>Pertamina EP</i> 2021 {{ date('d-M-Y') }}, All Right Reserved</small>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>