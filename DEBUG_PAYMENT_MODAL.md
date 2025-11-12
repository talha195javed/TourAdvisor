# 🔍 Debug Payment Modal - Step by Step Guide

## ✅ Debug Logging Added!

I've added comprehensive debug logging to help identify the issue. Here's what to do:

---

## 🧪 Testing Steps

### Step 1: Open Browser Console

1. Open your application in browser
2. Press **F12** (or Right-click → Inspect)
3. Go to **Console** tab
4. Keep it open while testing

### Step 2: Check Stripe Key on Page Load

When the page loads, you should see:
```
Stripe Publishable Key: pk_test_...
```

**If you see:**
- ✅ `pk_test_51ABC...` → Stripe key is loaded correctly
- ❌ `undefined` → **Stripe keys not configured!**

---

## 🎯 Test Payment Flow

### Step 3: Start Booking Process

1. Click "Book Now" on a package
2. Fill in all booking details:
   - Personal Info
   - Travel Details  
   - Passengers
   - (Optional) Visa
   - **Payment Method** → Select "Pay Now with Card"
   - Review & Confirm

### Step 4: Click "Confirm Booking"

Watch the console for these messages:

```
🔵 Starting Stripe payment process...
Booking: {booking_reference: "BK...", ...}
Total amount: 1299.99
Calling API: /stripe/create-payment-intent
```

### Step 5: Check API Response

**Success Case:**
```
API Response: {success: true, clientSecret: "pi_...", paymentIntentId: "pi_..."}
✅ Payment intent created successfully!
Client Secret: pi_3ABC123...
🔄 Switching to stripe-payment section...
Active section set to: stripe-payment
```

**Then you should see the Stripe payment form!** 🎉

**Failure Cases:**

#### Case 1: Stripe Keys Missing
```
❌ Payment intent error: Error
Error response: {message: "Stripe API key not configured"}
```
**Solution:** Add Stripe keys to `.env`

#### Case 2: Authentication Error
```
❌ Payment intent error: 401 Unauthorized
```
**Solution:** Make sure you're logged in

#### Case 3: Server Error
```
❌ Payment intent error: 500 Internal Server Error
Error response: {error: "..."}
```
**Solution:** Check Laravel logs

---

## 🔍 Debug Scenarios

### Scenario A: Payment Modal Appears

**Console shows:**
```
✅ Payment intent created successfully!
🔄 Switching to stripe-payment section...
```

**Modal shows:** Stripe card input form

**Action:** Enter test card and complete payment!

---

### Scenario B: Debug Box Appears

**You see a yellow box with:**
```
⚠️ Debug Information
Active Section: stripe-payment
Client Secret: Missing
Booking ID: 123
Waiting for payment intent...
```

**This means:**
- ✅ Section switched to stripe-payment
- ❌ Client secret not received
- ❌ API call failed

**Check console for error messages!**

---

### Scenario C: Nothing Happens

**Modal stays on Review section**

**Possible causes:**
1. JavaScript error (check console)
2. Payment method not selected
3. Validation error

**Check console for errors!**

---

## 🐛 Common Issues & Solutions

### Issue 1: "Stripe Publishable Key: undefined"

**Problem:** Stripe keys not in `.env`

**Solution:**
```bash
# Add to .env
STRIPE_KEY=pk_test_YOUR_KEY_HERE
STRIPE_SECRET=sk_test_YOUR_SECRET_HERE
VITE_STRIPE_PUBLISHABLE_KEY="${STRIPE_KEY}"

# Rebuild
npm run build

# Hard refresh browser
Ctrl+Shift+R (or Cmd+Shift+R)
```

---

### Issue 2: "Failed to initialize payment"

**Check console for:**
```
❌ Payment intent error: ...
Error response: {...}
```

**Common causes:**
- Stripe secret key not in `.env`
- Stripe PHP package not installed
- Database connection issue
- User not authenticated

**Solution:**
```bash
# Check .env has both keys
STRIPE_KEY=pk_test_...
STRIPE_SECRET=sk_test_...

# Verify Stripe package installed
composer show stripe/stripe-php

# Check Laravel logs
tail -f storage/logs/laravel.log
```

---

### Issue 3: Debug box shows but no payment form

**Console shows:**
```
✅ Payment intent created successfully!
Client Secret: pi_3ABC...
🔄 Switching to stripe-payment section...
```

**But payment form doesn't appear**

**Possible causes:**
1. Stripe.js not loaded
2. React rendering issue
3. Browser cache

**Solution:**
```bash
# Rebuild frontend
npm run build

# Clear browser cache
Ctrl+Shift+R (or Cmd+Shift+R)

# Check for JavaScript errors in console
```

---

## 📋 Checklist

Before testing, verify:

- [ ] Stripe keys in `.env`:
  ```env
  STRIPE_KEY=pk_test_...
  STRIPE_SECRET=sk_test_...
  VITE_STRIPE_PUBLISHABLE_KEY="${STRIPE_KEY}"
  ```

- [ ] Frontend rebuilt:
  ```bash
  npm run build
  ```

- [ ] Browser cache cleared:
  ```
  Ctrl+Shift+R (or Cmd+Shift+R)
  ```

- [ ] User logged in to application

- [ ] Browser console open (F12)

---

## 🎯 Expected Console Output (Success)

```
Stripe Publishable Key: pk_test_51ABC123...
[User fills form and clicks Confirm]
🔵 Starting Stripe payment process...
Booking: {id: 123, booking_reference: "BK20251110...", ...}
Total amount: 1299.99
Calling API: /stripe/create-payment-intent
API Response: {success: true, clientSecret: "pi_3ABC...", paymentIntentId: "pi_3ABC..."}
✅ Payment intent created successfully!
Client Secret: pi_3ABC123_secret_DEF456...
🔄 Switching to stripe-payment section...
Active section set to: stripe-payment
[Stripe payment form appears]
```

---

## 🚨 If Still Not Working

### Collect This Information:

1. **Console Output:**
   - Copy all console messages
   - Include any errors (red text)

2. **Network Tab:**
   - Open Network tab in DevTools
   - Find `/api/stripe/create-payment-intent` request
   - Check Status Code
   - Check Response

3. **Laravel Logs:**
   ```bash
   tail -f storage/logs/laravel.log
   ```

4. **Environment:**
   - Is `VITE_STRIPE_PUBLISHABLE_KEY` in `.env`?
   - Did you rebuild after adding it?
   - Did you hard refresh browser?

---

## 🎉 Success Indicators

You'll know it's working when:

1. ✅ Console shows: `Stripe Publishable Key: pk_test_...`
2. ✅ Console shows: `✅ Payment intent created successfully!`
3. ✅ Console shows: `Active section set to: stripe-payment`
4. ✅ **Stripe card input form appears in modal**
5. ✅ You can enter card number: `4242 4242 4242 4242`

---

## 📞 Next Steps

1. **Test the flow** with console open
2. **Copy console output** if there are errors
3. **Check the specific error message**
4. **Follow the solution** for that error

The debug logging will tell us exactly where the issue is!

---

*Debug version deployed. Check your browser console for detailed logs!*
