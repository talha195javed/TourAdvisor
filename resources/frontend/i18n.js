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
      heroTitle: 'Begin Your Sacred Journey',
      heroSubtitle: 'Experience blessed Umrah & Hajj packages with comfort, guidance, and spiritual fulfillment',
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
      premiumExperiences: 'Premium Umrah & Hajj Packages',
      discoverYour: 'Plan Your',
      dreamDestination: 'Sacred Journey',
      packagesSubtitle: 'Discover our carefully curated Umrah and Hajj packages designed to provide you with a spiritually enriching experience. From 5-star accommodations near Haram to guided religious tours, your blessed journey awaits.',
      bestPrice: 'Best Price Guarantee',
      support247: '24/7 Support',
      instantConfirmation: 'Instant Confirmation',
      flexibleBooking: 'Flexible Booking',
      browsePackages: 'Browse Packages',
      travelPackages: 'Umrah & Hajj Packages',
      categories: 'Categories',
      happyTravelers: 'Happy Pilgrims',
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
      services: 'Our Services',
      tourPackages: 'Umrah Packages',
      hotelBooking: 'Hajj Packages',
      flightBooking: 'Group Packages',
      support: 'Support',
      helpCenter: 'Help Center',
      termsConditions: 'Terms & Conditions',
      privacyPolicy: 'Privacy Policy',
      followUs: 'Follow Us',
      allRightsReserved: 'All rights reserved',

      // Common
      loading: 'Loading...',
      error: 'Error loading data',

      // Why Choose Us Section
      whyChooseUs: 'Why Choose Us',
      yourJourneyOurPriority: 'Your Sacred Journey, Our Priority',
      support247Title: '24/7 Support',
      support247Desc: 'Round-the-clock assistance to ensure your pilgrimage is smooth and spiritually fulfilling',
      bestPricesTitle: 'Best Prices',
      bestPricesDesc: 'Competitive rates and exclusive packages to make your Umrah and Hajj journey affordable',
      curatedExperiencesTitle: 'Guided Experience',
      curatedExperiencesDesc: 'Expert religious guides and scholars to help you perform your rituals correctly and meaningfully',

      // CTA Section
      readyToStart: 'Ready to Begin Your Sacred Journey?',
      joinThousands: 'Join thousands of blessed pilgrims who have fulfilled their spiritual dreams with us',
      chatOnWhatsApp: 'Chat on WhatsApp',

      // Reviews Section
      customerReviews: 'Pilgrim Reviews',
      whatCustomersSay: 'What Our Pilgrims Say',
      reviewsSubtitle: 'Real experiences from blessed pilgrims who trusted us with their sacred journey',
      reviews: 'Reviews',
      satisfaction: 'Satisfaction',
      joinHappyCustomers: 'Join thousands of satisfied pilgrims',
      bookYourTrip: 'Book Your Journey Now',
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
      heroTitle: 'ابدأ رحلتك المقدسة',
      heroSubtitle: 'استمتع بباقات العمرة والحج المباركة مع الراحة والإرشاد والإشباع الروحي',
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
      premiumExperiences: 'باقات العمرة والحج المميزة',
      discoverYour: 'خطط',
      dreamDestination: 'لرحلتك المقدسة',
      packagesSubtitle: 'اكتشف باقات العمرة والحج المنتقاة بعناية والمصممة لتوفير تجربة روحانية غنية. من الإقامة الفاخرة بالقرب من الحرم إلى الجولات الدينية المرشدة، رحلتك المباركة بانتظارك.',
      bestPrice: 'ضمان أفضل سعر',
      support247: 'دعم على مدار الساعة',
      instantConfirmation: 'تأكيد فوري',
      flexibleBooking: 'حجز مرن',
      browsePackages: 'تصفح الباقات',
      travelPackages: 'باقات العمرة والحج',
      categories: 'الفئات',
      happyTravelers: 'معتمرون سعداء',
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
      services: 'خدماتنا',
      tourPackages: 'باقات العمرة',
      hotelBooking: 'باقات الحج',
      flightBooking: 'الباقات الجماعية',
      support: 'الدعم',
      helpCenter: 'مركز المساعدة',
      termsConditions: 'الشروط والأحكام',
      privacyPolicy: 'سياسة الخصوصية',
      followUs: 'تابعنا',
      allRightsReserved: 'جميع الحقوق محفوظة',

      // Common
      loading: 'جاري التحميل...',
      error: 'خطأ في تحميل البيانات',

      // Why Choose Us Section
      whyChooseUs: 'لماذا تختارنا',
      yourJourneyOurPriority: 'رحلتك المقدسة، أولويتنا',
      support247Title: 'دعم على مدار الساعة',
      support247Desc: 'مساعدة على مدار الساعة لضمان أن تكون رحلتك سلسة ومُشبعة روحانياً',
      bestPricesTitle: 'أفضل الأسعار',
      bestPricesDesc: 'أسعار تنافسية وباقات حصرية لجعل رحلة العمرة والحج في متناول يدك',
      curatedExperiencesTitle: 'تجربة مُرشدة',
      curatedExperiencesDesc: 'مرشدون دينيون وعلماء خبراء لمساعدتك على أداء مناسكك بشكل صحيح وهادف',

      // CTA Section
      readyToStart: 'هل أنت مستعد لبدء رحلتك المقدسة؟',
      joinThousands: 'انضم إلى آلاف المعتمرين المباركين الذين حققوا أحلامهم الروحية معنا',
      chatOnWhatsApp: 'تحدث على واتساب',

      // Reviews Section
      customerReviews: 'آراء المعتمرين',
      whatCustomersSay: 'ماذا يقول معتمرونا',
      reviewsSubtitle: 'تجارب حقيقية من معتمرين مباركين وثقوا بنا في رحلتهم المقدسة',
      reviews: 'التقييمات',
      satisfaction: 'الرضا',
      joinHappyCustomers: 'انضم إلى آلاف المعتمرين الراضين',
      bookYourTrip: 'احجز رحلتك الآن',
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
