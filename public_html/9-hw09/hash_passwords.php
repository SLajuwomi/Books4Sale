<?php

$passwordUser1 = 'alicePass123'; 
$passwordUser2 = 'bobSecureP@ss'; 
$passwordUser3 = 'charlieR0cks!'; 


echo "Hashing passwords using PASSWORD_BCRYPT (default for Laravel)...\n\n";

$hashedPasswordUser1 = password_hash($passwordUser1, PASSWORD_BCRYPT);
echo "Plain: " . $passwordUser1 . "\nHashed for Alice: " . $hashedPasswordUser1 . "\n\n";

$hashedPasswordUser2 = password_hash($passwordUser2, PASSWORD_BCRYPT);
echo "Plain: " . $passwordUser2 . "\nHashed for Bob: " . $hashedPasswordUser2 . "\n\n";

$hashedPasswordUser3 = password_hash($passwordUser3, PASSWORD_BCRYPT);
echo "Plain: " . $passwordUser3 . "\nHashed for Charlie: " . $hashedPasswordUser3 . "\n\n";

echo "IMPORTANT: Copy each 'Hashed for ...' value into the SQL script below.\n";
echo "Then, DELETE this hash_passwords.php file!\n";