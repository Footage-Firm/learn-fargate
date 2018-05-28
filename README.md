# ECS Fargate Tutorial

Hello, and welcome to the fun and easy introduction to Amazon's Fargate platform in Elastic Container Service. In this tutorial, we will walk you through how to leverage Amazon's powerful container platform to encode thousands of images in only minutes. This project is built using the powerful [Laravel](https://laravel.com/) PHP web framework, which makes it easy to spin up a complex web app with queues and remote storage. 

### Prerequisites

For this tutorial, you are going to need the following:

- An AWS Account
- [Docker](https://www.docker.com/)
- (Optional) [AWS CLI](https://docs.aws.amazon.com/cli/latest/userguide/installing.html)

### Setup
- TODO

### Instructions
- TODO

---

## Development

### Setup Database
```bash
docker-compose up -d db
mysql -h 0.0.0.0 -u root -pVBrootFTW\! < docker/db/setup_db.sql
php artisan migrate
```
