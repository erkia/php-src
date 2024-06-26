--TEST--
Check for libsodium AEAD
--EXTENSIONS--
sodium
--SKIPIF--
<?php
if (!defined('SODIUM_CRYPTO_AEAD_AES256GCM_NPUBBYTES')) print "skip libsodium without AESGCM";
if (!defined('SODIUM_CRYPTO_AEAD_AEGIS128L_NPUBBYTES')) print "skip libsodium without AEGIS-128L";
if (!defined('SODIUM_CRYPTO_AEAD_AEGIS256_NPUBBYTES')) print "skip libsodium without AEGIS-256";
?>
--FILE--
<?php
echo "aead_chacha20poly1305:\n";

$msg = random_bytes(random_int(1, 1000));
$nonce = random_bytes(SODIUM_CRYPTO_AEAD_CHACHA20POLY1305_NPUBBYTES);
$key = sodium_crypto_aead_chacha20poly1305_keygen();
$ad = random_bytes(random_int(1, 1000));

$ciphertext = sodium_crypto_aead_chacha20poly1305_encrypt($msg, $ad, $nonce, $key);
$msg2 = sodium_crypto_aead_chacha20poly1305_decrypt($ciphertext, $ad, $nonce, $key);
var_dump($ciphertext !== $msg);
var_dump($msg === $msg2);
var_dump(sodium_crypto_aead_chacha20poly1305_decrypt($ciphertext, 'x' . $ad, $nonce, $key));
try {
    // Switched order
    $msg2 = sodium_crypto_aead_chacha20poly1305_decrypt($ciphertext, $ad, $key, $nonce);
    var_dump(false);
} catch (SodiumException $ex) {
    var_dump(true);
}

echo "aead_chacha20poly1305_ietf:\n";

if (SODIUM_LIBRARY_MAJOR_VERSION > 7 ||
    (SODIUM_LIBRARY_MAJOR_VERSION == 7 &&
     SODIUM_LIBRARY_MINOR_VERSION >= 6)) {
    $msg = random_bytes(random_int(1, 1000));
    $nonce = random_bytes(SODIUM_CRYPTO_AEAD_CHACHA20POLY1305_IETF_NPUBBYTES);
    $key = sodium_crypto_aead_chacha20poly1305_ietf_keygen();
    $ad = random_bytes(random_int(1, 1000));

    $ciphertext = sodium_crypto_aead_chacha20poly1305_ietf_encrypt($msg, $ad, $nonce, $key);
    $msg2 = sodium_crypto_aead_chacha20poly1305_ietf_decrypt($ciphertext, $ad, $nonce, $key);
    var_dump($ciphertext !== $msg);
    var_dump($msg === $msg2);
    var_dump(sodium_crypto_aead_chacha20poly1305_ietf_decrypt($ciphertext, 'x' . $ad, $nonce, $key));
    try {
        // Switched order
        $msg2 = sodium_crypto_aead_chacha20poly1305_ietf_decrypt($ciphertext, $ad, $key, $nonce);
        var_dump(false);
    } catch (SodiumException $ex) {
        var_dump(true);
    }
} else {
    var_dump(true);
    var_dump(true);
    var_dump(false);
    var_dump(true);
}

echo "aead_xchacha20poly1305_ietf:\n";

if (SODIUM_LIBRARY_MAJOR_VERSION > 9 ||
    (SODIUM_LIBRARY_MAJOR_VERSION == 9 &&
     SODIUM_LIBRARY_MINOR_VERSION >= 4)) {
    $msg = random_bytes(random_int(1, 1000));
    $nonce = random_bytes(SODIUM_CRYPTO_AEAD_XCHACHA20POLY1305_IETF_NPUBBYTES);
    $key = sodium_crypto_aead_xchacha20poly1305_ietf_keygen();
    $ad = random_bytes(random_int(1, 1000));

    $ciphertext = sodium_crypto_aead_xchacha20poly1305_ietf_encrypt($msg, $ad, $nonce, $key);
    $msg2 = sodium_crypto_aead_xchacha20poly1305_ietf_decrypt($ciphertext, $ad, $nonce, $key);
    var_dump($ciphertext !== $msg);
    var_dump($msg === $msg2);
    var_dump(sodium_crypto_aead_xchacha20poly1305_ietf_decrypt($ciphertext, 'x' . $ad, $nonce, $key));
    try {
        // Switched order
        $msg2 = sodium_crypto_aead_xchacha20poly1305_ietf_decrypt($ciphertext, $ad, $key, $nonce);
        var_dump(false);
    } catch (SodiumException $ex) {
        var_dump(true);
    }
} else {
    var_dump(true);
    var_dump(true);
    var_dump(false);
    var_dump(true);
}

echo "aead_aes256gcm:\n";

if (sodium_crypto_aead_aes256gcm_is_available()) {
    $msg = random_bytes(random_int(1, 1000));
    $nonce = random_bytes(SODIUM_CRYPTO_AEAD_AES256GCM_NPUBBYTES);
    $ad = random_bytes(random_int(1, 1000));
    $key = sodium_crypto_aead_aes256gcm_keygen();
    $ciphertext = sodium_crypto_aead_aes256gcm_encrypt($msg, $ad, $nonce, $key);
    $msg2 = sodium_crypto_aead_aes256gcm_decrypt($ciphertext, $ad, $nonce, $key);
    var_dump($ciphertext !== $msg);
    var_dump($msg === $msg2);
    var_dump(sodium_crypto_aead_aes256gcm_decrypt($ciphertext, 'x' . $ad, $nonce, $key));
    try {
        // Switched order
        $msg2 = sodium_crypto_aead_aes256gcm_decrypt($ciphertext, $ad, $key, $nonce);
        var_dump(false);
    } catch (SodiumException $ex) {
        var_dump(true);
    }
} else {
    var_dump(true);
    var_dump(true);
    var_dump(false);
    var_dump(true);
}

echo "aead_aegis128l:\n";

if (defined('SODIUM_CRYPTO_AEAD_AEGIS128L_NPUBBYTES')) {
    $msg = random_bytes(random_int(1, 1000));
    $nonce = random_bytes(SODIUM_CRYPTO_AEAD_AEGIS128L_NPUBBYTES);
    $ad = random_bytes(random_int(1, 1000));
    $key = sodium_crypto_aead_aegis128l_keygen();
    $ciphertext = sodium_crypto_aead_aegis128l_encrypt($msg, $ad, $nonce, $key);
    $msg2 = sodium_crypto_aead_aegis128l_decrypt($ciphertext, $ad, $nonce, $key);
    var_dump($ciphertext !== $msg);
    var_dump($msg === $msg2);
    var_dump(sodium_crypto_aead_aegis128l_decrypt($ciphertext, 'x' . $ad, $nonce, $key));
    try {
        // Switched order
        $msg2 = sodium_crypto_aead_aegis128l_decrypt($ciphertext, $ad, $key, $nonce);
        var_dump(false);
    } catch (SodiumException $ex) {
        var_dump(true);
    }
} else {
    var_dump(true);
    var_dump(true);
    var_dump(false);
    var_dump(false);
}

echo "aead_aegis256:\n";

if (defined('SODIUM_CRYPTO_AEAD_AEGIS256_NPUBBYTES')) {
    $msg = random_bytes(random_int(1, 1000));
    $nonce = random_bytes(SODIUM_CRYPTO_AEAD_AEGIS256_NPUBBYTES);
    $ad = random_bytes(random_int(1, 1000));
    $key = sodium_crypto_aead_aegis256_keygen();
    $ciphertext = sodium_crypto_aead_aegis256_encrypt($msg, $ad, $nonce, $key);
    $msg2 = sodium_crypto_aead_aegis256_decrypt($ciphertext, $ad, $nonce, $key);
    var_dump($ciphertext !== $msg);
    var_dump($msg === $msg2);
    var_dump(sodium_crypto_aead_aegis256_decrypt($ciphertext, 'x' . $ad, $nonce, $key));
    try {
        // Switched order
        $msg2 = sodium_crypto_aead_aegis256_decrypt($ciphertext, $ad, $key, $nonce);
        var_dump(false);
    } catch (SodiumException $ex) {
        var_dump(true);
    }
} else {
    var_dump(true);
    var_dump(true);
    var_dump(false);
    var_dump(false);
}
?>
--EXPECT--
aead_chacha20poly1305:
bool(true)
bool(true)
bool(false)
bool(true)
aead_chacha20poly1305_ietf:
bool(true)
bool(true)
bool(false)
bool(true)
aead_xchacha20poly1305_ietf:
bool(true)
bool(true)
bool(false)
bool(true)
aead_aes256gcm:
bool(true)
bool(true)
bool(false)
bool(true)
aead_aegis128l:
bool(true)
bool(true)
bool(false)
bool(false)
aead_aegis256:
bool(true)
bool(true)
bool(false)
bool(false)
