up:
    docker-compose up -d node mariadb adminer

up-prod:
    docker-compose -f docker-compose.yml -f docker-compose.prod.yml up node mariadb

down:
    docker-compose down
