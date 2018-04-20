<?php
/**
  * Add Description
  *
  */
  
namespace machinebox;

class classificationbox {
	
	private $boxurl = null;
	private $model_id = null;
	public $verbose = false;

	public function __construct($boxurl, $model_id = null) {
		$this->boxurl = $boxurl;
		if ($model_id != null) $this->useModel($model_id);
	}
	
	public function usemodel($model_id) {
		$this->model_id = $model_id;
		return true;
	}
	
	public function createmodel($model_id = null, $model_name = "MachineboxClassifierbox", Array $classes = array(0,1), $ngrams = 1, $skipgrams = 0) {
		$w = array();
		if ($model_id != null) $w["id"] = $model_id;
		$w["name"] = $model_name;
		$w["options"]["ngrams"] = $ngrams;
		$w["options"]["skipgrams"] = $skipgrams;
		$w["classes"] = $classes;
		try {
			$resp = $this->jsonRequest("POST", "/classificationbox/models", $w);
		} catch (\Exception $ex) {
			return false;
		}
		$this->useModel($model_id);
		return true;
	}
	
	public function teach($class = 1, inputlist $inputs = null) {
		if ($model_id == null) throw new \Exception("No Model in use for teaching");
		$w = array();
		$w["class"] = $class;
		$w["inputy"] = $inputs->toArray();
		$resp = $this->jsonRequest("POST", "/classificationbox/models/".$this->model_id."/teach", $w);
		return $resp["success"];
	}
	
	public function predict(inputlist $inputs = null, $limit = 10) {
		if ($model_id == null) throw new Exception("No Model in use for teaching");
		$w = array();
		$w["limit"] = $limit;
		$w["inputy"] = $inputs->toArray();
		$resp = $this->jsonRequest("POST", "/classificationbox/models/".$this->model_id."/teach", $w);
		return $resp["success"];
	}
	
	/**
	  * Lists all models on the machinebox
	  *
	  * @return Array  Associative Array of all models id, name, box
	  */
	public function listmodels() {
		$out = array();
		$resp = $this->jsonRequest("GET", "/classificationbox/models");
		if (!isset($resp["success"]) OR !$resp["success"] OR !isset($resp["models"]) OR !is_array($resp["models"])) throw new \Exception("Machinebox-Error while listing");
		foreach ($resp["models"] as $row) {
			$row["box"] = new classificationbox($this->boxurl, $row["id"]);
			$out[$row["id"]] = $row;
		}
		return $out;
	}
	
	public function deletemodel($id = null) {
		if ($id == null) $id = $this->model_id;
		if ($id == null) throw new \Exception("No model for deletion specified");
		$resp = $this->jsonRequest("DELETE", "/classificationbox/models/".$id);
		return true;
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
		if ($this->verbose) echo($method."  ".$this->boxurl.$path.PHP_EOL.json_encode($data).PHP_EOL);
		$result = curl_exec($ch);
		$info = curl_getinfo($ch);
		if ($this->verbose) echo($info["http_code"]." - ".$result.PHP_EOL);
		if ($info["http_code"] == 400) throw new \Exception($result);
		curl_close($ch);

		$result = json_decode($result, true);
		return $result;
	}
	
	
}