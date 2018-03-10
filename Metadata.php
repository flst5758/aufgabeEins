<?php

/**
 * Description of Metadata
 *
 * @author MBlock
 */
class Metadata {
	
	public $_form;
	public $_year;
	public $_lang;
	public $_ed;
	public $_title;
	public $_author;
	public $_publisher;
	public $_city;
	public $_isbn;
	
	public function getForm() {
		return $this->_form;
	}

	public function getYear() {
		return $this->_year;
	}

	public function getLang() {
		return $this->_lang;
	}

	public function getEd() {
		return $this->_ed;
	}

	public function getTitle() {
		return $this->_title;
	}

	public function getAuthor() {
		return $this->_author;
	}

	public function getPublisher() {
		return $this->_publisher;
	}

	public function getCity() {
		return $this->_city;
	}

	public function getIsbn() {
		return $this->_isbn;
	}

	public function setForm($form) {
		$this->_form = $form;
	}

	public function setYear($year) {
		$this->_year = $year;
	}

	public function setLang($lang) {
		$this->_lang = $lang;
	}

	public function setEd($ed) {
		$this->_ed = $ed;
	}

	public function setTitle($title) {
		$this->_title = $title;
	}

	public function setAuthor($author) {
		$this->_author = $author;
	}

	public function setPublisher($publisher) {
		$this->_publisher = $publisher;
	}

	public function setCity($city) {
		$this->_city = $city;
	}

	public function setIsbn($isbn) {
		$this->_isbn = $isbn;
	}


}
