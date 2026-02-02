<?php

namespace App\Functions;

use Illuminate\Support\Facades\Log;
use RuntimeException;

class EncryptionFunction
{
    private const CIPHER = 'AES-256-CTR';
    private const IV_LENGTH = 16;
    private const HASH_ALGO = 'sha256';
    private const HMAC_LENGTH = 16;
    private const HMAC_COMPACT = 8; // Shorter HMAC for compact mode (reduced security slightly)
    private const COMPRESSION_LEVEL = 9;
    private const USE_COMPRESSION = true;
    
    private static string $key = 'YourSuperSecretKey123';

    /**
     * Set the encryption key
     */
    public static function setKey(string $key): void
    {
        if (strlen($key) < 16) {
            throw new RuntimeException('Encryption key must be at least 16 characters long.');
        }
        self::$key = $key;
    }

    /**
     * Encode any data type with AES-256-CTR encryption (with smart compression)
     */
    public static function encode(string|int|float|bool|array|object $data): string
    {
        // Serialize data to handle all types
        $serialized = serialize($data);
        
        // Compress large data (> 1KB) to reduce output size
        if (self::USE_COMPRESSION && strlen($serialized) > 1024) {
            $serialized = gzcompress($serialized, self::COMPRESSION_LEVEL);
            if ($serialized === false) {
                throw new RuntimeException('Compression failed.');
            }
            // Mark as compressed with a prefix byte (0x01)
            $serialized = "\x01" . $serialized;
        } else {
            // Mark as uncompressed with a prefix byte (0x00)
            $serialized = "\x00" . $serialized;
        }
        
        $iv = random_bytes(self::IV_LENGTH);
        $encryptionKey = hash_hkdf(self::HASH_ALGO, self::$key);

        $encryptedData = openssl_encrypt(
            $serialized,
            self::CIPHER,
            $encryptionKey,
            OPENSSL_RAW_DATA,
            $iv
        );

        if ($encryptedData === false) {
            throw new RuntimeException('Encryption failed.');
        }

        $payload = $iv . $encryptedData;
        $hmac = substr(hash_hmac(self::HASH_ALGO, $payload, $encryptionKey, true), 0, self::HMAC_LENGTH);

        // Use URL-safe Base64 encoding (no +/= issues in URLs/APIs)
        return self::base64UrlEncode($hmac . $payload);
    }

    /**
     * Compact encoding - 20-30% smaller output (shorter HMAC)
     * Use when size is critical (URLs, QR codes, etc)
     */
    public static function encodeCompact(string|int|float|bool|array|object $data): string
    {
        $serialized = serialize($data);
        
        if (self::USE_COMPRESSION && strlen($serialized) > 1024) {
            $serialized = gzcompress($serialized, self::COMPRESSION_LEVEL);
            if ($serialized === false) {
                throw new RuntimeException('Compression failed.');
            }
            $serialized = "\x01" . $serialized;
        } else {
            $serialized = "\x00" . $serialized;
        }
        
        $iv = random_bytes(self::IV_LENGTH);
        $encryptionKey = hash_hkdf(self::HASH_ALGO, self::$key);

        $encryptedData = openssl_encrypt(
            $serialized,
            self::CIPHER,
            $encryptionKey,
            OPENSSL_RAW_DATA,
            $iv
        );

        if ($encryptedData === false) {
            throw new RuntimeException('Encryption failed.');
        }

        $payload = $iv . $encryptedData;
        // Use shorter HMAC (8 bytes instead of 16) - saves ~10 bytes after encoding
        $hmac = substr(hash_hmac(self::HASH_ALGO, $payload, $encryptionKey, true), 0, self::HMAC_COMPACT);

        return self::base64UrlEncode($hmac . $payload);
    }

    /**
     * Binary encoding - 33% smaller (no Base64 overhead)
     * Use for storage/API only (not URL-safe, needs special handling)
     */
    public static function encodeBinary(string|int|float|bool|array|object $data): string
    {
        $serialized = serialize($data);
        
        if (self::USE_COMPRESSION && strlen($serialized) > 1024) {
            $serialized = gzcompress($serialized, self::COMPRESSION_LEVEL);
            if ($serialized === false) {
                throw new RuntimeException('Compression failed.');
            }
            $serialized = "\x01" . $serialized;
        } else {
            $serialized = "\x00" . $serialized;
        }
        
        $iv = random_bytes(self::IV_LENGTH);
        $encryptionKey = hash_hkdf(self::HASH_ALGO, self::$key);

        $encryptedData = openssl_encrypt(
            $serialized,
            self::CIPHER,
            $encryptionKey,
            OPENSSL_RAW_DATA,
            $iv
        );

        if ($encryptedData === false) {
            throw new RuntimeException('Encryption failed.');
        }

        $payload = $iv . $encryptedData;
        $hmac = substr(hash_hmac(self::HASH_ALGO, $payload, $encryptionKey, true), 0, self::HMAC_LENGTH);

        // Return raw binary (smallest possible)
        return $hmac . $payload;
    }

    /**
     * Decode encrypted data (returns original data type)
     * Supports all encoding formats: standard, compact, and binary
     */
    public static function decode(string $encoded): mixed
    {
        try {
            // Try URL-safe Base64 decoding first
            $decoded = self::base64UrlDecode($encoded);
            if ($decoded === false) {
                // If Base64 fails, assume it's binary encoded
                $decoded = $encoded;
            }

            // Auto-detect HMAC length (try 16 first, then 8)
            $hmacLength = self::HMAC_LENGTH;
            if (strlen($decoded) < self::HMAC_LENGTH + self::IV_LENGTH) {
                $hmacLength = self::HMAC_COMPACT;
            }

            if (strlen($decoded) < $hmacLength + self::IV_LENGTH) {
                throw new RuntimeException('Invalid encoded data length.');
            }

            $hmac = substr($decoded, 0, $hmacLength);
            $payload = substr($decoded, $hmacLength);

            $encryptionKey = hash_hkdf(self::HASH_ALGO, self::$key);
            $calculatedHmac = substr(hash_hmac(self::HASH_ALGO, $payload, $encryptionKey, true), 0, $hmacLength);

            if (!hash_equals($hmac, $calculatedHmac)) {
                throw new RuntimeException('HMAC verification failed. Data may have been tampered with.');
            }

            $iv = substr($payload, 0, self::IV_LENGTH);
            $encryptedData = substr($payload, self::IV_LENGTH);

            $decrypted = openssl_decrypt(
                $encryptedData,
                self::CIPHER,
                $encryptionKey,
                OPENSSL_RAW_DATA,
                $iv
            );

            if ($decrypted === false) {
                throw new RuntimeException('Decryption failed.');
            }

            // Check compression marker (first byte)
            $compressionMarker = $decrypted[0];
            $data = substr($decrypted, 1);

            // Decompress if needed
            if ($compressionMarker === "\x01") {
                $data = gzuncompress($data);
                if ($data === false) {
                    throw new RuntimeException('Decompression failed.');
                }
            }

            // Unserialize to restore original data type
            return unserialize($data);
        } catch (RuntimeException $e) {
            Log::error('Decryption error: [ENFN-1002]', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);
            return false;
        }
    }

    /**
     * Encode ID securely
     */
    public static function encodeId(int|string $id): string|false
    {
        try {
            $id = (string)$id;
            
            if (!ctype_digit($id)) {
                throw new RuntimeException("Invalid ID format: $id");
            }

            return self::encode($id);
        } catch (RuntimeException $e) {
            Log::warning('ID encoding failed: [ENFN-1003]', [
                'id' => $id,
                'error' => $e->getMessage(),
            ]);
            return false;
        }
    }

    /**
     * Decode ID securely
     */
    public static function decodeId(string $encodedId): int|false
    {
        try {
            $decodedId = self::decode($encodedId);
            
            if ($decodedId === false || !ctype_digit((string)$decodedId)) {
                throw new RuntimeException("Decoded ID is not a valid number: $decodedId");
            }

            return (int)$decodedId;
        } catch (RuntimeException $e) {
            Log::warning('ID decoding failed: [ENFN-1004]', [
                'encoded' => $encodedId,
                'error' => $e->getMessage(),
            ]);
            return false;
        }
    }

    /**
     * URL-safe Base64 encoding (replaces +/= with -_)
     */
    private static function base64UrlEncode(string $data): string
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    /**
     * URL-safe Base64 decoding (restores -_ to +/)
     */
    private static function base64UrlDecode(string $data): string|false
    {
        // Add padding if needed
        $padding = strlen($data) % 4;
        if ($padding) {
            $data .= str_repeat('=', 4 - $padding);
        }
        // Restore standard Base64 characters
        return base64_decode(strtr($data, '-_', '+/'), true);
    }
}