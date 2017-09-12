<?php
	/*
		This class is for pagination
	*/ 
	
	@include_once("CMessage.php");
	
	class CPaging
	{
		var $m_PageLimit = 10;				// Number of records per page 
		var $m_TotalPages = 0;				// Total number of Pages
		var $m_CurrentPage = 1;				// Current page Id
		var $m_NumberOfRecords = 0;			// Number of Records from database
		var $m_RecordSet = NULL;			// Storing Resultset from database 
		var $m_HaveNext = true;				// Specify Last Page
		var $m_HavePrevious = true;			// Specify fist Page
		
		var $m_PageStartIndex = 0;			// First page index
		var $m_PageEndIndex = 0;			// Last Page Index
		
		var $m_FirstRecordId = 0;			//First record Id of each page
		var $m_LastRecordId = 0;			//Last record Id of each page
		
		var $m_Query = NULL;				// Query variable
		
		var $c_Conn		= NULL;				// Connection object to do database operations
		var $c_Message	= NULL;				// Message Object
		
		function __construct($conn) 
		{
			$this->c_Conn = $conn;
			$this->c_Message = new CMessage();
		}
		
		//-------------------------------------------------------------------------------
		//Find Number of Records and get result
		//--------------------------------------------------------------------------------
		function Configure($Query)
		{	
			try
			{	
				$this->m_Query = $Query;
				
				//Call GetQuery(false) function for Calculate number of records				
				$this->m_Query = $this->GetQuery(false);
				if($this->CheckConnection())
				{
					if( $this->c_Conn->Connect() )
					{
						$Result = $this->c_Conn->GetRecordSet($this->m_Query);
						
						//Set Number Of Records
						$this->m_NumberOfRecords = mysqli_num_rows($Result);
						
						//Calculate number of Pages
						$this->m_TotalPages = ceil( $this->m_NumberOfRecords / $this->m_PageLimit );      
						if($this->m_TotalPages == 0) $this->m_TotalPages = (int)1;
						return true;
					}	
					else
					{
						// CONNECTION FAILURE
						$this->c_Message->SetMessage(1);
						return FALSE;
					}// End Of if( $this->c_Conn->Connect() )
				}
				else
				{
					// CONNECTION FAILURE
					$this->c_Message->SetMessage(1);
					return FALSE;
				}	// End of if($this->CheckConnection())
			}
			catch(Exception $ex)
			{
				$this->c_Message->SetMessage(4);
			}		
		} // End of function SetQuery($Query)
		
		
		//-------------------------------------------------------------------------------
		//Calculate pages
		//--------------------------------------------------------------------------------	
		function GetResultSet($PageIndex)
		{
			try
			{	
				$this->m_CurrentPage = $PageIndex;
			
				//if $this->Currentpage = Fist page then hide the previous link
				if($this->m_CurrentPage == 1 ) 
				{
					$this->m_HavePrevious = false;
				}
				else 
				{
					$this->m_HavePrevious = true;
				}
		
				//Calculate PageStartIndex and PageEndIndex
				$this->m_PageStartIndex = $this->m_CurrentPage - 3;
				$this->m_PageEndIndex   = $this->m_CurrentPage + 3;
				if( $this->m_PageStartIndex < 1 ) $this->m_PageStartIndex = 1;
				if( $this->m_PageEndIndex > $this->m_TotalPages ) $this->m_PageEndIndex = $this->m_TotalPages;
			
				//if $this->Currentpage = Last page then hide the next link
				if( $this->m_CurrentPage == $this->m_TotalPages ) 
				{
					$this->m_HaveNext = false;
				}
				else 
				{
					$this->m_HaveNext = true;
				}
			
				//Set First and Last Record Id of each page
				$this->m_FirstRecordId = ($this->m_CurrentPage - 1) * $this->m_PageLimit +1;
				$this->m_LastRecordId = ($this->m_CurrentPage) * ($this->m_PageLimit);
				if(	$this->m_LastRecordId > $this->m_NumberOfRecords) $this->m_LastRecordId = $this->m_NumberOfRecords;
					
				//Call GetQuery(true) function for get Records
				return $this->c_Conn->GetRecordSet($this->GetQuery(true));
			}
			catch(Exception $ex)
			{
				$this->c_Message->SetMessage(4);
			}	
		}	// End of function GetResultSet($PageIndex)
		
		//----------------------------------------------------------------------------
		//Function for built query
		//-----------------------------------------------------------------------------
		private function GetQuery($WithOutLimit)
		{
			try
			{
				$BuiltQuery = "";
                //lp
                /*$LimitStart=0;
                if($this->m_CurrentPage>1)
                   $LimitStart=strval(($this->m_CurrentPage - 1) * $this->m_PageLimit);*/
                
				//Return Query With out LIMIT
				if(!$WithOutLimit)
				{
					$LimitPos = strrpos($this->m_Query,"LIMIT");
					if($LimitPos > 0)
					{
						$BuiltQuery = substr($this->m_Query, 0, $LimitPos );
					}
					else if($LimitPos === false)
					{
						$BuiltQuery = $this->m_Query;						
					}
				}
				//Return Query With  LIMIT
				else if($WithOutLimit)
				{
					$BuiltQuery	= $this->m_Query . " LIMIT " . strval(($this->m_CurrentPage - 1) * $this->m_PageLimit) . " , " . $this->m_PageLimit;
				}
				return $BuiltQuery;
			}
			catch(Exception $ex)
			{
				$this->c_Message->SetMessage(4);
			}	
		}	
				
		//----------------------------------------------------------------------
		// Check Connection. Return TRUE if connection is set unless returns FALSE
		//----------------------------------------------------------------------
		function CheckConnection()
		{
			try 
			{
				if(isset($this->c_Conn)) 
				{
					return TRUE;
				}	
				else 
				{
					// CONNECTION FAILURE
					$this->c_Message->SetMessage(1);
					return FALSE;
				} // end of if(isset($this->c_Conn)) 				
			}	
			catch(Exception $ex) 
			{
				// CONNECTION FAILURE
				$this->c_Message->SetMessage(1);
				return FALSE;
			}
		}	// end of CheckConnection()

		//----------------------------------------------------------------------
		// Return current message of the class 
		//----------------------------------------------------------------------
		function GetMessage()
		{
			return $this->c_Message;
		} // end of function GetMessage()
	
	}


?>