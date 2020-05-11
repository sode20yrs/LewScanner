<?php

function printBanner()
{
    echo PHP_EOL.' _                   ____                                  '.PHP_EOL;
    echo '| |    _____      __/ ___|  ___ __ _ _ __  _ __   ___ _ __ '.PHP_EOL;
    echo "| |   / _ \\ \\ /\\ / /\\___ \\ / __/ _` | '_ \\| '_ \\ / _ \\ '__|".PHP_EOL;
    echo '| |__|  __/\\ V  V /  ___) | (_| (_| | | | | | | |  __/ |   '.PHP_EOL;
    echo '|_____\\___| \\_/\\_/  |____/ \\___\\__,_|_| |_|_| |_|\\___|_|   '.PHP_EOL.PHP_EOL;
}

function printUsage()
{
    echo "Enter a target website!".PHP_EOL.PHP_EOL."Example: ./scan.php https://website.com".PHP_EOL.PHP_EOL;
}

function hostOnline($url)
{
    return @fopen($url, 'r');
}

function getHTTPCode($url)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    $f = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    return $httpcode;
}

function httpIsRedirect($url)
{
    return str_split(getHTTPCode($url))[0] == 3;
}