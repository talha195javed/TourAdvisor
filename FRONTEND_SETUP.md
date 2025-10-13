# TourAdvisor Frontend Setup Guide

## Overview
This is a modern React-based frontend for the TourAdvisor travel agency, featuring:
- 🏠 Home page with hero section and featured packages
- 📦 Packages page with search, filtering, and sorting
- 🌍 Bilingual support (English & Arabic)
- 📱 Fully responsive design
- 🎨 Modern UI with TailwindCSS

## Installation Steps

### 1. Install Dependencies
```bash
npm install
```

### 2. Build Assets
For development with hot reload:
```bash
npm run dev
```

For production build:
```bash
npm run build
```

### 3. Start Laravel Server
In a separate terminal:
```bash
php artisan serve
```

### 4. Access the Application
- **Frontend**: http://localhost:8000
- **Packages Page**: http://localhost:8000/packages
- **Admin Panel**: http://localhost:8000/admin/login

## Project Structure

```
resources/
├── frontend/
│   ├── main.jsx              # React entry point
│   ├── App.jsx               # Main app component with routing
│   ├── i18n.js               # Internationalization config
│   ├── components/
│   │   ├── Navbar.jsx        # Navigation with language switcher
│   │   ├── Footer.jsx        # Footer component
│   │   └── PackageCard.jsx   # Package display card
│   ├── pages/
│   │   ├── Home.jsx          # Home page
│   │   └── Packages.jsx      # Packages listing page
│   └── services/
│       └── api.js            # API service layer
└── views/
    └── frontend.blade.php    # HTML entry point
```

## API Endpoints

The following API endpoints are available:

- `GET /api/packages` - Get all active packages (with filters)
- `GET /api/packages/{id}` - Get single package
- `GET /api/packages/featured/list` - Get featured packages
- `GET /api/categories` - Get all categories
- `GET /api/hotels` - Get all hotels

### Query Parameters for /api/packages:
- `search` - Search by title or location
- `category_id` - Filter by category
- `sort_by` - Sort field (created_at, price)
- `sort_order` - Sort direction (asc, desc)

## Features

### Home Page
- Hero section with call-to-action
- Featured packages (latest 6)
- Features section highlighting key benefits
- Responsive design

### Packages Page
- Search functionality
- Category filtering
- Sort by newest, price (low to high, high to low)
- Active filter tags
- Empty state handling
- Loading states

### Language Support
- English (default)
- Arabic (RTL support)
- Language switcher in navbar
- All UI text translated

### Components
- **Navbar**: Sticky navigation with language switcher
- **Footer**: Links and social media
- **PackageCard**: Displays package info with image, details, and price

## Customization

### Colors
Edit `tailwind.config.js` to customize the color scheme.

### Translations
Edit `resources/frontend/i18n.js` to add or modify translations.

### Styling
All components use TailwindCSS utility classes. Modify classes directly in components.

## Testing

### Test the Frontend
1. Ensure you have packages in the database
2. Visit http://localhost:8000
3. Test language switching
4. Test search and filters on /packages
5. Verify responsive design on mobile

### Add Sample Data
Use the admin panel to add packages, categories, and hotels, or use Laravel seeders.

## Troubleshooting

### Issue: Blank page
- Check browser console for errors
- Ensure `npm run dev` is running
- Verify Laravel server is running

### Issue: API not working
- Check `/api/packages` endpoint directly
- Verify database has active packages
- Check Laravel logs: `storage/logs/laravel.log`

### Issue: Styles not loading
- Run `npm run build`
- Clear browser cache
- Check Vite is configured correctly

## Production Deployment

1. Build assets:
```bash
npm run build
```

2. Optimize Laravel:
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

3. Set environment to production in `.env`:
```
APP_ENV=production
APP_DEBUG=false
```

## Support

For issues or questions, check:
- Laravel logs: `storage/logs/laravel.log`
- Browser console for frontend errors
- Network tab for API call issues
