# 🚀 TourAdvisor Frontend - Quick Start Guide

## ✨ What's Been Created

A modern, bilingual (English/Arabic) travel agency frontend with:

- **Home Page**: Hero section + featured packages
- **Packages Page**: Search, filter by category, sort by price/date
- **Language Switcher**: Toggle between English and Arabic (RTL support)
- **Responsive Design**: Works on mobile, tablet, and desktop
- **Modern UI**: Built with React, TailwindCSS, and Lucide icons

---

## 🎯 Quick Start (3 Steps)

### Step 1: Seed Demo Data (Optional but Recommended)

If you want to see the frontend with sample packages:

```bash
php artisan db:seed --class=FrontendDemoSeeder
```

This creates 6 sample packages, 5 categories, and 3 hotels.

### Step 2: Start the Application

**Option A - Easy Start (Recommended):**
```bash
./start-frontend.sh
```

**Option B - Manual Start:**

Terminal 1 - Laravel:
```bash
php artisan serve
```

Terminal 2 - Vite (in a new terminal):
```bash
npm run dev
```

### Step 3: Open in Browser

- **Frontend Homepage**: http://localhost:8000
- **Packages Page**: http://localhost:8000/packages
- **Admin Panel**: http://localhost:8000/admin/login

---

## 🎨 Features Overview

### Home Page (`/`)
- **Hero Section**: Eye-catching gradient background with CTA
- **Featured Packages**: Shows latest 6 packages
- **Features Section**: Highlights key benefits (24/7 support, best prices, etc.)

### Packages Page (`/packages`)
- **Search Bar**: Search by package title or location
- **Category Filter**: Filter packages by category
- **Sort Options**: 
  - Newest first
  - Price: Low to High
  - Price: High to Low
- **Active Filters Display**: Shows applied filters with remove option
- **Empty State**: Friendly message when no packages found

### Language Support
- Click the language button in navbar to switch
- Supports English (LTR) and Arabic (RTL)
- All text is translated
- Layout automatically adjusts for RTL

---

## 📁 Project Structure

```
resources/frontend/
├── main.jsx                 # React entry point
├── App.jsx                  # Main app with routing
├── i18n.js                  # Translations (EN/AR)
├── components/
│   ├── Navbar.jsx          # Navigation + language switcher
│   ├── Footer.jsx          # Footer with links
│   ├── PackageCard.jsx     # Package display card
│   └── LoadingSpinner.jsx  # Loading component
├── pages/
│   ├── Home.jsx            # Home page
│   └── Packages.jsx        # Packages listing
└── services/
    └── api.js              # API calls

routes/
├── api.php                 # API endpoints
└── web.php                 # Frontend routes
```

---

## 🔌 API Endpoints

All endpoints are in `/api`:

| Endpoint | Description | Parameters |
|----------|-------------|------------|
| `GET /api/packages` | Get all packages | `search`, `category_id`, `sort_by`, `sort_order` |
| `GET /api/packages/featured/list` | Get featured packages | - |
| `GET /api/packages/{id}` | Get single package | - |
| `GET /api/categories` | Get all categories | - |
| `GET /api/hotels` | Get all hotels | - |

---

## 🎨 Customization

### Change Colors

Edit `tailwind.config.js`:
```javascript
theme: {
  extend: {
    colors: {
      primary: '#your-color',
    }
  }
}
```

### Add Translations

Edit `resources/frontend/i18n.js`:
```javascript
en: {
  translation: {
    yourKey: 'Your English Text'
  }
},
ar: {
  translation: {
    yourKey: 'النص العربي'
  }
}
```

### Modify Styling

All components use TailwindCSS. Edit classes directly in `.jsx` files.

---

## 🐛 Troubleshooting

### Issue: Blank Page
**Solution:**
1. Check browser console (F12) for errors
2. Ensure `npm run dev` is running
3. Verify Laravel server is running
4. Check `/api/packages` returns data

### Issue: No Packages Showing
**Solution:**
1. Run the seeder: `php artisan db:seed --class=FrontendDemoSeeder`
2. Or add packages via admin panel: http://localhost:8000/admin/login
3. Ensure packages have `is_active = true`

### Issue: Styles Not Loading
**Solution:**
1. Stop and restart `npm run dev`
2. Clear browser cache (Ctrl+Shift+R)
3. Run `npm run build` for production

### Issue: API Errors
**Solution:**
1. Check Laravel logs: `storage/logs/laravel.log`
2. Verify database connection in `.env`
3. Test API directly: http://localhost:8000/api/packages

---

## 📱 Responsive Breakpoints

- **Mobile**: < 768px
- **Tablet**: 768px - 1024px
- **Desktop**: > 1024px

All components are fully responsive.

---

## 🌍 Language Files

Translations are in `resources/frontend/i18n.js`:

- **English**: Default language
- **Arabic**: Full RTL support with Arabic translations

To add a new language:
1. Add language object in `i18n.js`
2. Add translations for all keys
3. Update language switcher in `Navbar.jsx`

---

## 🚀 Production Build

When ready for production:

```bash
# Build frontend assets
npm run build

# Optimize Laravel
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Set production environment
# Edit .env: APP_ENV=production, APP_DEBUG=false
```

---

## 📦 Package Management

### Add New Package via Admin
1. Login: http://localhost:8000/admin/login
2. Go to Packages section
3. Click "Create Package"
4. Fill in details and save

### Package Fields
- **Title**: Package name
- **Description**: Detailed description
- **Price**: Package price
- **Duration**: Number of days
- **Image**: Main package image (URL or upload)
- **Features**: Array of features/inclusions
- **Category**: Select category
- **Hotel**: Select hotel (optional)
- **Location**: Destination location
- **Transfer Type**: Air, Bus, Car, etc.
- **Active Status**: Show/hide on frontend

---

## 🎯 Next Steps

1. **Add More Packages**: Use admin panel or seeder
2. **Customize Design**: Edit colors and styles
3. **Add More Pages**: Create About, Contact pages
4. **Add Booking**: Implement booking functionality
5. **Add Authentication**: User login/registration
6. **Add Reviews**: Package reviews and ratings
7. **Add Payment**: Payment gateway integration

---

## 💡 Tips

- Use the demo seeder to quickly populate data
- Test language switching on different pages
- Check responsive design on mobile
- Monitor browser console for any errors
- Use React DevTools for debugging

---

## 📞 Support

If you encounter issues:
1. Check this guide first
2. Review `FRONTEND_SETUP.md` for detailed info
3. Check Laravel logs: `storage/logs/laravel.log`
4. Check browser console for frontend errors

---

## ✅ Checklist

- [ ] Dependencies installed (`npm install`)
- [ ] Demo data seeded (optional)
- [ ] Laravel server running
- [ ] Vite dev server running
- [ ] Frontend loads at http://localhost:8000
- [ ] Packages display correctly
- [ ] Language switcher works
- [ ] Search and filters work
- [ ] Responsive on mobile

---

**Enjoy building your travel agency! 🌍✈️**
