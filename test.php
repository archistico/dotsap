<?php
// Set up
require 'vendor/autoload.php';
$f3 = \Base::instance();
$test=new Test;

echo "<h1>TEST</h1>";

// -------------------------------------------
//                    TEST
// -------------------------------------------

$t1 = new \App\Intervallo();
$t1->AddSecondi(50);

$test->expect(
    $t1->ToMinutiSecondi() == "0 min. 50 s",
    "0 min. 50 s"
);

$t1->AddSecondi(10);
$test->expect(
    $t1->ToMinutiSecondi() == "1 min. 0 s",
    "1 min. 0 s"
);

$t1->AddSecondi(30);
$test->expect(
    $t1->ToMinutiSecondi() == "1 min. 30 s",
    "1 min. 30 s"
);

// -------------------------------------------
//                  RISULTATI
// -------------------------------------------

$pass = 0;
$fail = 0;
foreach ($test->results() as $result) {
    echo $result['text'].'<br>';
    if ($result['status']){
        echo "<span style='color: green'> + Pass</span><br>";
        $pass+=1;
    }
    else {
        echo "<span style='color: red'> - Fail (".$result['source'].")</span><br>";
        $fail+=1;
    }
    echo '<br>';
}

echo "<strong>Pass: $pass / Fail: $fail</strong> => ";
if($fail == 0) {
    echo "<span style='color: green'>Passed</span>";
} else {
    echo "<span style='color: red'>Failed</span>";
}