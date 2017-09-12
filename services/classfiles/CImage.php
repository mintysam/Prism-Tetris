<?php

class CImage
{
    var $m_RootFolder	=	"";	// "/images/photo"
    var $m_ImagePath	=	"";
    var $m_Width 		= 	0;
    var $m_height		= 	0;
    var $m_type 		= 	0;
    var $m_attr 		= 	0;

    var $m_rootpathprefix	= 	'../../';


    var $default_image       = '';
    var $folderLimit         = 1000;

    ///**************************************************************************************************************************
    ///	Copy Image frm Source to destination path
    ///	$oldImage= orginal path of image, $newImage = new path of an image(/images/photo)
    ///**************************************************************************************************************************
    function CopyImage($oldImage, $newImage)
    {
        try
        {
            $copied = @copy($oldImage, $this->m_RootFolder.$newImage);	//Copy image frm orginal path to new path
            if (!$copied)
            {	//not copied
                return false;
            }
            else
            {
                return true;
            }//end of if (!$copied)
        }
        catch (Exception $ex)
        {
            return false;
        }
    }
    ///**************************************************************************************************************************
    ///	Photo uploading
    ///**************************************************************************************************************************
    function UploadPhoto($image,$imageName,$path, $tmpName)
    {
        $errors=0;
        if ($image)
        {
            $extension = $this->getExtension($image);
            $extension = @strtolower($extension);
            if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "gif") && ($extension != "pdf"))
            $errors=1;

            if($errors !=1)
            {
                $size		=	@filesize($tmpName);

                $image_name	=	$imageName;
                $newname	=	$path.$image_name;
                $copied 	= 	@copy($tmpName, $newname);
                if (!$copied)
                {
                    $errors=1;
                }
                else
                {
                    return $image_name;
                }
            }
        }
    }

    ///**************************************************************************************************************************
    ///To get an extension frm a file
    ///**************************************************************************************************************************
    function getExtension($str)
    {
        $i = strrpos($str,".");
        if (!$i) { return ""; }
        $l = strlen($str) - $i;
        $ext = substr($str,$i+1,$l);
        return $ext;
    }
    ///****************************************************************************************************************************
    /// Returns type according to num.
    ///****************************************************************************************************************************
    function getFileType()
    {
        try
        {
            list($this->m_Width, $this->m_height, $this->m_type, $this->m_attr) = getimagesize($this->m_ImagePath);
            return $this->m_type;
        }
        catch (Exception $ex)
        {
            return 0;
        }
    }
}
    ?>