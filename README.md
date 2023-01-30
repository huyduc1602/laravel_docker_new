# LARAVEL_EXAMPLE

# How to run project
1. Build image container
```bash
docker-compose build --no-cache
```
2. Start container
```bash
docker-compose up -d
```
3. Install packages in source app-backend
```bash
winpty docker exec -it   phpfpm bash -c "composer install"
```
4. Run website
- Link: open browser and go to http://localhost

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
- Api document: http://localhost/api/docs/admin

4. Install [Postman](https://www.postman.com/) to manage apis on local then import the latest environment files from [ggdrive](https://drive.google.com/drive/folders/folder_api_name)

**See syntax of [OpenApi](https://oai.github.io/Documentation/specification-structure.html)**