# Laravel apps on AWS architecture


Do not use this docker image directly. See https://github.com/peec/laravel-aws to get started.


## Environment variables

This docker container can be configured with the following environment variables.

```

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

# Laravel specifics
APP_KEY
DB_CONNECTION  (default: mysql)
CACHE_DRIVER   (default: memcached)


# RDS
RDS_USERNAME
RDS_PASSWORD
RDS_HOSTNAME
RDS_PORT
RDS_DB_NAME


# Memcached
MEMCACHED_PERSISTENT_ID (default: app)
MEMCACHED_USERNAME
MEMCACHED_PASSWORD
MEMCACHED_HOST
MEMCACHED_PORT




```