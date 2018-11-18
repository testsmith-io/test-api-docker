
# Start the containers
`docker-compuse up -d`

# Install application dependencies
docker-compose exec php bash -c "cd /var/www/html && composer update --no-dev"

# Create DB schema

`docker exec -i test-api-docker_mariadb_1 mysql -uroot -proot --database=sakila < ./image/mysql/scripts/sakila-schema.sql`

# Load data

`docker exec -i test-api-docker_mariadb_1 mysql -uroot -proot --database=sakila < ./image/mysql/scripts/sakila-data.sql`
 
# API endpoints

`http://<docker-machine-ip>:8080/api/version`

# Credits
This project is inspired by https://github.com/piobuddev