<?php
/**
 * lordbyron Apr 19, 2012
 * specify one of the xml files to parse. use $loop to run the loading many times.
 * usage: php parse.php
 */

$acc ='';
//$path = 'quadratic.xml';
//$path = 'complex.xml';
//$path = 'laughs.xml';
$opts = getopt('', array('path:', 'loop::', 'pre'));

if (!$opts)
{
	echo 'Usage: php parse.php --path <xml_file> [--loop <iterations>] [--pre]' . PHP_EOL;
	exit(1);
}

$path = $opts['path'];
$loop = $opts['loop'] ?: 1;
$pre = isset($opts['pre']);

for ($i=0; $i<$loop; ++$i) {

	$s = file_get_contents($path);
	libxml_disable_entity_loader();
	libxml_use_internal_errors(true);

	// Comment out this line to see behavior/performance without preparse step
	if ($pre) $s = preparse($s);
	$x = simplexml_load_string($s);
	$acc .= (string) $x;
}

var_dump($acc);

// Take and return an XML string, less DOCTYPE nodes
// This takes time to pull in the whole document, doubling the total parsing
// time.
function preparse($s) {
	$d = DOMDocument::loadXML($s);
	foreach ($d->childNodes as $c) {
		if ($c->nodeType === XML_DOCUMENT_TYPE_NODE) {
			$d->removeChild($c);
		}
	}
	return $d->saveXML();
}

?>
