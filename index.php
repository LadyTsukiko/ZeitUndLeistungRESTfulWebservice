<?php
echo 'not a webpage';
 $tst = "hans";
$hash = password_hash($tst, PASSWORD_DEFAULT);
$hash = '$2a$10$xO9VF55.HY7rWQjJ5z5IROcPud3I4Nl28TyegxkJAkUbF41rNAY36';

if(password_verify($tst, $hash)){
    //echo "sucsess";
}