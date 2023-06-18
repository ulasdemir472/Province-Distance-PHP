<?php
function OpenCon()
{
    $dbhost = "localhost";
    $dbuser = "root";
    $dbpass = "password";
    $db = "Sehirler";
    $conn = new mysqli($dbhost, $dbuser, $dbpass, $db) or die("Connect failed: %s\n" . $conn->error);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // komsu_sehirler tablosunu oluşturma
    // $sql2 = "CREATE TABLE komsu_sehirler (
    //     id INT PRIMARY KEY AUTO_INCREMENT,
    //     sehir_id INT,
    //     sehir_isim VARCHAR(50),
    //     komsu_sehir_id INT,
    //     komsu_sehir_isim VARCHAR(50),
    //     FOREIGN KEY (sehir_id) REFERENCES iller(id),
    //     FOREIGN KEY (komsu_sehir_id) REFERENCES iller(id)
    // )";

    // if ($conn->query($sql2) === TRUE) {
    //     echo "Table komsu-iller created successfully";
    // } else {
    //     echo "Error: " . $sql2 . "<br>" . $conn->error;
    // }



    // $sql = "INSERT INTO iller (isim, plaka, enlem, boylam) VALUES
    // ('Adana', 1, 37.000000, 35.321333),
    // ('Adıyaman', 2, 37.764811, 38.278630),
    // ('Afyonkarahisar', 3, 38.756996, 30.538735),
    // ('Ağrı', 4, 39.719928, 43.051936),
    // ('Amasya', 5, 40.653963, 35.833652),
    // ('Ankara', 6, 39.920772, 32.854110),
    // ('Antalya', 7, 36.896890, 30.713323),
    // ('Artvin', 8, 41.182789, 41.819769),
    // ('Aydın', 9, 37.845013, 27.839761),
    // ('Balıkesir', 10, 39.648369, 27.882610),
    // ('Bilecik', 11, 40.142826, 30.066853),
    // ('Bingöl', 12, 39.062707, 40.769918),
    // ('Bitlis', 13, 38.393446, 42.123410),
    // ('Bolu', 14, 40.739452, 31.611561),
    // ('Burdur', 15, 37.718590, 30.290996),
    // ('Bursa', 16, 40.182572, 29.066868),
    // ('Çanakkale', 17, 40.155312, 26.414162),
    // ('Çankırı', 18, 40.607283, 33.621871),
    // ('Çorum', 19, 40.550556, 34.955562),
    // ('Denizli', 20, 37.783333, 29.094738),
    // ('Diyarbakır', 21, 37.913630, 40.217724),
    // ('Edirne', 22, 41.677191, 26.555790),
    // ('Elazığ', 23, 38.681808, 39.226186),
    // ('Erzincan', 24, 39.750000, 39.500000),
    // ('Erzurum', 25, 39.904318, 41.267885),
    // ('Eskişehir', 26, 39.766979, 30.525627),
    // ('Gaziantep', 27, 37.066220, 37.383320),
    // ('Giresun', 28, 40.912811, 38.389533),
    // ('Gümüşhane', 29, 40.460067, 39.482695),
    // ('Hakkâri', 30, 37.574835, 43.740246),
    // ('Hatay', 31, 36.199999, 36.166665),
    // ('Isparta', 32, 37.766667, 30.550000),
    // ('Mersin', 33, 36.800000, 34.633333),
    // ('İstanbul', 34, 41.008237, 28.978359),
    // ('İzmir', 35, 38.418850, 27.128720),
    // ('Kars', 36, 40.602905, 43.097527),
    // ('Kastamonu', 37, 41.388710, 33.782730),
    // ('Kayseri', 38, 38.733334, 35.483334),
    // ('Kırklareli', 39, 41.733334, 27.216667),
    // ('Kırşehir', 40, 39.150002, 34.166668),
    // ('Kocaeli', 41, 40.853271, 29.881520),
    // ('Konya', 42, 37.866667, 32.483333),
    // ('Kütahya', 43, 39.416667, 29.983334),
    // ('Malatya', 44, 38.355198, 38.309463),
    // ('Manisa', 45, 38.610000, 27.052500),
    // ('Kahramanmaraş', 46, 37.583333, 36.933334),
    // ('Mardin', 47, 37.312236, 40.735112),
    // ('Muğla', 48, 37.215278, 28.363611),
    // ('Muş', 49, 38.946174, 41.753349),
    // ('Nevşehir', 50, 38.624420, 34.723969),
    // ('Niğde', 51, 37.966667, 34.683334),
    // ('Ordu', 52, 40.986166, 37.879379),
    // ('Rize', 53, 41.020050, 40.523449),
    // ('Sakarya', 54, 40.756937, 30.378138),
    // ('Samsun', 55, 41.286667, 36.330002),
    // ('Siirt', 56, 37.934017, 41.940449),
    // ('Sinop', 57, 42.026422, 35.155125),
    // ('Sivas', 58, 39.747662, 37.017879),
    // ('Tekirdağ', 59, 40.983334, 27.516667),
    // ('Tokat', 60, 40.316666, 36.550000),
    // ('Trabzon', 61, 41.000000, 39.733334),
    // ('Tunceli', 62, 39.106667, 39.548889),
    // ('Şanlıurfa', 63, 37.167137, 38.793892),
    // ('Uşak', 64, 38.682301, 29.408190),
    // ('Van', 65, 38.491666, 43.383335),
    // ('Yozgat', 66, 39.820000, 34.804722),
    // ('Zonguldak', 67, 41.455620, 31.782712),
    // ('Aksaray', 68, 38.372093, 34.025886),
    // ('Bayburt', 69, 40.258729, 40.226348),
    // ('Karaman', 70, 37.175930, 33.228748),
    // ('Kırıkkale', 71, 39.841296, 33.511515),
    // ('Batman', 72, 37.881168, 41.135108),
    // ('Şırnak', 73, 37.418700, 42.491834),
    // ('Bartın', 74, 41.581129, 32.461005),
    // ('Ardahan', 75, 41.110770, 42.702881),
    // ('Iğdır', 76, 39.921510, 44.045430),
    // ('Yalova', 77, 40.657917, 29.273900),
    // ('Karabük', 78, 41.204380, 32.625000),
    // ('Kilis', 79, 36.716058, 37.115020),
    // ('Osmaniye', 80, 37.074220, 36.247143),
    // ('Düzce', 81, 40.843849, 31.156540);";

    // if ($conn->query($sql) === TRUE) {
    //     echo "New records created successfully";
    // } else {
    //     echo "Error: " . $sql . "<br>" . $conn->error;
    // }
    //echo "<br/>Connected succesfully<br/>";
    return $conn;
}
function CloseConn($conn)
{
    $conn->close();
}
