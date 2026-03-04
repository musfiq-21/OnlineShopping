<?php
function hashUserPassword(string $password): string {
    // PASSWORD_DEFAULT tracks the best algorithm as PHP updates (currently Bcrypt)
    return password_hash($password, PASSWORD_DEFAULT);
}

function password_verify(string $password, string $hash): bool {
    return password_verify($password, $hash);
}