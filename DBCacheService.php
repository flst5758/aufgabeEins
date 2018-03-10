<?php
require_once './My_MySQLi.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DBCacheService
 *
 * @author Florian Steffen
 */
class DBCacheService implements IsbnService {

    private $_dataService = null;

    public function __construct($dataService) {
        $this->_dataService = $dataService;
    }

    public function getData($isbn = null) {
        $dbConnection = new My_MySQLi("localhost", "root", "", "aufgabe_eins");
        $record = $dbConnection->query('SELECT * FROM `metadata` WHERE isbn = ?');
        
        $stm=$dbConnection->prepare('SELECT `id`, `isbn`, `form`, `year`, `lang`, `edition`, `title`, `author`, `publisher`, `city` FROM `metadata` WHERE isbn = ?');
        $stm->bind_param("s", $isbn);
        $stm->execute();
        $result = $stm->get_result();
        if($result->num_rows > 0){
            return $this->convertToMetadata($result);
        }

        $books = $this->_dataService->getData($isbn);
        foreach ($books as $metadata) {
            $stm=$dbConnection->prepare("INSERT INTO `metadata` (`id`, `isbn`, `form`, `year`, `lang`, `edition`, `title`, `author`, `publisher`, `city`) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?);");
            $stm->bind_param("sssssssss", $metadata->getIsbn(), 
                $metadata->getForm(), 
                $metadata->getYear(),
                $metadata->getLang(),
                $metadata->getEd(),
                $metadata->getTitle(),
                $metadata->getAuthor(),
                $metadata->getPublisher(),
                $metadata->getCity());
            $stm->execute();    
        }
        
        return $books;
    }
    
    private function convertToMetadata($result){
        $books = array();
        while($row = $result->fetch_assoc())
        {
            $metadata = new Metadata();

            $metadata->setIsbn($row['isbn']);
            $metadata->setForm($row['form']);
            $metadata->setYear($row['year']);
            $metadata->setLang($row['lang']);
            $metadata->setEd($row['edition']);
            $metadata->setTitle($row['title']);
            $metadata->setAuthor($row['author']);
            $metadata->setPublisher($row['publisher']);
            $metadata->setCity($row['city']);
            
            $books[] = $metadata;
        }
        return $books;
    }
    

    

}
