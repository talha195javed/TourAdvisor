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
      customerReviews: '📍 Hotel Location Guide',
      whatCustomersSay: 'Nearby Landmarks & Route Guide',
      reviewsSubtitle: 'Discover how conveniently located your hotel is, with clear routes and walking distances to the most important holy sites in Makkah.',
      reviews: 'Reviews',
      satisfaction: 'Satisfaction',
      joinHappyCustomers: 'Join thousands of satisfied pilgrims',
      bookYourTrip: 'Book Your Journey Now',

      // Route Section
      routeDistance: 'Distance',
      routeWalkingTime: 'Walking Time',
      routeOpenInMaps: 'Open in Google Maps',
      routeHaramTitle: 'Masjid al-Haram',
      routeHaramSubtitle: 'Main gate access & closest walking route',
      routeClockTowerTitle: 'Clock Tower (Abraj Al Bait)',
      routeClockTowerSubtitle: 'Shopping, food court & convenient meeting point',
      routeZamzamTitle: 'Zamzam Area',
      routeZamzamSubtitle: 'Easy access for water collection and entrances',
      routeTipsTitle: 'Route Tips',
      routeTipsSubtitle: 'Make your walk easier with these practical tips',
      routeTip1: 'Start early to avoid peak crowd hours around prayer times.',
      routeTip2: 'Use a pin in Google Maps and share it with your group before leaving.',
      routeTip3: 'If you are with elders, request wheelchair routes and shaded paths.',
      routeCtaTitle: 'Need the exact hotel route?',
      routeCtaSubtitle: 'Send us your hotel name and we will reply with the best route and landmarks.',
      routeSendOnWhatsApp: 'Send Hotel Name on WhatsApp',

      // Stats Section
      trustedByThousands: 'Trusted by Thousands of Pilgrims',
      statsSubtitle: 'Join our growing family of satisfied travelers who have experienced the journey of a lifetime',
      happyPilgrims: 'Happy Pilgrims',
      packageOptions: 'Package Options',
      yearsExperience: 'Years Experience',

      // Services Section
      ourServices: 'Our Services',
      whatWeOffer: 'What We Offer',
      servicesSubtitle: 'Comprehensive services to make your pilgrimage seamless and memorable',
      premiumHotels: 'Premium Hotels',
      premiumHotelsDesc: '5-star hotels near Haram with stunning views',
      transportation: 'Transportation',
      transportationDesc: 'Comfortable AC buses & private transfers',
      guidedTours: 'Guided Tours',
      guidedToursDesc: 'Expert scholars to guide your spiritual journey',
      mealPlans: 'Meal Plans',
      mealPlansDesc: 'Halal buffet meals with international cuisine',
      visaAssistance: 'Visa Assistance',
      visaAssistanceDesc: 'Complete visa processing & documentation',
      ziyaratTours: 'Ziyarat Tours',
      ziyaratToursDesc: 'Visit historical Islamic sites in Makkah & Madinah',
      travelInsurance: 'Travel Insurance',
      travelInsuranceDesc: 'Comprehensive coverage for peace of mind',
      flightBookingDesc: 'Direct flights to Jeddah & Madinah with premium airlines',

      // How It Works Section
      howItWorks: 'How It Works',
      simpleBookingProcess: 'Simple Booking Process',
      bookingProcessSubtitle: 'Book your dream pilgrimage in just 4 easy steps',
      choosePackage: 'Choose Package',
      choosePackageDesc: 'Browse our curated Umrah & Hajj packages',
      fillDetails: 'Fill Details',
      fillDetailsDesc: 'Provide your travel information & preferences',
      securePayment: 'Secure Payment',
      securePaymentDesc: 'Pay securely with multiple payment options',
      startJourney: 'Start Journey',
      startJourneyDesc: 'Begin your blessed pilgrimage experience',

      // FAQ Section
      faq: 'FAQ',
      frequentlyAsked: 'Frequently Asked Questions',
      faqSubtitle: 'Find answers to common questions about our services',
      faq1Question: 'What documents do I need for Umrah?',
      faq1Answer: 'You need a valid passport (6+ months validity), passport-size photos, completed visa application, and vaccination certificates. We assist with all documentation.',
      faq2Question: 'How far in advance should I book?',
      faq2Answer: 'We recommend booking at least 4-6 weeks in advance for Umrah and 6-12 months for Hajj to ensure availability and best prices.',
      faq3Question: 'Are meals included in the packages?',
      faq3Answer: 'Yes, most of our packages include breakfast and dinner. Some premium packages offer full board with all meals included.',
      faq4Question: 'What is your cancellation policy?',
      faq4Answer: 'Free cancellation up to 30 days before departure. Partial refunds available for cancellations within 30 days. Contact us for details.',
      moreQuestions: 'Have more questions?',
      chatWithUs: 'Chat With Us',

      // Trust Badges Section
      trustedPartners: 'Trusted by Leading Organizations',
      ministryApproved: 'Ministry Approved',
      iataAccredited: 'IATA Accredited',
      securePayments: 'Secure Payments',
      globalNetwork: 'Global Network',
      topRated: 'Top Rated',
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
      customerReviews: '📍 دليل موقع الفندق',
      whatCustomersSay: 'أقرب المعالم ومسارات الوصول',
      reviewsSubtitle: 'اكتشف مدى قرب فندقك مع مسارات واضحة ومسافات مشي إلى أهم المواقع المقدسة في مكة.',
      reviews: 'التقييمات',
      satisfaction: 'الرضا',
      joinHappyCustomers: 'انضم إلى آلاف المعتمرين الراضين',
      bookYourTrip: 'احجز رحلتك الآن',

      // Route Section
      routeDistance: 'المسافة',
      routeWalkingTime: 'وقت المشي',
      routeOpenInMaps: 'افتح في خرائط Google',
      routeHaramTitle: 'المسجد الحرام',
      routeHaramSubtitle: 'أقرب طريق للمشي والوصول إلى المداخل الرئيسية',
      routeClockTowerTitle: 'برج الساعة (أبراج البيت)',
      routeClockTowerSubtitle: 'التسوق والمطاعم ونقطة تجمع مميزة',
      routeZamzamTitle: 'منطقة زمزم',
      routeZamzamSubtitle: 'سهولة الوصول لجلب الماء والدخول من البوابات القريبة',
      routeTipsTitle: 'نصائح الطريق',
      routeTipsSubtitle: 'اجعل مشيك أسهل بهذه النصائح العملية',
      routeTip1: 'ابدأ مبكراً لتجنب أوقات الازدحام الشديد حول الصلوات.',
      routeTip2: 'ضع دبوساً في خرائط Google وشاركه مع مجموعتك قبل الخروج.',
      routeTip3: 'إذا كنت مع كبار السن، اطلب مسارات الكراسي المتحركة والطرق المظللة.',
      routeCtaTitle: 'تحتاج المسار الدقيق للفندق؟',
      routeCtaSubtitle: 'أرسل لنا اسم الفندق وسنرد عليك بأفضل مسار وأقرب المعالم.',
      routeSendOnWhatsApp: 'أرسل اسم الفندق على واتساب',

      // Stats Section
      trustedByThousands: 'موثوق به من آلاف المعتمرين',
      statsSubtitle: 'انضم إلى عائلتنا المتنامية من المسافرين الراضين الذين عاشوا رحلة العمر',
      happyPilgrims: 'معتمرون سعداء',
      packageOptions: 'خيارات الباقات',
      yearsExperience: 'سنوات الخبرة',

      // Services Section
      ourServices: 'خدماتنا',
      whatWeOffer: 'ما نقدمه',
      servicesSubtitle: 'خدمات شاملة لجعل رحلتك سلسة ولا تُنسى',
      premiumHotels: 'فنادق فاخرة',
      premiumHotelsDesc: 'فنادق 5 نجوم بالقرب من الحرم مع إطلالات رائعة',
      transportation: 'المواصلات',
      transportationDesc: 'حافلات مكيفة مريحة ونقل خاص',
      guidedTours: 'جولات مُرشدة',
      guidedToursDesc: 'علماء خبراء لإرشادك في رحلتك الروحية',
      mealPlans: 'خطط الوجبات',
      mealPlansDesc: 'وجبات بوفيه حلال مع مأكولات عالمية',
      visaAssistance: 'المساعدة في التأشيرة',
      visaAssistanceDesc: 'معالجة التأشيرات والوثائق بالكامل',
      ziyaratTours: 'جولات الزيارات',
      ziyaratToursDesc: 'زيارة المواقع الإسلامية التاريخية في مكة والمدينة',
      travelInsurance: 'تأمين السفر',
      travelInsuranceDesc: 'تغطية شاملة لراحة البال',
      flightBookingDesc: 'رحلات مباشرة إلى جدة والمدينة مع شركات طيران متميزة',

      // How It Works Section
      howItWorks: 'كيف يعمل',
      simpleBookingProcess: 'عملية حجز بسيطة',
      bookingProcessSubtitle: 'احجز رحلة أحلامك في 4 خطوات سهلة',
      choosePackage: 'اختر الباقة',
      choosePackageDesc: 'تصفح باقات العمرة والحج المنتقاة',
      fillDetails: 'أدخل التفاصيل',
      fillDetailsDesc: 'قدم معلومات السفر وتفضيلاتك',
      securePayment: 'دفع آمن',
      securePaymentDesc: 'ادفع بأمان مع خيارات دفع متعددة',
      startJourney: 'ابدأ الرحلة',
      startJourneyDesc: 'ابدأ تجربة حجك المباركة',

      // FAQ Section
      faq: 'الأسئلة الشائعة',
      frequentlyAsked: 'الأسئلة المتكررة',
      faqSubtitle: 'اعثر على إجابات للأسئلة الشائعة حول خدماتنا',
      faq1Question: 'ما هي الوثائق المطلوبة للعمرة؟',
      faq1Answer: 'تحتاج إلى جواز سفر ساري المفعول (صلاحية 6 أشهر أو أكثر)، صور بحجم جواز السفر، طلب تأشيرة مكتمل، وشهادات التطعيم. نحن نساعد في جميع الوثائق.',
      faq2Question: 'كم من الوقت مسبقاً يجب أن أحجز؟',
      faq2Answer: 'نوصي بالحجز قبل 4-6 أسابيع على الأقل للعمرة و6-12 شهراً للحج لضمان التوفر وأفضل الأسعار.',
      faq3Question: 'هل الوجبات مشمولة في الباقات؟',
      faq3Answer: 'نعم، معظم باقاتنا تشمل الإفطار والعشاء. بعض الباقات الفاخرة تقدم إقامة كاملة مع جميع الوجبات.',
      faq4Question: 'ما هي سياسة الإلغاء لديكم؟',
      faq4Answer: 'إلغاء مجاني حتى 30 يوماً قبل المغادرة. استرداد جزئي متاح للإلغاءات خلال 30 يوماً. اتصل بنا للتفاصيل.',
      moreQuestions: 'لديك المزيد من الأسئلة؟',
      chatWithUs: 'تحدث معنا',

      // Trust Badges Section
      trustedPartners: 'موثوق به من المنظمات الرائدة',
      ministryApproved: 'معتمد من الوزارة',
      iataAccredited: 'معتمد من IATA',
      securePayments: 'مدفوعات آمنة',
      globalNetwork: 'شبكة عالمية',
      topRated: 'الأعلى تقييماً',
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
