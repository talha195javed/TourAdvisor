# 🚀 How to Start Your Booking System

## ⚠️ IMPORTANT: You're in the Wrong Directory!

You're currently in: `VisitorManagementApp`
You need to be in: `booking_admin_dashboard`

---

## 📂 Navigate to Correct Directory

```bash
cd ~/Desktop/booking_admin_dashboard
```

Or from your current location:

```bash
cd ../booking_admin_dashboard
```

---

## 🔧 Complete Setup & Start Commands

### Step 1: Navigate to Project Directory

```bash
cd ~/Desktop/booking_admin_dashboard
```

### Step 2: Add Stripe Keys to .env

**Option A: Use the automated script**
```bash
./setup-stripe.sh
```

**Option B: Manual setup**

Edit your `.env` file and add:
```env
STRIPE_KEY=pk_test_YOUR_PUBLISHABLE_KEY_HERE
STRIPE_SECRET=sk_test_YOUR_SECRET_KEY_HERE
VITE_STRIPE_PUBLISHABLE_KEY="${STRIPE_KEY}"
```

Get keys from: https://dashboard.stripe.com/test/apikeys

### Step 3: Rebuild Frontend

```bash
npm run build
```

### Step 4: Start the Server

```bash
php artisan serve
```

The server will start at: http://localhost:8000

---

## 🎯 Quick Start (Copy-Paste)

```bash
# Navigate to project
cd ~/Desktop/booking_admin_dashboard

# Add Stripe keys (automated)
./setup-stripe.sh

# OR add manually to .env, then:
npm run build

# Start server
php artisan serve
```

---

## 🌐 Access Your Application

Once the server is running:

- **Frontend:** http://localhost:8000
- **Admin Panel:** http://localhost:8000/admin

---

## 🧪 Test Stripe Payment

1. Open http://localhost:8000
2. Browse packages
3. Click "Book Now"
4. Fill in booking details
5. Select "Pay Now with Card"
6. Use test card: `4242 4242 4242 4242`
7. Complete payment!

---

## 🔍 Verify You're in the Right Directory

Before running commands, check:

```bash
pwd
```

Should show: `/Users/mtalhajaved/Desktop/booking_admin_dashboard`

If not, navigate there:
```bash
cd ~/Desktop/booking_admin_dashboard
```

---

## 📋 Available Commands (in booking_admin_dashboard)

```bash
# Start Laravel server
php artisan serve

# Build frontend for production
npm run build

# Run frontend in development mode
npm run frontend

# Run migrations
php artisan migrate

# Clear cache
php artisan cache:clear
php artisan config:clear

# Setup Stripe keys
./setup-stripe.sh
```

---

## ⚠️ Common Mistakes

### ❌ Wrong Directory
```bash
mtalhajaved@Mac VisitorManagementApp % php artisan serve
Could not open input file: artisan
```

### ✅ Correct Directory
```bash
mtalhajaved@Mac booking_admin_dashboard % php artisan serve
Starting Laravel development server: http://127.0.0.1:8000
```

---

## 🎉 You're All Set!

After navigating to the correct directory and adding Stripe keys:

1. ✅ Database is ready (migration already run)
2. ✅ Code is ready (all files in place)
3. ⏳ Add Stripe keys
4. ⏳ Start server
5. ⏳ Test payment!

---

*Make sure you're in `/Users/mtalhajaved/Desktop/booking_admin_dashboard` before running any commands!*
