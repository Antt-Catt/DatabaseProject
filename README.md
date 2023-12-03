# Covoiturage

## Construction

```bash
cd database && sudo docker build -t postgres-db-image -f Dockerfile.postgres . && cd ..
cd website && sudo docker build -t php-app-image . && cd ..
```

## Lancement

```bash
cd database && sudo docker run -d --name postgres-container -p 5432:5432 postgres-db-image && cd ..
cd website && sudo docker run -d --name php-app-container --link postgres-container -p 8080:80 php-app-image && cd ..
```

L'application est alors accessible à l'url : http://localhost:8080.

## Arrêt

Lister les conteneurs :
```bash
sudo docker ps -a
```

Arrêter un conteneurs :
```bash
sudo docker stop <CONTAINER_ID>
```

Lancer un conteneurs après un arrêt :
```bash
sudo docker start <CONTAINER_ID>
```

## Suppression

Supprimer les conteneurs :
```bash
sudo docker rm <CONTAINER ID>
```

Lister les images :
```bash
sudo docker images
```

Suprimer les images :
```bash
sudo docker rim <IMAGE_ID>
```
