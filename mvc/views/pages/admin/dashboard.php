<!DOCTYPE html>
<html lang="en">

<head>
  <title>Danh sách nhân viên | Quản trị Admin</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- or -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://kit.fontawesome.com/881d143453.js" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
  <!-- Font-icon css-->
  <style>
    

  </style>
</head>
<div class="container-fluid w-100 text-white">
  <div class="row m-auto pt-5 ms-1 ">
    <div class="col-lg-3 col-md-6 col-sm-12 position-relative  border  rounded bg-success">
      <div class="row ">
        <div class="logoLeft "><i class=" border border-4 rounded-circle p-3 fa-solid fa-user fa-2x m-2"></i></div>
        <div class="info1">
          <h6 style="width:100%">Người dùng</h6>
          <p><b><?=sizeof($data['listAllKh']) ?>  khách hàng</b></p>
        </div>
      </div>
    </div>

    <div class="col-lg-3 col-md-6 col-sm-12  border rounded bg-danger">
    <div class="row w-100 logobox">
        <div class="logoLeft"><i class="border border-4  rounded-circle p-3 fa-solid fa-burger fa-2x m-2"></i></div>
        <div class="info2 ">
          <h6>Sản phẩm</h6>
          <p><b><?=sizeof($data['listAllSp']) ?> sản phẩm</b></p>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-12  border rounded bg-primary">
    <div class="row w-100 logobox">
      <div class="logoLeft "><i class="border border-4 rounded-circle p-3 fa-solid fa-comment fa-2x m-2"></i></div>
      <div class="info3 ">
        <h6>Bình luận</h6>
        <p><b><?=sizeof($data['listAllBl']) ?>  bình luận</b></p>
      </div> 
      </div> 
    </div>

    <div class="col-lg-3 col-md-6 col-sm-12  border rounded bg-info">
      <div class="row w-100 logobox">
        <div class="logoLeft ">
          <i class="border border-4 rounded-circle p-3 fa-solid fa-pen-nib fa-2x m-2 "></i>
        </div>  
        <div class="info4 ">
          <h6>Bài viết</h6>
          <p><b><?=sizeof($data['listAllNews']) ?> bài viết</b></p>
        </div>
        </div> 
      </div>
  </div>
</div>



<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<div class="container-fluid d-flex flex-column mt-5 ms-1">
<div class="container d-flex flex-column align-items-center shadow text-center p-3">
      <form method="post">
        <?php if(!isset($_POST['btnNgay'])){ ?>
          <h2>Doanh thu theo tháng</h2>
          <input class="border-0 bg-transparent text-underline text-info py-2" type="submit" value="Xem theo ngày" name="btnNgay">
        <?php }else{ ?>
          <h2>Doanh thu theo ngày</h2>
          <input class="border-0 bg-transparent text-underline text-info py-2" type="submit" value="Xem theo tháng">
        <?php } ?>
      </form>
    </h2>
      <canvas class="" id="myChart1" style="width:100%;height:600px;"></canvas>  
  </div>
    <div class="shadow d-flex flex-column align-items-center p-3">
    <h2>Thống kê loại hàng</h2>
      <div id="myChart" style="width:100%; height:600px;"></div>
    </div>  
    
</div>

<?php 
  function tinhDoanhThu($date, $data, $loaiDate){
    for($i=1;$i<$date;$i++){//kiem tra thang'
      if(isset($data[($i-1)][$loaiDate])){
        for($j = 1; $j <$date;$j++){//duyet thang' co doanh thu
          if(!isset($yValues[$j])) $yValues[$j]="";//khong ton tai -> khoi tao mang rong
          if($j == $data[($i-1)][$loaiDate]){//neu thang co doanh thu
             $yValues[$j] = $data[($i-1)]['tong'];// gan tong doanh thu cho mang
          }elseif($yValues[$j]==""){
            $yValues[$j] = 0;// gan mang rong bang 0
          } 
        }
      }
    }
    return $yValues;// tra ve mang
  }
  if(isset($_POST['btnNgay'])){
    $max = 10000000;
    if($data['thangHienTai']==1 || $data['thangHienTai']==3 ||$data['thangHienTai']==5 ||$data['thangHienTai']==7 ||$data['thangHienTai']==8 ||$data['thangHienTai']==10 || $data['thangHienTai']==12){
      $date = 32;
      $yValues = tinhDoanhThu($date,$data['tkdhtheongay'],'ngay');
    }elseif($data['thangHienTai']==2){
      $date = 29;
      $yValues = tinhDoanhThu($date,$data['tkdhtheongay'],'ngay');
    }else{
      $date = 31;
      $yValues = tinhDoanhThu($date,$data['tkdhtheongay'],'ngay');
    }
  }elseif(!isset($_POST['btnNgay'])){
    $date = 13;
    $yValues = tinhDoanhThu($date,$data['tkdh'],'thang');
    $max = 100000000;
  }
?>


<script>
var yValues = [<?php
  foreach($yValues as $key => $value){         
      echo $value.",";//10000,2000,0
  }
    ?>];

var xValues = [<?php for($i=1;$i<$date;$i++){
  echo $i.",";
  }?>];
new Chart("myChart1", {
  type: "line",
  data: {
    labels: xValues,
    datasets: [{
      fill: false,
      lineTension: 0,
      backgroundColor: "rgba(0,0,255,1.0)",
      borderColor: "rgba(0,0,255,0.1)",
      data: yValues
    }]
  },
  options: {
    legend: {display: false},
    scales: {
      yAxes: [{ticks: {min: 0, max:<?=$max?>}}],
    }
  }
  
});
</script>

<script>
google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChart);

function drawChart() {
var data = google.visualization.arrayToDataTable([
  ['Danh Mục', 'Số Lượng Sản Phẩm'],
    <?php 
    $tongloai = count($data['tk']);
    $i=1;
    foreach($data['tk'] as $kq){         
        if($i == $tongloai) $dau=""; else $dau=",";
        echo "['".$kq['tenLoai']."',".$kq['countsp']."],";
        $i++;
    }
    ?>
]);

var options = {
  // title:'Biểu đồ thông kê theo loại',
  is3D:true
};

var chart = new google.visualization.PieChart(document.getElementById('myChart'));
  chart.draw(data, options);
}
</script>