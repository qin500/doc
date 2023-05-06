<?php
$filename = 'client-info.txt';
echo nl2br(file_get_contents($filename));
exit();
