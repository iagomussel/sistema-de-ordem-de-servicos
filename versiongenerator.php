<?php
$compress = array();
$path = "./";
$dirsIterator = new RecursiveTreeIterator(new RecursiveDirectoryIterator($path));
$compress["diretorios"] = array();
$compress["arquivos"]  = array();

foreach ($dirsIterator as $dir => $dirTree) {
    if (is_dir($dir)) {
        $compress["diretorios"][$dir] = true;
    } else {
		$compress["arquivos"][$dir] = base64_encode(file_get_contents($dir));
	}
}

echo "<pre>".base64_encode(json_encode($compress,JSON_PRETTY_PRINT));
?>
