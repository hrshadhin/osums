<?php
 namespace App\Http\Helpers;

class AppHelper
{

    public static function gerCRVHash()
    {
        /**
         * Get file sha1 hash for copyright protection check
         */
        $path = base_path() . '/resources/views/layouts/footer.blade.php';
        $contents = file_get_contents($path);
        $c_sha1 = sha1($contents);
        return substr($c_sha1, 0, 7);
    }

}