import React from 'react';
import { useTranslation } from 'react-i18next';

function ReviewsSection() {
  const { t } = useTranslation();

  const reviews = [
    {
      id: 1,
      name: 'Sarah Johnson',
      nameAr: 'سارة جونسون',
      location: 'New York, USA',
      locationAr: 'نيويورك، الولايات المتحدة',
      rating: 5,
      review: 'Absolutely amazing experience! The team took care of every detail and made our honeymoon unforgettable. Highly recommend!',
      reviewAr: 'تجربة رائعة حقًا! اهتم الفريق بكل التفاصيل وجعل شهر العسل لا يُنسى. أوصي بشدة!',
      image: 'https://i.pravatar.cc/150?img=1',
      package: 'Maldives Luxury Package',
      packageAr: 'باقة المالديف الفاخرة',
      date: '2 weeks ago',
      dateAr: 'منذ أسبوعين'
    },
    {
      id: 2,
      name: 'Ahmed Al Maktoum',
      nameAr: 'أحمد المكتوم',
      location: 'Dubai, UAE',
      locationAr: 'دبي، الإمارات',
      rating: 5,
      review: 'Professional service from start to finish. The Dubai city tour was perfectly organized and our guide was excellent!',
      reviewAr: 'خدمة احترافية من البداية إلى النهاية. كانت جولة دبي منظمة بشكل مثالي ودليلنا كان ممتازًا!',
      image: 'https://i.pravatar.cc/150?img=12',
      package: 'Dubai Explorer',
      packageAr: 'مستكشف دبي',
      date: '1 month ago',
      dateAr: 'منذ شهر'
    },
    {
      id: 3,
      name: 'Maria Garcia',
      nameAr: 'ماريا غارسيا',
      location: 'Barcelona, Spain',
      locationAr: 'برشلونة، إسبانيا',
      rating: 5,
      review: 'Best travel agency ever! They customized our package perfectly and the prices were very competitive. Will book again!',
      reviewAr: 'أفضل وكالة سفر على الإطلاق! قاموا بتخصيص باقتنا بشكل مثالي والأسعار كانت تنافسية جدًا. سأحجز مرة أخرى!',
      image: 'https://i.pravatar.cc/150?img=5',
      package: 'European Adventure',
      packageAr: 'مغامرة أوروبية',
      date: '3 weeks ago',
      dateAr: 'منذ 3 أسابيع'
    },
    {
      id: 4,
      name: 'John Smith',
      nameAr: 'جون سميث',
      location: 'London, UK',
      locationAr: 'لندن، المملكة المتحدة',
      rating: 5,
      review: 'Outstanding customer support! They were available 24/7 and helped us with everything. The hotel was luxurious and location perfect.',
      reviewAr: 'دعم عملاء متميز! كانوا متاحين على مدار الساعة وساعدونا في كل شيء. كان الفندق فاخرًا والموقع مثاليًا.',
      image: 'https://i.pravatar.cc/150?img=8',
      package: 'Bali Paradise',
      packageAr: 'جنة بالي',
      date: '1 week ago',
      dateAr: 'منذ أسبوع'
    },
    {
      id: 5,
      name: 'Fatima Hassan',
      nameAr: 'فاطمة حسن',
      location: 'Cairo, Egypt',
      locationAr: 'القاهرة، مصر',
      rating: 5,
      review: 'Wonderful family vacation! Everything was well-organized, and the kids had an amazing time. Thank you for the memories!',
      reviewAr: 'عطلة عائلية رائعة! كان كل شيء منظمًا بشكل جيد، والأطفال قضوا وقتًا رائعًا. شكرًا على الذكريات!',
      image: 'https://i.pravatar.cc/150?img=9',
      package: 'Family Fun Package',
      packageAr: 'باقة المرح العائلي',
      date: '2 months ago',
      dateAr: 'منذ شهرين'
    },
    {
      id: 6,
      name: 'Michael Chen',
      nameAr: 'مايكل تشن',
      location: 'Singapore',
      locationAr: 'سنغافورة',
      rating: 5,
      review: 'Exceeded all expectations! The attention to detail and personalized service made this trip truly special. Highly professional team!',
      reviewAr: 'تجاوز كل التوقعات! الاهتمام بالتفاصيل والخدمة الشخصية جعلت هذه الرحلة مميزة حقًا. فريق محترف للغاية!',
      image: 'https://i.pravatar.cc/150?img=13',
      package: 'Thailand Explorer',
      packageAr: 'مستكشف تايلاند',
      date: '3 weeks ago',
      dateAr: 'منذ 3 أسابيع'
    }
  ];

  return (
    <section className="py-24 bg-gradient-to-br from-slate-50 via-blue-50 to-purple-50 relative overflow-hidden">
      {/* Background Decorations */}
      <div className="absolute top-0 left-0 w-96 h-96 bg-blue-200 rounded-full filter blur-3xl opacity-20 -ml-48 -mt-48"></div>
      <div className="absolute bottom-0 right-0 w-96 h-96 bg-purple-200 rounded-full filter blur-3xl opacity-20 -mr-48 -mb-48"></div>
      
      {/* Floating Elements */}
      <div className="absolute top-1/4 right-1/4 w-4 h-4 bg-blue-400 rounded-full animate-ping"></div>
      <div className="absolute bottom-1/3 left-1/3 w-3 h-3 bg-purple-400 rounded-full animate-ping" style={{ animationDelay: '1s' }}></div>

      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        {/* Section Header */}
        <div className="text-center mb-16">
          <div className="inline-flex items-center space-x-2 rtl:space-x-reverse bg-gradient-to-r from-blue-100 to-purple-100 border border-blue-200 rounded-full px-6 py-3 mb-6">
            <svg className="w-5 h-5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
              <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
            </svg>
            <span className="text-blue-700 font-semibold text-sm tracking-wide">{t('customerReviews')}</span>
          </div>
          
          <h2 className="text-4xl md:text-5xl font-black text-gray-900 mb-4">
            {t('whatCustomersSay')}
          </h2>
          <p className="text-xl text-gray-600 max-w-2xl mx-auto">
            {t('reviewsSubtitle')}
          </p>

          {/* Stats Bar */}
          <div className="flex items-center justify-center space-x-8 rtl:space-x-reverse mt-8">
            <div className="text-center">
              <div className="text-3xl font-black text-blue-600">4.9/5</div>
              <div className="text-sm text-gray-600">{t('averageRating')}</div>
            </div>
            <div className="h-12 w-px bg-gray-300"></div>
            <div className="text-center">
              <div className="text-3xl font-black text-purple-600">500+</div>
              <div className="text-sm text-gray-600">{t('reviews')}</div>
            </div>
            <div className="h-12 w-px bg-gray-300"></div>
            <div className="text-center">
              <div className="text-3xl font-black text-green-600">98%</div>
              <div className="text-sm text-gray-600">{t('satisfaction')}</div>
            </div>
          </div>
        </div>

        {/* Reviews Grid */}
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
          {reviews.map((review, index) => (
            <div
              key={review.id}
              className="group bg-white rounded-3xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 border border-gray-100 relative overflow-hidden"
              style={{ animationDelay: `${index * 100}ms` }}
            >
              {/* Gradient Overlay on Hover */}
              <div className="absolute inset-0 bg-gradient-to-br from-blue-500/5 to-purple-500/5 opacity-0 group-hover:opacity-100 transition-opacity rounded-3xl"></div>

              {/* Quote Icon */}
              <div className="absolute top-6 right-6 opacity-10 group-hover:opacity-20 transition-opacity">
                <svg className="w-16 h-16 text-blue-500" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z" />
                </svg>
              </div>

              <div className="relative">
                {/* Header */}
                <div className="flex items-center space-x-4 rtl:space-x-reverse mb-6">
                  <div className="relative">
                    <img
                      src={review.image}
                      alt={review.name}
                      className="w-16 h-16 rounded-full object-cover border-4 border-blue-100 group-hover:border-blue-200 transition-colors"
                    />
                    <div className="absolute -bottom-1 -right-1 w-6 h-6 bg-green-500 rounded-full border-2 border-white flex items-center justify-center">
                      <svg className="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="3" d="M5 13l4 4L19 7" />
                      </svg>
                    </div>
                  </div>
                  <div className="flex-1">
                    <h3 className="font-bold text-gray-900 text-lg">{review.name}</h3>
                    <p className="text-sm text-gray-500 flex items-center">
                      <svg className="w-4 h-4 mr-1 rtl:ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                      </svg>
                      {review.location}
                    </p>
                  </div>
                </div>

                {/* Rating */}
                <div className="flex items-center space-x-1 rtl:space-x-reverse mb-4">
                  {[...Array(review.rating)].map((_, i) => (
                    <svg key={i} className="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                      <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                    </svg>
                  ))}
                </div>

                {/* Review Text */}
                <p className="text-gray-700 leading-relaxed mb-6 line-clamp-4">
                  "{review.review}"
                </p>

                {/* Package Badge */}
                <div className="flex items-center justify-between pt-4 border-t border-gray-100">
                  <div className="flex items-center space-x-2 rtl:space-x-reverse">
                    <div className="w-8 h-8 bg-gradient-to-br from-blue-500 to-purple-500 rounded-lg flex items-center justify-center">
                      <svg className="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                      </svg>
                    </div>
                    <span className="text-sm font-semibold text-gray-700">{review.package}</span>
                  </div>
                  <span className="text-xs text-gray-500">{review.date}</span>
                </div>
              </div>
            </div>
          ))}
        </div>

        {/* Bottom CTA */}
        <div className="text-center mt-16">
          <div className="inline-flex flex-col items-center space-y-4">
            <p className="text-gray-600 text-lg">
              {t('joinHappyCustomers')}
            </p>
            <a
              href="https://wa.me/971561325543"
              target="_blank"
              rel="noopener noreferrer"
              className="group inline-flex items-center space-x-3 rtl:space-x-reverse bg-gradient-to-r from-blue-600 to-purple-600 text-white px-8 py-4 rounded-2xl font-bold text-lg shadow-xl hover:shadow-2xl hover:scale-105 transition-all duration-300"
            >
              <span>{t('bookYourTrip')}</span>
              <svg className="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
              </svg>
            </a>
          </div>
        </div>
      </div>
    </section>
  );
}

export default ReviewsSection;
