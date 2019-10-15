<?php include("serverV2.php"); ?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF8">
    <title>Parcel Delivery System</title>
    <link id='styleCss' type="text/css" rel="styleSheet" href="../css/indexStyle.css">
    <link type="text/css" rel="stylesheet" href="../css/style.css">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</head>
<style>
html {
    font-family: sans-serif;
    line-height: 1.15;
    height: 100%;
}

body {
    margin: 0;
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
    font-size: 1rem;
    font-weight: 400;
    line-height: 1.5;
    color: #1a1a1a;
    text-align: left;
    height: 100%;
    background-color: #fff;
}

.container2 {
    display: flex;
    flex-direction: column;
    height: 40%;
    width: 100%;
}

.map {
    flex: 1;
    background: #f0f0f0;
}
</style>
<body>

    <?php include_once("content/header.php"); ?>

    <div class="container">
        <div class="col-md-12">
            <h1>Parcel ID : <?php echo $_GET["data"]; ?></h1>

            <table border="1">
                <tr>
                    <th>Info</th>
                    <th>Location</th>
                    <th>Timestamp</th>
                </tr>
                <?php getBookingDetails($_GET["data"], $db); ?>
            </table>
        </div>
    </div>
    <main class="container2">
        <div id="map" class="map"></div>
    </main>
<?php
    $geo = getCoordinate($_GET["data"], $db);
    if (isset($geo['status']) && ($geo['status'] == 'OK')) {
        $latitude = $geo['results'][0]['geometry']['location']['lat'];
        $longitude = $geo['results'][0]['geometry']['location']['lng'];
    }
?>
    <script>
    function init() {
        const initialPosition = { lat: <?php echo $latitude; ?>, lng: <?php echo $longitude; ?> };

        const map = new google.maps.Map(document.getElementById('map'), {
            center: initialPosition,
            zoom: 15
      });

        const marker = new google.maps.Marker({ map, position: initialPosition });
    }
    </script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAtgbDVO3hASMchsL0gyj4b-Itpg5_u-_o&callback=init"></script>
    <?php include_once("content/foot.php"); ?>
</body>
</html>
