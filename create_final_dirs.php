<?php

//iterate dirs, check for Final directory and create if none exists

$path = '/srv/candoc/commitment/'; //change paths for testing - production //dont forget the last /

if ($handle = opendir($path)) {
    $blacklist = array('.', '..', 'somedir', 'somefile.php'); //hardcode blacklist files
    while (false !== ($file = readdir($handle))) {
        if (!in_array($file, $blacklist)) {
          if(is_numeric($file)){
            echo "$file\n";
            @mkdir($path . $file."/final");
	    @chown($path . $file."/final", "sambashare");
	    @chgrp($path . $file."/final", "sambashare");
          }
        }
    }
    closedir($handle);
}

?>
