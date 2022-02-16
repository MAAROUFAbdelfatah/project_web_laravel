<?php
namespace App\Traits;
use Illuminate\Support\Facades\Storage;
Trait  FilesTrait
{
    function saveFile($file,$folder){

        $file_extension = $file->getClientOriginalExtension();
        $file_name = time().'.'.$file_extension;
        $path = $folder;
        $file -> move($path,$file_name);
        return $file_name;
    }

    function deleteFile($name, $folder){
        $path = $folder.'/'.$name;
        $path = public_path($path);
        unlink($path);
    }

    function isImage($file){
        $file_extension = $file->getClientOriginalExtension();
        $ex = strtolower($file_extension);
        if($ex  == "jpg" || $ex  == "png" || $ex  == "jpeg" || $ex  == "gift")
            return TRUE;
        return FALSE;
    }

    function isPDF($file){
        $file_extension = $file->getClientOriginalExtension();
        if(strtolower($file_extension) == "pdf")
            return TRUE;
        return FALSE;
    }
}