@extends('layouts.app')

@section('title')
    Joborder | Settings
@endsection

@section('content')
    <div class="row banner-text justify-content-center">
        <div class="col-md-8 m-t-20">
            <h3>Upload Tanda Tangan</h3>
            @if(Session::get('success'))
                <div class="alert alert-success">{{ Session::get('success') }}</div>
            @endif
            @if(Session::get('error'))
                <div class="alert alert-danger">{{ Session::get('error') }}</div>
            @endif
            <form action="{{ url('settings/upload') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <img class="m-2 shadow" src="{{ url('new_joborder/public/signature/'.Auth::user()->signature) }}" style="width:120px;" id="previewSignature"><br>
                <input required onchange="previewFile(this);" type="file" class="form-control" name="signature">
                <small>File Harus PNG, Rekomendasi Ukuran 500 x 500 px</small>
                <button class="btn btn-sm btn-primary mt-2 btn-block" type="submit"><i class="fas fa-upload"></i> Upload</button>
            </form>
        </div>
    </div>
@endsection

@section('js')
<script>
function previewFile(input){
    var file = $("input[name=signature]").get(0).files[0];
    if(file){
        var reader = new FileReader();
        reader.onload = function(){
            $("#previewSignature").attr("src", reader.result);
        }
        reader.readAsDataURL(file);
    }
}
</script>
@endsection