@extends('layouts.app')

@section('title')
    Joborder | User
@endsection

@section('content')
    <div class="row banner-text justify-content-center">
        <div class="col-md-10 m-t-20">
            <h5 class="mb-2"> <strong>Add Request Inspection</strong> </h5>
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
                </ul>
            </div>
            @endif
            @if(Session::get('error'))
                <div class="alert alert-danger">{{ Session::get('error') }}</div>
            @endif
            <hr>
            <form action="{{ route('user_create') }}" method="POST">
            @csrf
            <div class="form-group">
                <label class="float-left" for="">Regional</label>
                <select name="regional_id" id="reg" onchange="setReg()" class="form-control" name="" id="">
                    <option  class="" value="0">-- Pilih Regional --</option>
                    @foreach($regional as $reg)
                        <option class="{{ $reg->regional_alias }}" value="{{ $reg->id }}">{{ $reg->regional_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label class="float-left" for="">Zona</label>
                <select name="zona_id" id="zon" onchange="setZone()" class="form-control" name="" id="">
                    <option class="" value="0">-- Pilih Zona --</option>
                    @foreach($zona as $zon)
                        <option class="{{ $zon->zona_alias }}" value="{{ $zon->id }}">{{ $zon->zona_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label class="float-left" for="">Request Number</label>
                <input required type="number" class="form-control" name="req_number" id="">
                @if(!empty($latest))<div class="badge badge-danger mr-1">Latest = {{ $latest->requestnumber }}</div> @endif<div class="badge badge-warning">-<span id="reg_al"></span>-<span id="zon_al"></span></div>
            </div>
            <div class="form-group">
                <label class="float-left" for="">Area Inspection</label>
                <select class="form-control" name="area" id="">
                    <option value="0">-- Pilih Area --</option>
                    <option value="1">Jabodetabek</option>
                    <option value="2">Luar Jabodetabek</option>
                </select>
            </div>
            <div class="form-group">
                <label class="float-left" for="">User</label>
                <input type="text" value="{{ Auth::user()->fullname }}" disabled class="form-control">
                <input hidden type="text" name="user_id" value="{{ Auth::user()->id }}" class="form-control">
            </div>
            <div class="form-group">
                <label class="float-left" for="">Wellname</label>
                <input type="text" name="wellname" class="form-control">
            </div>
            <div class="form-group">
                <label class="float-left" for="">Sercom</label>
                <select id="sercom" name="sercom_id" onchange="setSercom()" class="form-control">
                    <option value="0">-- Pilih Sercom --</option>
                    @foreach($sercom as $com)
                    <option class="{{ $com->sercom_name }}" value="{{ $com->id }}" >{{ $com->sercom_name }}</option>
                    @endforeach
                </select>
                <input hidden type="text" name="sercom" id="sercomName">
            </div>
            <div class="form-group">
                <label class="float-left" for="">Tanggal Order</label>
                <input required type="date" name="orderdate" value="{{ date('Y-m-d') }}" class="form-control">
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="card card-bordered">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-check float-left">
                                        <input class="form-check-input" type="checkbox" name="value1[]" value="Equipment" id="equipment">
                                        <label class="form-check-label" for="equipment">
                                            <b>Equipment</b> 
                                        </label>
                                    </div>
                                    <div class="form-check float-left">
                                        <input class="form-check-input" type="checkbox" name="value2[]" value="Inspection" id="inspection">
                                        <label class="form-check-label" for="inspection">
                                            Inspection
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check float-left">
                                        <input class="form-check-input" type="checkbox" name="value2[]" value="Function Test" id="functiontest">
                                        <label class="form-check-label" for="functiontest">
                                            Function
                                        </label>
                                    </div>
                                    <div class="form-check float-left">
                                        <input class="form-check-input" type="checkbox" name="value2[]" value="Investigation" id="investigation">
                                        <label class="form-check-label" for="investigation">
                                            Investigation
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card card-bordered">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-check float-left">
                                        <input class="form-check-input" type="checkbox" value="Chemical" name="value1[]" id="chemical">
                                        <label class="form-check-label" for="chemical">
                                            <b>Chemical</b>
                                        </label>
                                    </div>
                                    <div class="form-check float-left">
                                        <input class="form-check-input" type="checkbox" value="Individual Test" name="value2[]" id="individualtest">
                                        <label class="form-check-label" for="individualtest">
                                            Individual
                                        </label>
                                    </div>    
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check float-left">
                                        <input class="form-check-input" type="checkbox" value="Formulation Test" name="value2[]" id="formulationtest">
                                        <label class="form-check-label" for="formulationtest">
                                            Formulation
                                        </label>
                                    </div>
                                    <div class="form-check float-left">
                                        <input class="form-check-input" type="checkbox" value="Barcoding" name="value2[]" id="barcoding">
                                        <label class="form-check-label" for="barcoding">
                                            Barcoding
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <a href="{{ url('user') }}" class="btn btn-danger m-b-10">Kembali</a> 
            <button type="submit" class="btn btn-primary m-b-10">Simpan</button> 
            </form>
        </div>
    </div>


@endsection

@section('js')
    <script>

        function setReg(){
            var reg_alias = $('#reg option:selected').attr('class');
            $('#reg_al').text(reg_alias)
        }
        function setZone(){
            var zon_alias = $('#zon option:selected').attr('class');
            $('#zon_al').text(zon_alias)
        }
        function setSercom(){
            var sercomName = $('#sercom option:selected').attr('class');
            $('#sercomName').val(sercomName)
        }
    </script>
@endsection