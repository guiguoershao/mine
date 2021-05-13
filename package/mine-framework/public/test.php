<?php
$filename = "test.sql";
$content = "";
$current = "";
$step = 1;
$start = 0;
$handle = fopen($filename, 'r+');
while (!feof($handle)) {
    fseek($handle, $start, SEEK_SET);
    $current = fread($handle, $step);
    $content .= $current;
    $start += $step;
}
fclose($handle);
print_r($content);