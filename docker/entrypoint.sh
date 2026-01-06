#!/bin/bash
set -e

echo "🚀 Starting ENSAT Students Application..."

# Wait for database to be ready
if [ -n "$DB_HOST" ] && [ "$DB_CONNECTION" != "sqlite" ]; then
    echo "⏳ Waiting for database at $DB_HOST:${DB_PORT:-3306}..."
    
    counter=0
    max_attempts=30
    
    until mysql -h "$DB_HOST" -P "${DB_PORT:-3306}" -u "$DB_USERNAME" -p"$DB_PASSWORD" --skip-ssl -e "SELECT 1"; do
        counter=$((counter + 1))
        if [ $counter -gt $max_attempts ]; then
            echo "❌ Database connection failed after $max_attempts attempts"
            exit 1
        fi
        echo "   Attempt $counter/$max_attempts - waiting..."
        sleep 2
    done
    
    echo "✅ Database is ready!"
fi

# Run migrations
echo "📊 Running database migrations..."
php artisan migrate --force --no-interaction

# Check if database needs seeding (only if users table is empty)
USER_COUNT=$(php artisan tinker --execute="echo \App\Models\User::count();")
if [ "$USER_COUNT" -eq "0" ]; then
    echo "🌱 Seeding database..."
    php artisan db:seed --force --no-interaction
else
    echo "✅ Database already seeded (found $USER_COUNT users)"
fi

# Clear and cache configuration
echo "⚡ Optimizing Laravel..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Create storage link if not exists
if [ ! -L public/storage ]; then
    echo "🔗 Creating storage link..."
    php artisan storage:link
fi

# Ensure correct permissions
echo "🔒 Setting permissions..."
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

echo "✅ Application initialized successfully!"
echo "🌐 Ready to serve requests on port 9000"

# Execute the main command (php-fpm)
exec "$@"
