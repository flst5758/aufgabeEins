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
$book = $service->getData($isbn);
echo json_encode(get_object_vars($book), JSON_PRETTY_PRINT);

