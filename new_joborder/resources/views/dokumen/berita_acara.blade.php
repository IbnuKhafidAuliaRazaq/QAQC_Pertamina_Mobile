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
            <img src="{{ asset('/new_joborder/public/surat/logo.png') }}" class="float-left" style="height:75px" alt="">
            <img src="{{ asset('/new_joborder/public/surat/qaqc.png') }}" class="float-right" style="height:75px" alt="">
        </div>
    </div>
    <br><br><br><br>
    <h3 style="text-transform: uppercase;" class="text-center">{{ $data['berita']->judul }}</h3>
    <h4 class="text-center">{{ $data['berita']->up_sercom }}</h4>
    <h6 class="text-center">Dilaksanakan Tanggal : {{ date('d-M-Y', strtotime($data['inspection']->dateinspection) ) }} - {{ date('d-M-Y' , strtotime($data['inspection']->releaseinspection)) }}</h6>
    <h6 class="text-center">Lokasi : {{ $data['berita']->lokasi_milik }}</h6>
    <br><br>
    <p>{{ $data['berita']->rincianpekerjaan }}</p>
    <br>
    <p>{{ $data['berita']->Pengantar }}</p>
    <p>{{ $data['berita']->ringkasanpekerjaan }}</p><br>
    
    <p>Demikian Berita Acara ini dibuat sesuai kondisi yang sebenarnya untuk dipergunakan seperlunya dan dapat dilakukan verifikasi kembali  jika diperlukan.</p>
    <br>
    <h5 class="text-center">Mewakili</h5>
    <br><br>
    <div class="row">
        <div class="col-12">
            <div style="
                width:180px;
                background-image: url('{{ url('new_joborder/public/signature/'.$data['inspector']->signature) }}');
                background-size: cover;
                background-repeat: no-repeat;" class="ml-2 float-left text-center">
                <strong>PT. Pertamina EP</strong>
                <br><br><br><br><br>
                <strong>{{ $data['inspector']->fullname }}</strong><br>
                {{ $data['inspector']->position }}
                
            </div>
            <div class="mr-2 float-right text-center">
                <strong>{{ $data['berita']->up_sercom }}</strong>   
                <br><br><br><br><br>
                <strong>{{ $data['berita']->wakil_sercom }}</strong><br>
                {{ $data['berita']->jabatan_sercom }}<br>
            </div>
        </div>
    </div>
    <br><br><br><br><br><br><br><br><br><br><br>
    <hr>
    <div class="row">
        <div class="col-12">
            <small>Copyright &copy; <i>Pertamina EP</i> 2021 {{ date('d-M-Y') }}, All Right Reserved</small>
        </div>
    </div>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>