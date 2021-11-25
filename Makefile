up:
    docker-compose up -d node postgres adminer

up-prod:
    docker-compose -f docker-compose.yml -f docker-compose.prod.yml up node postgres

down:
    docker-compose down
