# 🔐 Authentication System Implementation Guide

## ✅ Complete Authentication System with Login/Signup

This guide documents the complete authentication system that has been implemented for the booking platform.

---

## 🎯 Overview

The system now includes:
- ✅ Client registration and login
- ✅ JWT token-based authentication using Laravel Sanctum
- ✅ Protected booking routes (requires login)
- ✅ Client information stored in database
- ✅ Client ID linked to bookings
- ✅ User menu with logout functionality
- ✅ Automatic redirect to login when booking

---

## 📊 Database Structure

### 1. **Clients Table**
```sql
CREATE TABLE clients (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(255) NULL,
    country VARCHAR(255) NULL,
    address TEXT NULL,
    email_verified_at TIMESTAMP NULL,
    remember_token VARCHAR(100) NULL,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

### 2. **Bookings Table Update**
```sql
ALTER TABLE bookings 
ADD COLUMN client_id BIGINT NULL AFTER id,
ADD FOREIGN KEY (client_id) REFERENCES clients(id) ON DELETE SET NULL;
```

---

## 🔧 Backend Implementation

### 1. **Client Model** (`app/Models/Client.php`)
```php
class Client extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'phone', 'country', 'address'
    ];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
```

### 2. **Booking Model Update**
```php
// Added to fillable
'client_id'

// Added relationship
public function client()
{
    return $this->belongsTo(Client::class);
}
```

### 3. **Authentication Controller** (`app/Http/Controllers/API/AuthController.php`)

#### Available Endpoints:

**Register:**
```
POST /api/auth/register
Body: {
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password123",
    "password_confirmation": "password123",
    "phone": "+1234567890",
    "country": "United States",
    "address": "123 Main St"
}
Response: {
    "success": true,
    "message": "Registration successful!",
    "client": {...},
    "token": "..."
}
```

**Login:**
```
POST /api/auth/login
Body: {
    "email": "john@example.com",
    "password": "password123"
}
Response: {
    "success": true,
    "message": "Login successful!",
    "client": {...},
    "token": "..."
}
```

**Logout:**
```
POST /api/auth/logout
Headers: Authorization: Bearer {token}
Response: {
    "success": true,
    "message": "Logged out successfully!"
}
```

**Get Current User:**
```
GET /api/auth/me
Headers: Authorization: Bearer {token}
Response: {
    "success": true,
    "client": {...}
}
```

**Get My Bookings:**
```
GET /api/auth/my-bookings
Headers: Authorization: Bearer {token}
Response: {
    "success": true,
    "bookings": [...]
}
```

### 4. **Protected Booking Route**
```php
// routes/api.php
Route::middleware('auth:sanctum')->post('/bookings', function (Request $request) {
    // Get authenticated client
    $client = $request->user();
    
    // Create booking with client_id
    $booking = Booking::create([
        'client_id' => $client->id,
        // ... other fields
    ]);
});
```

---

## 🎨 Frontend Implementation

### 1. **Authentication Context** (`resources/frontend/context/AuthContext.jsx`)

Provides authentication state and methods throughout the app:
```javascript
const { client, token, isAuthenticated, login, register, logout } = useAuth();
```

### 2. **Login Page** (`resources/frontend/pages/Login.jsx`)
- Email and password fields
- Form validation
- Error handling
- Redirect after login
- Link to signup page

### 3. **Signup Page** (`resources/frontend/pages/Signup.jsx`)
- Full name, email, password fields
- Optional: phone, country, address
- Password confirmation
- Client-side validation
- Auto-login after registration

### 4. **Protected Routes**
```javascript
// PackageDetail.jsx - Book Now button
const handleBookNowClick = () => {
    if (!isAuthenticated) {
        navigate('/login', { state: { from: location } });
        return;
    }
    setIsBookingModalOpen(true);
};
```

### 5. **Navbar Updates**
- Shows Login/Signup buttons for guests
- Shows user menu with name for authenticated users
- Dropdown menu with logout option
- Mobile-responsive design

### 6. **API Integration** (`resources/frontend/services/api.js`)
```javascript
// Automatically adds auth token to all requests
api.interceptors.request.use((config) => {
    const token = localStorage.getItem('auth_token');
    if (token) {
        config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
});
```

---

## 🔄 Authentication Flow

### Registration Flow:
```
1. User clicks "Sign Up" → Signup page
2. User fills form → Submit
3. POST /api/auth/register
4. Backend creates client → Returns token
5. Frontend stores token in localStorage
6. User redirected to home page (authenticated)
```

### Login Flow:
```
1. User clicks "Login" → Login page
2. User enters credentials → Submit
3. POST /api/auth/login
4. Backend validates → Returns token
5. Frontend stores token in localStorage
6. User redirected to previous page or home
```

### Booking Flow (Protected):
```
1. User clicks "Book Now"
2. System checks authentication:
   - If NOT authenticated → Redirect to /login
   - If authenticated → Open booking modal
3. User fills booking form
4. POST /api/bookings (with Bearer token)
5. Backend gets client from token
6. Booking created with client_id
7. Success message shown
```

### Logout Flow:
```
1. User clicks "Logout" in menu
2. POST /api/auth/logout (with token)
3. Backend deletes token
4. Frontend removes token from localStorage
5. User redirected to home page (guest)
```

---

## 🗂️ File Structure

### Backend Files:
```
app/
├── Models/
│   ├── Client.php (NEW)
│   └── Booking.php (UPDATED)
├── Http/Controllers/API/
│   └── AuthController.php (NEW)
database/migrations/
├── 2025_11_06_000001_create_clients_table.php (NEW)
└── 2025_11_06_000002_add_client_id_to_bookings_table.php (NEW)
routes/
└── api.php (UPDATED)
```

### Frontend Files:
```
resources/frontend/
├── context/
│   └── AuthContext.jsx (NEW)
├── pages/
│   ├── Login.jsx (NEW)
│   ├── Signup.jsx (NEW)
│   └── PackageDetail.jsx (UPDATED)
├── components/
│   ├── Navbar.jsx (UPDATED)
│   ├── ProtectedRoute.jsx (NEW)
│   └── BookingModal.jsx (UPDATED)
├── services/
│   ├── api.js (UPDATED)
│   └── authAPI.js (NEW)
└── App.jsx (UPDATED)
```

---

## 🔐 Security Features

1. **Password Hashing**: Passwords are hashed using bcrypt
2. **Token-Based Auth**: Laravel Sanctum tokens for API authentication
3. **Protected Routes**: Booking requires authentication
4. **Token Expiration**: Old tokens deleted on new login
5. **HTTPS Ready**: System works with HTTPS in production
6. **CSRF Protection**: Built into Laravel
7. **SQL Injection Prevention**: Using Eloquent ORM

---

## 📱 User Experience

### For Guests:
- Browse packages freely
- Click "Book Now" → Redirected to login
- Can create account or login
- After login → Returned to booking

### For Authenticated Users:
- See their name in navbar
- Click "Book Now" → Opens booking modal directly
- Bookings linked to their account
- Can logout anytime

---

## 🧪 Testing Checklist

### Registration:
- ✅ Create new account with all fields
- ✅ Validation errors display correctly
- ✅ Password confirmation works
- ✅ Email uniqueness enforced
- ✅ Auto-login after registration
- ✅ Token stored in localStorage

### Login:
- ✅ Login with valid credentials
- ✅ Error on invalid credentials
- ✅ Token stored in localStorage
- ✅ Redirect to previous page
- ✅ User info displayed in navbar

### Protected Booking:
- ✅ Guest clicks "Book Now" → Redirected to login
- ✅ After login → Returned to package page
- ✅ Authenticated user clicks "Book Now" → Modal opens
- ✅ Booking created with client_id
- ✅ Client relationship works

### Logout:
- ✅ Logout button visible when authenticated
- ✅ Token removed from localStorage
- ✅ User redirected to home
- ✅ Navbar shows login/signup buttons

### Database:
- ✅ Clients table created
- ✅ client_id column added to bookings
- ✅ Foreign key constraint works
- ✅ Bookings linked to clients

---

## 🔍 Verification Commands

### Check Database:
```sql
-- View clients table
SELECT * FROM clients;

-- View bookings with client info
SELECT b.id, b.booking_reference, b.client_id, c.name, c.email 
FROM bookings b 
LEFT JOIN clients c ON b.client_id = c.id 
ORDER BY b.id DESC;

-- Count bookings per client
SELECT c.name, c.email, COUNT(b.id) as booking_count
FROM clients c
LEFT JOIN bookings b ON c.id = b.client_id
GROUP BY c.id;
```

### Test API Endpoints:
```bash
# Register
curl -X POST http://localhost:8000/api/auth/register \
  -H "Content-Type: application/json" \
  -d '{"name":"Test User","email":"test@example.com","password":"password123","password_confirmation":"password123"}'

# Login
curl -X POST http://localhost:8000/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{"email":"test@example.com","password":"password123"}'

# Get current user (replace TOKEN)
curl -X GET http://localhost:8000/api/auth/me \
  -H "Authorization: Bearer TOKEN"
```

---

## ⚙️ Setup Instructions

### Initial Setup (Already Completed):

1. **Publish Sanctum migrations:**
```bash
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
```

2. **Run migrations:**
```bash
php artisan migrate
```

This creates:
- `clients` table
- `personal_access_tokens` table (for Sanctum)
- Adds `client_id` to `bookings` table

---

## 🚀 How to Use

### For Users:
1. **Sign Up**: Click "Sign Up" in navbar → Fill form → Submit
2. **Login**: Click "Login" in navbar → Enter credentials → Submit
3. **Book Package**: Browse packages → Click "Book Now" → Fill booking form
4. **Logout**: Click your name in navbar → Click "Logout"

### For Admins:
- View client information in database
- See which client made each booking
- Track booking history per client
- Manage client accounts if needed

---

## 💡 Key Features

1. **Seamless Integration**: Authentication integrated with existing booking system
2. **User-Friendly**: Clear login/signup forms with validation
3. **Secure**: Token-based authentication with Laravel Sanctum
4. **Persistent Sessions**: Tokens stored in localStorage
5. **Protected Routes**: Booking requires authentication
6. **Client Tracking**: All bookings linked to client accounts
7. **Responsive Design**: Works on desktop and mobile
8. **Bilingual Support**: Works with English/Arabic translation system

---

## 🎉 Result

**Complete authentication system successfully implemented!**

- ✅ Clients can register and login
- ✅ Booking requires authentication
- ✅ Client ID stored with each booking
- ✅ User menu shows authenticated state
- ✅ Secure token-based authentication
- ✅ Database relationships established
- ✅ Frontend and backend fully integrated

---

## 📋 Next Steps (Optional Enhancements)

1. **Email Verification**: Add email verification for new accounts
2. **Password Reset**: Implement forgot password functionality
3. **Profile Page**: Allow users to update their profile
4. **Booking History**: Show user's past bookings
5. **Social Login**: Add Google/Facebook login
6. **Two-Factor Auth**: Add 2FA for extra security
7. **Remember Me**: Add "Remember Me" checkbox on login

---

*Implemented: November 6, 2025*
*Status: ✅ FULLY FUNCTIONAL*
