<?php

/**
 * @description Project specific functions. Contains functions that are very much specific to the  current project
 * @author Lijoy Joseph
 */
class CPrjFunctions
{

    function __construct()
    {

    }

    /**
     * @description This function checks if the admin is logged in before any operation.
     */
    public function mfnIsSessionActive($type = "M")
    {
        switch ($type) {
            case "M":
                if ($_SESSION['UTYPE'] != "M"):
                    return FALSE;
                else:
                    return TRUE;
                endif;
                break;
            case "U":
                if ($_SESSION['UTYPE'] != "U"):
                    return FALSE;
                else:
                    return TRUE;
                endif;
                break;
            case "S":
                if ($_SESSION['UTYPE'] != "S"):
                    return FALSE;
                else:
                    return TRUE;
                endif;
                break;
            case "A":
                if ($_SESSION['UTYPE'] != "A"):
                    return FALSE;
                else:
                    return TRUE;
                endif;
                break;
            case "C":
                if ($_SESSION['UTYPE'] != "C"):
                    return FALSE;
                else:
                    return TRUE;
                endif;
                break;
            case "MS":
                if ($_SESSION['UTYPE'] != "MS"):
                    return FALSE;
                else:
                    return TRUE;
                endif;
                break;
            case "CD":
                if ($_SESSION['UTYPE'] != "CD"):
                    return FALSE;
                else:
                    return TRUE;
                endif;
                break;
        }
    }

    /**
     * This function returns the availability of username
     * @param $USRNAME Username
     * @param $CCommon Common class
     * @return boolean
     */

    public function mfnChkUserAvailability($USRNAME, $USER_TYPE, &$CCommon)
    {
        if ($USRNAME == NULL OR $USER_TYPE == NULL)
            return FALSE;
        $CConnection = $CCommon->mfnGetDBObj();
        $sql = "SELECT usr_uname FROM tbl_user WHERE usr_uname = $USRNAME AND usr_type = $USER_TYPE LIMIT 1";
        $USRNAME = $CConnection->ExecuteScalar($sql);
        return (!$USRNAME) ? TRUE : FALSE;
    }

    /**
     * This function returns if a job number is already in the database
     * @param $JOBID jobid
     * @param $CCommon Common class
     * @return boolean
     */

    public function mfnChkJobNumberAvailable($JOBID, &$CCommon)
    {
        if ($JOBID == NULL OR $JOBID == "")
            return FALSE;
        $CConnection = $CCommon->mfnGetDBObj();
        $sql = "SELECT jb_id FROM tbl_job WHERE jb_id = '$JOBID' LIMIT 1";
        $RETURN = $CConnection->ExecuteScalar($sql);
        return (!$RETURN) ? TRUE : FALSE;
    }

    /**
     * This function checks if secret password is right or wrong
     * @param $UID Management ID
     * @param $PASS Password
     * @param $CCommon Common class
     * @return boolean
     */

    public function mfnChkSecretPass($UID, $PASS, &$CCommon)
    {
        if ($UID == NULL OR $UID == "")
            return FALSE;
        $CConnection = $CCommon->mfnGetDBObj();
        $sql = "SELECT usr_id FROM tbl_user WHERE usr_id = '$UID' AND usr_spcl_pass='" . md5($PASS) . "' LIMIT 1";
        $RETURN = $CConnection->ExecuteScalar($sql);
        return ($RETURN) ? TRUE : FALSE;
    }

    /**
     * This function returns boolean value depending if invoiced or not
     * @param $JOBID jobid
     * @param $CCommon Common class
     * @return boolean
     */

    public function mfnIsJobInvoiced($JOBID, &$CCommon)
    {
        if ($JOBID == NULL OR $JOBID == "")
            return FALSE;
        $CConnection = $CCommon->mfnGetDBObj();
        $sql = "SELECT inj_job_id FROM tbl_invoice_jobs WHERE inj_job_id = '$JOBID' AND inj_response = 1  LIMIT 1";
        $RETURN = $CConnection->ExecuteScalar($sql);
        return ($RETURN) ? TRUE : FALSE;
    }

    /**
     * This function check if a job is already send to invoice
     * @param $JOBID Job Id
     * @param $CCommon Common class
     * @return boolean
     */

    public function mfnJobIsInvoiced($JOBID, &$CCommon)
    {
        if ($JOBID == NULL)
            return TRUE;
        $CConnection = $CCommon->mfnGetDBObj();
        $sql = "SELECT inj_id FROM tbl_invoice_jobs WHERE inj_job_id = '$JOBID' LIMIT 1";
        $RETURN_VAL = $CConnection->ExecuteScalar($sql);
        return ($RETURN_VAL) ? TRUE : FALSE;
    }

    /**
     * This function returns the status of the job
     * @param $JOBID jobid
     * @param $CCommon Common class
     * @return "C" Closed, "O" Opened
     */

    public function mfnChkJobStatus($JOBID, &$CCommon)
    {
        if ($JOBID == NULL OR $JOBID == "")
            return "C";
        $CConnection = $CCommon->mfnGetDBObj();
        $sql = "SELECT jb_id FROM tbl_job WHERE jb_id = '$JOBID' AND jb_closed = 0  LIMIT 1";
        $RETURN = $CConnection->ExecuteScalar($sql);
        return ($RETURN) ? "O" : "C";
    }

    /**
     * This function returns the progress names
     * @param $progress
     * @return progress string
     */

    public function mfnGetJobProgress($progress)
    {
        switch ($progress) {
            case "IP":
                $return = "In Progress (ATR)";
                break;
            case "IPC":
                $return = "In Progress (CTR)";
                break;
            case "OH":
                $return = "On Hold";
                break;
            case "CC":
                $return = "Cancelled";
                break;
            case "CP":
                $return = "Completed";
                break;
            case "FOC":
                $return = "Free of Charge";
                break;
            case "PTH":
                $return = "Pitch";
                break;
            default:
                $return = "Not Set";
                break;
        }
        return $return;
    }

    /**
     * This function returns the list of progress
     * @return progress array
     */

    public function mfnGetJobProgressList()
    {
        return array(
            "IP" => "In Progress (ATR)",
            "IPC" => "In Progress (CTR)",
            "OH" => "On Hold",
            "CC" => "Cancelled",
            "CP" => "Completed",
            "FOC" => "Free of Charge",
            "PTH" => "Pitch",
        );
    }

    /**
     * This function returns the availability of username
     * @param $USRNAME Client Name
     * @param $CCommon Common class
     * @return boolean
     */

    public function mfnChkClientAvailability($CLNTNAME, &$CCommon)
    {
        if ($CLNTNAME == NULL)
            return FALSE;
        $CConnection = $CCommon->mfnGetDBObj();
        $sql = "SELECT clnt_name FROM tbl_client WHERE clnt_name = $CLNTNAME LIMIT 1";
        $CLNTNAME = $CConnection->ExecuteScalar($sql);
        return (!$CLNTNAME) ? TRUE : FALSE;
    }

    /**
     * This function check if a specified client is used to add job.
     * @param $CLNTID Client ID
     * @param $CCommon Common class
     * @return boolean
     */

    public function mfnIsClientUsed($CLNTID, &$CCommon)
    {
        if ($CLNTID == NULL)
            return TRUE;
        $CConnection = $CCommon->mfnGetDBObj();
        $sql = "SELECT clnt_id FROM tbl_job WHERE clnt_id = '$CLNTID' LIMIT 1";
        $CLNT = $CConnection->ExecuteScalar($sql);
        return ($CLNT) ? TRUE : FALSE;
    }

    /**
     * This function returns list of client service people list
     * @param $CCommon Common class
     * @param $byGroup Boolean
     * @return Array of all the client servicing people with their ID being the key if $byGroup is false; else returns an array containing all the rows as arrays
     */

    public function mfnGetClientServiceList(&$CCommon, $byGroup = false)
    {
        $CLIENT_LIST = array();
        $CConnection = $CCommon->mfnGetDBObj();
        $SQL = "SELECT usr_id, usr_name, grp_name FROM tbl_user
                LEFT JOIN tbl_user_group ON tbl_user.grp_id = tbl_user_group.grp_id
                WHERE usr_active = 1 AND usr_type='S'AND tbl_user.grp_id IS NOT NULL
                ORDER BY tbl_user.grp_id, usr_uname ";
        $CLNT_RSLT = $CConnection->GetRecordSet($SQL);
        if ($byGroup == false):
            while ($OBJ = mysqli_fetch_object($CLNT_RSLT)):
                $CLIENT_LIST[$OBJ->usr_id] = $OBJ->usr_name;
            endwhile;
            return $CLIENT_LIST;
        else:
            while ($OBJ = mysqli_fetch_object($CLNT_RSLT)):
                $CLIENT_LIST[] = array('usr_id' => $OBJ->usr_id, 'usr_name' => $OBJ->usr_name, 'grp_name' => $OBJ->grp_name);
            endwhile;
            return $CLIENT_LIST;
        endif;
    }

    /**
     * This function check if a specified brand is used to add job.
     * @param $BRNDID Client ID
     * @param $CCommon Common class
     * @return boolean
     */

    public function mfnIsBrandUsed($BRNDID, &$CCommon)
    {
        if ($BRNDID == NULL)
            return TRUE;
        $CConnection = $CCommon->mfnGetDBObj();
        $sql = "SELECT brnd_id FROM tbl_job WHERE brnd_id = '$BRNDID' LIMIT 1";
        $BRND = $CConnection->ExecuteScalar($sql);
        return ($BRND) ? TRUE : FALSE;
    }

    /**
     * This function returns the availability of username
     * @param $BRND_NAME Brand Name
     * @param $CLNT_ID Client ID
     * @param $CCommon Common class
     * @return boolean
     */

    public function mfnChkBrandAvailability($BRND_NAME, $CLNT_ID, &$CCommon)
    {
        if ($BRND_NAME == NULL OR $CLNT_ID == NULL)
            return FALSE;
        $CConnection = $CCommon->mfnGetDBObj();
        $sql = "SELECT brnd_name FROM tbl_brand WHERE brnd_name = $BRND_NAME AND clnt_id = $CLNT_ID LIMIT 1";
        $BRND_NAME = $CConnection->ExecuteScalar($sql);
        return (!$BRND_NAME) ? TRUE : FALSE;
    }

    /**
     * This function check if a user has permission for a job
     * @param $JOBID Job Id
     * @param $USERID User Id
     * @param $CCommon Common class
     * @param $GID Group Id
     * @return boolean
     */
    public function mfnChkJobPermission($JOBID, $USERID, &$CCommon, $GID = null)
    {
        //@FIX THIS FUNCTION
        if ($JOBID == null)
            return FALSE;
        $CConnection = $CCommon->mfnGetDBObj();

//        $sql = "SELECT jb_creator_id FROM tbl_job WHERE jb_id = '$JOBID' AND jb_creator_id = '$USERID' LIMIT 1";
//        $RETURN_VAL = $CConnection->ExecuteScalar($sql);
//        if($RETURN_VAL){ return TRUE; }

        $sql = "SELECT usr_id FROM tbl_user USR WHERE USR.usr_id = '$USERID' AND USR.grp_id IN ((SELECT grp_id FROM tbl_user WHERE usr_id IN (SELECT jb_creator_id FROM tbl_job WHERE jb_id = '$JOBID') )) ";
        $USER = $CConnection->ExecuteScalar($sql);
        return ($USER) ? TRUE : FALSE;
    }

    /**
     * This function check if a normal user is assigned to a job
     * @param $JOBID Job Id
     * @param $USERID User Id
     * @param $CCommon Common class
     * @return boolean
     */
    public function mfnChkUserAssigned($JOBID, $USERID, &$CCommon)
    {
        //@FIX THIS FUNCTION
        if ($JOBID == null OR $USERID == null)
            return FALSE;
        $CConnection = $CCommon->mfnGetDBObj();

        $sql = "SELECT usr_id FROM tbl_job_assigned WHERE jb_id = '$JOBID' AND usr_id = '$USERID' LIMIT 1";
        $RETURN_VAL = $CConnection->ExecuteScalar($sql);
        return ($RETURN_VAL) ? TRUE : FALSE;
    }


    /**
     * This function returns the group member ids with the provided separater.
     * @param $UID integer User Id
     * @param string $SEP
     * @return string
     */

    public function mfnGetGroupMembers($UID, &$CCommon, $SEP = ",")
    {
        if ($UID == NULL)
            return "";
        $CConnection = $CCommon->mfnGetDBObj();
        $sql = "SELECT GROUP_CONCAT(usr_id SEPARATOR '$SEP') FROM tbl_user WHERE grp_id = (SELECT USR.grp_id FROM tbl_user USR WHERE USR.usr_id = '$UID')";
        $RETURN_VAL = $CConnection->ExecuteScalar($sql);
        return $RETURN_VAL;
    }

    /**
     * This function check if a job is already locked
     * @param $JOBID Job Id
     * @param $CCommon Common class
     * @return boolean
     */

    public function mfnIsJobBillMonthLocked($JOBID, &$CCommon)
    {
        if ($JOBID == NULL)
            return TRUE;
        $CConnection = $CCommon->mfnGetDBObj();
        $sql = "SELECT jh_bill_month_locked FROM tbl_job_helper WHERE jh_jb_id = '$JOBID' LIMIT 1";
        $RETURN_VAL = $CConnection->ExecuteScalar($sql);
        return ($RETURN_VAL == "1") ? TRUE : FALSE;
    }

    /**
     * This function returns the id of the servicing person who assigned $JOBID to the $USERID
     * @param $JOBID Job Id
     * @param $USERID User Id Id
     * @param $CCommon Common class
     * @return Assigned person ID or FALSE
     */

    public function mfnUsrJobAssignedID($JOBID, $USERID, &$CCommon)
    {
        if ($JOBID == NULL OR $USERID == NULL)
            return TRUE;
        $CConnection = $CCommon->mfnGetDBObj();
        $sql = "SELECT usr_id_ass FROM tbl_job_assigned WHERE usr_id = '$USERID' AND jb_id='$JOBID' LIMIT 1";
        $RETURN_VAL = $CConnection->ExecuteScalar($sql);
        return ($RETURN_VAL) ? $RETURN_VAL : FALSE;
    }

    /**
     * This function checks if a proposal is already in the database
     * @param $PROPID Proposal Number
     * @param $CCommon Common class
     * @return boolean
     */

    public function mfnChkProposalAvailable($PROPID, &$CCommon)
    {
        if ($PROPID == NULL OR $PROPID == "")
            return FALSE;
        $CConnection = $CCommon->mfnGetDBObj();
        $sql = "SELECT ppsl_number FROM tbl_proposal WHERE ppsl_number = '$PROPID' LIMIT 1";
        $RETURN = $CConnection->ExecuteScalar($sql);
        return (!$RETURN) ? TRUE : FALSE;
    }

    /**
     * This function check if a user has permission for a quote
     * @param $QID Job Id
     * @param $USERID User Id
     * @param $CCommon Common class
     * @return boolean
     */

    public function mfnChkQuotePermission($QID, $USERID, &$CCommon)
    {
        if ($QID == NULL)
            return FALSE;
        $CConnection = $CCommon->mfnGetDBObj();
        $sql = "SELECT ppsl_number FROM tbl_proposal WHERE ppsl_id = '$QID' AND ppsl_creator_id = '$USERID' LIMIT 1";
        $RETURN_VAL = $CConnection->ExecuteScalar($sql);
        return ($RETURN_VAL) ? TRUE : FALSE;
    }

    /**
     * To check if the admin has entered the right secret password
     * @param int $UID
     * @param string $PASS
     * @param object $CCommon
     * @return boolean
     */
    public function mfnCheckAdminSpclPassAuth($UID = NULL, $PASS = NULL, &$CCommon = NULL)
    {
        if ($UID == NULL OR $PASS == NULL OR $CCommon == NULL)
            return FALSE;
        $CConnection = $CCommon->mfnGetDBObj();
        $sql = "SELECT usr_id FROM tbl_user WHERE usr_id = '$UID' AND usr_spcl_pass = '$PASS' LIMIT 1";
        $RETURN_VAL = $CConnection->ExecuteScalar($sql);
        return ($RETURN_VAL) ? TRUE : FALSE;
    }

    /**
     * Format and returns po number
     * @param type $DATE Date
     * @param type $ID Inward cost ID
     */
    public function mfnFormatPO($DATE, $ID)
    {
        return ($DATE == "" OR $ID == "") ? FALSE : substr($DATE, 5, 2) . "/" . substr($DATE, 2, 2) . "/" . $ID;
    }

    /**
     * Returns PO number
     * @param type $JID
     * @param type $CCommon
     * @return Formatted po number
     */
    public function mfnMakePONumber($JID, &$CCommon = NULL)
    {
        if ($JID == NULL OR $CCommon == NULL)
            return FALSE;
        $CConnection = $CCommon->mfnGetDBObj();
        $sql = "SELECT COUNT(ic_id) FROM tbl_inward_cost WHERE ic_job_id = '$JID'";
        $VAL = $CConnection->ExecuteScalar($sql);
        if ($VAL > 0) {
            $sql = "SELECT RIGHT(ic_po_number, 1) AS mychar FROM tbl_inward_cost WHERE ic_job_id = '$JID' ORDER BY ic_id DESC";
            $myChar = $CConnection->ExecuteScalar($sql);
            $array = range('A', 'Z');
            $VAL = array_search($myChar, $array) + 1;
        }
        return $JID . $this->mfnGetAlphabet($VAL);
    }

    /**
     * Returns alphabet according to the variable
     * @param type $NO
     * @return type
     */
    public function mfnGetAlphabet($NO = 0)
    {
        $array = range('A', 'Z');
        return $array[$NO];
    }

    /**
     * Returns Boolean
     * @param type $JID
     * @param type $USER
     * @param type $CCommon
     * @return Boolean if needs to be blocked
     */
    public function mfnNeedToBlock($JID, $USER, &$CCommon = NULL)
    {
        if ($JID == NULL OR $USER == NULL OR $CCommon == NULL)
            return FALSE;
        $ARR_BLOCKED_JOBS = array(
            20895, 20894, 20850, 20844, 20841,
            20837, 20818, 20809, 20807, 20781,
            20722, 20710, 20679, 20665, 20659,
            20646
        );
        //TANSH
        if ($USER == "30"):
            if (in_array($JID, $ARR_BLOCKED_JOBS) == true):
                return true;
            else:
                return false;
            endif;
        endif;
    }

}

?>
