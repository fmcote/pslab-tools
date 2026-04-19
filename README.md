# PSLab Tools

Outils IA déployés sur pscreativelab.ca

## Structure
```
salon-emploi/
  salon-emploi.html   # Interface CV analyser
  claude-proxy.php    # Proxy API Anthropic (clé côté serveur)
```

## Déploiement
Connecté à Bluehost via Git Version Control.
Push sur `main` → déploiement automatique sur pscreativelab.ca/salon-emploi/

## Configuration
La clé API Anthropic est dans `claude-proxy.php` — ne jamais committer une vraie clé.
Utiliser la variable d'environnement `ANTHROPIC_API_KEY` en production.

## Architecture service
- `salon-emploi/` — Outil #1 : Analyseur CV pour salon d'emploi
- (à venir) `outils/` — Autres outils P&S Lab
