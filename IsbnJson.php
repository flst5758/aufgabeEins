<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'IsbnServiceJson.php';
require_once './DBCacheService.php';
require_once 'Metadata.php';
$isbn = $_POST["isbn"];
$service = new DBCacheService(new IsbnServiceJson($isbn));
$books = $service->getData($isbn);

$mapBook = function($book) {return get_object_vars($book);}; 
$json = array_map($mapBook, $books);
echo json_encode($json, JSON_PRETTY_PRINT);

