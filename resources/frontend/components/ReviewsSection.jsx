import React from 'react';
import { useTranslation } from 'react-i18next';

function ReviewsSection() {
  const { t, i18n } = useTranslation();

  const isArabic = i18n.language === 'ar';

  const routes = [
    {
      id: 'haram',
      icon: '🕌',
      titleKey: 'routeHaramTitle',
      subtitleKey: 'routeHaramSubtitle',
      distance: '600 m',
      time: '8 min',
      mapsUrl: 'https://www.google.com/maps/search/?api=1&query=Masjid%20al%20Haram',
    },
    {
      id: 'clock-tower',
      icon: '🕰️',
      titleKey: 'routeClockTowerTitle',
      subtitleKey: 'routeClockTowerSubtitle',
      distance: '900 m',
      time: '12 min',
      mapsUrl: 'https://www.google.com/maps/search/?api=1&query=Abraj%20Al%20Bait%20Clock%20Tower',
    },
    {
      id: 'zamzam',
      icon: '💧',
      titleKey: 'routeZamzamTitle',
      subtitleKey: 'routeZamzamSubtitle',
      distance: '700 m',
      time: '10 min',
      mapsUrl: 'https://www.google.com/maps/search/?api=1&query=Zamzam%20Well',
    },
  ];

  return (
    <section className="py-24 bg-gradient-to-br from-gray-50 via-blue-50/30 to-indigo-50/50 relative overflow-hidden">
      {/* Decorative Elements */}
      <div className="absolute top-0 left-0 w-[600px] h-[600px] bg-gradient-to-br from-blue-200/40 to-indigo-200/40 rounded-full filter blur-3xl -ml-64 -mt-64"></div>
      <div className="absolute bottom-0 right-0 w-[500px] h-[500px] bg-gradient-to-br from-amber-200/30 to-yellow-200/30 rounded-full filter blur-3xl -mr-48 -mb-48"></div>

      {/* Floating Elements */}
      <div className="absolute top-1/4 right-1/4 w-3 h-3 bg-blue-400 rounded-full animate-ping opacity-60"></div>
      <div className="absolute bottom-1/3 left-1/3 w-2 h-2 bg-indigo-400 rounded-full animate-ping opacity-60" style={{ animationDelay: '1s' }}></div>
      <div className="absolute top-1/2 right-1/3 w-2 h-2 bg-amber-400 rounded-full animate-ping opacity-60" style={{ animationDelay: '2s' }}></div>

      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        {/* Header */}
        <div className="text-center mb-16">
          <div className="inline-flex items-center gap-2 bg-white/80 backdrop-blur-xl border border-blue-200/50 rounded-full px-5 py-2.5 mb-6 shadow-lg shadow-blue-500/5">
            <span className="text-lg">📍</span>
            <span className="text-blue-700 font-semibold text-sm">{t('customerReviews')}</span>
          </div>

          <h2 className="text-4xl md:text-5xl font-extrabold text-gray-900 mb-4">
            {t('whatCustomersSay')}
          </h2>
          <p className="text-lg text-gray-600 max-w-2xl mx-auto">
            {t('reviewsSubtitle')}
          </p>
        </div>

          <div className="lg:col-span-2">
              <div className="relative rounded-3xl overflow-hidden shadow-lg">
                  <img
                      src="/images/route.png"
                      alt="Route"
                      className="w-full h-[500px] md:h-[600px] lg:h-[100%] object-cover"
                  />
              </div>
          </div>

      </div>

      {/* Animation Styles */}
      <style jsx>{`
        @keyframes gradient-x {
          0% { background-position: 0% 50%; }
          50% { background-position: 100% 50%; }
          100% { background-position: 0% 50%; }
        }
        .animate-gradient-x {
          animation: gradient-x 3s ease infinite;
        }
      `}</style>
    </section>
  );
}

export default ReviewsSection;
