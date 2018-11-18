
# Start the containers
`docker-compuse up -d`

# Create DB schema

`docker exec -i docker-lumen-new_mariadb_1 mysql -uroot -proot --database=sakila < ./image/mysql/scripts/sakila-schema.sql`

# Load data

`docker exec -i docker-lumen-new_mariadb_1 mysql -uroot -proot --database=sakila < ./image/mysql/scripts/sakila-data.sql`
 
# API endpoints

`http://<docker-machine-ip>:8080/api/version`

# Credits
This project is inspired by https://github.com/piobuddev