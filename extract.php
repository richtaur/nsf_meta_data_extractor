#!/usr/bin/php
<?php

require('extractor.php');
require('metadata.php');

$data = new MetaData($argv[1]);

if ($data->isValid()) {

	echo 'Name: ' . $data->getKey('name') . "\n";
	echo 'Songs: ' . $data->getKey('num_songs') . "\n";
	echo 'Artist: ' . $data->getKey('artist') . "\n";
	echo 'Copyright: ' . $data->getKey('copyright') . "\n";

	/*
	or do it this way:
	print_R($data->getData());
	echo $data->getJSON();
	*/

} else {
	echo "Oops! Error reading file...\n";
}
