# LARAVEL DOCKER EXAMPLE

# How to run project
1. Build image container
```bash
docker-compose build --no-cache
```
2. Start container
```bash
docker-compose up -d
```
3. To start source on local. First, we need start docker in root folder, you can refer from `README.md` file on root 
folder.(`cd` to project an run terminal)

```bash
docker exec -it trainning-php bash
```
4. Copy `.env.example` to `.env` then update some environment variables in this file such as `APP_URL, DB_DATABASE,...`,

5. Then run some commands line in docker container:
```shell
composer install

php artisan key:generate

php artisan jwt:secret

php artisan migrate

php artisan db:seed

cp -rf resources/images/* storage/app/trainning

php artisan storage:link
```

4. Run website
- Link: open browser and go to http://localhost:8006

Another Cli:
- Stop container
```bash
docker-compose down
```

## How to generate API documentation using Swagger
Note: Run `docker-compose up -d` first

1. Cd root directory
2. Run bash
```shell
docker-compose exec app bash -c "cp -r resources/swagger-api/* storage/api-docs"
```
3. Open browser and go to links as below to see the generated documentation:
- Api document: http://localhost:8006/api/docs/admin

4. Install [Postman](https://www.postman.com/) to manage apis on local then import the latest environment files from [ggdrive](https://drive.google.com/drive/folders/folder_api_name)

**See syntax of [OpenApi](https://oai.github.io/Documentation/specification-structure.html)**
