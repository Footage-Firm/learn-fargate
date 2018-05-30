# Instructions for Encoding Using ECS

#### Run job processor locally
```
# Limit memory
docker run -it -c 128 -m 512m \
-v /Users/chas/Projects/wasabi/bin/scripts/misc/encode-stockitem-previews:/app/bin/scripts/misc/encode-stockitem-previews \
-e <ENV VAR>=<ENV VAL> \
$IMAGE \
node bin/scripts/misc/encode-stockitem-previews/processEncodePreviewJobs.js

# Docker compose
docker-compose up --scale worker=4 <?>

```

#### Launch an encoder army using AWS ECS
1. Create a cluster in ECS (using either Fargate or EC2)
1. Log into ECR:
    `$(aws ecr get-login --no-include-email --region us-east-1)`
1. Build the docker image you wish to execute on ECS.
1. Tag and push to ECR:
    ```
    # Get the ECR endpoint from AWS console.
    docker tag $IMAGE 031780582162.dkr.ecr.us-east-1.amazonaws.com/learn-fargate:<TEAM NAME>
    docker push 031780582162.dkr.ecr.us-east-1.amazonaws.com/learn-fargate:<TEAM NAME>
    ```
1. Create a Task Definition in ECS using the pushed tag.
    - Try to estimate how much CPU and MEM is required for a single task to run to help keep EC2 usage efficient.
1. Launch as many tasks as required:
    ```
    # aws ecs run-task --cluster <cluster> --task-definition <task definition> --count <count> --launch-type <EC2|FARGATE>
    aws ecs run-task --cluster learn-fargate --task-definition <task name>:<ver> --count 1 --launch-type FARGATE

    # run with environment variable
    aws ecs run-task --cluster learn-fargate \
    --overrides '{ "containerOverrides": [ { "name": "<CONTAINER NAME>", "environment": [ { "name": "<ENV VAR NAME>", "value": "<ENV VAR VALUE>" } ] } ] }' \
    --task-definition <task name>:<ver> --count 1 --launch-type FARGATE
    ```
1. (Optional Commands):
    ```
    # Trail aws logs
    awslogs get /ecs/learn-fargate ALL --watch --start='10m ago'
    awslogs get /ecs/learn-fargate ALL --watch --start='10m ago' --filter-pattern="?<KEY WORD>"

    # List info in ecs
    awless list containerclusters
    ```


#### Build default-worker
```
docker build . --dockerfile docker/default-worker/Dockerfile -t learn-fargate:default-worker
docker tag learn-fargate:default-worker 031780582162.dkr.ecr.us-east-1.amazonaws.com/learn-fargate:default-worker
docker push 031780582162.dkr.ecr.us-east-1.amazonaws.com/learn-fargate:default-worker
```