# Minikube

## Lancement

Démarrer le cluster :
```
minikube start --driver=docker --ports=30000:30000,30001:30001
```

Appliquer les fichiers de configuration :
```
kubectl apply -f pod.yaml
kubectl apply -f service.yaml
```

Une fois que le pod a fini de se créer (environ 2min), le site est accessible sur localhost:30000

## Suppression

Supprimer le cluster : 
```
minikube delete
```
