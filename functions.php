<?php
session_start();
header("connection: close");
error_reporting(0);
$validExtens = array('pdf','.doc','.docx','ppt','pptx','txt','zip','jpg','jpeg','tiff','tif','xlsx','xls');
$year = $_SESSION['year'];

    // Code used from
    // http://codeaid.net/php/convert-size-in-bytes-to-a-human-readable-format-(php)
    // Only a portion of the original code is used
    // Used to return the relavant size (B, KB, MB) of uploaded file
    function getSize($bytes, $precision = 2)
    {
	$unit = 1024;
	$kilobyte = $unit;
	$megabyte = $kilobyte * $unit;
	$gigabyte = $megabyte * $unit;

	if(($bytes >= 0) && ($bytes < $kilobyte))
	    return $bytes . ' B';

	elseif(($bytes >= $kilobyte) && ($bytes < $megabyte))
	    return round($bytes / $kilobyte, $precision) . ' KB';

	elseif(($bytes >= $megabyte) && ($bytes < $gigabyte))
	    return round($bytes / $megabyte, $precision) . ' MB';

	else
	    return $bytes . ' B';
    }

function getDownloads($group, $req, $year)
{
    $directory = dir('./upload/'.$year.'/'.$group);
    $fileArray = Array();
    $requirment = $req;

    while(($file = $directory->read()) !== false)
    {
        if ((strstr($file, '.', true) == $req) && ((substr($file, -3)=="txt") 
	   || (substr($file, -3) == "doc") 
	   || (substr($file, -4) == "docx") 
	   || (substr($file, -3) == "pdf") 
	   || (substr($file, -3) == "ppt") 
	   || (substr($file, -4) == "pptx")
	   || (substr($file, -3) == "zip")
	   || (substr($file, -3) == "jpg")
	   || (substr($file, -4) == "jpeg")
	   || (substr($file, -4) == "tiff")
	   || (substr($file, -3) == "tif")
	   || (substr($file, -4) == "xlsx")
	   || (substr($file, -3) == "xls")))
        {
            $fileArray[] = trim($file);
        }
    }

    $directory->close();
    sort($fileArray);

    $fileCount = count($fileArray);
    foreach($fileArray as $filename)
    {
	$stats = stat('./upload/' . $year . '/' .$group.'/'.$filename);
	$mtime = $stats['mtime'];
	$uid = $stats['uid'];

	$size = getSize($stats['size']);

	echo "Last Modified: ";
	echo strftime("%d %b %Y, %I:%M%p ", $mtime);
	echo "<br/><br/>";
	echo '<a href="download.php?year='.$year.'&group='.$group.'&filename='.$filename.'" role="button" class="btn btn-inverse">Download<br /><small>'.$size.'</small></a></td>';
    }
}
function removePeriod($string)
{
    $string = str_replace(".", "", $string);
    return $string;
}
function getExtens($group, $req, $year)
{
    global $validExtens;
    $iniArray = parse_ini_file("upload/$year/$group/reqConfig.ini");
    $exts = explode("," , $iniArray[$req]);

    if(empty($exts[0]))
	$exts = $validExtens;

    $exts = array_map(trim, $exts);
    $exts = array_map(removePeriod, $exts);
    return $exts;
}
?>
