<?php

/**
 *
 * @author MBlock
 */
interface IsbnService {
	
	public function getServiceData($isbn = null);
	
	public function parseServiceData($data = null);
	
	public function getData();
	
}
