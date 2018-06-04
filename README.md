# ECS Fargate Tutorial

Hello, and welcome to the fun and easy introduction to Amazon's Fargate platform in Elastic Container Service.

In this tutorial, we will walk you through how to leverage Amazon's powerful container platform to encode thousands of images in only minutes.

This project is built using the [Laravel](https://laravel.com/) PHP web framework, which makes it easy to spin up a complex web app with queues and remote storage.

### Prerequisites

For this tutorial, you are going to need the following:

- An AWS Account
- [Docker](https://www.docker.com/) (with docker-compose)
- (Optional) [AWS CLI](https://docs.aws.amazon.com/cli/latest/userguide/installing.html)

### Application Set-Up

To get the tutorial ready for users, you'll need to do the following:

1. Setup an S3 bucket with a _source-photos_ directory filled with the images you want to watermark (the number of photos does not matter) and a _teams_ directory to hold the team folders.
1. Create a production MySQL database.
1. Run `php artisan db:setup` and `php artisan migrate` against your production database to create the schemas needed for the app.
1. Deploy the web application and default queue worker to some production environment. For our workshop, we deployed to ECS:
    1. Build the web image: `docker build . --file docker/web/Dockerfile`
    1. Build the default queue worker image: `docker-compose build worker && docker build . --file docker/queue-worker/Dockerfile`
    1. Push to ECR, then create a Cluster, Task Definition (with both the web and worker containers), and Service.
1. (Optional) Create an IAM user with limited permissions and distribute the public/private keys to workshop users.

For the rest of this tutorial, we will assume that the S3 bucket exists at s3://learn-fargate, and that the web application is deployed to http://learn-fargate.videoblocksdev.com (with a default queue worker running).

### Tutorial Steps

1. Navigate your browser to http://learn-fargate.videoblocksdev.com
1. Choose your teammates (in the real world), decide on a team name, and then enter your team in the "Register New Team!" form.
    - Registering your team will launch 10,000 "WatermarkJob" jobs in the queue which is designed to download an image from S3, watermark it, and upload it to your team's S3 folder.
    - The jobs will not begin executing until you create a worker to take items off of your queue!
    - Note: You should see your team directory in S3 after a minute or two: https://s3.amazonaws.com/learn-fargate/teams
1. Now it's time to create your worker image.
    1. First, you'll need to create a Dockerfile which extends "learn-fargate:worker":
        1. Build the "learn-fargate:worker" image:
            ```shell
            $ docker-compose build worker
            ```
        1. Create your own `.env.production` file or get a copy from someone else. This will have the production database information.
            - One is uploaded at https://s3.amazonaws.com/learn-fargate/.env.production (you have to navigate to the S3 console to donwload it because it is private).
            - Make sure you have an AWS Key and Secret defined.
        1. Create your Dockerfile in the root directory (or wherever):

            ```Dockerfile
            FROM learn-fargate:worker
            COPY . /var/www/html
            RUN composer install

            COPY ./docker/queue-worker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
            RUN cp .env.production .env

            # Set file permissions
            RUN chmod -R 777 storage && chmod -R 777 bootstrap/cache

            # Set team name in your environment
            ENV TEAM_NAME="Roughnecks"
            ```
        1. Build your image:
            ```shell
            $ docker build . -t learn-fargate:roughnecks
            ```
        1. Run the image locally just to see if it works:
            ```shell
            $ docker run --rm -it learn-fargate:roughnecks
            ```
1. Next, we want to get your image into Elastic Container Registry. This is where
    1. Login to ECR:
        ```shell
        $ $(aws ecr get-login --no-include-email --region us-east-1)
        ```
    1. Tag your image with the ECR repository tag:
        ```shell
        $ docker tag learn-fargate:roughnecks 031780582162.dkr.ecr.us-east-1.amazonaws.com/learn-fargate:roughnecks
        ```
    1. Push the tagged image to ECR:
        ```shell
        $ docker push 031780582162.dkr.ecr.us-east-1.amazonaws.com/learn-fargate:roughnecks
        ```
1. Now that our docker image is in ECR, ECS will have access to it. Now it's time to create our task.
    1. Navigate to https://console.aws.amazon.com/ecs/home?region=us-east-1#/clusters.
    1. On the left-hand side, click on "Task Definitions" > "Create new Task Definition."
    1. Select "Fargate" and then proceed to enter the necessary configs:
        - Name: < _whatever you wish_ >
        - Task Role: ecsTaskExecutionRole
        - Task memory: < _what RAM does an image encoding task require?_ >
        - Task CPU: < _what CPU does an image encoding task require?_ >
        - Add container:
            - Container name: < _whatever_ >
            - Image: 031780582162.dkr.ecr.us-east-1.amazonaws.com/learn-fargate:roughnecks
        - Create!

1. Once the task is ready, lauching it is as simple as running a few commands:
    ```shell
    $ aws ecs run-task --cluster learn-fargate \
    --task-definition learn-fargate-roughnecks:1 --launch-type FARGATE \
    --network-configuration "awsvpcConfiguration={subnets=[subnet-f83be2d3],securityGroups=[sg-69445911],assignPublicIp=ENABLED}" \
    --count 1
    ```
    You can also launch tasks via the console.
1. Launch away! Check your progress here: http://learn-fargate.videoblocksdev.com/progress
    - See you task in-the-flesh: https://console.aws.amazon.com/ecs/home?region=us-east-1#/clusters/learn-fargate/tasks

---

### Local Development

- `composer install && npm install`
- `docker-compose up -d db`
- `php artisan db:setup` Setup database (hostname and password are hard-coded).
- `php artisan migrate` Migrate tables (ensure the correct db host is provided).
- `APP_ENV=testing php artisan migrate`  Migrate testing tables.
- `docker-compose up -d web`

---

### Todo:
- [ ] Create IAM with limited permissions (or just a temp one)
- [ ] Cloudformation!
