# Adafi News App (LAMP Stack on AWS ECS) new

A containerized PHP-based news application deployed on AWS using ECS Fargate and an Application Load Balancer (ALB). The app is connected to an Amazon RDS MySQL database and follows DevOps best practices including Docker, ECR, secure secrets management, and infrastructure deployment via AWS CLI.

---

## 🌐 Live URL

**[http://adafi-alb-1546447544.eu-west-1.elb.amazonaws.com](http://adafi-alb-1546447544.eu-west-1.elb.amazonaws.com)**

---

## 🧱 Stack Overview

* **Frontend/Backend:** PHP + HTML (LAMP-style)
* **Database:** Amazon RDS MySQL
* **Infrastructure:**

  * Amazon ECS (Fargate)
  * Amazon ECR (Docker image)
  * ALB (Application Load Balancer)
  * Custom VPC with Public & Private Subnets
* **Tools:** Docker, Composer, AWS CLI

---

## 🚀 Features

* Submit and view news articles with images
* Image upload handling
* `.env` configuration with `phpdotenv`
* Runs locally with Docker or deploys to AWS via ECS

---

## 🧪 Local Setup

```bash
git clone https://github.com/<your-username>/adafi-news-app.git
cd adafi-news-app

# Create .env file with DB connection details
touch .env
# Add variables: DB_HOST, DB_NAME, DB_USER, DB_PASS

# Build and run locally with Docker
docker build -t adafi-app .
docker run -d -p 8080:80 \
  --name adafi-local \
  -e DB_HOST=<rds-endpoint> \
  -e DB_NAME=adafi_db \
  -e DB_USER=admin \
  -e DB_PASS=AdafiPass123! \
  adafi-app
```

App will be available at: `http://localhost:8080`

---

## ☁️ AWS Deployment Steps (CLI)

### 1. Create VPC & Subnets (once per environment)

```bash
# Already created: general-lab-vpc with tagged public/private subnets
```

### 2. Build & Push Docker Image to ECR

```bash
docker build -t adafi-app .
aws ecr create-repository --repository-name adafi-app

# Tag & push
docker tag adafi-app:latest <account_id>.dkr.ecr.eu-west-1.amazonaws.com/adafi-app:latest
docker push <account_id>.dkr.ecr.eu-west-1.amazonaws.com/adafi-app:latest
```

### 3. Register Task Definition

```bash
aws ecs register-task-definition \
  --family adafi-task \
  --network-mode awsvpc \
  --requires-compatibilities FARGATE \
  --execution-role-arn arn:aws:iam::<account_id>:role/ecsTaskExecutionRole \
  --container-definitions file://container-def.json
```

### 4. Create ALB + Target Group

```bash
aws elbv2 create-load-balancer --name adafi-alb ...
aws elbv2 create-target-group --name adafi-targets ...
aws elbv2 create-listener --load-balancer-arn <alb-arn> --port 80 ...
```

### 5. Deploy ECS Service

```bash
aws ecs create-service \
  --cluster adafi-cluster \
  --service-name adafi-service \
  --task-definition adafi-task \
  --desired-count 1 \
  --launch-type FARGATE \
  --network-configuration awsvpcConfiguration={...} \
  --load-balancers ...
```

---

## 📂 Folder Structure

```
adafi-news-app/
├── app/
│   ├── config/           # db.php, dotenv
│   ├── includes/         # header.php, footer.php
│   ├── views/            # home.php, add.php
│   └── uploads/          # uploaded images
├── public/               # index.php, upload.php
├── Dockerfile
├── docker-compose.yml (optional)
├── composer.json / lock
└── README.md
```

---

## 🔐 Secrets Handling

Environment variables are passed securely via Docker `-e` flags or `.env` files. In production, use AWS Secrets Manager or Systems Manager Parameter Store.

---

## 📸 Screenshots to Capture for Submission

* ECS Cluster: `describe-services`
* ALB DNS test in browser
* Target group health
* `docker push` to ECR
* CLI task definition and service commands

---

## 📘 Credits

Built by Michael Odartei Lamptey as part of DevOps Phase 2 project.
