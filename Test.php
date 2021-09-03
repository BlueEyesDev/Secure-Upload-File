<?php
include 'UploadFile.php';
$UploadFileSecu = new UploadFileSecu();
if (!empty($_FILES))
   echo $UploadFileSecu->UploadFile("userfile", "uploadfiles", "png", ["PNG", "JPG"]);
?>

<form enctype="multipart/form-data" method="post">
  Upload File : <input name="userfile" type="file" />
  <input type="submit" value="Upload" />
</form>
