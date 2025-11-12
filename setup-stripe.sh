#!/bin/bash

# Stripe Setup Script
# This script helps you add Stripe keys to your .env file

echo "🔧 Stripe Payment Setup"
echo "======================="
echo ""

# Check if .env exists
if [ ! -f .env ]; then
    echo "❌ Error: .env file not found!"
    echo "Please copy .env.example to .env first:"
    echo "  cp .env.example .env"
    exit 1
fi

echo "📝 Please enter your Stripe API keys"
echo "You can get them from: https://dashboard.stripe.com/test/apikeys"
echo ""

# Get Publishable Key
read -p "Enter your Stripe Publishable Key (pk_test_...): " STRIPE_KEY
if [ -z "$STRIPE_KEY" ]; then
    echo "❌ Error: Publishable key cannot be empty!"
    exit 1
fi

# Get Secret Key
read -p "Enter your Stripe Secret Key (sk_test_...): " STRIPE_SECRET
if [ -z "$STRIPE_SECRET" ]; then
    echo "❌ Error: Secret key cannot be empty!"
    exit 1
fi

echo ""
echo "✅ Adding Stripe keys to .env file..."

# Check if keys already exist
if grep -q "STRIPE_KEY=" .env; then
    # Update existing keys
    sed -i.bak "s|STRIPE_KEY=.*|STRIPE_KEY=$STRIPE_KEY|" .env
    sed -i.bak "s|STRIPE_SECRET=.*|STRIPE_SECRET=$STRIPE_SECRET|" .env
    sed -i.bak "s|VITE_STRIPE_PUBLISHABLE_KEY=.*|VITE_STRIPE_PUBLISHABLE_KEY=\"\${STRIPE_KEY}\"|" .env
    echo "✅ Updated existing Stripe keys"
else
    # Add new keys
    echo "" >> .env
    echo "# Stripe Payment Configuration" >> .env
    echo "STRIPE_KEY=$STRIPE_KEY" >> .env
    echo "STRIPE_SECRET=$STRIPE_SECRET" >> .env
    echo "VITE_STRIPE_PUBLISHABLE_KEY=\"\${STRIPE_KEY}\"" >> .env
    echo "✅ Added Stripe keys to .env"
fi

echo ""
echo "🔨 Rebuilding frontend..."
npm run build

echo ""
echo "🧹 Clearing Laravel cache..."
php artisan config:clear
php artisan cache:clear

echo ""
echo "✅ Setup complete!"
echo ""
echo "🎉 You can now test Stripe payments!"
echo ""
echo "Test Card: 4242 4242 4242 4242"
echo "Expiry: Any future date (e.g., 12/25)"
echo "CVC: Any 3 digits (e.g., 123)"
echo ""
echo "Happy testing! 🚀"
