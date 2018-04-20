<?php

namespace machinebox;

class inputlist {
	
	private $data = array();

	public function add($key, $value) {
		$this->data[] = array("key" => $key, "value" => $value);
	}
	
	public function clear() {
		$this->data = array();
	}
	
	public function toArray() {
		$out = array();
		foreach ($this->data as $row) {
			if (is_string($row["value"])) $out[] = array("key" => $row["key"], "type" => "text", "value" => $row["value"]);
			elseif (is_numeric($row["value"])) $out[] = array("key" => $row["key"], "type" => "number", "value" => $row["value"]);
			//TODO: Objects
		}
		return $out;
	}
	
	
	
}