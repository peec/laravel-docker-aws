#!/usr/bin/env php
<?php
$Outputs = require('configure-instance-resources.php');


$RDS_USERNAME = getenv('RDS_USERNAME');
$RDS_PASSWORD = getenv('RDS_PASSWORD');
$RDS_HOSTNAME = getenv('RDS_HOSTNAME');
$RDS_PORT = getenv('RDS_PORT');
$RDS_DB_NAME = getenv('RDS_DB_NAME');


$MEDIA_S3_ACCESS_KEY = getenv('MEDIA_S3_ACCESS_KEY') ? getenv('MEDIA_S3_ACCESS_KEY') : $Outputs['MediaAccessKey'];
$MEDIA_S3_SECRET_KEY = getenv('MEDIA_S3_SECRET_KEY') ? getenv('MEDIA_S3_SECRET_KEY') : $Outputs['MediaSecretKey'];
$MEDIA_S3_BUCKET = getenv('MEDIA_S3_BUCKET') ? getenv('MEDIA_S3_BUCKET') : $Outputs['MediaBucketName'];
$MEDIA_S3_REGION = getenv('MEDIA_S3_REGION') ? getenv('MEDIA_S3_REGION') : 'eu-west-1';
$MEDIA_S3_WEBSITE_URL = getenv('MEDIA_S3_WEBSITE_URL') ? getenv('MEDIA_S3_WEBSITE_URL') : $Outputs['MediaWebsiteURL'];
$MEDIA_S3_SECURE_URL = getenv('MEDIA_S3_SECURE_URL') ? getenv('MEDIA_S3_SECURE_URL') : $Outputs['MediaSecureURL'];





$envMap = array();


if ($Outputs['SiteCDNDomainName']) {
    $envMap['CDN'] = $Outputs['SiteCDNDomainName'];
}


if ($Outputs['ElastiCacheAddress'] && $Outputs['ElastiCachePort']) {
    $envMap['CACHE_DRIVER'] = 'memcached';
    $envMap['MEMCACHED_PERSISTENT_ID'] = getenv('MEMCACHED_PERSISTENT_ID') ? getenv('MEMCACHED_PERSISTENT_ID') : 'default';
    $envMap['MEMCACHED_USERNAME'] = '';
    $envMap['MEMCACHED_PASSWORD'] = '';
    $envMap['MEMCACHED_HOST'] = $Outputs['ElastiCacheAddress'];
    $envMap['MEMCACHED_PORT'] = $Outputs['ElastiCachePort'];

}


if ($RDS_USERNAME) {
    $envMap['DB_CONNECTION'] = getenv('DB_CONNECTION');
    $envMap['DB_HOST'] = $RDS_HOSTNAME;
    $envMap['DB_PORT'] = $RDS_PORT;
    $envMap['DB_DATABASE'] = $RDS_DB_NAME;
    $envMap['DB_USERNAME'] = $RDS_USERNAME;
    $envMap['DB_PASSWORD'] = $RDS_PASSWORD;

}

if ($MEDIA_S3_ACCESS_KEY) {
    $envMap['MEDIA_S3_ACCESS_KEY'] = $MEDIA_S3_ACCESS_KEY;
    $envMap['MEDIA_S3_SECRET_KEY'] = $MEDIA_S3_SECRET_KEY;
    $envMap['MEDIA_S3_BUCKET'] = $MEDIA_S3_BUCKET;
    $envMap['MEDIA_S3_REGION'] = $MEDIA_S3_REGION;
    $envMap['MEDIA_S3_WEBSITE_URL'] = $MEDIA_S3_WEBSITE_URL;
    $envMap['MEDIA_S3_SECURE_URL'] = $MEDIA_S3_SECURE_URL;
}

$envMap['APP_KEY'] = getenv('APP_KEY');




$envFile = "";
foreach ($envMap as $key => $value) {
    $envFile .= "$key=$value\n";
}


file_put_contents($envFile, getenv('APP_DIR') . '/.env');