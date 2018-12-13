<?php
require 'vendor/autoload.php';
$f3 = \Base::instance();

echo "<h1>TEST</h1>";

function hello() {
    return 'Hello, World';
}

// Set up
$test=new Test;

// This is where the tests begin
$test->expect(
    is_callable('hello'),
    'hello() is a function'
);

// Another test
$hello=hello();
$test->expect(
    !empty($hello),
    'Something was returned'
);

// This test should succeed
$test->expect(
    is_string($hello),
    'Return value is a string'
);

// This test is bound to fail
$test->expect(
    strlen($hello)==13,
    'String length is 13'
);

$pass = 0;
$fail = 0;
// Display the results; not MVC but let's keep it simple
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