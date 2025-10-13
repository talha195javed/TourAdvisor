#!/bin/bash

# TourAdvisor Frontend Start Script
# This script starts both Laravel server and Vite dev server

echo "🚀 Starting TourAdvisor Frontend..."
echo ""

# Check if npm dependencies are installed
if [ ! -d "node_modules" ]; then
    echo "📦 Installing npm dependencies..."
    npm install
    echo ""
fi

# Start Laravel and Vite concurrently
echo "🔥 Starting Laravel server and Vite dev server..."
echo ""
echo "Frontend will be available at: http://localhost:8000"
echo "Admin panel will be available at: http://localhost:8000/admin/login"
echo ""
echo "Press Ctrl+C to stop all servers"
echo ""

# Use concurrently to run both servers
npx concurrently -n "Laravel,Vite" -c "green,blue" \
    "php artisan serve" \
    "npm run dev"
