<?php
require_once './IsbnService.php';
require_once './Metadata.php';

/**
 * Description of IsbnServiceJson
 *
 * @author MBlock
 */
class IsbnServiceJson implements IsbnService {
	
	private $_isbn = null;
	private $_serviceData = null;
	private $_metadata = null;
	
	public function __construct($isbn = null) {
		$this->_isbn = $isbn;
		$this->getData();
	}
	
	public function getData() {
		if (is_null($this->_isbn)) {
			return;
		}
		if (is_null($this->_serviceData)) {
			$this->getServiceData();
		}
		if (is_null($this->_metadata)) {
			$this->parseServiceData();
		}
		
		return $this->_metadata;
	}

	public function getServiceData($isbn = null) {
		$flag = true;
		if (!is_null($isbn)) {
			$isbn = $isbn;
			$flag = false;
		} else {
			$isbn = $this->_isbn;
		}
		if (is_null($isbn)) {
			return;
		}
		
		$url = "http://xisbn.worldcat.org/webservices/xid/isbn/" . $isbn . "?method=getMetadata&format=json&fl=*";//Wird json ausgegeben, nur über Aufruf der URL
		$serviceData = file_get_contents($url);
		if ($flag) {
			$this->_serviceData = $serviceData;
		}
		
		return $serviceData;
	}

	public function parseServiceData($data = null) {
		$flag = true;
		if (!is_null($data)) {
			$serviceData = $data;
			$flag = false;
		} else {
			$serviceData = $this->_serviceData;
		}
		if (is_null($serviceData)) {
			return;
		}
		
		$json = json_decode($serviceData);
		$attributes = $json->list[0];
		$metadata = new Metadata();
		
		$metadata->setIsbn($attributes->isbn[0]);
		$metadata->setForm($attributes->form[0]);
		$metadata->setYear($attributes->year);
		$metadata->setLang($attributes->lang);
		$metadata->setEd($attributes->ed);
		$metadata->setTitle($attributes->title);
		$metadata->setAuthor($attributes->author);
		$metadata->setPublisher($attributes->publisher);
		$metadata->setCity($attributes->city);
		
		if ($flag) {
			$this->_metadata = $metadata;
		}
		
		return $metadata;
	}

}
