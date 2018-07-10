<?php

namespace machinebox;

class inputlist {
	
	private $data = array();

	public function add($key, $type = "text", $value) {
		$this->data[] = array("key" => $key, "type" => $type, "value" => $value);
	}
	
	public function clear() {
		$this->data = array();
	}
	
	public function toArray() {
		$out = array();
		foreach ($this->data as $row) {
			$out[] = array("key" => $row["key"], "type" => $row["type"], "value" => $row["value"]);
			
		}
		return $out;
	}
	
	
	
}