# 🔧 Troubleshooting Blank White Page

## Quick Diagnosis Steps

### Step 1: Check Browser Console
1. Open the page: http://127.0.0.1:8000
2. Press **F12** (or right-click → Inspect)
3. Click the **Console** tab
4. Look for any **red error messages**

### Step 2: Check Network Tab
1. In DevTools, click the **Network** tab
2. Refresh the page (Ctrl+R or Cmd+R)
3. Look for any **failed requests** (red status codes)
4. Check if these files load successfully:
   - `http://localhost:5173/@vite/client`
   - `http://localhost:5173/resources/css/app.css`
   - `http://localhost:5173/resources/frontend/main.jsx`

---

## Common Issues & Solutions

### Issue 1: Vite Not Running
**Symptoms:** Network tab shows failed requests to localhost:5173

**Solution:**
```bash
# Stop any running npm processes
# Press Ctrl+C in the terminal running npm

# Start Vite again
npm run dev
```

### Issue 2: Port 5173 Blocked
**Symptoms:** Can't connect to localhost:5173

**Solution:**
```bash
# Kill any process on port 5173
lsof -ti:5173 | xargs kill -9

# Restart Vite
npm run dev
```

### Issue 3: React Error
**Symptoms:** Console shows React errors

**Solution:** Check the specific error message and:
1. Look for component import errors
2. Check for syntax errors in JSX
3. Verify all dependencies are installed

### Issue 4: CORS or Mixed Content
**Symptoms:** Console shows CORS or mixed content errors

**Solution:** Both servers must be running:
```bash
# Terminal 1
php artisan serve

# Terminal 2
npm run dev
```

---

## Test Basic React Rendering

If you want to test if React is working at all:

1. Open `resources/frontend/main.jsx`
2. Change line 15: `const USE_TEST_APP = false;` to `const USE_TEST_APP = true;`
3. Save and refresh browser
4. You should see "React is Working! ✅"

If this works, the issue is in the App component or routing.

---

## Check Console Logs

The app now has console logging. Check for these messages:
- ✅ "React app starting..."
- ✅ "Root element: <div id="app"></div>"
- ✅ "React app rendered"

If you see these, React is loading but might have a rendering error.

---

## Manual Checks

### 1. Verify Servers Are Running

**Check Laravel:**
```bash
curl -I http://127.0.0.1:8000/
# Should return: HTTP/1.1 200 OK
```

**Check Vite:**
```bash
curl -I http://localhost:5173/
# Should return: HTTP/1.1 200 OK
```

### 2. Check if React Files Load

```bash
curl http://localhost:5173/resources/frontend/main.jsx | head -20
# Should show JavaScript code
```

### 3. View Page Source
1. Right-click on blank page → "View Page Source"
2. Look for: `<script type="module" src="http://localhost:5173/@vite/client"`
3. This should be present in the HTML

---

## What to Report

If still blank, please provide:

1. **Console errors** (from F12 → Console tab)
2. **Network errors** (from F12 → Network tab, any red items)
3. **Console logs** (the messages starting with "React app...")

---

## Quick Fix: Restart Everything

```bash
# Stop all servers (Ctrl+C in both terminals)

# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Restart
# Terminal 1:
php artisan serve

# Terminal 2:
npm run dev

# Refresh browser with hard reload: Ctrl+Shift+R (or Cmd+Shift+R on Mac)
```

---

## Still Not Working?

Try accessing Vite directly:
- Visit: http://localhost:5173/resources/frontend/main.jsx
- If this shows JavaScript code, Vite is working
- If this fails, Vite isn't running properly

---

## Emergency: Build Production Assets

If dev mode isn't working, try production build:

```bash
npm run build
```

Then refresh: http://127.0.0.1:8000

This will use built assets instead of Vite dev server.
