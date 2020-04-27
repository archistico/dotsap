<?php

$nomeCommit = "";
$tag = "";

if (count($argv) == 1) {
    echo "Specificare il nome del commit tra apici doppi \"...\" ";
    die();
}

$nomeCommit = addslashes((string) $argv[1]);
if (count($argv) == 3) {
    $tag = (string) $argv[2];
}

echo "|-------------------------------|\n";
echo "|--------- NUOVO COMMIT --------|\n";
echo "|-------------------------------|\n";
echo "Nome: $nomeCommit\n";
exec("git add .");
exec('git commit -m"' . $nomeCommit . '"');
exec("git push origin master");

if (!empty($tag)) {
    echo "Tag: $tag\n";
    $comando = 'git tag -a "v' . $tag . '" -m "version v' . $tag . '"';
    exec($comando);
} else {
    $envfile = "env.php";
    if (file_exists($envfile) === true) {
        if (is_writeable($envfile)) {
            try {
                $file_content = file_get_contents($envfile);
                $lines = explode("\n", $file_content);
                $numlinea = 0;

                foreach ($lines as $num => $line) {
                    $pos = strpos($line, "APP_VERSIONE");
                    if ($pos !== false)
                        $numlinea = $num;
                }

                $testo = $lines[$numlinea];
                $testo = trim((explode("=>", $testo))[1]);
                $testo = trim(str_replace('"', '', $testo));
                $testo = trim(str_replace("'", '', $testo));
                $testo = trim(str_replace(',', '', $testo));

                $major = (int) trim((explode(".", $testo))[0]);
                $minor = (int) trim((explode(".", $testo))[1]);
                $patch = (int) trim((explode(".", $testo))[2]);
                $patch++;

                // Ricreo il file env.php
                $newfiletext = "";
                $fw = fopen($envfile, "w");
                for ($c = 0; $c < count($lines); $c++) {
                    if ($c == $numlinea) {
                        $newfiletext .= "      'APP_VERSIONE' => '$major.$minor.$patch'," . "\n";
                    } else {
                        $newfiletext .= $lines[$c] . "\n";
                    }
                }

                fwrite($fw, $newfiletext);
                fclose($fw);

                $comando = 'git tag -a "v' . "$major.$minor.$patch" . '" -m "version v' . "$major.$minor.$patch" . '"';
                exec($comando);

            } catch (Exception $e) {
                $Result["message"] = 'Error : ' . $e;
            }
        }
    }
}
