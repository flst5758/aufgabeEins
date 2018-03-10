<html>
	<head>
		<title>JAX-RS</title>
	</head>
	<body>
<?php

require_once './IsbnServiceJson.php';
require_once './Metadata.php';
require_once './My_MySQLi.php';

function printMetadata($metadata) {
	echo "<ul>";
	$reflect = new ReflectionClass($metadata);
	foreach ($reflect->getMethods() as $method) {
		$methodName = $method->name;
		if (substr($methodName, 0, 3) != "get") {
			continue;
		}
		
		echo "<li>";
		echo $metadata->$methodName();
		echo "</li>";
	}
	echo "</ul>";
}

function insertMetadata($metadataList) {
	$mysql = new My_MySQLi("localhost", "root", "", "bibipr_php3");//Anlegen neuer Datenbank (unten: Einspeisen neuer Werte in Datenbank)
	$sql = "INSERT INTO metadata (isbn, form, year, lang, edition, title, author, publisher, city) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?);";
	
	$statement = $mysql->prepare($sql); //in array wird Feld erstellt, in statement werden die Schlüssel definiert, in foreach werden die Werte übergeben;
	$array = array("isbn"=>"", "form"=>"", "year" => "", "lang"  => "", "edition"  => "", "title"  => "", "author"  => "", "publisher"  => "", "city"  => "");
	$statement->bind_param("ssissssss", $array["isbn"], $array["form"], $array["year"], $array["lang"], $array["edition"], $array["title"], $array["author"], $array["publisher"], $array["city"]);
	//durch & werden immer Referenzen übergeben;
	foreach ($metadataList as $metadata) {
		$array["isbn"] = $metadata->getIsbn();
		$array["form"] = $metadata->getForm();
		$array["year"] = $metadata->getYear();
		$array["lang"] = $metadata->getLang();
		$array["edition"] = $metadata->getEd();
		$array["title"] = $metadata->getTitle();
		$array["author"] = $metadata->getAuthor();
		$array["publisher"] = $metadata->getPublisher();
		$array["city"] = $metadata->getCity();
		
		$statement->execute();//Bei jedem Schleifendurchlauf werden diese Werte (oben) neu überschrieben
	}
}

function getMetadata() {
	$sql = "SELECT * FROM metadata;";
	$mysql = new My_MySQLi("localhost", "root", "", "bibipr_php3");//SQL-Query
	
	$result = $mysql->query($sql);//hier steht in result nur Ergebnismenge; In Fetch-Object (SQLi-Funktion) wird dann das Objekt selbst ausgegeben;
	$resultList = array();
	
	while ($resultObj = $result->fetch_object()) {//fetch object: im Select wurden mehrere Entitäten selektiert; Durch Fetch wird nur 1 Entität zurückgegeben
		$metadata = new Metadata();
		$metadata->setIsbn($resultObj->isbn);
		$metadata->setForm($resultObj->form);
		$metadata->setYear($resultObj->year);
		$metadata->setLang($resultObj->lang);
		$metadata->setEd($resultObj->edition);
		$metadata->setTitle($resultObj->title);
		$metadata->setAuthor($resultObj->author);
		$metadata->setPublisher($resultObj->publisher);
		$metadata->setCity($resultObj->city);
		
		$resultList[] = $metadata;
	}
	
	return $resultList;
}

$books = array();
echo "<h1>XML</h1>";
$isbnServiceXml = new IsbnServiceXml("978-3-645-60284-6");
$books[] = $isbnServiceXml->getData();
printMetadata($isbnServiceXml->getData());
$isbnServiceXml = new IsbnServiceXml("978-3-897-21876-5");
$books[] = $isbnServiceXml->getData();
printMetadata($isbnServiceXml->getData());
$isbnServiceXml = new IsbnServiceXml("978-3-836-22004-0");
$books[] = $isbnServiceXml->getData();
printMetadata($isbnServiceXml->getData());

echo "<h1>JSON</h1>";
$isbnServiceJson = new IsbnServiceJson("978-3-645-60284-6");
$books[] = $isbnServiceJson->getData();
printMetadata($isbnServiceJson->getData());
$isbnServiceJson = new IsbnServiceJson("978-3-897-21876-5");
$books[] = $isbnServiceJson->getData();
printMetadata($isbnServiceJson->getData());
$isbnServiceJson = new IsbnServiceJson("978-3-836-22004-0");
$books[] = $isbnServiceJson->getData();
printMetadata($isbnServiceJson->getData());

insertMetadata($books);

echo "<h1>Ausgabe aus der Datenbank</h1>";
foreach (getMetadata() as $metadata) {
	printMetadata($metadata);
}

?>
	</body>
</html>