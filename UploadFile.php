<?php

class UploadFileSecu {
    private $IsFilesArray = FALSE;
    function __CONSTRUCT() {
        $this->IsFilesArray = !empty($_FILES);
    }
    public function UploadFile($Name, $DirPath, $Extension, $AllowedExtension){
        try {
            if (!$this->IsFilesArray)
                trigger_error("\$_FILES is Empty", E_USER_ERROR);

            if (!isset($_FILES[$Name]))
                trigger_error("\$_FILES[$Name] is null", E_USER_ERROR);

            if (is_dir($DirPath) == FALSE)
                trigger_error("Not found dir : $DirPath", E_USER_ERROR);

            $handle = fopen($_FILES[$Name]['tmp_name'], "r");
            $contents = fread($handle, filesize($_FILES[$Name]['tmp_name']));
            fclose($handle);
            $FileData = substr(bin2hex($contents), 0, 8);

            if (!in_array($this->GetRealExtension($FileData), $AllowedExtension))
                trigger_error("Unknown Extension", E_USER_ERROR);
            
            $RandomFileName = $this->RandomFileName();
            move_uploaded_file($_FILES[$Name]['tmp_name'], "{$DirPath}/{$RandomFileName}.{$Extension}");
            return "{$DirPath}/{$RandomFileName}.{$Extension}";
        } catch (Exception $e) {
            trigger_error($e->getMessage(), E_USER_ERROR);
            return null;
        }
    }
    private function GetRealExtension($EightByte){
        switch ($EightByte) {
            case '89504e47':
                return "PNG";
            case 'ffd8ffe0':
                return "JPG";
            default:
                return "Unknown";
        }
    }
    private function RandomFileName(){
        return bin2hex(random_bytes(5))."-".bin2hex(random_bytes(10));
    }
}
?>
