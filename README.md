# Laravel apps on AWS architecture


Do not use this docker image directly. See https://github.com/peec/laravel-aws to get started.


## Environment variables

This docker container can be configured with the following environment variables.

```

CDN


# Github
GITHUB_OAUTH_TOKEN


# AWS
AWS_ACCESS_KEY_ID
AWS_SECRET_ACCESS_KEY
AWS_DEFAULT_REGION


# S3
MEDIA_S3_ACCESS_KEY
MEDIA_S3_SECRET_KEY
MEDIA_S3_BUCKET
MEDIA_S3_REGION
MEDIA_S3_SECURE_URL
MEDIA_S3_WEBSITE_URL


# App secret
APP_ENV
APP_KEY


# Database
DB_CONNECTION  (default: mysql)


# Cache
CACHE_DRIVER   (default: memcached)


# RDS
RDS_USERNAME
RDS_PASSWORD
RDS_HOSTNAME
RDS_PORT
RDS_DB_NAME


# Redis
REDIS_HOST
REDIS_PORT
REDIS_DATABASE



# Session
SESSION_CONNECTION
SESSION_DRIVER


# Mail
MAIL_DRIVER
SES_KEY
SES_SECRET
SES_REGION


# Queue
QUEUE_DRIVER
SQS_KEY
SQS_SECRET
SQS_REGION
SQS_QUEUE
SQS_PREFIX



# Laravel worker

LARAVEL_QUEUE_WORKER_CONNECTION (default: sqs)
LARAVEL_QUEUE_WORKER_SLEEP (default: 3)
LARAVEL_QUEUE_WORKER_TRIES (default: 3)
LARAVEL_QUEUE_WORKER_NUMPROCS (default: 4)
LARAVEL_QUEUE_WORKER_TIMEOUT (default: 60)



# Git build

APP_GIT_REPOSITORY
APP_GIT_BRANCH


```
