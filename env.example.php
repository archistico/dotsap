<?php
  $APP_ORARIO_SUDDIVISIONE = json_encode(["00", "15", "30", "45"]);

  $variables = [
      'APP_RESPONSABILE' => "dott.ssa XXX YYY (CF: AAABBB00C11D222E)",
      'APP_DB_FILE' => "db/database.sqlite",
      'APP_ORARIO_INIZIO' => 8,
      'APP_ORARIO_FINE' => 19,
      'APP_ORARIO_SUDDIVISIONE' => $APP_ORARIO_SUDDIVISIONE,
  ];

  foreach ($variables as $key => $value) {
      putenv("$key=$value");
  }
?>