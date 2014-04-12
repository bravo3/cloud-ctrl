<?php

require __DIR__.'/../vendor/autoload.php';

// Read the comments in properties.dist.php
$nonDistProperties = __DIR__.'/properties.php';
if (file_exists($nonDistProperties)) {
    require $nonDistProperties;
} else {
    require __DIR__.'/properties.dist.php';
}
