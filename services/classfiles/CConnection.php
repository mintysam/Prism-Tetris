<?php

@include_once("CMessage.php");

class CConnection {

    var $m_ServerName = "";
    var $m_DatabaseName = "";
    var $m_UserName = "";
    var $m_Password = "";
    var $c_ConnectStat = NULL;
    var $c_Message = NULL;
    var $AutoIncrementId = 0;
    var $AffectedRows = 0;

    function __construct() {
        $this->c_Message = new CMessage();
    }

    // Function to set the database server details
    function Configure($ServerName, $DatabaseName, $UserName, $Password) {
        $this->m_ServerName = $ServerName;
        $this->m_DatabaseName = $DatabaseName;
        $this->m_UserName = $UserName;
        $this->m_Password = $Password;
    }

    // Function to connect to the database server
    // Returns TRUE if connected successfully
    // Otherwise returns FALSE
    function Connect() {
        try {
            $this->c_ConnectStat = mysqli_connect($this->m_ServerName, $this->m_UserName, $this->m_Password, $this->m_DatabaseName) or die(mysqli_error($this->m_ConnectStat));

            if (!$this->c_ConnectStat) {
                // CONNECTION FAILURE
                $this->c_Message->SetMessage(1);
                return false;
            } else {
                mysqli_set_charset($this->c_ConnectStat, "utf8");
                return true;
            }
        } catch (Exception $ex) {
            return false;
        }
    }

    // Close existing connection
    function Close() {
        try {
            if ($this->c_ConnectStat) {
                @mysqli_close($this->c_ConnectStat);
            }
        } catch (Exception $ex) {
            
        }
    }

    // Excuting query
    function ExecuteQuery($query) {
        try {

            $result = @mysqli_query($this->c_ConnectStat, $query);
            $this->AutoIncrementId = mysqli_insert_id($this->c_ConnectStat);
            $this->AffectedRows = mysqli_affected_rows($this->c_ConnectStat);
            $query = "";

            // checking the result of the execution
            //if( $this->AutoIncrementId==0 and $this->AffectedRows==0 ) {
            if (!$result) {
                // DB QUERY ERROR
                $this->c_Message->SetMessage(4);
                return false;
            } else {
                // DB QUERY EXECUTED
                $this->c_Message->SetMessage(5);
                return true;
            }
        } catch (Exception $ex) {
            return false;
        }
    }

    // Executing SELECT query and returns recordset if executed successfully else returns FALSE
    function GetRecordSet($query) {
        try {
            $ResultSet = @mysqli_query($this->c_ConnectStat, $query); //or die(mysqli_error($this->c_ConnectStat));
            // checking the result of the execution
            if (mysqli_errno($this->c_ConnectStat)) {
                // DB QUERY ERROR
                $this->c_Message->SetMessage(4);
                return false;
            } else {
                // DB QUERY EXECUTED
                $this->c_Message->SetMessage(5);
                return $ResultSet;
            }
        } catch (Exception $ex) {
            return false;
        }
    }

    // Executing and returning first cell result
    function ExecuteScalar($query) {
        try {
            $result = $this->GetRecordSet($query);

            while ($recordSetRow = mysqli_fetch_array($result)) {
                // DB QUERY EXECUTED
                $this->c_Message->SetMessage(5);
                return $recordSetRow[0];
                break;
            }
        } catch (Exception $ex) {
            // DB QUERY ERROR
            $this->c_Message->SetMessage(4);
            return false;
        }
    }

    // Begin a new transaction on server
    function BeginTransaction() {
        @mysqli_query($this->c_ConnectStat, "BEGIN");
        $this->c_Message->SetMessage(6);
    }

    // Commit a transaction
    function CommitTransaction() {
        @mysqli_query($this->c_ConnectStat, "COMMIT");
        $this->c_Message->SetMessage(7);
    }

    // Roll back a trasaction
    function RollbackTransaction() {
        @mysqli_query($this->c_ConnectStat, "ROLLBACK");
        $this->c_Message->SetMessage(7);
    }

    // This will execute a series of queries and will perform COMMIT and ROLLBACK automatically
    function ExecuteTransaction($queryList) {
        try {
            @mysqli_query($this->c_ConnectStat, "SET AUTOCOMMIT=0");
            for ($i = 0; $i < count($queryList); $i++) {
                if ($i == 0) {
                    // DB TRANS BEGIN
                    $this->BeginTransaction();
                }
                if (!$this->ExecuteQuery($queryList[$i])) {
                    // DB TRANS ROLLBACK
                    $this->RollbackTransaction();
                    return false;
                }
            }
            // DB TRANS COMMIT
            $this->CommitTransaction();
            @mysqli_query($this->c_ConnectStat, "SET AUTOCOMMIT=1");
            return true;
        } catch (Exception $ex) {
            // DB TRANS ROLLBACK
            $this->RollbackTransaction();
            @mysqli_query($this->c_ConnectStat, "SET AUTOCOMMIT=1");
            return false;
        }
    }

    //Get the Identity ID(AUTO_INCREMENT ID)
    function GetAutoIncrementId() {
        // Returns the value generated for an AUTO_INCREMENT column by the previous INSERT
        return mysqli_insert_id($this->c_ConnectStat);
    }

    // Return current message of the class
    function GetMessage() {
        return $this->c_Message;
    }

}

?>