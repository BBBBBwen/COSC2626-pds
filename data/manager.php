<?php
    require 'connectDB.php';
    $query = "SELECT * FROM bookings;";
    $stmt = $db->prepare($query);
    $stmt->execute();
    $pending = 0;
    $transporting = 0;
    $complete = 0;
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        if($row['parcelStatus'] == 1) {
            $pending++;
        } else if($row['parcelStatus'] == 2) {
            $transporting++;
        } else if($row['parcelStatus'] == 3){
            $complete++;
        }
    }
?>
<html>
<head>
<script type="text/javascript"src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart); function drawChart(){
        var data = google.visualization.arrayToDataTable([
            ['Status', 'Number'],
            ['pending',<?php echo $pending; ?>],
            ['transporting',<?php echo $transporting; ?>],
            ['complete',<?php echo $complete; ?>],
        ]);

        var options ={
            title: 'Task completion rate'
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));
        chart.draw(data,options);
    }
</script>
</head>
<body>
<div id="piechart" style="width: 900px; height:500px;"></div>
</body>
</html>
