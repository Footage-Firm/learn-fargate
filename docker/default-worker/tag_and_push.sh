#!/usr/bin/env bash
docker-compose build worker
docker build . --file docker/default-worker/Dockerfile -t learn-fargate:default-worker
$(aws ecr get-login --no-include-email --region us-east-1)
docker tag learn-fargate:default-worker 031780582162.dkr.ecr.us-east-1.amazonaws.com/learn-fargate:default-worker
docker push 031780582162.dkr.ecr.us-east-1.amazonaws.com/learn-fargate:default-worker