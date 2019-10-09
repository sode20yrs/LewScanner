#!/usr/bin/php
<?php

if(!isset($argv[1]))
{
  echo "Enter a target website!\n\nExample: ./scan.php https://website.com\n\n";
  return;
}

if(!filter_var($argv[1], FILTER_VALIDATE_URL))
{
  echo "Enter a valid URL. \n\n";
  return;
}

echo "\n\n* Scanning\n\n";

if(substr($argv[1], -1) != "/") $argv[1] .= "/";

$words = file_get_contents(__DIR__."/words.dat");
$words = explode("\n", $words);
unset($words[count($words)-1]);
$words = array_values($words);

$found = [];

foreach ($words as $key => $value)
{
  echo "\n\n* Scanning: " . (number_format((float)($key+1)/count($words)*100, 2, '.', '')) . "% Done. Found: ". count($found) ."\n\n";

  if(get_headers($argv[1] . $value)[0] == "HTTP/1.1 200 OK") {
    $found[] = $argv[1] . $value;
  }

  system("clear");

}

echo "\n\n";

?>
