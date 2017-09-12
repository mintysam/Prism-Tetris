<?php
session_start();
@require_once './common/CCommon.php';
$wFlagErr = false;
$CCommon = new CCommon();
$CPrjFunctions = $CCommon->mfnGetPrjClass();
$ret = array();
if (!isset($_GET['A']) or !isset($_GET['B']) or !isset($_GET['C'])) ://If not logged in
    die("Not a valid request");
endif;
$PageNo = $_POST["hdnPopMsgPgno"];
if ($PageNo == ""):
    $PageNo = 1;
endif;
$StrSearchQuery = "SELECT DISTINCT tet_name, tet_lines, tet_level, tet_score, tet_time FROM tbl_tetris WHERE tet_lines >= 6 ORDER BY tet_score DESC, tet_time ASC";
$CPaging = $CCommon->mfnGetPagingClass();
$CPaging->m_PageLimit = 10;
$CPaging->Configure($StrSearchQuery);
$ResultPaging = $CPaging->GetResultSet($PageNo);
$NoOfRecords = $CPaging->m_NumberOfRecords;
$recordTo = $CPaging->m_LastRecordId;
$Pagination = '';
if ($CPaging->m_HavePrevious == false) {
//    $Pagination .='<a href="javascript:void(0);
} else {
    $Pagination .='<a href="javascript:void(0);
    " onclick="javascript:return fnSearchMsgList(' . strval($CPaging->m_CurrentPage - 1) . ');
    ">&lt;</a>&nbsp;';
}
for ($i = $CPaging->m_PageStartIndex; $i < $CPaging->m_PageEndIndex + 1; $i++) {
    if ($i == $CPaging->m_CurrentPage) {
        $Pagination .= '<a href="javascript:void(0);  " class="active" >' . $i . '</a>&nbsp;';
    } else {
        $Pagination .= '<a href="javascript:void(0); " onclick="javascript:return fnSearchMsgList(' . $i . '); ">' . $i . '</a>&nbsp;';
    }
}
if ($CPaging->m_HaveNext == FALSE) {
//    $Pagination .='<a href="javascript:void(0);
} else {
    $Pagination .='<a href="javascript:void(0);
    " onclick="javascript:return fnSearchMsgList(' . strval($CPaging->m_CurrentPage + 1) . ');
    ">&gt;</a>&nbsp;';
}
$items .= '<table width="80%" align="center" border="0" cellspacing="5" cellpadding="5" class="tblRsltCover">';
$slno = $CPaging->m_FirstRecordId;
$cnt = 1;
while ($record = @mysqli_fetch_object($ResultPaging)) {
    $items .= '
                <tr">
                    <td width="11%" align="center">' . $cnt . ' </td>
                    <td width="57%" align="left">' . $record->tet_name . '</td>                 
                    <td width="15%" align="center">' . $record->tet_score . '</td>                 
                    <td width="17%" align="center">' . $record->tet_time . '</td>                 
                </tr>
    ';
    $slno++;
    $cnt++;
}
$items .= '</table>';
if ($NoOfRecords <= 0) {
    /*
     * IF NO RECORDS FOUND DISPLAY MESSAGE
     */
    echo '<table width="100%"  border="0" cellpadding="5" cellspacing="0" >
            <tr>
                <td align="center">No records available at the moment.</td>
            </tr>
         </table>';
         exit();
} else {
    /*
     * PRINT THE RECORDS IF FOUND
     */
    echo $items;
    exit();
}
?>
