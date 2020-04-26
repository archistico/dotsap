<?php

$nomeCommit = "";
$tag = "";

if (count($argv)==1) {
    echo "Specificare il nome del commit tra apici doppi \"...\" ";
    die();
}

$nomeCommit = addslashes((string)$argv[1]);
if (count($argv)==3) {
    $tag = $argv[2];
}

echo "|-------------------------------|\n";
echo "|--------- NUOVO COMMIT --------|\n";
echo "|-------------------------------|\n";
echo "Nome: $nomeCommit\n";
if (!empty($tag)) {
    echo "Nome: $nomeCommit\n";
}
exec("git add .");
exec('git commit -m"'.$nomeCommit.'"')."\n";
//echo exec("git push origin master")."\n";
//exec("git describe --all --long | cut -d '/' -f 2 > version.txt");