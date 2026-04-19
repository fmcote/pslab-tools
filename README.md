# PSLab Tools

Infrastructure de déploiement pour les outils web de P&S Lab.

## Structure

```
pslab-tools/
├── salon-emploi/          # Analyseur CV - Salon emploi 23 avril 2026
│   ├── index.html         # Interface utilisateur
│   └── claude-proxy.php   # Proxy API Anthropic (clé côté serveur)
├── .github/
│   └── workflows/
│       └── deploy.yml     # CI/CD auto-déploiement vers Bluehost
└── README.md
```

## Déploiement

Push sur `main` → déploiement automatique sur pscreativelab.ca via FTP.

## Architecture

- **Frontend** : HTML/CSS/JS statique
- **Backend** : PHP proxy (clé API jamais exposée au client)
- **Hébergement** : Bluehost (pscreativelab.ca)
- **CI/CD** : GitHub Actions → FTP deploy

## Ajouter un nouvel outil

1. Créer un dossier `nom-outil/`
2. Ajouter `index.html` + `proxy.php` si nécessaire
3. Push → déploiement auto
