# Déploiement Bluehost

## Setup Git Version Control (une seule fois)

1. cPanel → Git Version Control → Create
2. Repository path: `/home2/qqkzfxmy/public_html/salon-emploi`
3. Repository URL: `https://github.com/fmcote/pslab-tools`
4. Branch: `main`
5. Subpath: `salon-emploi/`
6. Cliquer Create

## Déploiement manuel si nécessaire

Dans cPanel → Git Version Control → Manage → Pull

## Variable d'environnement

Dans cPanel → PHP Config ou via `.htaccess`:
```
SetEnv ANTHROPIC_API_KEY sk-ant-...votre-clé...
```

## URL finale

https://pscreativelab.ca/salon-emploi/salon-emploi.html
