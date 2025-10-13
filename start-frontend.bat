@echo off
echo Starting TourAdvisor Frontend...
echo.

REM Check if node_modules exists
if not exist "node_modules" (
    echo Installing npm dependencies...
    call npm install
    echo.
)

echo Starting Laravel server and Vite dev server...
echo.
echo Frontend will be available at: http://localhost:8000
echo Admin panel will be available at: http://localhost:8000/admin/login
echo.
echo Press Ctrl+C to stop all servers
echo.

REM Start both servers using concurrently
npx concurrently -n "Laravel,Vite" -c "green,blue" "php artisan serve" "npm run dev"
