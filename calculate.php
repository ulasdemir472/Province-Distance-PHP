<?php
include "db_connect.php";
$conn = OpenCon();


$sehir1 = htmlspecialchars($_POST['sehir1']);
$sehir2 = htmlspecialchars($_POST['sehir2']);


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

$response = array('distance' => $distance);
echo json_encode($response);


//echo "<br/><br/>" . "$sehir1 ve $sehir2 arasındaki kuş uçumu mesafe : " . number_format($distance, 2, '.', '') . " km";
