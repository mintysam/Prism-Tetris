<?php
session_start();
@require_once './common/CCommon.php';
$wFlagErr = false;
$CCommon = new CCommon();

$ret = array();
if (trim($_POST['txtUser'])=="" or trim($_POST['txtEmail'])=="" or !isset($_POST['hdnTime']) or !isset($_GET['lines']) or !isset($_GET['level']) or !isset($_GET['score'])) ://If not logged in
    die("Not a valid entry");
endif;
//If there is no error then save details
    $CConnection = $CCommon->mfnGetDBObj();
    $CCommon->mfnSanitizeVars();
    $CCommon->mfnAddQuotesToVars("A");//All

    $lStrSql = "INSERT INTO tbl_tetris
                    (
                        tet_name, tet_email, tet_lines, tet_level, 
                        tet_score, tet_time, tet_date_time
                    )
                    VALUES
                    ("
        . $_POST['txtUser'] . "," . $_POST['txtEmail'] . "," . $_GET['lines'] . "," . $_GET['level'] . ","
        . $_GET['score'] . "," . $_POST['hdnTime'] . "," . $CCommon->mfnAddQuotes(date("Y-m-d h:i:s"))
        . " )";
    $result = $CConnection->ExecuteQuery($lStrSql);
if ($result) :
    echo "Request completed successfully.";
    exit();
else ://Add or update failed for user
        echo "Unable to complete your request. <br /> Please try after sometime.";
        // echo $lStrSql;
        exit();
endif;
