# Laravel apps on AWS architecture

Integrates:

- Elasticache for caching.
- EFS (elastic file system) for storage/app directory.
- RDS for database

Make your laravel app scale like never before.



## Requirements

This image contains only the docker image for the php container. So you have to do some manual configuration. ( Could be packaged as a make: command but for now... )



### Configure your AWS IAM policies


For this to work you need to modify the beanstalk role in AWS IAM

Add this ( IAM -> Roles -> aws-elasticbeanstalk-ec2-role -> Inline Policies -> Create Role Policy -> Custom Policy ) and here is what you add:

```
{
  "Version": "2012-10-17",
  "Statement": [
    {
      "Action": [
        "ec2:Describe*",
        "cloudformation:Describe*",
        "elasticbeanstalk:Describe*"
      ],
      "Effect": "Allow",
      "Resource": "*"
    }
  ]
}
```



