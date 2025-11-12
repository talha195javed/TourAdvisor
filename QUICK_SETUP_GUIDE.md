# 🚀 Quick Setup Guide - Stripe Payment Integration

## ⚡ Quick Start (5 Minutes)

### Step 1: Get Stripe API Keys

1. Go to https://stripe.com and create an account (or login)
2. Navigate to **Developers** → **API keys**
3. Copy your **Publishable key** (starts with `pk_test_`)
4. Copy your **Secret key** (starts with `sk_test_`)

### Step 2: Configure Environment

Open your `.env` file and add:

```env
STRIPE_KEY=pk_test_YOUR_PUBLISHABLE_KEY_HERE
STRIPE_SECRET=sk_test_YOUR_SECRET_KEY_HERE
VITE_STRIPE_PUBLISHABLE_KEY="${STRIPE_KEY}"
```

**Important:** Replace `YOUR_PUBLISHABLE_KEY_HERE` and `YOUR_SECRET_KEY_HERE` with your actual Stripe keys!

### Step 3: Run Database Migration

```bash
php artisan migrate
```

This will add the new payment fields to your bookings table.

### Step 4: Rebuild Frontend

```bash
npm run build
```

Or for development:

```bash
npm run dev
```

### Step 5: Test It! 🎉

1. Start your server: `php artisan serve`
2. Open the booking modal
3. Fill in booking details
4. Select "Pay Now with Card" as payment method
5. Use test card: `4242 4242 4242 4242`
6. Any future expiry date and any 3-digit CVC
7. Complete the payment!

---

## 🧪 Test Cards

| Card Number | Result |
|------------|--------|
| 4242 4242 4242 4242 | ✅ Success |
| 4000 0000 0000 0002 | ❌ Decline |
| 4000 0025 0000 3155 | 🔒 3D Secure |

---

## 🎯 Payment Options Available

### 1. **Pay Now with Card** 💳
- Immediate Stripe payment
- Secure card processing
- Instant confirmation

### 2. **Cash Payment** 💵
- Pay on arrival
- Booking confirmed
- Admin verifies later

### 3. **Personal Payment** 🤝
- Arrange payment directly
- Flexible payment terms
- Admin managed

### 4. **Pay Later** ⏰
- Complete booking now
- Pay anytime later
- **Can edit booking before payment!**

---

## ✏️ Edit Booking Feature

Users can edit their bookings if they selected "Pay Later":

- Edit personal information
- Change travel dates
- Update passenger details
- Modify special requests

**Once payment is made, booking cannot be edited.**

---

## 📱 API Endpoints

### Create Booking
```
POST /api/bookings
```

### Edit Booking
```
PUT /api/bookings/{id}
```

### Make Payment Later
```
POST /api/bookings/{id}/pay
```

### Create Payment Intent
```
POST /api/stripe/create-payment-intent
```

### Confirm Payment
```
POST /api/stripe/confirm-payment
```

---

## 🔧 Troubleshooting

### Issue: "Stripe is not defined"
**Solution:** Rebuild frontend
```bash
npm run build
```

### Issue: Payment fails
**Solution:** Check Stripe keys in `.env` file

### Issue: Can't edit booking
**Solution:** Check if `can_edit_before_payment` is true and payment hasn't been made

---

## 📚 Full Documentation

See `STRIPE_PAYMENT_INTEGRATION.md` for complete details.

---

## ✅ Production Checklist

Before going live:

- [ ] Replace test Stripe keys with live keys
- [ ] Enable HTTPS
- [ ] Test all payment flows
- [ ] Set up Stripe webhooks
- [ ] Configure email notifications
- [ ] Test on mobile devices

---

## 🎉 You're All Set!

Your booking system now has:
- ✅ Stripe payment integration
- ✅ Multiple payment options
- ✅ Edit booking capability
- ✅ Secure payment processing
- ✅ Beautiful UI/UX

**Happy booking!** 🚀
