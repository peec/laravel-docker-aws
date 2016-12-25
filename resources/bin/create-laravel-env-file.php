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


$MEMCACHED_HOST = getenv('MEMCACHED_HOST') ? getenv('MEMCACHED_HOST') : $Outputs['ElastiCacheAddress'];
$MEMCACHED_PORT = getenv('MEMCACHED_PORT') ? getenv('MEMCACHED_PORT') : $Outputs['ElastiCachePort'];
$MEMCACHED_PERSISTENT_ID = getenv('MEMCACHED_PERSISTENT_ID') ? getenv('MEMCACHED_PERSISTENT_ID') : 'default';
$MEMCACHED_USERNAME =  getenv('MEMCACHED_USERNAME') ;
$MEMCACHED_PASSWORD =  getenv('MEMCACHED_PASSWORD') ;


$CDN = getenv('CDN') ? getenv('CDN') : $Outputs['SiteCDNDomainName'];


//// Laravel Cache
$CACHE_DRIVER = getenv('CACHE_DRIVER') ? getenv('CACHE_DRIVER') : 'memcached';

//// Laravel database driver
$DB_CONNECTION = getenv('DB_CONNECTION') ? getenv('DB_CONNECTION') : 'mysql';

//// Laravel app key
$APP_KEY = getenv('APP_KEY');


/// Laravel session
$SESSION_DRIVER = getenv('SESSION_DRIVER') ? getenv('SESSION_DRIVER') : 'memcached';
$SESSION_CACHE_STORE = getenv('SESSION_CACHE_STORE') ? getenv('SESSION_CACHE_STORE') : getenv('CACHE_DRIVER');

$envMap = array();

/* CDN Resource*/

if ($CDN) {
    $envMap['CDN'] = $CDN;
}

/* Cache Configuration*/
$envMap['CACHE_DRIVER'] = $CACHE_DRIVER;

/* Memcached Resource */

if ($MEMCACHED_HOST && $MEMCACHED_PORT) {
    $envMap['MEMCACHED_PERSISTENT_ID'] = $MEMCACHED_PERSISTENT_ID;
    $envMap['MEMCACHED_USERNAME'] = $MEMCACHED_USERNAME;
    $envMap['MEMCACHED_PASSWORD'] = $MEMCACHED_PASSWORD;
    $envMap['MEMCACHED_HOST'] = $MEMCACHED_HOST;
    $envMap['MEMCACHED_PORT'] = $MEMCACHED_PORT;

}


/* Session Configuration */
$envMap['SESSION_DRIVER'] = $SESSION_DRIVER;
$envMap['SESSION_CACHE_STORE'] = $SESSION_CACHE_STORE;



/* RDS Resource */

if ($RDS_USERNAME) {
    $envMap['DB_CONNECTION'] = $DB_CONNECTION;
    $envMap['DB_HOST'] = $RDS_HOSTNAME;
    $envMap['DB_PORT'] = $RDS_PORT;
    $envMap['DB_DATABASE'] = $RDS_DB_NAME;
    $envMap['DB_USERNAME'] = $RDS_USERNAME;
    $envMap['DB_PASSWORD'] = $RDS_PASSWORD;

}

/* S3 Resource */

if ($MEDIA_S3_ACCESS_KEY) {
    $envMap['MEDIA_S3_ACCESS_KEY'] = $MEDIA_S3_ACCESS_KEY;
    $envMap['MEDIA_S3_SECRET_KEY'] = $MEDIA_S3_SECRET_KEY;
    $envMap['MEDIA_S3_BUCKET'] = $MEDIA_S3_BUCKET;
    $envMap['MEDIA_S3_REGION'] = $MEDIA_S3_REGION;
    $envMap['MEDIA_S3_WEBSITE_URL'] = $MEDIA_S3_WEBSITE_URL;
    $envMap['MEDIA_S3_SECURE_URL'] = $MEDIA_S3_SECURE_URL;
}

/* APP_KEY for laravel */

$envMap['APP_KEY'] = $APP_KEY;




$envFile = "";
foreach ($envMap as $key => $value) {
    $envFile .= "$key=$value\n";
}


file_put_contents(getenv('APP_DIR') . '/.env', $envFile);