<?php
  $variables = [
      'APP_RESPONSABILE' => "dott.ssa XXX YYY (CF: AAABBB00C11D222E)",
      'APP_DB_FILE' => "db/database.sqlite",
  ];

  foreach ($variables as $key => $value) {
      putenv("$key=$value");
  }
?>