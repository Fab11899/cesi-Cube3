# Minikube

## Installation

## Lancement

Démarrer le cluster :
```
minikube start --driver=docker --ports=8000:8000,5173:5173
```

Appliquer les fichiers de configuration :
```
kubectl apply -f pod.yaml
kubectl apply -f service.yaml
```

Démarrer le service :
```
minikube service breizhsport-service
```

## Suppression

Supprimer le cluster : 
```
minikube delete
```
