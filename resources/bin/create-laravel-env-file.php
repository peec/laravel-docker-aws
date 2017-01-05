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



    'MEDIA_S3_REGION',
    'MEDIA_S3_ACCESS_KEY',
    'MEDIA_S3_SECRET_KEY',
    'MEDIA_S3_DOMAIN_NAME',

    // Laravel requires s3 bucket without slash.
    'MEDIA_S3_BUCKET' => function () {
        $domain = getenv('MEDIA_S3_DOMAIN_NAME');
        return substr($domain, 0, strrpos($domain, '/'));
    },
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
    'SES_KEY',
    'SES_SECRET',
    'SES_REGION',

    'QUEUE_DRIVER',
    'SQS_KEY',
    'SQS_SECRET',
    'SQS_REGION',
    'SQS_QUEUE',

    // Laravel requires only SQS prefix ( not queue name also. ).
    'SQS_PREFIX' => function () {
        $prefix = getenv('SQS_PREFIX');
        return substr($prefix, 0,strrpos($prefix, '/'));
    },


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




///
/// Build the .env file.
///

$envMap = array();

$envFile = "";
foreach ($envMap as $key => $value) {
    if (is_callable($value)) {
        $value = call_user_func($value);
    } else {
        $key = $value;
        $value = getenv($key);
    }
    $envFile .= "$key=$value\n";
}


file_put_contents(getenv('APP_DIR') . '/.env', $envFile);
