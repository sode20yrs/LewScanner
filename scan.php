#!/usr/bin/php
<?php

require_once __DIR__ . "/functions.php";

system('clear');

printBanner();

if(!isset($argv[1]))
{
  printUsage();
  return;
}

if(!filter_var($argv[1], FILTER_VALIDATE_URL))
{
  echo PHP_EOL."Invalid URL. ".PHP_EOL.PHP_EOL;
  printUsage();

  return;
}

if(substr($argv[1], -1) != "/") $argv[1] .= "/";

if (!hostOnline($argv[1]))
{
  echo PHP_EOL."Could not resolve host: " . $argv[1].PHP_EOL.PHP_EOL;
  return;
}

$words = file_get_contents(__DIR__."/words.dat");
$words = explode("\n", $words);
unset($words[count($words)-1]);
$words = array_values($words);

$found = [];

foreach ($words as $key => $value)
{

  echo PHP_EOL;

  foreach ($found as $i => $f) {
    echo " " . $f . PHP_EOL;
  }

  echo PHP_EOL . "* Scanning: " . (number_format((float)($key+1)/count($words)*100, 2, '.', '')) . "% Done. Found: ". count($found) , PHP_EOL.PHP_EOL;

  if(directoryExists($argv[1] . $value) != 404) {
    $found[] = $argv[1] . $value;
  }

  system("clear");

}

printBanner();

echo PHP_EOL."==================================================================".PHP_EOL;
echo implode(PHP_EOL, $found);
echo PHP_EOL."==================================================================".PHP_EOL.PHP_EOL;