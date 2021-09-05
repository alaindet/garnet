sudo docker-compose up -d php mariadb adminer &&
sudo rm -rf ./backend/src/vendor &&
docker-compose run --rm composer install &&
cd frontend &&
npm run start -- --open