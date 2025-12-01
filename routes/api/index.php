<?php

$versions = scandir(__DIR__);

foreach ($versions as $version) {
    if (str_contains($version, '__')) continue;
    if ($version == '.' || $version == '..') continue;
    if (!is_dir(__DIR__ . "/$version")) continue;

    require __DIR__ . '/' . $version . '/index.php';
}
