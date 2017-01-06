#!/usr/bin/env php
<?php

$envToWrite = [
    'DB_USERNAME' => function () {
        return getenv('RDS_USERNAME');
    },
    'DB_PASSWORD' => function () {
        return getenv('RDS_PASSWORD');
    },
    'DB_HOST' => function () {
        return getenv('RDS_HOSTNAME');
    },
    'DB_PORT' => function () {
        return getenv('RDS_PORT');
    },
    'DB_DATABASE' => function () {
        return getenv('RDS_DB_NAME');
    },



    'MEDIA_S3_REGION' => function () {
        return fallback('MEDIA_S3_REGION', 'AWS_DEFAULT_REGION');
    },
    'MEDIA_S3_ACCESS_KEY' => function () {
        return fallback('MEDIA_S3_ACCESS_KEY', 'AWS_ACCESS_KEY_ID');
    },
    'MEDIA_S3_SECRET_KEY' => function () {
        return fallback('MEDIA_S3_SECRET_KEY', 'AWS_SECRET_ACCESS_KEY');
    },
    'MEDIA_S3_DOMAIN_NAME',
    'MEDIA_S3_BUCKET',
    'MEDIA_S3_WEBSITE_URL',
    'MEDIA_S3_SECURE_URL',



    'REDIS_HOST',
    'REDIS_PORT',
    'REDIS_DATABASE',

    'GITHUB_OAUTH_TOKEN',

    'CDN',


    'CACHE_DRIVER',

    'DB_CONNECTION',


    'SESSION_DRIVER',
    'SESSION_CONNECTION',


    'MAIL_DRIVER',
    'SES_KEY' => function () {
        return fallback('SES_KEY', 'AWS_ACCESS_KEY_ID');
    },
    'SES_SECRET' => function () {
        return fallback('SES_KEY', 'AWS_SECRET_ACCESS_KEY');
    },
    'SES_REGION' => function () {
        return fallback('SES_REGION', 'AWS_DEFAULT_REGION');
    },

    'QUEUE_DRIVER',
    'SQS_KEY' => function () {
        return fallback('SQS_KEY', 'AWS_SECRET_ACCESS_KEY');
    },
    'SQS_SECRET' => function () {
        return fallback('SQS_SECRET', 'AWS_SECRET_ACCESS_KEY');
    },
    'SQS_REGION' => function () {
        return fallback('SQS_REGION', 'AWS_DEFAULT_REGION');
    },
    'SQS_QUEUE',
    'SQS_QUEUE_NAME',

    'APP_ENV',
    'APP_DEBUG',
    'APP_URL',
    'APP_KEY',

    'AWS_ACCESS_KEY_ID',
    'AWS_SECRET_ACCESS_KEY',
    'AWS_DEFAULT_REGION',
    'LARAVEL_QUEUE_WORKER_TIMEOUT',
    'IS_ON_AWS'


];


function fallback ($env, $fallbackEnv) {
    return getenv($env) ? getenv($env) : getenv($fallbackEnv);
}



///
/// Build the .env file.
///


$envFile = "";
foreach ($envToWrite as $key => $value) {
    if (is_callable($value)) {
        $value = call_user_func($value);
    } else {
        $key = $value;
        $value = getenv($key);
    }
    $envFile .= "$key=$value\n";
}


file_put_contents(getenv('APP_DIR') . '/.env', $envFile);
