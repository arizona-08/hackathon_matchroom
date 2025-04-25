# Comment setup le projet

## Il y a des .env.example à renommer en .env
./.env.example => ./env
./frontend/.env        => ./frontend/.env
./backend/.env.example => ./backend/.env

## Les commandes

docker-compose up --build -d 

Puis 

php artisan storage:link

Faire sur sa machine 

composer install dans le dossier backend

docker compose restart

on rentre dans le container backend

docker exec -it backend bash 

php artisan migrate

on sort du container

# S'il y a des soucis avec le front 

rentre dans le container frontend

docker exec -it frontend sh

npm install

npm install ipx 

docker compose restart



