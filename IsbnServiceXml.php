<?php
require_once './IsbnService.php';
require_once './Metadata.php';

/**
 * Description of IsbnServiceXml
 *
 * @author MBlock
 */
class IsbnServiceXml implements IsbnService {
	
	private $_isbn = null;
	private $_serviceData = null;
	private $_metadata = null;
	
	public function __construct($isbn = null) {//Konstruktor
		$this->_isbn = $isbn;
		$this->getData();
	}
	
	public function getData() {
		if (is_null($this->_isbn)) {//php-eigene Funktion is_null
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
		
		$url = "http://xisbn.worldcat.org/webservices/xid/isbn/" . $isbn . "?method=getMetadata&format=xml&fl=*";//hier wird XML abgefragt, nur über Aufruf der URL
		$serviceData = file_get_contents($url);//Aufruf an Dienst
		if ($flag) {
			$this->_serviceData = $serviceData;
		}
		
		return $serviceData;
	}

	public function parseServiceData($data = null) {
		$flag = true;
		if (!is_null($data)) {
			$xml = $data;
			$flag = false;
		} else {
			$xml = $this->_serviceData;
		}
		if (is_null($xml)) {
			return;
		}
		
		$simpleXml = new SimpleXMLElement($xml);
		$attributes = $simpleXml->isbn->attributes();
		$metadata = new Metadata();
		$metadata->setIsbn($simpleXml->isbn);
		$metadata->setForm($attributes["form"]);
		$metadata->setYear($attributes["year"]);
		$metadata->setLang($attributes["lang"]);
		$metadata->setEd($attributes["ed"]);
		$metadata->setTitle($attributes["title"]);
		$metadata->setAuthor($attributes["author"]);
		$metadata->setPublisher($attributes["publisher"]);
		$metadata->setCity($attributes["city"]);
		
		if ($flag) {
			$this->_metadata = $metadata;
		}
		
		return $metadata;
	}

}
