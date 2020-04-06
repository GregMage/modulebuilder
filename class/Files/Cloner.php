<?php

namespace XoopsModules\Tdmcreate\Files;
use XoopsModules\Tdmcreate;

/**
 * Class Cloner
 */
class Cloner
{
    /**
     * Delete a file or recursively delete a directory
     *
     * @param string $path Path to file or directory

    public static function deleteFileFolder($path) {

        if (is_file($path)) {
            return @unlink($path);
        }
        elseif (is_dir($path)) {
            $scan = glob(rtrim($path,'/').'/*');
            foreach($scan as $index=>$path) {
                self::deleteFileFolder($path);
            }
            return @rmdir($path);
        }
    }*/

    // recursive cloning script
    /**
     * @param $path
     */
    public static function cloneFileFolder($src_path, $dst_path, $replace_code = false, $patKeys = [], $patValues =[])
    {
        // open the source directory
        $dir = opendir($src_path);
        // Make the destination directory if not exist
        @mkdir($dst_path);
        // Loop through the files in source directory
        while( $file = readdir($dir) ) {
            if (( $file != '.' ) && ( $file != '..' )) {
                if ( is_dir($src_path . '/' . $file) ) {
                    // Recursively calling custom copy function for sub directory
                    self::cloneFileFolder($src_path . '/' . $file, $dst_path . '/' . $file, $replace_code, $patKeys, $patValues);
                } else {
                    self::cloneFile($src_path . '/' . $file, $dst_path . '/' . $file, $replace_code, $patKeys, $patValues);
                }
            }
        }
        closedir($dir);
    }

    /**
     * @param $path
     */
    public static function cloneFile($src_file, $dst_file, $replace_code = false, $patKeys = [], $patValues =[])
    {
        if ($replace_code) {
            $noChangeExtensions = ['jpeg', 'jpg', 'gif', 'png', 'zip', 'ttf'];
            if (in_array(mb_strtolower(pathinfo($src_file, PATHINFO_EXTENSION)), $noChangeExtensions)) {
                // image
                copy($src_file, $dst_file);
            } else {
                // file, read it
                $content = file_get_contents($src_file);
                $content = str_replace($patKeys, $patValues, $content);
                file_put_contents($dst_file, $content);
            }
        } else {
            copy($src_file, $dst_file);
        }
    }
}
