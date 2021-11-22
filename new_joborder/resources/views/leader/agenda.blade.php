@extends('layouts.app')

@section('title')
    Joborder | Leader
@endsection

@section('content')
    
    

<style>

* {box-sizing: border-box;}
ul {list-style-type: none;}
body {font-family: Verdana, sans-serif;}

.month {
  padding: 70px 25px;
  width: 100%;
  text-align: center;
}

.month ul {
  margin: 0;
  padding: 0;
}

.month ul li {
  color: white;
  font-size: 20px;
  text-transform: uppercase;
  letter-spacing: 3px;
}

.month .prev {
  float: left;
  padding-top: 10px;
}

.month .next {
  float: right;
  padding-top: 10px;
}

.weekdays {
  margin: 0;
  padding: 10px 0;
}

.weekdays li {
  display: inline-block;
  width: 13.6%;
  text-align: center;
}

.days {
  padding: 10px 0;
  margin: 0;
}

.days div {
  list-style-type: none;
  display: inline-block;
  width: 13.6%;
  text-align: center;
  margin-bottom: 5px;
  font-size:12px;
}

.days div .active {
  padding: 5px;
  background: #1abc9c;
  color: white !important
}

/* Add media queries for smaller screens */
@media screen and (max-width:720px) {
  .weekdays div, .days div {width: 13.1%;}
}

@media screen and (max-width: 420px) {
  .weekdays div, .days div {width: 12.5%;}
  .days div .active {padding: 2px;}
}

@media screen and (max-width: 290px) {
  .weekdays div, .days div {width: 12.2%;}
}
</style>
<div class="card shadow">
    <div class="card-body">
        <?php if(empty($num_days)){
            $num_days = date("t");
        } ?>
        <div class="days">  
            <?php for($i=1;$i<=$num_days;$i++){ ?>
            <div style="width:120px;" class="border border-default"><?= $i ?><br>
            <?php foreach($agenda as $ag): ?>
                <?php $interval = date_diff(date_create($ag->dateinspection), date_create($ag->releaseinspection))->format('%a'); ?>
                <?php if(date("j", strtotime($ag->dateinspection)) == $i) { ?>
                    <span style="width:100px" class="badge badge-success m-1"><?= $ag->inspector_name ?></span>
                <?php }elseif( date("j", strtotime($ag->releaseinspection)) == $i){ ?>
                    <span style="width:100px" class="badge badge-warning m-1"><?= $ag->inspector_name ?></span>
                <?php }elseif($i > date("j", strtotime($ag->dateinspection)) && $i < date("j", strtotime($ag->releaseinspection))){ ?>
                    <span style="width:100px" class="badge badge-primary m-1"><?= $ag->inspector_name ?></span>
                <?php }else{ ?>
                    <span style="width:100px; opacity:0" class="badge badge-light m-1">none</span>
                <?php } ?>
            <?php endforeach; ?>
            </div>
            <?php } ?>
        </div>
        
    <a href="{{ url('leader') }}" class="btn btn-sm btn-danger mt-1"><i class="fas fa-arrow-left"></i> Back</a>
    </div>
</div>
@endsection