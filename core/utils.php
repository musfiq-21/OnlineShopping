<?php
function hashUserPassword(string $password): string {
    // PASSWORD_DEFAULT tracks the best algorithm as PHP updates (currently Bcrypt)
    return password_hash($password, PASSWORD_DEFAULT);
}