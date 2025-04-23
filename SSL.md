## SSL avec Traefik
# Pour sécuriser le site avec SSL, nous allons utiliser Traefik et Let's Encrypt.

```bash
bash
Copier
Modifier
mkdir -p ./letsencrypt
touch ./letsencrypt/acme.json
chmod 600 ./letsencrypt/acme.json
```

