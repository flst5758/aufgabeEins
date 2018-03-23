<?php

/*
 * REST-Service-frontend for cache isbn-proxy server
 * isbnJson.php = REST-Schnittstelle
 * 
 * @author FSteffen
 */
require_once 'code/IsbnServiceJson.php';
require_once 'code/DBCacheService.php';
require_once 'code/Metadata.php';
$isbn = $_POST["isbn"];
$service = new DBCacheService(new IsbnServiceJson($isbn));
$books = $service->getData($isbn);

$mapBook = function($book) {return get_object_vars($book);}; 
$json = array_map($mapBook, $books);
echo json_encode($json, JSON_PRETTY_PRINT);

