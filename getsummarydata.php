<?php

include('connection.php');

if ( !$con) {
    echo 'Koneksi gagal';
    return;
}

$query = "
    SELECT 
        ROUND(MAX(suhu), 0) AS suhu_max, 
        ROUND(MIN(suhu), 0) AS suhu_min, 
        ROUND(AVG(suhu), 2) AS suhu_rata
    FROM tb_hydroponic
";
$result = mysqli_query($con, $query);

if (mysqli_num_rows($result) > 0) {
    while ($rows = mysqli_fetch_assoc($result)) {
        $arr = array(
            "suhu_max"  => $rows['suhu_max'],
            "suhu_min"  => $rows['suhu_min'],
            "suhu_rata" => $rows['suhu_rata'],
        );
    }

    $arr['nilai_suhu_max_humid_max'] = array();

    $query_data = "SELECT id, suhu, humid, lux, ts FROM tb_hydroponic";
    $result_data = mysqli_query($con, $query_data);

    if (mysqli_num_rows($result_data) > 0) {
        $index = 0;
        while ($row = mysqli_fetch_assoc($result_data)) {
            $arr['nilai_suhu_max_humid_max'][] = array(
                "idx" => $row['id'],
                "suhu" => round($row['suhu'], 0),
                "humid" => round($row['humid'], 0),
                "kecerahan" => $row['lux'],
                "timestamp" => $row['ts']
            );
            $index++;
        }
    }

    $arr['month_year_max'] = array();
    $query_month_year = "SELECT DISTINCT CONCAT(MONTH(ts), '-', YEAR(ts)) AS month_year FROM tb_hydroponic";
    $result_month_year = mysqli_query($con, $query_month_year);

    if (mysqli_num_rows($result_month_year) > 0) {
        while ($row = mysqli_fetch_assoc($result_month_year)) {
            $arr['month_year_max'][] = array(
                "month_year" => $row['month_year']
            );
        }
    }

    echo json_encode($arr, JSON_PRETTY_PRINT);
}
else {
    echo 'Tidak ada data';
}

?>