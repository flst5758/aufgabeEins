<?php

require_once 'IsbnService.php';
require_once 'Metadata.php';

/**
 * Description of IsbnServiceJson: gets information from worldcat REST-Service it returns it as matadata object
 *
 * @author MBlock, FSteffen
 */
class IsbnServiceJson implements IsbnService {


    public function __construct() {
    }

    public function getData($isbn = null) {
        $temp = $this->getServiceData($isbn);
        return $this->parseServiceData($temp);
    }

    private function getServiceData($isbn = null) {
        if (is_null($isbn)) {
            return;
        }

        $url = "http://xisbn.worldcat.org/webservices/xid/isbn/" . $isbn . "?method=getMetadata&format=json&fl=*"; //Wird json ausgegeben, nur über Aufruf der URL
        //$url = "http://xisbn.worldcat.org/webservices/xid/isbn/0596002815?method=getMetadata&format=xml&fl=*";
        $serviceData = file_get_contents($url);
      //  echo htmlspecialchars($serviceData);

        return $serviceData;
    }

    public function parseServiceData($data = null) {

        if (is_null($data)) {
            return array();
        }

        $json = json_decode($data);
        if ($json->stat == 'unknownId' || $json->stat == 'invalidId') {
            return array();
        }
      //  echo "test 3";
      //  echo $data;
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

        return array($metadata);
    }

}
