# ECS Fargate Tutorial

Hello, and welcome to the fun and easy introduction to Amazon's Fargate platform in Elastic Container Service. In this tutorial, we will walk you through how to leverage Amazon's powerful container platform to encode thousands of images in only minutes. This project is built using the powerful [Laravel](https://laravel.com/) PHP web framework, which makes it easy to spin up a complex web app with queues and remote storage. 

### Prerequisites

For this tutorial, you are going to need the following:

- An AWS Account
- [Docker](https://www.docker.com/)
- (Optional) [AWS CLI](https://docs.aws.amazon.com/cli/latest/userguide/installing.html)

### Setup

- `artisan db:setup` Setup database (hostname and password are hard-coded).
- `artisan migrate` Migrate tables (ensure the correct db host is provided).
- `APP_ENV=testing artisan migrate`  Migrate testing tables.

---

### Todo:
- [ ] Setup Route53 to point to service.
- [ ] Get prod dockerfile working, gitignore .env file, get worker dockerfile working.
- [ ] Setup production S3 bucket and source-files (readonly and public).
- [ ] Setup custom queues for each team.
- [ ] Store results/progress in the backend and propagate to the front-end.
- [ ] Go through entire process for a pretend team.
- [ ] Finish README.
