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
$MEDIA_S3_REGION = getenv('MEDIA_S3_REGION') ? getenv('MEDIA_S3_REGION') : getenv('AWS_DEFAULT_REGION');
$MEDIA_S3_WEBSITE_URL = getenv('MEDIA_S3_WEBSITE_URL') ? getenv('MEDIA_S3_WEBSITE_URL') : $Outputs['MediaWebsiteURL'];
$MEDIA_S3_SECURE_URL = getenv('MEDIA_S3_SECURE_URL') ? getenv('MEDIA_S3_SECURE_URL') : $Outputs['MediaSecureURL'];


$REDIS_HOST = getenv('REDIS_HOST') ? getenv('REDIS_HOST') : $Outputs['ElastiCacheAddress'];
$REDIS_PORT = getenv('REDIS_PORT') ? getenv('REDIS_PORT') : $Outputs['ElastiCachePort'];
$REDIS_DATABASE = getenv('REDIS_DATABASE')  ? getenv('REDIS_DATABASE') : 0;

    $GITHUB_OAUTH_TOKEN = getenv('GITHUB_OAUTH_TOKEN');



$CDN = getenv('CDN') ? getenv('CDN') : $Outputs['SiteCDNDomainName'];


//// Laravel Cache
$CACHE_DRIVER = getenv('CACHE_DRIVER') ? getenv('CACHE_DRIVER') : 'redis';

//// Laravel database driver
$DB_CONNECTION = getenv('DB_CONNECTION') ? getenv('DB_CONNECTION') : 'mysql';

//// Laravel app key
$APP_KEY = getenv('APP_KEY');


/// Laravel session
$SESSION_DRIVER = getenv('SESSION_DRIVER') ? getenv('SESSION_DRIVER') : 'redis';
$SESSION_CONNECTION = getenv('SESSION_CONNECTION') ? getenv('SESSION_CONNECTION') : 'default';


/// Laravel Mail
$MAIL_DRIVER = getenv('MAIL_DRIVER') ? getenv('MAIL_DRIVER') : 'ses';
$SES_KEY = getenv('SES_KEY') ? getenv('SES_KEY') : getenv('AWS_ACCESS_KEY_ID');
$SES_SECRET = getenv('SES_SECRET') ? getenv('SES_SECRET') : getenv('AWS_SECRET_ACCESS_KEY');
$SES_REGION = getenv('SES_REGION') ? getenv('SES_REGION') : getenv('AWS_DEFAULT_REGION');


//// SQS Queue

$QUEUE_DRIVER = getenv('QUEUE_DRIVER') ? getenv('QUEUE_DRIVER') : 'sqs';

$SQS_KEY = getenv('SQS_KEY') ? getenv('SQS_KEY') : $Outputs['SQSAccessKey'];
if (!$SQS_KEY) {
    $SQS_KEY = getenv('AWS_ACCESS_KEY_ID');
}

$SES_SECRET = getenv('SQS_SECRET') ? getenv('SQS_SECRET') : $Outputs['SQSSecretKey'];
if (!$SES_SECRET) {
    $SES_SECRET = getenv('AWS_SECRET_ACCESS_KEY');
}

$SES_REGION = getenv('SQS_REGION') ? getenv('SQS_REGION') : getenv('AWS_DEFAULT_REGION');
$SQS_QUEUE = getenv('SQS_QUEUE') ? getenv('SQS_QUEUE') : $Outputs['LaravelQueueName'];
$SQS_PREFIX = getenv('SQS_PREFIX') ? getenv('SQS_PREFIX') : null;

if (!$SQS_PREFIX && $Outputs['LaravelQueueURL']) {
    $laravelQueueUrl = $Outputs['LaravelQueueURL'];
    // Remove queue name so we only get the prefix.
    $SQS_PREFIX = substr($laravelQueueUrl, 0,strrpos($laravelQueueUrl, '/'));
}




$envMap = array();

/* Queue */


$envMap['QUEUE_DRIVER'] = $QUEUE_DRIVER;
$envMap['SQS_KEY'] = $SQS_KEY;
$envMap['SQS_SECRET'] = $SES_SECRET;
$envMap['SQS_REGION'] = $SES_REGION;
$envMap['SQS_QUEUE'] = $SQS_QUEUE;
$envMap['SQS_PREFIX'] = $SQS_PREFIX;


/* CDN Resource*/

if ($CDN) {
    $envMap['CDN'] = $CDN;
}

/* Cache Configuration*/
$envMap['CACHE_DRIVER'] = $CACHE_DRIVER;


/* Session Configuration */
$envMap['SESSION_DRIVER'] = $SESSION_DRIVER;
$envMap['SESSION_CONNECTION'] = $SESSION_CONNECTION;


/* RDS Resource */

$envMap['DB_CONNECTION'] = $DB_CONNECTION;

if ($RDS_USERNAME) {
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

/* SES Configuration */
$envMap['MAIL_DRIVER'] = $MAIL_DRIVER;
$envMap['SES_KEY'] = $SES_KEY;
$envMap['SES_SECRET'] = $SES_SECRET;
$envMap['SES_REGION'] = $SES_REGION;



/* APP_KEY for laravel */

$envMap['APP_KEY'] = $APP_KEY;

if ($GITHUB_OAUTH_TOKEN) {
    $envMap['GITHUB_OAUTH_TOKEN'] = $GITHUB_OAUTH_TOKEN;
}

$envMap['APP_ENV'] = getenv('APP_ENV');
$envMap['APP_DEBUG'] = getenv('APP_DEBUG');
$envMap['APP_URL'] = getenv('APP_URL');
$envMap['AWS_ACCESS_KEY_ID'] = getenv('AWS_ACCESS_KEY_ID');
$envMap['AWS_SECRET_ACCESS_KEY'] = getenv('AWS_SECRET_ACCESS_KEY');
$envMap['AWS_DEFAULT_REGION'] = getenv('AWS_DEFAULT_REGION');
$envMap['LARAVEL_QUEUE_WORKER_TIMEOUT'] = getenv('LARAVEL_QUEUE_WORKER_TIMEOUT');
$envMap['IS_ON_AWS'] = getenv('IS_ON_AWS');

$envMap['REDIS_HOST'] = $REDIS_HOST;
$envMap['REDIS_PORT'] = $REDIS_PORT;
$envMap['REDIS_DATABASE'] = $REDIS_DATABASE;




$envFile = "";
foreach ($envMap as $key => $value) {
    $envFile .= "$key=$value\n";
}


file_put_contents(getenv('APP_DIR') . '/.env', $envFile);
