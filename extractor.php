<?php

class Extractor {

	private
		$data,
		$file_handler,
		$is_valid,
		$meta_data;

	public function __construct($filename) {
		if ($filename) {
			$this->open($filename);
		} else {
			echo "usage: ./extract.php FILE\n";
			echo "example: ./extract.php Blaster_Master.nsf\n";
			exit;
		}
	}

	protected function close() {
		if ($this->is_valid) fclose($this->file_handler);
	}

	protected function extract($extension) {

		if (!$this->is_valid) {
			echo "Sorry, couldn't open the file.";
			return;
		}

		foreach ($this->formats[$extension] as $instruction) {

			if (is_numeric($instruction)) {
				$this->setData($instruction);
			} else {
				$this->setData($instruction['bytes'], $instruction['label'], $instruction['fn']);
			}

		}

		$this->close();

	}

	private function getBlock($bytes) {
		return ($this->is_valid ? fread($this->file_handler, $bytes) : null);
	}

	public function getData() {
		return $this->meta_data;
	}

	public function getJSON() {
		return json_encode($this->meta_data);
	}

	public function getKey($key) {
		return $this->meta_data->$key;
	}

	public function isValid() {
		return $this->is_valid;
	}

	protected function open($filename) {
		$this->file_handler = @fopen($filename, 'rb');
		$this->is_valid = (bool) $this->file_handler;
	}

	protected function setData($bytes, $key = null, $fn = null) {

		if ($key) {

			if ($fn) {
				$this->meta_data->$key = $fn($this->getBlock($bytes));
			} else {
				$this->meta_data->$key = $this->getBlock($bytes);
			}

		} else {
			$this->getBlock($bytes);
		}

	}

}
