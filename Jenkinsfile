pipeline {
    agent any

    environment {
        GIT_COMMIT_SHORT = "${sh(script: 'git rev-parse --short HEAD', returnStdout: true).trim()}"
    }

    stages {
        stage('Checkout') {
            steps {
                git branch: 'main', url: 'https://github.com/okello23/labspars2.git'
            }
        }

        stage('Create Dockerfile') {
            steps {
                writeFile file: 'Dockerfile', text: '''
FROM php:8.1-fpm

# Install required extensions and dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    unzip \
    git \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install pdo_mysql zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html/labspars

# Copy application files
COPY . /var/www/html/labspars

# Install dependencies
RUN composer install --no-interaction --no-dev --optimize-autoloader

# Set permissions
RUN chown -R www-data:www-data /var/www/html/labspars/storage
RUN chown -R www-data:www-data /var/www/html/labspars/bootstrap/cache
RUN chmod -R 777 /var/www/html/labspars
'''
            }
        }

        stage('Build Docker Image') {
            steps {
                sh "docker build -t labsparsdockerimg:${env.GIT_COMMIT_SHORT} ."
            }
        }

        stage('Deploy Laravel Application Locally') {
            steps {
                // Create Docker Compose file dynamically
                writeFile file: 'docker-compose.yml', text: '''
version: '3.8'

services:
  app:
    image: labsparsdockerimg:${GIT_COMMIT_SHORT}
    ports:
      - "8081:8080"
    volumes:
      - .:/var/www/html/labspars
    environment:
      APP_ENV: local
      APP_KEY: "base64:ySxZVnws0cWt6eb8iSgrvn0mqHv71YwaBA1zGWXNS2w="
      DB_CONNECTION: mysql
      DB_HOST: db
      DB_PORT: 3306
      DB_DATABASE: labspars
      DB_USERNAME: ben
      DB_PASSWORD: 68965
    depends_on:
      - db

  db:
    image: mysql:8.0
    environment:
      MYSQL_ROOT_PASSWORD: 68965
      MYSQL_DATABASE: labspars
      MYSQL_USER: ben
      MYSQL_PASSWORD: 68965
    volumes:
      - db_data:/var/lib/mysql

volumes:
  db_data:
'''
                // Deploy locally
                sh "docker-compose down && docker-compose up -d --build"
            }
        }
    }

    post {
        always {
            echo "Pipeline execution complete. Application should now be running locally at http://localhost:8080"
        }
    }
}
