# Garnet App

Garnet: a progress tracker

## Usage for development (first run)

- Copy example environment files for Docker and fill the missing values
  ```
  cp ./environment/mariadb.env.example ./environment/mariadb.env
  cp ./environment/php.env.example ./environment/php.env
  ```
- Fill and/or edit environment files
- [TODO: Remove] Copy Docker PHP environment file to `backend` folder
  ```
  cp ./environment/php.env ./backend/src/.env
  ```
- Start Docker compose services and install dependencies
  ```
  docker-compose up -d php mariadb adminer
  docker-compose run --rm composer install
  ```
- Open Adminer on port http://localhost:8081
- Import `./database/schema.sql`
- Import `./database/mock.sql` for some mock data
- Run the frontend on port 4200 (automatically opens browser at the end)
  ```
  cd frontend
  npm install
  npm run start -- --open
  ```

## Scripts

To run any script, you first have to run `npm install` in the root folder

- Create random API Key locally
```
npm run make:api-key
```

### How to recover a corrupted Git repository

https://github.com/microsoft/WSL/issues/5026#issuecomment-751779330

```
rm -rf .git &&                    # delete old corrupted repo
git init &&                       # initialise new repo
git remote add origin "${url}" && # link to old repo
git fetch &&                      # get old history
git reset origin/main --hard &&   # force update to old history
git branch -m master main &&      # rename local branch as "main" if needed
git branch -u origin/main         # track local "main" with online "main"
```
