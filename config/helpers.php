<?php
/**
 * Helper functions for secure ID encoding and other utilities
 */

/**
 * Encode an integer ID to a URL-safe hash string
 * @param int $id The original ID
 * @return string URL-safe encoded string
 */
function encodeId(int $id): string {
    $secret = $_ENV['APP_KEY'] ?? 'default-secret-key-change-me';
    $data = $id . ':' . substr(hash('sha256', $id . $secret), 0, 8);
    return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}

/**
 * Decode a hashed string back to the original ID
 * @param string $hash The encoded string
 * @return int|null The original ID or null if invalid
 */
function decodeId(string $hash): ?int {
    $secret = $_ENV['APP_KEY'] ?? 'default-secret-key-change-me';
    $decoded = base64_decode(strtr($hash, '-_', '+/'));
    
    if (!$decoded || !str_contains($decoded, ':')) {
        return null;
    }
    
    [$id, $checksum] = explode(':', $decoded, 2);
    $id = (int) $id;
    
    $expectedChecksum = substr(hash('sha256', $id . $secret), 0, 8);
    if (!hash_equals($expectedChecksum, $checksum)) {
        return null;
    }
    
    return $id;
}

/**
 * Generate a unique hash ID for new records
 * @return string A unique 16-character hash
 */
function generateHashId(): string {
    return bin2hex(random_bytes(8));
}

/**
 * Generate a secure random token
 * @param int $length Length of the token
 * @return string Random token
 */
function generateToken(int $length = 32): string {
    return bin2hex(random_bytes($length / 2));
}
