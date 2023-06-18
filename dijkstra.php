<?php
// Veritabanı bağlantısı kurulur
include "db_connect.php";
$conn = OpenCon();

$sehir1 = htmlspecialchars($_POST['sehir1']);
$sehir2 = htmlspecialchars($_POST['sehir2']);

// Veritabanından şehir verilerini sorgular
$sql = "SELECT sehir_id, sehir_isim, komsu_sehir_id FROM komsu_sehirler";
$result = $conn->query($sql);

$graph = array();
$start = 0;
$end = 0;

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {

        $sehir_id = $row['sehir_id'];
        $komsu_sehir_id = $row['komsu_sehir_id'];

        if ($row['sehir_isim'] == $sehir1) {
            $start = $sehir_id;
        }
        if ($row['sehir_isim'] == $sehir2) {
            $end = $sehir_id;
        }


        // Şehirleri graf oluştururken şehir ID'lerini kullanın
        if (!isset($graph[$sehir_id])) {
            $graph[$sehir_id] = array();
        }
        $graph[$sehir_id][] = $komsu_sehir_id;  //'A' => array('B', 'C'),
    }
}



// Veritabanı bağlantısını kapatır
$conn->close();
function dijkstra($graph, $start, $end)
{
    $distances = array_fill_keys(array_keys($graph), INF);
    $distances[$start] = 0;
    $visited = array();

    while (true) {
        $minDistance = INF;
        $minNode = null;

        foreach ($distances as $node => $distance) {
            if (!in_array($node, $visited) && $distance < $minDistance) {
                $minDistance = $distance;
                $minNode = $node;
            }
        }

        if ($minNode === null || $minNode === $end) {
            break;
        }

        $visited[] = $minNode;

        foreach ($graph[$minNode] as $neighbor) {
            if (!in_array($neighbor, $visited)) {
                $newDistance = $distances[$minNode] + 1;
                if ($newDistance < $distances[$neighbor]) {
                    $distances[$neighbor] = $newDistance;
                }
            }
        }
    }

    return $distances[$end];
}

function getShortestPath($graph, $start, $end)
{
    $distances = array_fill_keys(array_keys($graph), INF);
    $distances[$start] = 0;
    $visited = array();
    $previous = array_fill_keys(array_keys($graph), null);

    while (true) {
        $minDistance = INF;
        $minNode = null;

        foreach ($distances as $node => $distance) {
            if (!in_array($node, $visited) && $distance < $minDistance) {
                $minDistance = $distance;
                $minNode = $node;
            }
        }

        if ($minNode === null || $minNode === $end) {
            break;
        }

        $visited[] = $minNode;

        foreach ($graph[$minNode] as $neighbor) {
            if (!in_array($neighbor, $visited)) {
                $newDistance = $distances[$minNode] + 1;
                if ($newDistance < $distances[$neighbor]) {
                    $distances[$neighbor] = $newDistance;
                    $previous[$neighbor] = $minNode;
                }
            }
        }
    }

    $path = array();
    $currentNode = $end;

    while ($currentNode !== null) {
        $path[] = $currentNode;
        $currentNode = $previous[$currentNode];
    }

    $path = array_reverse($path);

    return $path;
}

// Graf verisini kullanarak Dijkstra algoritmasını uygulayabilirsiniz
//$start = 28; // Başlangıç şehri ID'si
//$end = 34; // Hedef şehri ID'si
$shortestDistance = dijkstra($graph, $start, $end); //hedef şehre gidene kadar ki hamle sayısı
$shortestPath = getShortestPath($graph, $start, $end); //şehirler id li

if ($result->num_rows > 0) {
    foreach ($shortestPath as $index => $plate) {
        $result->data_seek(0);
        while ($row = $result->fetch_assoc()) {
            $sehir_id = $row['sehir_id'];
            $sehir_isim = $row["sehir_isim"];
            if ($plate == $sehir_id) {
                $shortestPath[$index] = $sehir_isim;
            }
        }
    }
}

header('Content-Type: application/json');
echo json_encode($shortestPath);
