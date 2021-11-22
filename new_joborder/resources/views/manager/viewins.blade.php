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
        <h3>Approval Inspection</h3>
        <table class="table table-striped">
                <tr>
                    <th>Request Number</th>
                    <td><?= $inspection->requestnumber->requestnumber ?></td>
                </tr>
                <tr>
                    <th>Inspector Name</th>
                    <td><?= $inspection->inspector_name ?></td>
                </tr>
                <tr>
                    <th>Date Inspection</th>
                    <td><?= $inspection->dateinspection ?></td>
                </tr>
                <tr>
                    <th>Release</th>
                    <td><?= $inspection->releaseinspection ?></td>
                </tr>
                <tr>
                    <th>Dokumen</th>
                    <td>@if($inspection->requestnumber->area == 1) <a class="print" onclick="fire_load()" href="{{ url('print_surat/'.$inspection->id) }}">Surat Ijin Jalan.pdf</a> @else($inspection->requestnumber->area == 2) <a class="print" onclick="fire_load()" href="{{ url('print_surat/'.$inspection->id) }}">Surat Perjalanan Dinas.pdf</a>@endif</td>
                </tr>
                <tr>
                    <th>Approval</th>
                    <td>
                        <?php if($inspection->managerapprove == 1){ $navigate = 'hold'; ?>
                            <div class="badge badge-warning">Hold</div>
                            <div onclick="modalApprove()" style="cursor: pointer;" class="badge badge-primary">Choose Action</div>
                        <?php  } ?>
                        <?php if($inspection->managerapprove == 2){ $navigate = 'accept'; ?>
                            <div class="badge badge-success">Accept</div>
                        <?php  } ?>
                        <?php if($inspection->managerapprove == 0){ $navigate = 'reject'; ?>
                            <div class="badge badge-danger">Reject</div>
                        <?php  } ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <textarea readonly class="form-control" id="" cols="30" rows="10">{{ $inspection->response_email }}</textarea>
                    </td>
                </tr>
            </table>
            <a href="{{ url('/manager/inspection/'.$navigate) }}" class="btn btn-danger">Kembali</a>
        </div>
    </div>

    <div class="modal fade" id="modalApprove" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pilih Putusan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('approval_ins', $inspection->id) }}" method="POST">
                @csrf
                  <input type="radio" id="2" name="managerapprove" value="2">
                  <label for="2">Accept</label><br>
                  <input type="radio" id="0" name="managerapprove" value="0">
                  <label for="0">Reject</label><br>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
            </div>
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