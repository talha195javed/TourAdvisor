import i18n from 'i18next';
import { initReactI18next } from 'react-i18next';

const resources = {
  en: {
    translation: {
      // Navigation
      home: 'Home',
      packages: 'Packages',
      about: 'About',
      contact: 'Contact',
      
      // Hero Section
      heroTitle: 'Discover Your Next Adventure',
      heroSubtitle: 'Explore amazing travel packages and create unforgettable memories',
      explorePackages: 'Explore Packages',
      
      // Featured Packages
      featuredPackages: 'Featured Packages',
      viewAllPackages: 'View All Packages',
      
      // Package Card
      days: 'Days',
      startingFrom: 'Starting from',
      viewDetails: 'View Details',
      bookNow: 'Book Now',
      
      // Packages Page
      allPackages: 'All Packages',
      searchPackages: 'Search packages...',
      filterByCategory: 'Filter by Category',
      allCategories: 'All Categories',
      sortBy: 'Sort By',
      newest: 'Newest',
      priceLowest: 'Price: Low to High',
      priceHighest: 'Price: High to Low',
      noPackagesFound: 'No packages found',
      premiumExperiences: 'Premium Travel Experiences',
      discoverYour: 'Discover Your',
      dreamDestination: 'Dream Destination',
      packagesSubtitle: 'Explore curated travel packages designed to turn your wanderlust into reality. From pristine beaches to majestic mountains, your perfect adventure awaits.',
      bestPrice: 'Best Price Guarantee',
      support247: '24/7 Support',
      instantConfirmation: 'Instant Confirmation',
      flexibleBooking: 'Flexible Booking',
      browsePackages: 'Browse Packages',
      travelPackages: 'Travel Packages',
      categories: 'Categories',
      happyTravelers: 'Happy Travelers',
      averageRating: 'Average Rating',
      
      // Package Details
      duration: 'Duration',
      location: 'Location',
      hotel: 'Hotel',
      category: 'Category',
      features: 'Features',
      description: 'Description',
      transferType: 'Transfer Type',
      departureAirport: 'Departure Airport',
      arrivalAirport: 'Arrival Airport',
      included: 'What\'s Included',
      accommodation: 'Accommodation',
      transfer: 'Transfer',
      perPerson: 'per person',
      knowMore: 'Know More',
      needHelp: 'Need Help?',
      contactUs: 'Contact us for any questions',
      backToPackages: 'Back to Packages',
      
      // Footer
      aboutUs: 'About Us',
      ourStory: 'Our Story',
      careers: 'Careers',
      services: 'Services',
      tourPackages: 'Tour Packages',
      hotelBooking: 'Hotel Booking',
      flightBooking: 'Flight Booking',
      support: 'Support',
      helpCenter: 'Help Center',
      termsConditions: 'Terms & Conditions',
      privacyPolicy: 'Privacy Policy',
      followUs: 'Follow Us',
      allRightsReserved: 'All rights reserved',
      
      // Common
      loading: 'Loading...',
      error: 'Error loading data',
    }
  },
  ar: {
    translation: {
      // Navigation
      home: 'الرئيسية',
      packages: 'الباقات',
      about: 'من نحن',
      contact: 'اتصل بنا',
      
      // Hero Section
      heroTitle: 'اكتشف مغامرتك القادمة',
      heroSubtitle: 'استكشف باقات السفر المذهلة وأنشئ ذكريات لا تُنسى',
      explorePackages: 'استكشف الباقات',
      
      // Featured Packages
      featuredPackages: 'الباقات المميزة',
      viewAllPackages: 'عرض جميع الباقات',
      
      // Package Card
      days: 'أيام',
      startingFrom: 'ابتداءً من',
      viewDetails: 'عرض التفاصيل',
      bookNow: 'احجز الآن',
      
      // Packages Page
      allPackages: 'جميع الباقات',
      searchPackages: 'البحث عن الباقات...',
      filterByCategory: 'تصفية حسب الفئة',
      allCategories: 'جميع الفئات',
      sortBy: 'ترتيب حسب',
      newest: 'الأحدث',
      priceLowest: 'السعر: من الأقل إلى الأعلى',
      priceHighest: 'السعر: من الأعلى إلى الأقل',
      noPackagesFound: 'لم يتم العثور على باقات',
      premiumExperiences: 'تجارب سفر مميزة',
      discoverYour: 'اكتشف',
      dreamDestination: 'وجهتك المثالية',
      packagesSubtitle: 'استكشف باقات السفر المنتقاة بعناية والمصممة لتحويل شغفك بالسفر إلى واقع. من الشواطئ النقية إلى الجبال المهيبة، مغامرتك المثالية بانتظارك.',
      bestPrice: 'ضمان أفضل سعر',
      support247: 'دعم على مدار الساعة',
      instantConfirmation: 'تأكيد فوري',
      flexibleBooking: 'حجز مرن',
      browsePackages: 'تصفح الباقات',
      travelPackages: 'باقات السفر',
      categories: 'الفئات',
      happyTravelers: 'مسافرون سعداء',
      averageRating: 'متوسط التقييم',
      
      // Package Details
      duration: 'المدة',
      location: 'الموقع',
      hotel: 'الفندق',
      category: 'الفئة',
      features: 'المميزات',
      description: 'الوصف',
      transferType: 'نوع النقل',
      departureAirport: 'مطار المغادرة',
      arrivalAirport: 'مطار الوصول',
      included: 'ما يشمله',
      accommodation: 'الإقامة',
      transfer: 'النقل',
      perPerson: 'للشخص الواحد',
      knowMore: 'اعرف المزيد',
      needHelp: 'تحتاج مساعدة؟',
      contactUs: 'اتصل بنا لأي استفسارات',
      backToPackages: 'العودة إلى الباقات',
      
      // Footer
      aboutUs: 'من نحن',
      ourStory: 'قصتنا',
      careers: 'الوظائف',
      services: 'الخدمات',
      tourPackages: 'باقات الجولات',
      hotelBooking: 'حجز الفنادق',
      flightBooking: 'حجز الرحلات',
      support: 'الدعم',
      helpCenter: 'مركز المساعدة',
      termsConditions: 'الشروط والأحكام',
      privacyPolicy: 'سياسة الخصوصية',
      followUs: 'تابعنا',
      allRightsReserved: 'جميع الحقوق محفوظة',
      
      // Common
      loading: 'جاري التحميل...',
      error: 'خطأ في تحميل البيانات',
    }
  }
};

i18n
  .use(initReactI18next)
  .init({
    resources,
    lng: 'en',
    fallbackLng: 'en',
    interpolation: {
      escapeValue: false
    }
  });

export default i18n;
