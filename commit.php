<?php

$nomeCommit = addslashes((string)$argv[1]);
echo count($argv);

echo "|-------------------------------|\n";
echo "|--------- NUOVO COMMIT --------|\n";
echo "|-------------------------------|\n";
echo "Nome: $nomeCommit\n";
exec("git add .");
exec('git commit -m"'.$nomeCommit.'"')."\n";
//echo exec("git push origin master")."\n";
//exec("git describe --all --long | cut -d '/' -f 2 > version.txt");