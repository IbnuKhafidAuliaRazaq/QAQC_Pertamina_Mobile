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
                        <?php if($request->managerapprove == 1){ $navigate = 'hold'; ?>
                            <div class="badge badge-warning">Hold</div>
                            <div onclick="modalApprove()" style="cursor: pointer;" class="badge badge-primary">Choose Action</div>
                        <?php  } ?>
                        <?php if($request->managerapprove == 2){ $navigate = 'accept';?>
                            <div class="badge badge-success">Accept</div>
                        <?php  } ?>
                        <?php if($request->managerapprove == 0){ $navigate = 'reject'; ?>
                            <div class="badge badge-danger">Reject</div>
                        <?php  } ?>
                    </td>
                </tr>
            </table>
            <a href="{{ url('/manager/request/'.$navigate) }}" class="btn btn-danger">Kembali</a>
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
                <form action="{{ route('approval', $request->id) }}" method="POST">
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