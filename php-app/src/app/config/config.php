<?php

/* -- CONSTANTS -- */
define('BYTE_MEGABYTE', 1048576); // 1024 * 1024
define('SECONDS_MINUTE', 60);
define('SECONDS_HOUR', 3600);

/* -- Database Configuration -- */
define('DBNAME', $_ENV['MONOLITHIC_POSTGRES_DB']);
define('DBUSER', $_ENV['MONOLITHIC_POSTGRES_USER'] ?? 'postgres');
define('DBPASSWORD', $_ENV['MONOLITHIC_POSTGRES_PASSWORD']);
define('DBHOST', $_ENV['MONOLITHIC_POSTGRES_HOST']);
define('DBPORT', $_ENV['MONOLITHIC_POSTGRES_PORT']);

define('CONNECT_RETRIES', 4);

/* -- Static File Configuration -- */
// Videos
define('VIDEO_TYPE', 'video');
define('MAX_VIDEO_SIZE', 50 * BYTE_MEGABYTE);
// Audios
define('AUDIO_TYPE', 'audio');
define('MAX_AUDIO_SIZE', 10 * BYTE_MEGABYTE);
// Images
define('IMAGE_TYPE', 'image');
define('MAX_IMAGE_SIZE', 10 * BYTE_MEGABYTE);

define('MAX_FILE_SIZE', [
    VIDEO_TYPE => MAX_VIDEO_SIZE,
    AUDIO_TYPE => MAX_AUDIO_SIZE,
    IMAGE_TYPE => MAX_IMAGE_SIZE
]);

define('SUPPORTED_FILES', [
    VIDEO_TYPE => [
        'video/mp4' => '.mp4'
    ],
    AUDIO_TYPE => [
        'audio/mpeg' => '.mp3'
    ],
    IMAGE_TYPE => [
        'image/jpeg' => '.jpeg',
        'image/png' => '.png'
    ]
]);

/* -- Session Configuration -- */
define('COOKIES_LIFETIME', 24 * 60 * 60);
define('SESSION_EXPIRATION_TIME', 24 * 60 * 60);
define('SESSION_REGENERATION_TIME', 30 * 60);

/* -- App Configuration -- */
define('DEBOUNCE_TIMEOUT', 500);
define('ROWS_PER_PAGE', 10); // For pagination
