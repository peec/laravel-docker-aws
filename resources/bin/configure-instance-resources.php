<?php
// Configures the generated resources with environment variables
// Such as:
// - Elasticache


// For this to work you need to modify the beanstalk role in AWS IAM
// Add this ( IAM -> Roles -> aws-elasticbeanstalk-ec2-role -> Inline Policies -> Create Role Policy -> Custom Policy ) and here is what you add:
/*
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
*/


$Outputs = array(
    'ElastiCachePort' => null,
    'ElastiCacheAddress' => null,


    'SiteCDNDomainName' => null
);


// curl http://169.254.169.254/latest/meta-data/instance-id
// aws ec2 describe-instances --instance-ids i-b40a053c --region eu-west-1

$ec2IdentityDocument = file_get_contents('http://169.254.169.254/latest/dynamic/instance-identity/document');
$ec2IdentityDocumentJson = json_decode($ec2IdentityDocument, true);
$ec2Region = $ec2IdentityDocumentJson['region'];
$ec2InstanceId = $ec2IdentityDocumentJson['instanceId'];
// Allow to fail...
if ($ec2InstanceId && $ec2Region) {
    echo "Describing instances for $ec2InstanceId\n";
    // We need to find the stack name  of the beanstalk environment. This is located on the ec2 info.
    $shell = shell_exec("aws ec2 describe-instances --instance-ids $ec2InstanceId --region $ec2Region");
    $json = json_decode($shell, true);

    if ($json) {
        foreach ($json['Reservations'][0]['Instances'][0]['Tags'] as $tag) {
            // Stack name found.
            if ($tag['Key'] === 'aws:cloudformation:stack-name') {
                $stackName = $tag['Value'];

                // Then we list all the outputs of the stack ( we describe this in resources ).

                echo "Describing stack $stackName\n";
                $shell = shell_exec("aws cloudformation describe-stacks --region=$ec2Region --stack-name $stackName");
                $json = json_decode($shell, true);
                if ($json) {
                    $stack = $json['Stacks'][0];
                    // Keys like:
                    // ElastiCachePort
                    // ElastiCacheAddress
                    foreach ($stack['Outputs'] as $output) {
                        $Outputs[$output['OutputKey']] = $output['OutputValue'];
                    }
                    echo "Stack outputs found:\n";
                    print_r($Outputs);


                } else {
                    echo "configure-instance-resources:ERROR: Could not get json from aws cloudformation describe-stacks \n";
                }

            }
        }
    } else {
        echo "configure-instance-resources:ERROR: Could not get json from aws ec2 describe-instances \n";
    }


    // now we can use configuration

} else {
    echo "configure-instance-resources:ERROR: Could not get region:$ec2Region instance-id:$ec2InstanceId.\n";
}


return $Outputs;
