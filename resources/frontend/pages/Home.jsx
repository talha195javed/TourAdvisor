import React, { useState, useEffect } from 'react';
import { useTranslation } from 'react-i18next';
import { Link } from 'react-router-dom';
import PackageCard from '../components/PackageCard';
import HeroSection from '../components/HeroSection';
import ReviewsSection from '../components/ReviewsSection';
import { packagesAPI } from '../services/api';

function Home() {
  const { t, i18n } = useTranslation();
  const [featuredPackages, setFeaturedPackages] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  useEffect(() => {
    fetchFeaturedPackages();
  }, [i18n.language]);

  const fetchFeaturedPackages = async () => {
    try {
      setLoading(true);
      const response = await packagesAPI.getFeatured();
      setFeaturedPackages(response.data);
      setError(null);
    } catch (err) {
      console.error('Error fetching featured packages:', err);
      setError(t('error'));
    } finally {
      setLoading(false);
    }
  };

  return (
    <div className="min-h-screen overflow-hidden">
      <HeroSection />

      <section className="py-24 bg-gradient-to-b from-gray-50 to-white relative">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="text-center mb-16">
            <span className="inline-block px-4 py-2 bg-gradient-to-r from-blue-100 to-indigo-100 text-blue-700 rounded-full text-sm font-semibold mb-4">
              ✨ {t('featuredPackages')}
            </span>
            <h2 className="text-4xl md:text-5xl font-extrabold text-gray-900 mb-4">
              {t('premiumExperiences')}
            </h2>
            <p className="text-xl text-gray-600 max-w-2xl mx-auto">
              {t('packagesSubtitle')}
            </p>
          </div>

          {loading ? (
            <div className="flex flex-col justify-center items-center py-20">
              <div className="relative">
                <div className="animate-spin rounded-full h-20 w-20 border-t-4 border-b-4 border-blue-600"></div>
                <div className="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                  <svg className="h-8 w-8 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/>
                  </svg>
                </div>
              </div>
              <p className="mt-4 text-gray-600">{t('loading')}</p>
            </div>
          ) : error ? (
            <div className="text-center py-20 bg-red-50 rounded-2xl">
              <svg className="h-16 w-16 text-red-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
              <p className="text-red-600 text-lg font-semibold">{error}</p>
            </div>
          ) : (
            <>
              <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                {featuredPackages.map((pkg, index) => (
                  <div
                    key={pkg.id}
                    className="animate-fade-in-up"
                    style={{ animationDelay: `${index * 100}ms` }}
                  >
                    <PackageCard package={pkg} />
                  </div>
                ))}
              </div>

              {featuredPackages.length === 0 && (
                <div className="text-center py-20">
                  <svg className="h-24 w-24 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                  </svg>
                  <p className="text-gray-600 text-lg">{t('noPackagesFound')}</p>
                </div>
              )}

              {featuredPackages.length > 0 && (
                <div className="text-center mt-16">
                  <Link
                    to="/packages"
                    className="group inline-flex items-center space-x-2 rtl:space-x-reverse bg-gradient-to-r from-blue-600 to-indigo-600 text-white px-10 py-4 rounded-full font-semibold text-lg hover:shadow-2xl hover:scale-105 transition-all duration-300"
                  >
                    <span>{t('viewAllPackages')}</span>
                    <svg className="h-5 w-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                    </svg>
                  </Link>
                </div>
              )}
            </>
          )}
        </div>
      </section>

      <section className="py-24 bg-white relative overflow-hidden">
        <div className="absolute top-0 right-0 w-96 h-96 bg-blue-100 rounded-full filter blur-3xl opacity-30 -mr-48 -mt-48"></div>
        <div className="absolute bottom-0 left-0 w-96 h-96 bg-indigo-100 rounded-full filter blur-3xl opacity-30 -ml-48 -mb-48"></div>

        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
          <div className="text-center mb-16">
            <span className="inline-block px-4 py-2 bg-gradient-to-r from-blue-100 to-indigo-100 text-blue-700 rounded-full text-sm font-semibold mb-4">
              🕌 {t('whyChooseUs')}
            </span>
            <h2 className="text-4xl md:text-5xl font-extrabold text-gray-900 mb-4">
              {t('yourJourneyOurPriority')}
            </h2>
          </div>

          <div className="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div className="group relative bg-gradient-to-br from-blue-50 to-blue-100 rounded-3xl p-8 hover:shadow-2xl transition-all duration-300 hover:-translate-y-2">
              <div className="absolute top-0 right-0 w-32 h-32 bg-blue-200 rounded-full filter blur-2xl opacity-50 group-hover:opacity-70 transition-opacity"></div>
              <div className="relative">
                <div className="bg-gradient-to-br from-blue-500 to-blue-600 w-16 h-16 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                  <svg className="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
                </div>
                <h3 className="text-2xl font-bold mb-3 text-gray-900">{t('support247Title')}</h3>
                <p className="text-gray-700 leading-relaxed">{t('support247Desc')}</p>
              </div>
            </div>

            <div className="group relative bg-gradient-to-br from-green-50 to-green-100 rounded-3xl p-8 hover:shadow-2xl transition-all duration-300 hover:-translate-y-2">
              <div className="absolute top-0 right-0 w-32 h-32 bg-green-200 rounded-full filter blur-2xl opacity-50 group-hover:opacity-70 transition-opacity"></div>
              <div className="relative">
                <div className="bg-gradient-to-br from-green-500 to-green-600 w-16 h-16 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                  <svg className="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
                </div>
                <h3 className="text-2xl font-bold mb-3 text-gray-900">{t('bestPricesTitle')}</h3>
                <p className="text-gray-700 leading-relaxed">{t('bestPricesDesc')}</p>
              </div>
            </div>

            <div className="group relative bg-gradient-to-br from-indigo-50 to-indigo-100 rounded-3xl p-8 hover:shadow-2xl transition-all duration-300 hover:-translate-y-2">
              <div className="absolute top-0 right-0 w-32 h-32 bg-indigo-200 rounded-full filter blur-2xl opacity-50 group-hover:opacity-70 transition-opacity"></div>
              <div className="relative">
                <div className="bg-gradient-to-br from-indigo-500 to-indigo-600 w-16 h-16 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                  <svg className="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                  </svg>
                </div>
                <h3 className="text-2xl font-bold mb-3 text-gray-900">{t('curatedExperiencesTitle')}</h3>
                <p className="text-gray-700 leading-relaxed">{t('curatedExperiencesDesc')}</p>
              </div>
            </div>
          </div>
        </div>
      </section>

      <ReviewsSection />

      {/* Stats Counter Section */}
      <section className="py-20 bg-gradient-to-br from-gray-900 via-blue-900 to-indigo-900 relative overflow-hidden">
        {/* Background Pattern */}
        <div className="absolute inset-0 opacity-10" style={{
          backgroundImage: 'radial-gradient(circle at 25% 25%, white 2px, transparent 2px), radial-gradient(circle at 75% 75%, white 1px, transparent 1px)',
          backgroundSize: '60px 60px'
        }}></div>

        {/* Floating Orbs */}
        <div className="absolute -top-20 -left-20 w-80 h-80 bg-blue-500 rounded-full filter blur-3xl opacity-20 animate-pulse"></div>
        <div className="absolute -bottom-20 -right-20 w-80 h-80 bg-indigo-500 rounded-full filter blur-3xl opacity-20 animate-pulse"></div>

        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
          <div className="text-center mb-12">
            <h2 className="text-3xl md:text-4xl font-bold text-white mb-4">
              {t('trustedByThousands') || 'Trusted by Thousands of Pilgrims'}
            </h2>
            <p className="text-blue-200 text-lg max-w-2xl mx-auto">
              {t('statsSubtitle') || 'Join our growing family of satisfied travelers who have experienced the journey of a lifetime'}
            </p>
          </div>

          <div className="grid grid-cols-2 md:grid-cols-4 gap-8">
            <div className="text-center group">
              <div className="bg-white/10 backdrop-blur-md rounded-3xl p-8 border border-white/20 hover:bg-white/20 transition-all duration-300 hover:-translate-y-2">
                <div className="text-5xl md:text-6xl font-black bg-gradient-to-r from-blue-400 to-indigo-400 bg-clip-text text-transparent mb-2">
                  15K+
                </div>
                <p className="text-blue-200 font-medium">{t('happyPilgrims') || 'Happy Pilgrims'}</p>
              </div>
            </div>
            <div className="text-center group">
              <div className="bg-white/10 backdrop-blur-md rounded-3xl p-8 border border-white/20 hover:bg-white/20 transition-all duration-300 hover:-translate-y-2">
                <div className="text-5xl md:text-6xl font-black bg-gradient-to-r from-amber-400 to-orange-400 bg-clip-text text-transparent mb-2">
                  50+
                </div>
                <p className="text-blue-200 font-medium">{t('packageOptions') || 'Package Options'}</p>
              </div>
            </div>
            <div className="text-center group">
              <div className="bg-white/10 backdrop-blur-md rounded-3xl p-8 border border-white/20 hover:bg-white/20 transition-all duration-300 hover:-translate-y-2">
                <div className="text-5xl md:text-6xl font-black bg-gradient-to-r from-sky-400 to-blue-400 bg-clip-text text-transparent mb-2">
                  10+
                </div>
                <p className="text-blue-200 font-medium">{t('yearsExperience') || 'Years Experience'}</p>
              </div>
            </div>
            <div className="text-center group">
              <div className="bg-white/10 backdrop-blur-md rounded-3xl p-8 border border-white/20 hover:bg-white/20 transition-all duration-300 hover:-translate-y-2">
                <div className="text-5xl md:text-6xl font-black bg-gradient-to-r from-rose-400 to-pink-400 bg-clip-text text-transparent mb-2">
                  4.9
                </div>
                <p className="text-blue-200 font-medium">{t('averageRating') || 'Average Rating'}</p>
              </div>
            </div>
          </div>
        </div>
      </section>

      {/* Services/What We Offer Section */}
      <section className="py-24 bg-white relative overflow-hidden">
        <div className="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-blue-500 via-indigo-500 to-blue-500"></div>

        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="text-center mb-16">
            <span className="inline-block px-4 py-2 bg-gradient-to-r from-blue-100 to-indigo-100 text-blue-700 rounded-full text-sm font-semibold mb-4">
              🌟 {t('ourServices') || 'Our Services'}
            </span>
            <h2 className="text-4xl md:text-5xl font-extrabold text-gray-900 mb-4">
              {t('whatWeOffer') || 'What We Offer'}
            </h2>
            <p className="text-xl text-gray-600 max-w-2xl mx-auto">
              {t('servicesSubtitle') || 'Comprehensive services to make your pilgrimage seamless and memorable'}
            </p>
          </div>

          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            {/* Service 1 */}
            <div className="group relative bg-gradient-to-br from-white to-gray-50 rounded-3xl p-6 border border-gray-100 hover:shadow-2xl hover:shadow-blue-500/10 transition-all duration-500 hover:-translate-y-2">
              <div className="absolute inset-0 bg-gradient-to-br from-blue-500/5 to-indigo-500/5 rounded-3xl opacity-0 group-hover:opacity-100 transition-opacity"></div>
              <div className="relative">
                <div className="w-14 h-14 bg-gradient-to-br from-blue-500 to-indigo-500 rounded-2xl flex items-center justify-center mb-5 group-hover:scale-110 transition-transform shadow-lg shadow-blue-500/20">
                  <span className="text-2xl">✈️</span>
                </div>
                <h3 className="text-xl font-bold text-gray-900 mb-2">{t('flightBooking') || 'Flight Booking'}</h3>
                <p className="text-gray-600 text-sm leading-relaxed">{t('flightBookingDesc') || 'Direct flights to Jeddah & Madinah with premium airlines'}</p>
              </div>
            </div>

            {/* Service 2 */}
            <div className="group relative bg-gradient-to-br from-white to-gray-50 rounded-3xl p-6 border border-gray-100 hover:shadow-2xl hover:shadow-blue-500/10 transition-all duration-500 hover:-translate-y-2">
              <div className="absolute inset-0 bg-gradient-to-br from-blue-500/5 to-indigo-500/5 rounded-3xl opacity-0 group-hover:opacity-100 transition-opacity"></div>
              <div className="relative">
                <div className="w-14 h-14 bg-gradient-to-br from-amber-500 to-orange-500 rounded-2xl flex items-center justify-center mb-5 group-hover:scale-110 transition-transform shadow-lg shadow-amber-500/20">
                  <span className="text-2xl">🏨</span>
                </div>
                <h3 className="text-xl font-bold text-gray-900 mb-2">{t('premiumHotels') || 'Premium Hotels'}</h3>
                <p className="text-gray-600 text-sm leading-relaxed">{t('premiumHotelsDesc') || '5-star hotels near Haram with stunning views'}</p>
              </div>
            </div>

            {/* Service 3 */}
            <div className="group relative bg-gradient-to-br from-white to-gray-50 rounded-3xl p-6 border border-gray-100 hover:shadow-2xl hover:shadow-blue-500/10 transition-all duration-500 hover:-translate-y-2">
              <div className="absolute inset-0 bg-gradient-to-br from-blue-500/5 to-indigo-500/5 rounded-3xl opacity-0 group-hover:opacity-100 transition-opacity"></div>
              <div className="relative">
                <div className="w-14 h-14 bg-gradient-to-br from-sky-500 to-blue-500 rounded-2xl flex items-center justify-center mb-5 group-hover:scale-110 transition-transform shadow-lg shadow-sky-500/20">
                  <span className="text-2xl">🚐</span>
                </div>
                <h3 className="text-xl font-bold text-gray-900 mb-2">{t('transportation') || 'Transportation'}</h3>
                <p className="text-gray-600 text-sm leading-relaxed">{t('transportationDesc') || 'Comfortable AC buses & private transfers'}</p>
              </div>
            </div>

            {/* Service 4 */}
            <div className="group relative bg-gradient-to-br from-white to-gray-50 rounded-3xl p-6 border border-gray-100 hover:shadow-2xl hover:shadow-blue-500/10 transition-all duration-500 hover:-translate-y-2">
              <div className="absolute inset-0 bg-gradient-to-br from-blue-500/5 to-indigo-500/5 rounded-3xl opacity-0 group-hover:opacity-100 transition-opacity"></div>
              <div className="relative">
                <div className="w-14 h-14 bg-gradient-to-br from-purple-500 to-violet-500 rounded-2xl flex items-center justify-center mb-5 group-hover:scale-110 transition-transform shadow-lg shadow-purple-500/20">
                  <span className="text-2xl">📖</span>
                </div>
                <h3 className="text-xl font-bold text-gray-900 mb-2">{t('guidedTours') || 'Guided Tours'}</h3>
                <p className="text-gray-600 text-sm leading-relaxed">{t('guidedToursDesc') || 'Expert scholars to guide your spiritual journey'}</p>
              </div>
            </div>

            {/* Service 5 */}
            <div className="group relative bg-gradient-to-br from-white to-gray-50 rounded-3xl p-6 border border-gray-100 hover:shadow-2xl hover:shadow-blue-500/10 transition-all duration-500 hover:-translate-y-2">
              <div className="absolute inset-0 bg-gradient-to-br from-blue-500/5 to-indigo-500/5 rounded-3xl opacity-0 group-hover:opacity-100 transition-opacity"></div>
              <div className="relative">
                <div className="w-14 h-14 bg-gradient-to-br from-rose-500 to-pink-500 rounded-2xl flex items-center justify-center mb-5 group-hover:scale-110 transition-transform shadow-lg shadow-rose-500/20">
                  <span className="text-2xl">🍽️</span>
                </div>
                <h3 className="text-xl font-bold text-gray-900 mb-2">{t('mealPlans') || 'Meal Plans'}</h3>
                <p className="text-gray-600 text-sm leading-relaxed">{t('mealPlansDesc') || 'Halal buffet meals with international cuisine'}</p>
              </div>
            </div>

            {/* Service 6 */}
            <div className="group relative bg-gradient-to-br from-white to-gray-50 rounded-3xl p-6 border border-gray-100 hover:shadow-2xl hover:shadow-blue-500/10 transition-all duration-500 hover:-translate-y-2">
              <div className="absolute inset-0 bg-gradient-to-br from-blue-500/5 to-indigo-500/5 rounded-3xl opacity-0 group-hover:opacity-100 transition-opacity"></div>
              <div className="relative">
                <div className="w-14 h-14 bg-gradient-to-br from-green-500 to-blue-500 rounded-2xl flex items-center justify-center mb-5 group-hover:scale-110 transition-transform shadow-lg shadow-green-500/20">
                  <span className="text-2xl">📋</span>
                </div>
                <h3 className="text-xl font-bold text-gray-900 mb-2">{t('visaAssistance') || 'Visa Assistance'}</h3>
                <p className="text-gray-600 text-sm leading-relaxed">{t('visaAssistanceDesc') || 'Complete visa processing & documentation'}</p>
              </div>
            </div>

            {/* Service 7 */}
            <div className="group relative bg-gradient-to-br from-white to-gray-50 rounded-3xl p-6 border border-gray-100 hover:shadow-2xl hover:shadow-blue-500/10 transition-all duration-500 hover:-translate-y-2">
              <div className="absolute inset-0 bg-gradient-to-br from-blue-500/5 to-indigo-500/5 rounded-3xl opacity-0 group-hover:opacity-100 transition-opacity"></div>
              <div className="relative">
                <div className="w-14 h-14 bg-gradient-to-br from-cyan-500 to-indigo-500 rounded-2xl flex items-center justify-center mb-5 group-hover:scale-110 transition-transform shadow-lg shadow-cyan-500/20">
                  <span className="text-2xl">🎒</span>
                </div>
                <h3 className="text-xl font-bold text-gray-900 mb-2">{t('ziyaratTours') || 'Ziyarat Tours'}</h3>
                <p className="text-gray-600 text-sm leading-relaxed">{t('ziyaratToursDesc') || 'Visit historical Islamic sites in Makkah & Madinah'}</p>
              </div>
            </div>

            {/* Service 8 */}
            <div className="group relative bg-gradient-to-br from-white to-gray-50 rounded-3xl p-6 border border-gray-100 hover:shadow-2xl hover:shadow-blue-500/10 transition-all duration-500 hover:-translate-y-2">
              <div className="absolute inset-0 bg-gradient-to-br from-blue-500/5 to-indigo-500/5 rounded-3xl opacity-0 group-hover:opacity-100 transition-opacity"></div>
              <div className="relative">
                <div className="w-14 h-14 bg-gradient-to-br from-indigo-500 to-purple-500 rounded-2xl flex items-center justify-center mb-5 group-hover:scale-110 transition-transform shadow-lg shadow-indigo-500/20">
                  <span className="text-2xl">🛡️</span>
                </div>
                <h3 className="text-xl font-bold text-gray-900 mb-2">{t('travelInsurance') || 'Travel Insurance'}</h3>
                <p className="text-gray-600 text-sm leading-relaxed">{t('travelInsuranceDesc') || 'Comprehensive coverage for peace of mind'}</p>
              </div>
            </div>
          </div>
        </div>
      </section>

      {/* How It Works Section */}
      <section className="py-24 bg-gradient-to-b from-gray-50 to-white relative">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="text-center mb-16">
            <span className="inline-block px-4 py-2 bg-gradient-to-r from-blue-100 to-indigo-100 text-blue-700 rounded-full text-sm font-semibold mb-4">
              📍 {t('howItWorks')}
            </span>
            <h2 className="text-4xl md:text-5xl font-extrabold text-gray-900 mb-4">
              {t('simpleBookingProcess')}
            </h2>
            <p className="text-xl text-gray-600 max-w-2xl mx-auto">
              {t('bookingProcessSubtitle')}
            </p>
          </div>

          <div className="grid grid-cols-1 md:grid-cols-4 gap-8 relative">
            {/* Connecting Line */}
            <div className="hidden md:block absolute top-16 left-[12%] right-[12%] h-1 bg-gradient-to-r from-blue-200 via-indigo-300 to-blue-200 rounded-full"></div>

            {/* Step 1 */}
            <div className="relative text-center">
              <div className="relative inline-block mb-6">
                <div className="w-32 h-32 bg-gradient-to-br from-blue-500 to-indigo-500 rounded-full flex items-center justify-center shadow-2xl shadow-blue-500/30 mx-auto">
                  <span className="text-5xl">🔍</span>
                </div>
                <div className="absolute -top-2 -right-2 w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-lg border-4 border-blue-500">
                  <span className="text-blue-600 font-bold">1</span>
                </div>
              </div>
              <h3 className="text-xl font-bold text-gray-900 mb-2">{t('choosePackage')}</h3>
              <p className="text-gray-600">{t('choosePackageDesc')}</p>
            </div>

            {/* Step 2 */}
            <div className="relative text-center">
              <div className="relative inline-block mb-6">
                <div className="w-32 h-32 bg-gradient-to-br from-amber-500 to-orange-500 rounded-full flex items-center justify-center shadow-2xl shadow-amber-500/30 mx-auto">
                  <span className="text-5xl">📝</span>
                </div>
                <div className="absolute -top-2 -right-2 w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-lg border-4 border-amber-500">
                  <span className="text-amber-600 font-bold">2</span>
                </div>
              </div>
              <h3 className="text-xl font-bold text-gray-900 mb-2">{t('fillDetails')}</h3>
              <p className="text-gray-600">{t('fillDetailsDesc')}</p>
            </div>

            {/* Step 3 */}
            <div className="relative text-center">
              <div className="relative inline-block mb-6">
                <div className="w-32 h-32 bg-gradient-to-br from-sky-500 to-blue-500 rounded-full flex items-center justify-center shadow-2xl shadow-sky-500/30 mx-auto">
                  <span className="text-5xl">💳</span>
                </div>
                <div className="absolute -top-2 -right-2 w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-lg border-4 border-sky-500">
                  <span className="text-sky-600 font-bold">3</span>
                </div>
              </div>
              <h3 className="text-xl font-bold text-gray-900 mb-2">{t('securePayment')}</h3>
              <p className="text-gray-600">{t('securePaymentDesc')}</p>
            </div>

            {/* Step 4 */}
            <div className="relative text-center">
              <div className="relative inline-block mb-6">
                <div className="w-32 h-32 bg-gradient-to-br from-rose-500 to-pink-500 rounded-full flex items-center justify-center shadow-2xl shadow-rose-500/30 mx-auto">
                  <span className="text-5xl">🕋</span>
                </div>
                <div className="absolute -top-2 -right-2 w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-lg border-4 border-rose-500">
                  <span className="text-rose-600 font-bold">4</span>
                </div>
              </div>
              <h3 className="text-xl font-bold text-gray-900 mb-2">{t('startJourney')}</h3>
              <p className="text-gray-600">{t('startJourneyDesc')}</p>
            </div>
          </div>
        </div>
      </section>

      {/* FAQ Section */}
      <section className="py-24 bg-white relative">
        <div className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="text-center mb-16">
            <span className="inline-block px-4 py-2 bg-gradient-to-r from-blue-100 to-indigo-100 text-blue-700 rounded-full text-sm font-semibold mb-4">
              ❓ {t('faq')}
            </span>
            <h2 className="text-4xl md:text-5xl font-extrabold text-gray-900 mb-4">
              {t('frequentlyAsked')}
            </h2>
            <p className="text-xl text-gray-600">
              {t('faqSubtitle')}
            </p>
          </div>

          <div className="space-y-4">
            {/* FAQ Item 1 */}
            <div className="bg-gradient-to-br from-gray-50 to-white rounded-2xl border border-gray-100 overflow-hidden">
              <div className="p-6">
                <h3 className="text-lg font-bold text-gray-900 flex items-center gap-3">
                  <span className="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center text-blue-600">
                    <svg className="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                      <path fillRule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clipRule="evenodd" />
                    </svg>
                  </span>
                  {t('faq1Question')}
                </h3>
                <p className="mt-3 text-gray-600 pl-11">
                  {t('faq1Answer')}
                </p>
              </div>
            </div>

            {/* FAQ Item 2 */}
            <div className="bg-gradient-to-br from-gray-50 to-white rounded-2xl border border-gray-100 overflow-hidden">
              <div className="p-6">
                <h3 className="text-lg font-bold text-gray-900 flex items-center gap-3">
                  <span className="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center text-blue-600">
                    <svg className="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                      <path fillRule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clipRule="evenodd" />
                    </svg>
                  </span>
                  {t('faq2Question')}
                </h3>
                <p className="mt-3 text-gray-600 pl-11">
                  {t('faq2Answer')}
                </p>
              </div>
            </div>

            {/* FAQ Item 3 */}
            <div className="bg-gradient-to-br from-gray-50 to-white rounded-2xl border border-gray-100 overflow-hidden">
              <div className="p-6">
                <h3 className="text-lg font-bold text-gray-900 flex items-center gap-3">
                  <span className="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center text-blue-600">
                    <svg className="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                      <path fillRule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clipRule="evenodd" />
                    </svg>
                  </span>
                  {t('faq3Question')}
                </h3>
                <p className="mt-3 text-gray-600 pl-11">
                  {t('faq3Answer')}
                </p>
              </div>
            </div>

            {/* FAQ Item 4 */}
            <div className="bg-gradient-to-br from-gray-50 to-white rounded-2xl border border-gray-100 overflow-hidden">
              <div className="p-6">
                <h3 className="text-lg font-bold text-gray-900 flex items-center gap-3">
                  <span className="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center text-blue-600">
                    <svg className="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                      <path fillRule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clipRule="evenodd" />
                    </svg>
                  </span>
                  {t('faq4Question') || 'What is your cancellation policy?'}
                </h3>
                <p className="mt-3 text-gray-600 pl-11">
                  {t('faq4Answer') || 'Free cancellation up to 30 days before departure. Partial refunds available for cancellations within 30 days. Contact us for details.'}
                </p>
              </div>
            </div>
          </div>

          <div className="text-center mt-10">
            <p className="text-gray-600 mb-4">{t('moreQuestions') || 'Have more questions?'}</p>
            <a
              href="https://wa.me/971506003766"
              target="_blank"
              rel="noopener noreferrer"
              className="inline-flex items-center gap-2 bg-green-500 hover:bg-green-600 text-white px-6 py-3 rounded-full font-semibold transition-all duration-300 hover:scale-105"
            >
              <svg className="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
              </svg>
              {t('chatWithUs') || 'Chat With Us'}
            </a>
          </div>
        </div>
      </section>

      {/* Trust Badges Section */}
      <section className="py-16 bg-gradient-to-b from-gray-50 to-white border-t border-gray-100">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="text-center mb-10">
            <p className="text-gray-500 font-medium">{t('trustedPartners') || 'Trusted by Leading Organizations'}</p>
          </div>
          <div className="flex flex-wrap justify-center items-center gap-8 md:gap-16">
            <div className="flex flex-col items-center opacity-60 hover:opacity-100 transition-opacity">
              <div className="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center mb-2">
                <span className="text-2xl">🏛️</span>
              </div>
              <span className="text-xs text-gray-500">{t('ministryApproved') || 'Ministry Approved'}</span>
            </div>
            <div className="flex flex-col items-center opacity-60 hover:opacity-100 transition-opacity">
              <div className="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center mb-2">
                <span className="text-2xl">✅</span>
              </div>
              <span className="text-xs text-gray-500">{t('iataAccredited') || 'IATA Accredited'}</span>
            </div>
            <div className="flex flex-col items-center opacity-60 hover:opacity-100 transition-opacity">
              <div className="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center mb-2">
                <span className="text-2xl">🔒</span>
              </div>
              <span className="text-xs text-gray-500">{t('securePayments') || 'Secure Payments'}</span>
            </div>
            <div className="flex flex-col items-center opacity-60 hover:opacity-100 transition-opacity">
              <div className="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center mb-2">
                <span className="text-2xl">🌍</span>
              </div>
              <span className="text-xs text-gray-500">{t('globalNetwork') || 'Global Network'}</span>
            </div>
            <div className="flex flex-col items-center opacity-60 hover:opacity-100 transition-opacity">
              <div className="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center mb-2">
                <span className="text-2xl">⭐</span>
              </div>
              <span className="text-xs text-gray-500">{t('topRated') || 'Top Rated'}</span>
            </div>
          </div>
        </div>
      </section>

      {/* CTA Section */}
      <section className="py-24 bg-gradient-to-r from-blue-600 via-indigo-600 to-blue-700 relative overflow-hidden">
        <div className="absolute inset-0 bg-black opacity-10"></div>
        <div className="absolute inset-0">
          <div className="absolute top-0 left-1/4 w-96 h-96 bg-white rounded-full filter blur-3xl opacity-10 animate-pulse"></div>
          <div className="absolute bottom-0 right-1/4 w-96 h-96 bg-white rounded-full filter blur-3xl opacity-10 animate-pulse animation-delay-2000"></div>
        </div>

        <div className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
          <h2 className="text-4xl md:text-5xl font-extrabold text-white mb-6">
            {t('readyToStart')}
          </h2>
          <p className="text-xl text-blue-100 mb-10 max-w-2xl mx-auto">
            {t('joinThousands')}
          </p>
          <div className="flex flex-col sm:flex-row items-center justify-center gap-4">
            <Link
              to="/packages"
              className="inline-flex items-center space-x-2 rtl:space-x-reverse bg-white text-blue-600 px-10 py-4 rounded-full font-bold text-lg hover:bg-gray-100 hover:scale-105 transition-all duration-300 shadow-2xl"
            >
              <span>{t('browsePackages')}</span>
              <svg className="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
              </svg>
            </Link>
            <a
              href="https://wa.me/971506003766"
              target="_blank"
              rel="noopener noreferrer"
              className="inline-flex items-center space-x-2 rtl:space-x-reverse bg-green-500 text-white px-10 py-4 rounded-full font-bold text-lg hover:bg-green-600 hover:scale-105 transition-all duration-300 shadow-2xl"
            >
              <svg className="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
              </svg>
              <span>{t('chatOnWhatsApp')}</span>
            </a>
          </div>
        </div>
      </section>
    </div>
  );
}

export default Home;
