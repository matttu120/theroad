<?php
header("connection: close");

include_once("functions.php");

session_start();
error_reporting(0);

$req = $_GET['req'];
$group = $_GET['group'];
$year = $_GET['year'];

$allowedExts = getExtens($group, $req, $year);

$reqName = str_replace(" ", "", $req);

$extension = strtolower(end(explode(".", $_FILES["file"]["name"])));

if ((($_FILES["file"]["type"] == "application/pdf")
    || ($_FILES["file"]["type"] == "application/msword")
    || ($_FILES["file"]["type"] == "application/vnd.openxmlformats-officedocument.wordprocessingml.document")
    || ($_FILES["file"]["type"] == "application/vnd.openxmlformats-officedocument.presentationml.presentation")
    || ($_FILES["file"]["type"] == "application/vnd.ms-powerpoint")
    || ($_FILES["file"]["type"] == "application/mspowerpoint")
    || ($_FILES["file"]["type"] == "application/ms-powerpoint")
    || ($_FILES["file"]["type"] == "application/mspowerpnt")
    || ($_FILES["file"]["type"] == "application/vnd-mspowerpoint")
    || ($_FILES["file"]["type"] == "application/powerpoint")
    || ($_FILES["file"]["type"] == "application/x-powerpoint")
    || ($_FILES["file"]["type"] == "application/x-m")
    || ($_FILES["file"]["type"] == "application/zip")
    || ($_FILES["file"]["type"] == "application/msexcel")
    || ($_FILES["file"]["type"] == "application/rtf")
    || ($_FILES["file"]["type"] == "application/x-gzip")
    || ($_FILES["file"]["type"] == "image/png")
    || ($_FILES["file"]["type"] == "image/gif")
    || ($_FILES["file"]["type"] == "image/jpeg")
    || ($_FILES["file"]["type"] == "image/tiff")
    || ($_FILES["file"]["type"] == "text/plain"))
    && ($_FILES["file"]["size"] < (20*1024*1024))
    && in_array($extension, $allowedExts))
{
    if ($_FILES["file"]["error"] > 0)
    {
        echo "Error: " . $_FILES["file"]["error"] . "<br />";
    }
    else
    {
        echo "Upload: " . $_FILES["file"]["name"] . "<br />";
        echo "Type: " . $_FILES["file"]["type"] . "<br />";

	$uploadedFileNE = "upload/" . $year . "/" . $group . "/" . $reqName;
	$uploadedFile = $uploadedFileNE . "." . $extension;

	if ((file_exists($uploadedFileNE . ".doc"))
        || (file_exists($uploadedFileNE . ".docx"))
        || (file_exists($uploadedFileNE . ".txt"))
        || (file_exists($uploadedFileNE . ".pdf"))
        || (file_exists($uploadedFileNE . ".ppt"))
	|| (file_exists($uploadedFileNE . ".pptx"))
        || (file_exists($uploadedFileNE . ".zip"))
	|| (file_exists($uploadedFileNE . ".jpg"))
	|| (file_exists($uploadedFileNE . ".jpeg"))
	|| (file_exists($uploadedFileNE . ".tiff"))
	|| (file_exists($uploadedFileNE . ".tif"))
	|| (file_exists($uploadedFileNE . ".xlsx"))
	|| (file_exists($uploadedFileNE . ".xls")))
        {
        
        echo $uploadedFileNE . " already exists in the system, overwriting. <br /> ";
        
        if (file_exists($uploadedFileNE . ".doc")){
            unlink($uploadedFileNE . ".doc");
            }
        if (file_exists($uploadedFileNE . ".docx")){
                unlink($uploadedFileNE . ".docx");
            }
        if (file_exists($uploadedFileNE . ".txt")){
                unlink($uploadedFileNE . ".txt");
            }
        if (file_exists($uploadedFileNE . ".pdf")){
                unlink($uploadedFileNE . ".pdf");
            }
        if (file_exists($uploadedFileNE . ".ppt")){
                unlink($uploadedFileNE . ".ppt");
            }
        if (file_exists($uploadedFileNE . ".pptx")){
                unlink($uploadedFileNE . ".pptx");
            }
        if (file_exists($uploadedFileNE . ".xls")){
                unlink($uploadedFileNE . ".xls");
            }
        if (file_exists($uploadedFileNE . ".zip")){
                unlink($uploadedFileNE . ".zip");
            }
        if (file_exists($uploadedFileNE . ".jpg")){
                unlink($uploadedFileNE . ".jpg");
            }
        if (file_exists($uploadedFileNE . ".jpeg")){
                unlink($uploadedFileNE . ".jpeg");
            }
        if (file_exists($uploadedFileNE . ".tiff")){
                unlink($uploadedFileNE . ".tiff");
            }
        if (file_exists($uploadedFileNE . ".tif")){
                unlink($uploadedFileNE . ".tif");
            }
        if (file_exists($uploadedFileNE . ".xlsx")){
                unlink($uploadedFileNE . ".xlsx");
            }
    
	}
                 
	move_uploaded_file($_FILES["file"]["tmp_name"], $uploadedFile);
	echo "<br />File uploaded to: " . $uploadedFile;
	echo "<br/><br/>";

    }
    
}
else
{
    echo ("<META http-equiv=\"refresh\" content=\"0;URL=upload_error.php?groupName=$group\">");
}

echo '<body>';
echo ("<a href=\"students.php?groupName=$group\">&nbsp;&nbsp;Back To Group Page&nbsp;&nbsp;</ahref>");
echo '</body>';

if($_SERVER['SERVER_PORT']!=443)
{
    $url = "https://". $_SERVER['SERVER_NAME'] . ":443".$_SERVER['REQUEST_URI'];
    header("Location: $url");
}
?>
