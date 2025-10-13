# 🏗️ Component Structure & Architecture

## 📊 Component Hierarchy

```
App (Router)
│
├── Navbar (Sticky)
│   ├── Logo
│   ├── Navigation Links
│   │   ├── Home Link
│   │   └── Packages Link
│   ├── Language Switcher
│   └── Mobile Menu (Hamburger)
│
├── Routes
│   │
│   ├── Home Page (/)
│   │   ├── Hero Section
│   │   │   ├── Gradient Background
│   │   │   ├── Title & Subtitle
│   │   │   └── CTA Button
│   │   │
│   │   ├── Featured Packages Section
│   │   │   ├── Section Header
│   │   │   ├── Package Grid
│   │   │   │   └── PackageCard (x6)
│   │   │   │       ├── Image
│   │   │   │       ├── Category Badge
│   │   │   │       ├── Title
│   │   │   │       ├── Description
│   │   │   │       ├── Details (Location, Duration, Hotel)
│   │   │   │       └── Price & CTA
│   │   │   └── View All Button
│   │   │
│   │   └── Features Section
│   │       └── Feature Cards (x3)
│   │
│   └── Packages Page (/packages)
│       ├── Header Section
│       │
│       ├── Search & Filter Bar
│       │   ├── Search Input
│       │   ├── Category Dropdown
│       │   └── Sort Dropdown
│       │
│       ├── Active Filters Display
│       │   └── Filter Tags (removable)
│       │
│       ├── Results Count
│       │
│       └── Packages Grid
│           ├── PackageCard (multiple)
│           ├── LoadingSpinner (when loading)
│           └── Empty State (when no results)
│
└── Footer
    ├── Brand Section
    ├── Links Columns (x3)
    │   ├── About Links
    │   ├── Services Links
    │   └── Support Links
    └── Bottom Bar
        ├── Copyright
        └── Social Icons
```

---

## 🔄 Data Flow

### Home Page Flow
```
User visits "/" 
    ↓
App renders Home component
    ↓
Home component mounts (useEffect)
    ↓
API call: packagesAPI.getFeatured()
    ↓
Loading state: true (shows spinner)
    ↓
API returns data
    ↓
State updates: setFeaturedPackages(data)
    ↓
Loading state: false
    ↓
Render PackageCard for each package
    ↓
User sees featured packages
```

### Packages Page Flow
```
User visits "/packages"
    ↓
App renders Packages component
    ↓
Component mounts (useEffect)
    ↓
Parallel API calls:
    ├── categoriesAPI.getAll()
    └── packagesAPI.getAll()
    ↓
Loading state: true
    ↓
APIs return data
    ↓
State updates:
    ├── setCategories(data)
    └── setPackages(data)
    ↓
Loading state: false
    ↓
Render filters and packages
    ↓
User interacts (search/filter/sort)
    ↓
State updates (useEffect triggered)
    ↓
New API call with filters
    ↓
Re-render with new data
```

### Language Switch Flow
```
User clicks language button
    ↓
toggleLanguage() function
    ↓
i18n.changeLanguage(newLang)
    ↓
i18n context updates
    ↓
All components re-render
    ↓
t() function returns new translations
    ↓
document.dir changes (ltr/rtl)
    ↓
Layout mirrors (if RTL)
    ↓
User sees new language
```

---

## 🎯 Component Responsibilities

### App.jsx
**Purpose**: Main application container
- **Routing**: Manages routes with React Router
- **Layout**: Wraps all pages with Navbar and Footer
- **Direction**: Sets document direction based on language
- **State**: No local state (uses i18n context)

### Navbar.jsx
**Purpose**: Navigation and language switching
- **Navigation**: Links to pages with active states
- **Language**: Toggle between English and Arabic
- **Mobile**: Responsive hamburger menu
- **State**: `isMenuOpen` for mobile menu

### Footer.jsx
**Purpose**: Site footer with links
- **Links**: Organized in columns
- **Social**: Social media icons
- **Copyright**: Dynamic year
- **State**: No state (static content)

### PackageCard.jsx
**Purpose**: Display single package
- **Image**: Package main image with hover effect
- **Details**: Location, duration, hotel, rating
- **Price**: Prominent price display
- **CTA**: Book now button
- **Props**: `package` object

### LoadingSpinner.jsx
**Purpose**: Loading state indicator
- **Animation**: Spinning border animation
- **Sizes**: Small, medium, large
- **Props**: `size` (optional)

### Home.jsx
**Purpose**: Home page with featured packages
- **Hero**: Large hero section with CTA
- **Featured**: Grid of featured packages
- **Features**: Highlight key benefits
- **State**: `featuredPackages`, `loading`, `error`
- **Effects**: Fetch featured packages on mount

### Packages.jsx
**Purpose**: All packages with search/filter
- **Search**: Real-time search input
- **Filters**: Category dropdown
- **Sort**: Multiple sort options
- **Active Filters**: Show applied filters
- **State**: `packages`, `categories`, `loading`, `error`, filter states
- **Effects**: Fetch packages when filters change

---

## 🔌 API Service Layer

### api.js Structure
```javascript
// Base configuration
const api = axios.create({
  baseURL: '/api',
  headers: { ... }
})

// Packages API
export const packagesAPI = {
  getAll(params),      // GET /api/packages
  getById(id),         // GET /api/packages/{id}
  getFeatured()        // GET /api/packages/featured/list
}

// Categories API
export const categoriesAPI = {
  getAll()             // GET /api/categories
}

// Hotels API
export const hotelsAPI = {
  getAll()             // GET /api/hotels
}
```

---

## 🌍 i18n Configuration

### Translation Structure
```javascript
{
  en: {
    translation: {
      // Navigation
      home: "Home",
      packages: "Packages",
      
      // Hero
      heroTitle: "...",
      heroSubtitle: "...",
      
      // Packages
      searchPackages: "...",
      filterByCategory: "...",
      
      // Common
      loading: "...",
      error: "..."
    }
  },
  ar: {
    translation: {
      // Same keys, Arabic values
    }
  }
}
```

### Usage in Components
```javascript
// Import
import { useTranslation } from 'react-i18next';

// In component
const { t, i18n } = useTranslation();

// Use
<h1>{t('heroTitle')}</h1>

// Change language
i18n.changeLanguage('ar');

// Current language
i18n.language // 'en' or 'ar'
```

---

## 🎨 Styling Approach

### TailwindCSS Utilities
```javascript
// Example component
<div className="
  max-w-7xl          // Container width
  mx-auto            // Center
  px-4 sm:px-6 lg:px-8  // Responsive padding
  py-12             // Vertical padding
">
  <h1 className="
    text-4xl         // Font size
    font-bold        // Font weight
    text-gray-900    // Text color
    mb-6             // Margin bottom
  ">
    Title
  </h1>
</div>
```

### RTL Support
```javascript
// LTR and RTL classes
<div className="
  ml-2             // Margin left (LTR)
  rtl:mr-2         // Margin right (RTL)
  rtl:ml-0         // Remove left margin (RTL)
">
```

### Responsive Design
```javascript
// Mobile first approach
<div className="
  grid
  grid-cols-1      // 1 column on mobile
  md:grid-cols-2   // 2 columns on tablet
  lg:grid-cols-3   // 3 columns on desktop
  gap-8
">
```

---

## 🔄 State Management

### Component State (useState)
```javascript
// Local state in components
const [packages, setPackages] = useState([]);
const [loading, setLoading] = useState(true);
const [error, setError] = useState(null);
const [searchQuery, setSearchQuery] = useState('');
```

### Side Effects (useEffect)
```javascript
// Fetch data on mount
useEffect(() => {
  fetchPackages();
}, []);

// Fetch when filters change
useEffect(() => {
  fetchPackages();
}, [searchQuery, selectedCategory, sortBy]);
```

### Global State (i18n Context)
```javascript
// Language state managed by i18next
// Accessible in all components via useTranslation()
const { i18n } = useTranslation();
i18n.language // Current language
i18n.changeLanguage('ar') // Change language
```

---

## 🚀 Routing Configuration

### Routes Setup
```javascript
// In App.jsx
<Routes>
  <Route path="/" element={<Home />} />
  <Route path="/packages" element={<Packages />} />
</Routes>
```

### Navigation
```javascript
// Using Link component
import { Link } from 'react-router-dom';

<Link to="/packages">View Packages</Link>
```

### Active Route Detection
```javascript
import { useLocation } from 'react-router-dom';

const location = useLocation();
const isActive = location.pathname === '/packages';
```

---

## 📦 Props & Data Types

### Package Object
```typescript
{
  id: number,
  title: string,
  description: string,
  price: decimal,
  duration_days: number,
  main_image: string (URL),
  features: array,
  location: string,
  transfer_type: string,
  is_active: boolean,
  category: {
    id: number,
    name: string,
    slug: string
  },
  hotel: {
    id: number,
    name: string,
    star_rating: number,
    location: string
  }
}
```

### Category Object
```typescript
{
  id: number,
  name: string,
  slug: string,
  is_active: boolean,
  packages_count: number
}
```

### Hotel Object
```typescript
{
  id: number,
  name: string,
  location: string,
  star_rating: number,
  description: string,
  amenities: array,
  is_active: boolean
}
```

---

## 🎯 Key Design Patterns

### 1. Container/Presentational Pattern
- **Pages** (Home, Packages): Container components with logic
- **Components** (PackageCard, Navbar): Presentational with props

### 2. Composition Pattern
- Small, reusable components
- Composed into larger features
- Example: PackageCard used in Home and Packages

### 3. Custom Hooks Pattern
- i18next provides `useTranslation` hook
- React Router provides `useLocation`, `useNavigate`

### 4. Service Layer Pattern
- API calls abstracted in `services/api.js`
- Components don't know about Axios
- Easy to swap API implementation

### 5. Loading States Pattern
```javascript
const [loading, setLoading] = useState(true);

if (loading) return <LoadingSpinner />;
if (error) return <ErrorMessage />;
return <Content />;
```

---

## 🔧 Build & Development

### Development Mode
```bash
npm run dev
# Vite dev server with hot reload
# Fast refresh for React components
# Source maps for debugging
```

### Production Build
```bash
npm run build
# Minified and optimized
# Code splitting
# Tree shaking
# Asset optimization
```

### File Structure After Build
```
public/build/
├── assets/
│   ├── main.[hash].js
│   ├── main.[hash].css
│   └── [other chunks]
└── manifest.json
```

---

## 📱 Responsive Breakpoints

### TailwindCSS Breakpoints
```javascript
// Default breakpoints
sm: 640px   // Small devices
md: 768px   // Medium devices (tablets)
lg: 1024px  // Large devices (desktops)
xl: 1280px  // Extra large
2xl: 1536px // 2X Extra large

// Usage
<div className="
  text-sm      // Mobile
  md:text-base // Tablet+
  lg:text-lg   // Desktop+
">
```

---

## ✨ Animation Classes

### Transitions
```css
transition-colors    // Color transitions
transition-transform // Transform transitions
transition-shadow    // Shadow transitions
transition-all       // All properties
duration-300         // 300ms duration
```

### Transforms
```css
hover:scale-110     // Scale up on hover
hover:shadow-xl     // Increase shadow
hover:bg-blue-700   // Change background
```

### Animations
```css
animate-spin        // Spinning (loading)
animate-pulse       // Pulsing (hero icon)
```

---

## 🎉 Summary

### Architecture Highlights
✅ **Modular**: Small, focused components  
✅ **Reusable**: Components used multiple times  
✅ **Maintainable**: Clear structure and naming  
✅ **Scalable**: Easy to add new features  
✅ **Testable**: Components can be tested independently  

### Best Practices Used
✅ **React Hooks**: Modern React patterns  
✅ **Component Composition**: Build complex UIs from simple parts  
✅ **Separation of Concerns**: Logic vs presentation  
✅ **Service Layer**: API abstraction  
✅ **Responsive Design**: Mobile-first approach  
✅ **Accessibility**: Semantic HTML and ARIA  
✅ **Performance**: Code splitting and lazy loading  

---

**This architecture is production-ready and follows React best practices! 🚀**
