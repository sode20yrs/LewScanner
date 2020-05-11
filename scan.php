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

// If we get a redirection
if(httpIsRedirect($argv[1]))
{
    $argv[1] = str_replace("https://", "https://www.", $argv[1]);
    $argv[1] = str_replace("http://", "http://www.", $argv[1]);
}

$words = file_get_contents(__DIR__."/words.dat");
$words = explode("\n", $words);
unset($words[count($words)-1]);
$words = array_values($words);

$found = [];

foreach ($words as $key => $value)
{
  if(substr($value, -1) != "/") $value .= "/";

  echo PHP_EOL;

  foreach ($found as $i => $f) {
    echo " " . $f . PHP_EOL;
  }

  echo PHP_EOL . "* Scanning: " . (number_format((float)($key+1)/count($words)*100, 2, '.', '')) . "% Done. Found: ". count($found) , PHP_EOL.PHP_EOL;

  if(getHTTPCode($argv[1] . $value) != 404) {
    $found[] = $argv[1] . $value . (httpIsRedirect($argv[1] . $value) ? " (".getHTTPCode($argv[1] . $value) . " Redirected)" : "");
  }

  system("clear");

}

printBanner();

echo PHP_EOL."==================================================================".PHP_EOL;
echo implode(PHP_EOL, $found);
echo PHP_EOL."==================================================================".PHP_EOL.PHP_EOL;