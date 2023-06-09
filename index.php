<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <script>
        function Hesapla(e) {
            e.preventDefault();
            const sehir1 = document.getElementById("sehir1").value;
            const sehir2 = document.getElementById("sehir2").value;
            const sonuc = document.getElementById("sonuc");

            const xhr = new XMLHttpRequest();

            xhr.onreadystatechange = function() {
                if (this.readyState == 4 && this.status === 200) {
                    let response = JSON.parse(xhr.responseText);
                    let distance = response.distance;
                    console.log(response);
                    sonuc.innerHTML = `${sehir1} ve ${sehir2} arasındaki kuş uçumu mesafe : ${distance.toFixed(2)} km`;
                } else {
                    sonuc.innerHTML = xhr.status;
                }
            }
            xhr.open("POST", "calculate.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.send("sehir1=" + encodeURIComponent(sehir1) + "&sehir2=" + encodeURIComponent(sehir2));
        }
    </script>

</head>

<body>
    <form method="post">
        <label for="sehir1">1. Şehir</label>
        <input type="text" id="sehir1" name="sehir1" placeholder="Sehir ismi giriniz..." style="margin-top: 5px;"><br />
        <label for="sehir2">2. Şehir</label>
        <input type="text" id="sehir2" name="sehir2" placeholder="Sehir ismi giriniz..." style="margin-top: 5px;"><br />
        <button type="submit" onclick="Hesapla(event)" style="margin-top: 5px;">Hesapla</button>
    </form>
    <p id="sonuc"></p>
    <div id="map"></div>

    <?php
    include "db_connect.php";
    $conn = OpenCon();


    if (isset($_GET["sehir1"]) && isset($_GET["sehir2"])) {
        $sehir1 = $_GET["sehir1"];
        $sehir2 = $_GET["sehir2"];
    } else {
        echo "URL'de sehir1 ve (veya) sehir2 parametresi eksik.";
    }


    // Şehir bilgilerini veritabanından al
    $query = "SELECT enlem, boylam FROM iller WHERE isim = ?";
    $stmt = $conn->prepare($query);

    // İlk şehir
    $stmt->bind_param("s", $sehir1);
    $stmt->execute();
    $stmt->bind_result($lat1, $lng1); //latitude ve longtitude
    $stmt->fetch();


    // İkinci şehir
    $stmt->bind_param("s", $sehir2);
    $stmt->execute();
    $stmt->bind_result($lat2, $lng2);
    $stmt->fetch();

    // Haversine formülünü kullanarak uzaklığı hesaplama
    $earthRadius = 6371; // Dünya yarıçapı (kilometre olarak)
    $latDiff = deg2rad($lat2 - $lat1);
    $lngDiff = deg2rad($lng2 - $lng1);
    $a = sin($latDiff / 2) * sin($latDiff / 2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($lngDiff / 2) * sin($lngDiff / 2);
    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
    $distance = $earthRadius * $c;

    // Bağlantıyı kapat
    CloseConn($conn);
    $stmt->close();

    if ($distance != 0) {
        echo "<br/><br/>" . "$sehir1 ve $sehir2 arasındaki kuş uçumu mesafe : " . number_format($distance, 2, '.', '') . " km";
    }

    ?>

</body>

</html>