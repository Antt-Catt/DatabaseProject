# Covoiturage

## Build

```
cd database && sudo docker build -t postgres-db-image -f Dockerfile.postgres .
cd website && sudo docker build -t php-app-image . 
```

## Run

```
sudo docker run -d --name postgres-container -p 5432:5432 postgres-db-image
sudo docker run -d --name php-app-container --link postgres-container -p 8080:80 php-app-image
```
