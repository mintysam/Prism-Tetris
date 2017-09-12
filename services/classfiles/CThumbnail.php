<?php

@include_once("CImage.php");

class CThumbnail {

    var $m_RootFolder = ""; //	"/images/thumb"
    var $m_Height = 0; //	height of Thumbnail
    var $m_Width = 0; //	width of thumbnail
    var $m_Type = ""; //	file type
    var $m_Size = ""; //	size
    var $m_DestinationPath = "";
    var $m_MaskImage = "";
    var $m_Padding = "";

    function __construct() {
        $c_CImage = new CImage();
    }

    ///******************************************************************************************************************************
    ///		To get Thumbnail of an image
    ///******************************************************************************************************************************

    function GetThumbnail($name, $filename, $new_w, $new_h, $ImageType) {
        switch ($ImageType) {
            case 1:
                $src_img = @imagecreatefromgif($name);
                break;
            case 2:
                $src_img = @imagecreatefromjpeg($name);
                break;
            case 3:
                $src_img = @imagecreatefrompng($name);
                break;
            case 15:
                $src_img = @imagecreatefromwbmp($name);
                break;
        }

        $old_w = imageSX($src_img);
        $old_h = imageSY($src_img);

        if ($old_w == $new_w && $old_h == $new_h) {
            $thumb_w = $new_w;
            $thumb_h = $new_h;
        } else {
            if ((($new_w / 2) > $new_h) || (($new_h / 2) > $new_w)) {
                if ($old_w >= $old_h) {
                    $thumb_h = $new_h;
                    $proportion = $thumb_h * 100 / $old_h;
                    $thumb_w = $old_w * $proportion / 100;
                } else if ($old_w < $old_h) {
                    $thumb_w = $new_w;
                    $proportion = $thumb_w * 100 / $old_w;
                    $thumb_h = $old_h * $proportion / 100;
                }
            } else {
                if ($old_w <= $old_h) {
                    $thumb_h = $new_h;
                    $proportion = $thumb_h * 100 / $old_h;
                    $thumb_w = $old_w * $proportion / 100;
                } else if ($old_w > $old_h) {
                    $thumb_w = $new_w;
                    $proportion = $thumb_w * 100 / $old_w;
                    $thumb_h = $old_h * $proportion / 100;
                }
            }
        }

        $dst_img = ImageCreateTrueColor($thumb_w, $thumb_h);

        //Copy and resize part of an image with resampling
        imagecopyresampled($dst_img, $src_img, 0, 0, 0, 0, $thumb_w, $thumb_h, $old_w, $old_h);

        if (preg_match("/png/", $system[1])) {
            imagepng($dst_img, $filename, 100);
        } else {
            imagejpeg($dst_img, $filename, 100);
        }
        imagedestroy($dst_img);
        imagedestroy($src_img);
        return true;
    }

}

?>