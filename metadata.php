<?php

class MetaData extends Extractor {

	// Note: keys must be lowercase
	protected $formats = array(
		'nsf' => array(
			5, // NSF
			array(
				'bytes' => 1,
				'fn' => 'ord',
				'label' => 'version'
			),
			array(
				'bytes' => 1,
				'fn' => 'ord',
				'label' => 'num_songs'
			),
			1, // Starting song
			2, // Load address
			2, // Init address
			2, // Play address
			array(
				'bytes' => 32,
				'fn' => 'trim',
				'label' => 'name'
			),
			array(
				'bytes' => 32,
				'fn' => 'trim',
				'label' => 'artist'
			),
			array(
				'bytes' => 32,
				'fn' => 'trim',
				'label' => 'copyright'
			)
		)
	);

	public function __construct($filename) {

		parent::__construct($filename);

		$extension = $this->getExtension($filename);

		if (!isset($this->formats[$extension])) {
			echo "error: Unknown file format [$extension]\n";
			exit;
		}

		$this->extract($extension);

	}

	private function getExtension($filename) {
		return strtolower(array_pop(split('\.', $filename)));
	}

}
