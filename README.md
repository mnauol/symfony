# "Task Manager" Symfony Project

## Instructions how to run the application

1. [Install Docker, if you don't have it](https://www.docker.com/)
2. Clone this repository
```bash
git clone https://github.com/mnauol/symfony
cd symfony-docker
```
3. Run `docker compose build --no-cache` to build fresh images
4. Run `docker compose up --pull always -d --wait` to set up and start a fresh Symfony project
5. Run `docker exec -it <container_id> php bin/console doctrine:fixtures:load` to upload to database default(test) data
6. Open `https://localhost` in your web browser. 
7. After step 5 you can log in:
- **Server**: `database`
- **Login**: `app`
- **Password**: `!ChangeMe!`

### If you want to stop and delete Docker containers
+ Run `docker compose stop` to stop Docker containers
+ Run `docker compose up -d` to resume stopped containers
+ Run `docker compose down --remove-orphans` to stop and delete Docker containers

## Description of the project

My project is a Symfony-based "Task manager" that allows admins to create, manage and upload tasks for users. The project used Symfony framework and Docker for the development environment.

## Postman Collection
You can see the postman collection by name "Symfony.postman_collection.json"

## Credits
Created by [Olena Nesterets]
