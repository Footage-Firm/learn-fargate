#!/usr/bin/env bash
docker-compose build web
$(aws ecr get-login --no-include-email --region us-east-1)
docker tag learn-fargate:web 031780582162.dkr.ecr.us-east-1.amazonaws.com/learn-fargate:web
docker push 031780582162.dkr.ecr.us-east-1.amazonaws.com/learn-fargate:web