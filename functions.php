<?php

/**
 * Bereinigt unnötige Leerzeichen, entfernt Escape-Zeichen.
 * @param String $string
 * @return String
 */
function preValidate($string) {
	// Entfernt WhitespaceChars von Anfang und Ende der Zeichenkette
	$result = trim($string);

	// Entfernt Maskierungszeichen aus der Zeichenkette
	$result = stripcslashes($result);

	return $result;
}
/**
 * Liefert den Wert des angegebenen Namespace.
 * @param type $namespace
 * @return type
 */
function getSessionNamespace($namespace) {
	if (!isset($_SESSION[$namespace])) {
		return null;
	}
	
	return unserialize($_SESSION[$namespace]);
}

/**
 * Speichert den Wert im angegebenen Namespace zur Session.
 * @param type $namespace
 * @param type $data
 */
function setSessionNamespace($namespace, $data) {
	$_SESSION[$namespace] = serialize($data);
}

/**
 * Validiert den Wert anhand eines regulären Ausdrucks.
 * Wirft einen Fehler wenn die Zeichenkette leer ist oder die Validierung
 * fehlschlägt.
 * @param type $pattern
 * @param type $string
 * @return boolean
 * @throws Exception
 */
function validate($pattern, $string) {
	if (preg_match($pattern, $string) && !empty($string)) {
		return true;
	}
	
	throw new Exception("Validation Error", 666);
}
