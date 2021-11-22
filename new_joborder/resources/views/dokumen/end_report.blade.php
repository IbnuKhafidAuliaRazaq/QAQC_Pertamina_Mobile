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
            <img src="{{ asset('/new_joborder/public/surat/logo.png') }}" class="float-left" style="width:75px; margin-top:-25px; height:75px;" alt="">
        </div>
    </div>
    <h5 class="text-center">FORM REPORT {{ strtoupper($inspection->job_inspect) }}</h5><br>
    <table>
        <tr>
            <th>Date</th>
            <td>:</td>
            <td> {{ $inspection->dateinspection }}</td>
        </tr>
        <tr>
            <th>Job Order From</th>
            <td>:</td>
            <td> {{ $inspection->job_inspect }}</td>
        </tr>
        <tr>
            <th>No. OAS/Contract</th>
            <td>:</td>
            <td> {{ $inspection->sij_spd->atas_dasar }}</td>
        </tr>
        <tr>
            <th>Services</th>
            <td>:</td>
            <td> {{ $inspection->requestnumber->sercom }}</td>
        </tr>
        <tr>
            <th>Verificator</th>
            <td>:</td>
            <td> {{ $inspection->inspector_name }}</td>
        </tr>
        <tr>
            <th>QAQC</th>
            <td>:</td>
            <td>...............</td>
        </tr>
        <tr>
            <th>Inspection</th>
            <td>:</td>
            <td> {{ $inspection->job_inspect }}</td>
        </tr>
        <tr>
            <th>Location Inspection</th>
            <td>:</td>
            <td> {{ $inspection->lokasi }}</td>
        </tr>
    </table><br>
    <table class="table table-bordered">
        <thead class="table-primary">
            <tr>
                <th rowspan="2"><small><b>No</b></small> </th>
                <th><small>Description</small></th>
                <th colspan="3"><small>Observation</small></th>
                <th colspan="3"><small>Remarks</small></th>
                <th><small>Recomm</small></th>
                <th rowspan="2"><small>PIC</small></th>
            </tr>
            <tr>
                <th><small>Equipment/Services/Personel</small></th>
                <th><small>Refference</small> </th>
                <th width="50px"><small>Result</small> </th>
                <th width="50px"><small>Comment</small></th>
                <th width="50px"><small>Followup</small></th>
                <th width="100px"><small>SN</small></th>
                <th width="100px"><small>Picture</small></th>
                <th width="50px"><small>Ok/Not</small></th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; foreach($inspection_topic as $topic) : ?>
                <tr class="table-secondary">
                    <td><?= $no++ ?></td>
                    <td colspan="9"><?= $topic->inspection_topic ?></td>
                </tr>
                <?php $report = DB::select('select * from inspection_report where inspection_topic_id = '.$topic->id); ?>
                <?php $ch = ord('a'); foreach($report as $report) : ?>
                    <tr>
                        <td><?= chr($ch++).PHP_EOL ?></td>
                        <td><?= $report->equipmentchemical ?></td>
                        <td><?= $report->refference ?></td>
                        <td><?= $report->result ?></td>
                        <td><?= $report->comment ?></td>
                        <td><?= $report->followup ?></td>
                        <td><?= $report->sn ?></td>
                        <td><img style="width:100px" src="{{ url('new_joborder/public/pictures/'.$report->pictureevidence) }}" alt=""></td>
                        <td><?= $report->ok_note ?></td>
                        <td><?= $report->pic ?></td>
                    </tr>
                <?php endforeach; ?>
                
                
            <?php endforeach ?>
        </tbody>
    </table>
    <strong>Note</strong>
    <p>{{ $inspection->keterangan }}</p>
    <div style="
            background-image: url('{{ url('new_joborder/public/signature/'.$inspector->signature) }}');
            background-size: cover;
            background-repeat: no-repeat;"
                
        class="float-left">
        <strong>Wittness By,</strong>
        <br><br><br>
        <strong>{{ $inspection->inspector_name }}</strong>
    </div>
    <div style="
            background-image: url('{{ url('new_joborder/public/signature/'.$ttd_leader) }}');
            background-size: cover;
            background-repeat: no-repeat;"
        class="float-left ml-3">
        <br><br><br>
        <strong>Lilik Supriyanto</strong>
    </div>
    <div class="row">
        <div class="col">
            <small>Copyright &copy; <i>Pertamina EP</i> 2021 {{ date('d-M-Y') }}, All Right Reserved</small>
        </div>
    </div>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>