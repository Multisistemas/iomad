<?php
$secret_salt = 'P4radi50!';
$timestamp = time();
$user = 'pedroparadisosol@gmail.com';
$email = 'pedroparadisosol@gmail.com';
$cohortname = '99999';
$fn = 'Pedro Gmail';
$ln = 'Paradiso';
$city = 'CA';
$country = 'US';

$token = crypt($timestamp.$user.$email,$secret_salt);

$url = $CFG->wwwroot.'/auth/token/index.php';

$sso_url = $url.'?user='.$user.'&token='.$token.'&timestamp='.$timestamp.'&email='.$email.'&newuser='.$newuser.'&fn='.$fn.'&ln='.$ln.'&city='.$city.'&country='.$country;

header("Location: ".$sso_url);

/*
echo "<pre>";
print_r($sso_url);
echo "</pre>";
*/