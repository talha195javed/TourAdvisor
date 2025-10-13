# 🌍 TourAdvisor - Travel Agency Frontend

> A modern, bilingual (English/Arabic) travel agency website built with React, Laravel, and TailwindCSS

![React](https://img.shields.io/badge/React-18-blue)
![Laravel](https://img.shields.io/badge/Laravel-11-red)
![TailwindCSS](https://img.shields.io/badge/TailwindCSS-3-cyan)
![License](https://img.shields.io/badge/License-MIT-green)

---

## 📸 Screenshots

### Home Page
- Beautiful hero section with gradient background
- Featured packages grid
- Features highlights section

### Packages Page
- Search and filter functionality
- Category filtering
- Sort options (newest, price)
- Responsive grid layout

### Language Support
- English (LTR)
- Arabic (RTL) with automatic layout mirroring

---

## ✨ Features

### 🎨 User Interface
- ✅ Modern, clean design
- ✅ Smooth animations and transitions
- ✅ Responsive on all devices (mobile, tablet, desktop)
- ✅ Beautiful gradient backgrounds
- ✅ Card-based layouts
- ✅ Hover effects and interactions

### 🔍 Functionality
- ✅ Real-time package search
- ✅ Category filtering
- ✅ Multiple sort options
- ✅ Featured packages section
- ✅ Dynamic data from API
- ✅ Loading states
- ✅ Error handling
- ✅ Empty state messages

### 🌍 Internationalization
- ✅ English language support
- ✅ Arabic language support with RTL
- ✅ Easy language switching
- ✅ All UI text translated
- ✅ Automatic layout mirroring

### 📱 Responsive Design
- ✅ Mobile-first approach
- ✅ Touch-friendly interactions
- ✅ Hamburger menu on mobile
- ✅ Optimized for all screen sizes

---

## 🚀 Quick Start

### Prerequisites
- PHP 8.1+
- Composer
- Node.js 16+
- MySQL/MariaDB

### Installation

1. **Install Dependencies**
```bash
# PHP dependencies (if not already installed)
composer install

# Node dependencies
npm install
```

2. **Seed Demo Data** (Optional but recommended)
```bash
php artisan db:seed --class=FrontendDemoSeeder
```

3. **Start Development Servers**

**Option A - Easy Start:**
```bash
./start-frontend.sh
```

**Option B - Manual Start:**
```bash
# Terminal 1 - Laravel
php artisan serve

# Terminal 2 - Vite
npm run dev
```

4. **Open in Browser**
- Frontend: http://localhost:8000
- Packages: http://localhost:8000/packages
- Admin Panel: http://localhost:8000/admin/login

---

## 📁 Project Structure

```
resources/
├── frontend/                    # React application
│   ├── main.jsx                # Entry point
│   ├── App.jsx                 # Main app component
│   ├── i18n.js                 # Translations (EN/AR)
│   ├── components/             # Reusable components
│   │   ├── Navbar.jsx         # Navigation + language switcher
│   │   ├── Footer.jsx         # Footer
│   │   ├── PackageCard.jsx    # Package display card
│   │   └── LoadingSpinner.jsx # Loading indicator
│   ├── pages/                  # Page components
│   │   ├── Home.jsx           # Home page
│   │   └── Packages.jsx       # Packages listing
│   └── services/               # API services
│       └── api.js             # API calls
├── views/
│   └── frontend.blade.php     # HTML entry point
└── css/
    └── app.css                # Global styles

routes/
├── api.php                     # API endpoints
└── web.php                     # Frontend routes

database/
└── seeders/
    └── FrontendDemoSeeder.php # Demo data seeder
```

---

## 🔌 API Endpoints

### Packages
```
GET /api/packages
  Query params:
    - search: string (search by title/location)
    - category_id: number (filter by category)
    - sort_by: string (created_at, price)
    - sort_order: string (asc, desc)

GET /api/packages/featured/list
  Returns: Latest 6 active packages

GET /api/packages/{id}
  Returns: Single package details
```

### Categories
```
GET /api/categories
  Returns: All active categories with package count
```

### Hotels
```
GET /api/hotels
  Returns: All active hotels
```

---

## 🎨 Customization

### Change Colors

Edit `tailwind.config.js`:
```javascript
theme: {
  extend: {
    colors: {
      primary: {
        50: '#eff6ff',
        500: '#3b82f6',
        600: '#2563eb',
        700: '#1d4ed8',
      }
    }
  }
}
```

### Add/Edit Translations

Edit `resources/frontend/i18n.js`:
```javascript
const resources = {
  en: {
    translation: {
      myNewKey: 'My English Text',
    }
  },
  ar: {
    translation: {
      myNewKey: 'النص العربي',
    }
  }
};
```

Use in components:
```javascript
const { t } = useTranslation();
<h1>{t('myNewKey')}</h1>
```

### Modify Styling

All components use TailwindCSS utility classes. Edit directly in `.jsx` files:
```javascript
<div className="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
  Button
</div>
```

---

## 🧪 Testing

### Manual Testing Checklist

**Home Page:**
- [ ] Hero section displays correctly
- [ ] Featured packages load and display
- [ ] "Explore Packages" button works
- [ ] "View All Packages" button works
- [ ] Features section displays

**Packages Page:**
- [ ] All packages load
- [ ] Search functionality works
- [ ] Category filter works
- [ ] Sort options work
- [ ] Active filters display
- [ ] Empty state shows when no results

**Navigation:**
- [ ] Navbar links work
- [ ] Active page highlighted
- [ ] Mobile menu works
- [ ] Language switcher works

**Language Support:**
- [ ] English displays correctly
- [ ] Arabic displays correctly
- [ ] RTL layout works
- [ ] All text translated

**Responsive:**
- [ ] Mobile layout (< 768px)
- [ ] Tablet layout (768-1024px)
- [ ] Desktop layout (> 1024px)

---

## 🐛 Troubleshooting

### Blank Page
**Symptoms:** White/blank page, no content  
**Solutions:**
1. Check browser console (F12) for errors
2. Ensure `npm run dev` is running
3. Verify Laravel server is running (`php artisan serve`)
4. Clear browser cache (Ctrl+Shift+R)

### No Packages Showing
**Symptoms:** Empty packages grid  
**Solutions:**
1. Run seeder: `php artisan db:seed --class=FrontendDemoSeeder`
2. Check database has packages with `is_active = true`
3. Test API directly: http://localhost:8000/api/packages
4. Check Laravel logs: `storage/logs/laravel.log`

### Styles Not Loading
**Symptoms:** Unstyled content, broken layout  
**Solutions:**
1. Restart Vite: Stop and run `npm run dev` again
2. Clear browser cache
3. Check Vite is running without errors
4. Run `npm run build` for production

### API Errors
**Symptoms:** "Error loading data" messages  
**Solutions:**
1. Check Laravel logs: `storage/logs/laravel.log`
2. Verify database connection in `.env`
3. Test API endpoints directly in browser
4. Check network tab in browser DevTools

### Language Switching Issues
**Symptoms:** Language doesn't change  
**Solutions:**
1. Check browser console for errors
2. Verify i18n.js is loaded
3. Clear browser cache
4. Check translations exist for all keys

---

## 📚 Documentation

Comprehensive documentation is available:

- **[QUICKSTART.md](QUICKSTART.md)** - Quick start guide (3 steps)
- **[FRONTEND_SETUP.md](FRONTEND_SETUP.md)** - Detailed setup instructions
- **[FEATURES.md](FEATURES.md)** - Complete features list
- **[COMPONENT_STRUCTURE.md](COMPONENT_STRUCTURE.md)** - Architecture and component hierarchy
- **[IMPLEMENTATION_SUMMARY.md](IMPLEMENTATION_SUMMARY.md)** - What was built

---

## 🛠️ Tech Stack

### Frontend
- **React 18** - UI library
- **React Router 6** - Client-side routing
- **i18next** - Internationalization
- **Axios** - HTTP client
- **TailwindCSS 3** - Utility-first CSS
- **Lucide React** - Icon library
- **Vite 7** - Build tool & dev server

### Backend
- **Laravel 11** - PHP framework
- **MySQL** - Database
- **RESTful API** - JSON responses

---

## 📦 Package Scripts

```json
{
  "dev": "vite",                    // Start dev server
  "build": "vite build",            // Production build
  "frontend": "vite --port 5173"    // Dev server on specific port
}
```

---

## 🚀 Production Deployment

### Build for Production

1. **Build Assets**
```bash
npm run build
```

2. **Optimize Laravel**
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

3. **Environment Configuration**

Edit `.env`:
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com
```

4. **Web Server Configuration**

Point document root to `/public` directory.

### Performance Optimizations

✅ Code splitting (automatic)  
✅ Tree shaking (removes unused code)  
✅ Minification (JS, CSS)  
✅ Image optimization (use CDN)  
✅ Gzip compression (server config)  
✅ Browser caching (server config)  

---

## 🎯 Future Enhancements

### Suggested Features
- [ ] Package detail page with full information
- [ ] Booking form and reservation system
- [ ] User authentication (login/register)
- [ ] User dashboard and booking history
- [ ] Reviews and ratings system
- [ ] Wishlist/favorites functionality
- [ ] Image gallery for packages
- [ ] Google Maps integration
- [ ] Social sharing buttons
- [ ] Payment gateway integration
- [ ] Email notifications
- [ ] PDF itinerary generation
- [ ] Multi-currency support
- [ ] Blog/articles section
- [ ] Newsletter subscription
- [ ] Live chat support

---

## 📄 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

---

## 🤝 Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

---

## 📞 Support

For issues or questions:
1. Check the documentation files
2. Review Laravel logs: `storage/logs/laravel.log`
3. Check browser console for frontend errors
4. Test API endpoints directly

---

## 🎉 Credits

### Built With
- [React](https://react.dev/)
- [Laravel](https://laravel.com/)
- [TailwindCSS](https://tailwindcss.com/)
- [Vite](https://vitejs.dev/)
- [Lucide Icons](https://lucide.dev/)

### Images
- Demo images from [Unsplash](https://unsplash.com/)

---

## ✅ What's Included

### Pages
✅ Home page with hero and featured packages  
✅ Packages page with search, filter, and sort  

### Components
✅ Responsive navbar with language switcher  
✅ Footer with links and social media  
✅ Package cards with hover effects  
✅ Loading spinners  

### Features
✅ Bilingual support (English/Arabic)  
✅ RTL layout for Arabic  
✅ Real-time search  
✅ Category filtering  
✅ Multiple sort options  
✅ Responsive design  
✅ API integration  
✅ Error handling  
✅ Empty states  

### Documentation
✅ Quick start guide  
✅ Setup instructions  
✅ Features documentation  
✅ Component structure  
✅ Implementation summary  
✅ Troubleshooting guide  

---

**🌍 Your travel agency frontend is ready! Start exploring and customizing! ✈️**

**Happy coding! 🎨**
