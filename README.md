Pour lancer l'appli dans un container docker :
1. Avoir docker d'installé (et oui...)
2. Renommer le .env.example en .env
3. Se positionner à la racine du projet
4. Taper la commande : docker compose up --build
5. Accéder au front via localhost:8000 (vite sur localhost:5173)

Si il y a besoin de relancer :
1. Taper la commande : docker compose down --volumes
2. Taper la commande : docker compose up --build
