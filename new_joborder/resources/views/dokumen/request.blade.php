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
            <h5 class="text-center">Request Inspection {{ $request->requestnumber }}</h5>
        </div>
    </div>
    <br><br><br><br>
    <table class="table mt-2">
        <tr>
            <th>Order Date</th>
            <td>:</td>
            <td><?= date('d-m-Y', strtotime($request->orderdate))  ?></td>
        </tr>
        <tr>
            <th>Service Company</th>
            <td>:</td>
            <td><?= $request->sercom ?></td>
        </tr>
        <tr>
            <th>Wellname</th>
            <td>:</td>
            <td><?= $request->wellname ?></td>
        </tr>
        <tr>
            <th>Inspection For</th>
            <td>:</td>
            <td><?= $request->inspection ?></td>
        </tr>
        <tr>
            <th>Purpose</th>
            <td>:</td>
            <td><?= $request->purpose ?></td>
        </tr>
        <tr>
            <th>Status</th>
            <td>:</td>
            <td>
                <?php if($request->status == 1){ ?>
                    <div class="badge pill-badge badge-danger">Waiting</div>
                <?php  } ?>
                <?php if($request->status == 2){ ?>
                    <div class="badge pill-badge badge-warning">On Progress</div>
                <?php  } ?>
                <?php if($request->status == 3){ ?>
                    <div class="badge pill-badge badge-success">Completed</div>
                <?php  } ?>
            </td>
        </tr>
    </table><br>
    
    <small>Copyright &copy; <i>Pertamina EP</i> 2021 {{ date('d-M-Y') }}, All Right Reserved</small>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>