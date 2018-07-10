<?php
/**
  * The default model for all boxes
  *
  */
  
namespace machinebox;

class machinebox {
	
	protected $boxurl = null;
	protected $_verbose = false;
	
	public function __construct($boxurl) {
		
	}
	
	public function __get($name) {
		switch ($name) {
			case "hostname": return $this->jsonRequest("GET", "/healthz")["hostname"];
			case "build": return $this->jsonRequest("GET", "/healthz")["metadata"]["build"];
			case "boxname": return $this->jsonRequest("GET", "/healthz")["metadata"]["boxname"];
			case "success": return $this->jsonRequest("GET", "/healthz")["success"];
			case "errors": return $this->jsonRequest("GET", "/healthz")["errors"];
			case "status": return $this->jsonRequest("GET", "/info")["status"];
			case "plan": return $this->jsonRequest("GET", "/info")["plan"];
			case "version": return $this->jsonRequest("GET", "/info")["version"];
			case "error": return $this->jsonRequest("GET", "/info")["error"];
			case "verbose": return $this->_verbose;
		}
		return null;
	}
	
	public function __set($name, $value) {
		switch ($name) {
			case "verbose": $this->_verbose = ($value AND true);
		}
	}
	
	
	/**
      * @desc    Do a DELETE request with cURL
      *
	  * @param   string $method   method to request
      * @param   string $path     
      * @param   array  $json     
      *                           
      * @return  array  $result   JSON Respnse
      */
	private function jsonRequest($method, $path, $data = null) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $this->boxurl.$path);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
		if ($data != null) curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		if ($this->_verbose) echo($method."  ".$this->boxurl.$path.PHP_EOL.json_encode($data).PHP_EOL);
		$result = curl_exec($ch);
		$info = curl_getinfo($ch);
		if ($this->verbose) echo($info["http_code"]." - ".$result.PHP_EOL);
		if ($info["http_code"] == 400) throw new \Exception($result);
		curl_close($ch);

		$result = json_decode($result, true);
		return $result;
	}
}