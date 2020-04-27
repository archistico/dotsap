<?php
  $APP_ORARIO_SUDDIVISIONE = json_encode(["00", "15", "30", "45"]);

  $APP_AMBULATORI = json_encode([
    [
      'giorno' => 'Lunedì',
      'luogo' => 'St-Vincent',
      'inizio' => '17:00',
      'fine' => '19:00',
      'riservati' => ["17:00" => "---", "18:00" => "---", "18:40" => "---", "18:50" => "---"]
    ],
    [
      'giorno' => 'Martedì',
      'luogo' => 'St-Vincent',
      'inizio' => '9:00',
      'fine' => '13:00',
      'riservati' => ["9:00" => "---", "10:00" => "---", "10:15" => "---", "11:00" => "---", "12:00" => "---", "12:40" => "---", "12:50" => "---"]
    ],
    [
      'giorno' => 'Mercoledì',
      'luogo' => 'St-Vincent',
      'inizio' => '9:00',
      'fine' => '13:00',
      'riservati' => ["9:00" => "---", "10:00" => "---", "10:15" => "---", "10:30" => "Lumiere", "11:00" => "---", "12:00" => "---", "12:40" => "---", "12:50" => "Lumiere"]
    ],
    [
      'giorno' => 'Giovedì',
      'luogo' => 'St-Vincent',
      'inizio' => '9:00',
      'fine' => '13:00',
      'riservati' => ["9:00" => "---", "10:00" => "---", "10:15" => "---", "11:00" => "---", "12:00" => "---", "12:40" => "---", "12:50" => "---"]
    ],
    [
      'giorno' => 'Venerdì',
      'luogo' => 'Pontey',
      'inizio' => '17:00',
      'fine' => '19:00',
      'riservati' => ["17:00" => "---", "18:00" => "---", "18:40" => "---", "18:50" => "---"]
    ],
  ]);

  $variables = [
      'APP_RESPONSABILE' => "dott.ssa XXX YYY (CF: AAABBB00C11D222E)",
      'APP_DB_FILE' => "db/database.sqlite",
      'APP_ORARIO_INIZIO' => 8,
      'APP_ORARIO_FINE' => 19,
      'APP_ORARIO_SUDDIVISIONE' => $APP_ORARIO_SUDDIVISIONE,
      'APP_VERSIONE' => '1.0.6',
      'APP_AMBULATORI' => $APP_AMBULATORI,
  ];

  foreach ($variables as $key => $value) {
      putenv("$key=$value");
  }
?>
