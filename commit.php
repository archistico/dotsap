<?php

$nomeCommit = "";
$tag = "";

if (count($argv)==1) {
    echo "Specificare il nome del commit tra apici doppi \"...\" ";
    die();
}

$nomeCommit = addslashes((string)$argv[1]);
if (count($argv)==3) {
    $tag = (string)$argv[2];
}

echo "|-------------------------------|\n";
echo "|--------- NUOVO COMMIT --------|\n";
echo "|-------------------------------|\n";
echo "Nome: $nomeCommit\n";
exec("git add .");

if (!empty($tag)) {
    echo "Tag: $tag\n";
    exec("git tag -a \"v$tag\" -m \"version v$tag\"");
}

exec('git commit -m"'.$nomeCommit.'"');
exec("git push origin master");
exec("git describe --all --long | cut -d '/' -f 2 > version.txt");