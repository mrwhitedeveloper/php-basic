<?php
//include("config.php"); 
date_default_timezone_set('Asia/Kolkata');

define("db_host", "localhost");
define("db_name", "sample");
define("db_user", "root");
define("db_password", "");

function esc($string)
{
    return str_replace("'", "\'", $string);
}
function select($query)
{
    $con = mysqli_connect(db_host, db_user, db_password, db_name);
    $result = array();

    if (mysqli_connect_errno()) {
        return $result;
    } else {
        $sel = mysqli_query($con, $query);

        while ($row = mysqli_fetch_assoc($sel)) {
            $result[] = $row;
        }
        mysqli_close($con);
        return $result;
    }

}
function column($query)
{
    $con = mysqli_connect(db_host, db_user, db_password, db_name);
    $result = "";
    if (mysqli_connect_errno()) {
        $result = "";
    } else {
        $sel = mysqli_query($con, $query);
        // print_r($con);
        $records = mysqli_fetch_row($sel);
        $result = $records[0];
    }
    return $result;
}

function query($query)
{
    $con = mysqli_connect(db_host, db_user, db_password, db_name);
    $result = array();
    if (mysqli_connect_errno()) {
        $response["code"] = 0;
        $response["message"] = "Connection error";
    } else {
        if ($con->query($query) === true) {
            $response["code"] = 1;
            $response["message"] = "successfully completed";
        } else {
            $response["code"] = 2;
            $response["message"] = mysqli_error($con);
        }
    }   
    
    mysqli_close($con);
    header('Content-Type: application/json');
    echo json_encode($response);
}
function singleRow($sql)
{
    $con = mysqli_connect(db_host, db_user, db_password, db_name);
    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

    $single_result = mysqli_query($con, $sql);
    $single_row = mysqli_fetch_assoc($single_result);
    $response=$single_row;
    mysqli_close($con);
    header('Content-Type: application/json');
    echo json_encode($response);
}
function download($name)
{
    header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Content-Type: application/force-download");
    header("Content-Type: application/octet-stream");
    header("Content-Type: application/download");
    header("Content-Disposition: attachment;filename=" . $name);
    header("Content-Transfer-Encoding: binary ");
}
