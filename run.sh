#!/bin/sh

# Default to development if no environment specified
# Exemple sh ./run.sh dev
ENV=${1:-dev}

case $ENV in
  dev|development)
    echo "🚀 Starting development environment..."
    docker-compose down
    docker-compose up --build -d
    php artisan storage:link
    echo "✅ Development environment started!"
    echo "📊 Frontend: http://localhost:3000"
    echo "⚙️ Backend API: http://localhost:8000"
    echo "🗄️ Database: localhost:3306"
    ;;
    
  prod|production)
    echo "🚀 Starting production environment..."
    docker-compose -f docker-compose.prod.yml down
    docker-compose -f docker-compose.prod.yml up -d
    php artisan storage:link
    echo "✅ Production environment started!"
    echo "📊 Frontend: https://matchroom.online"
    echo "⚙️ Backend API: https://api.matchroom.online"
    echo "📈 Traefik Dashboard: https://traefik.matchroom.online"
    ;;
    
  *)
    echo "❌ Unknown environment: $ENV"
    echo "Usage: ./run-environment.sh [dev|prod]"
    exit 1
    ;;
esac