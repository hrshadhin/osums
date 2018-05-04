<?php
 
class AppHelper
{

    public static function gerCRVHash()
    {
        /**
         * Get file sha1 hash for copyright protection check
         */
        $path = base_path() . '/resources/views/layouts/master.blade.php';
        $contents = file_get_contents($path);
        $session_sha1 = sha1("blob " . strlen($contents). "\0" . $contents);
        return $session_sha1;
    }

}