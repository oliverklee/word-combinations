#!/usr/bin/env php
<?php
require_once __DIR__ . '/../vendor/autoload.php';

$wordListReader = new \OliverKlee\CodeKata\WordListReader();
$words = $wordListReader->read(__DIR__ . '/../Resources/Private/Dictionaries/brit-a-z.txt');

$prefixTree = new \OliverKlee\CodeKata\PrefixTree();
foreach ($words as $word) {
    $prefixTree->insert($word);
}
$prefixSets = $prefixTree->findPrefixes();

foreach ($prefixSets as $word => $prefixSet) {
    echo $word . ': ' . implode(', ', $prefixSet) . "\n";
}
