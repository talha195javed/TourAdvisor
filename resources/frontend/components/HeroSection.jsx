import React, { useState, useEffect } from 'react';
import { Link } from 'react-router-dom';
import { useTranslation } from 'react-i18next';

const heroImages = [
  {
    url: 'https://images.unsplash.com/photo-1591604129939-f1efa4d9f7fa?q=80&w=2070',
    title: 'Masjid al-Haram',
    location: 'Makkah, Saudi Arabia'
  },
  {
    url: 'https://images.unsplash.com/photo-1542816417-0983c9c9ad53?q=80&w=2070',
    title: 'Al-Masjid an-Nabawi',
    location: 'Madinah, Saudi Arabia'
  },
  {
    url: 'https://images.unsplash.com/photo-1564769625905-50e93615e769?q=80&w=2070',
    title: 'Kaaba at Night',
    location: 'Makkah, Saudi Arabia'
  },
  {
    url: 'https://images.unsplash.com/photo-1466442929976-97f336a657be?q=80&w=2070',
    title: 'Istanbul Blue Mosque',
    location: 'Istanbul, Turkey'
  },
  {
    url: 'https://images.unsplash.com/photo-1585155770913-c756e5f4e6f4?q=80&w=2070',
    title: 'Dubai Skyline',
    location: 'Dubai, UAE'
  }
];

function HeroSection() {
  const { t } = useTranslation();
  const [currentSlide, setCurrentSlide] = useState(0);

  useEffect(() => {
    const interval = setInterval(() => {
      setCurrentSlide((prev) => (prev + 1) % heroImages.length);
    }, 5000);
    return () => clearInterval(interval);
  }, []);

  return (
    <section className="relative min-h-screen flex items-center justify-center overflow-hidden">

      {/* Image Slider Background */}
      <div className="absolute inset-0">
        {heroImages.map((image, index) => (
          <div
            key={index}
            className={`absolute inset-0 transition-opacity duration-1000 ease-in-out ${
              index === currentSlide ? 'opacity-100' : 'opacity-0'
            }`}
          >
            <img
              src={image.url}
              alt={image.title}
              className="w-full h-full object-cover"
            />
          </div>
        ))}
        {/* Dark overlay with gradient */}
        <div className="absolute inset-0 bg-gradient-to-br from-slate-900/90 via-emerald-900/80 to-teal-900/85"></div>
        <div className="absolute inset-0 bg-gradient-to-t from-slate-900/90 via-transparent to-slate-900/50"></div>
      </div>

      {/* Slide indicators */}
      <div className="absolute bottom-32 left-1/2 transform -translate-x-1/2 z-20 flex space-x-2 rtl:space-x-reverse">
        {heroImages.map((_, index) => (
          <button
            key={index}
            onClick={() => setCurrentSlide(index)}
            className={`w-2 h-2 rounded-full transition-all duration-300 ${
              index === currentSlide
                ? 'bg-emerald-400 w-8'
                : 'bg-white/50 hover:bg-white/80'
            }`}
            aria-label={`Go to slide ${index + 1}`}
          />
        ))}
      </div>

      {/* Current slide info */}
      <div className="absolute bottom-32 right-8 z-20 text-right rtl:text-left rtl:right-auto rtl:left-8 hidden md:block">
        <p className="text-emerald-400 text-sm font-medium">{heroImages[currentSlide].location}</p>
        <p className="text-white/80 text-xs">{heroImages[currentSlide].title}</p>
      </div>

      <div className="absolute inset-0 opacity-30 pointer-events-none">
        <div className="absolute inset-0 bg-gradient-to-tr from-emerald-500/20 via-teal-500/20 to-green-500/20"></div>
      </div>

      <div className="absolute inset-0 overflow-hidden pointer-events-none">
        <div className="absolute top-1/4 left-1/4 w-96 h-96 bg-gradient-to-r from-emerald-400 to-teal-500 rounded-full mix-blend-screen filter blur-3xl opacity-10 animate-pulse"></div>
        <div className="absolute top-1/3 right-1/4 w-96 h-96 bg-gradient-to-r from-green-400 to-emerald-500 rounded-full mix-blend-screen filter blur-3xl opacity-10 animate-pulse" style={{ animationDelay: '2s' }}></div>
        <div className="absolute bottom-1/4 left-1/2 w-96 h-96 bg-gradient-to-r from-teal-400 to-green-500 rounded-full mix-blend-screen filter blur-3xl opacity-10 animate-pulse" style={{ animationDelay: '4s' }}></div>
      </div>

      <div className="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div className="grid lg:grid-cols-2 gap-12 items-center">
          <div className="text-left space-y-8">
            <div className="inline-flex items-center space-x-3 rtl:space-x-reverse bg-gradient-to-r from-emerald-500/10 to-teal-500/10 backdrop-blur-xl border border-emerald-500/20 rounded-full px-6 py-3 animate-fade-in-down">
              <div className="relative">
                <div className="absolute inset-0 bg-gradient-to-r from-emerald-400 to-teal-500 rounded-full blur-sm"></div>
                <svg className="h-5 w-5 text-emerald-400 relative" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/>
                </svg>
              </div>
              <span className="text-white font-semibold text-sm tracking-wide">🕋 Umrah & Hajj Packages</span>
            </div>

            <div className="animate-fade-in-up">
              <h1 className="text-5xl md:text-6xl lg:text-7xl font-black leading-tight mb-6">
                <span className="block text-white mb-2">{t('heroTitle')}</span>
                <span className="block bg-clip-text text-transparent bg-gradient-to-r from-emerald-400 via-teal-400 to-green-400">
                  {t('dreamDestination')}
                </span>
              </h1>
            </div>

            <p className="text-xl md:text-2xl text-slate-300 leading-relaxed max-w-xl animate-fade-in-up animation-delay-200">
              {t('heroSubtitle')}
            </p>

            <div className="flex flex-wrap gap-3 animate-fade-in-up animation-delay-300">
              <div className="flex items-center space-x-2 rtl:space-x-reverse bg-white/5 backdrop-blur-sm border border-white/10 rounded-full px-4 py-2">
                <svg className="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M5 13l4 4L19 7" />
                </svg>
                <span className="text-sm text-slate-200">{t('bestPrice')}</span>
              </div>
              <div className="flex items-center space-x-2 rtl:space-x-reverse bg-white/5 backdrop-blur-sm border border-white/10 rounded-full px-4 py-2">
                <svg className="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M5 13l4 4L19 7" />
                </svg>
                <span className="text-sm text-slate-200">{t('support247')}</span>
              </div>
              <div className="flex items-center space-x-2 rtl:space-x-reverse bg-white/5 backdrop-blur-sm border border-white/10 rounded-full px-4 py-2">
                <svg className="w-5 h-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M5 13l4 4L19 7" />
                </svg>
                <span className="text-sm text-slate-200">{t('instantConfirmation')}</span>
              </div>
            </div>

            <div className="flex flex-col sm:flex-row gap-4 animate-fade-in-up animation-delay-400">
              <Link
                to="/packages"
                className="group relative inline-flex items-center justify-center space-x-3 rtl:space-x-reverse bg-gradient-to-r from-emerald-500 to-teal-600 text-white px-8 py-4 rounded-2xl font-bold text-lg shadow-2xl shadow-emerald-500/50 hover:shadow-emerald-500/70 hover:scale-105 transition-all duration-300 overflow-hidden"
              >
                <span className="relative z-10">{t('explorePackages')}</span>
                <svg className="w-5 h-5 relative z-10 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                </svg>
                <div className="absolute inset-0 bg-gradient-to-r from-teal-600 to-green-600 opacity-0 group-hover:opacity-100 transition-opacity"></div>
              </Link>

              <a
                href="https://wa.me/971506003766"
                target="_blank"
                rel="noopener noreferrer"
                className="group inline-flex items-center justify-center space-x-3 rtl:space-x-reverse bg-white/10 backdrop-blur-xl border-2 border-white/20 text-white px-8 py-4 rounded-2xl font-bold text-lg hover:bg-white/20 hover:border-white/30 hover:scale-105 transition-all duration-300"
              >
                <svg className="w-5 h-5 text-green-400" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                </svg>
                <span>{t('contactUs')}</span>
              </a>
            </div>

            <div className="flex items-center space-x-8 rtl:space-x-reverse pt-4 animate-fade-in-up animation-delay-500">
              <div className="flex items-center space-x-2 rtl:space-x-reverse">
                <div className="flex -space-x-2 rtl:space-x-reverse">
                  <div className="w-8 h-8 rounded-full bg-gradient-to-br from-emerald-400 to-teal-500 border-2 border-slate-900"></div>
                  <div className="w-8 h-8 rounded-full bg-gradient-to-br from-teal-400 to-green-500 border-2 border-slate-900"></div>
                  <div className="w-8 h-8 rounded-full bg-gradient-to-br from-green-400 to-emerald-500 border-2 border-slate-900"></div>
                </div>
                <div className="text-sm text-slate-300">
                  <span className="font-bold text-white">5000+</span> {t('happyTravelers')}
                </div>
              </div>
              <div className="flex items-center space-x-1 rtl:space-x-reverse">
                {[...Array(5)].map((_, i) => (
                  <svg key={i} className="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                  </svg>
                ))}
                <span className="ml-2 text-sm text-slate-300 font-semibold">4.9/5</span>
              </div>
            </div>
          </div>

          <div className="hidden lg:block relative animate-fade-in-right">
            <div className="relative h-96">
              <div className="absolute top-0 left-0 w-72 bg-white/10 backdrop-blur-xl border border-white/20 rounded-3xl p-6 shadow-2xl hover:scale-105 transition-transform duration-300 z-10">
                <div className="flex items-center space-x-3 rtl:space-x-reverse mb-4">
                  <div className="w-12 h-12 bg-gradient-to-br from-emerald-400 to-teal-500 rounded-2xl flex items-center justify-center">
                    <svg className="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                  </div>
                  <div>
                    <div className="text-white font-bold">Hotels Near Haram</div>
                    <div className="text-slate-300 text-sm">5-Star Luxury</div>
                  </div>
                </div>
                <div className="h-2 bg-white/10 rounded-full overflow-hidden">
                  <div className="h-full w-4/5 bg-gradient-to-r from-emerald-400 to-teal-500 rounded-full"></div>
                </div>
              </div>

              <div className="absolute bottom-0 left-0 w-72 bg-white/10 backdrop-blur-xl border border-white/20 rounded-3xl p-6 shadow-2xl hover:scale-105 transition-transform duration-300">
                <div className="flex items-center space-x-3 rtl:space-x-reverse mb-4">
                  <div className="w-12 h-12 bg-gradient-to-br from-green-400 to-emerald-500 rounded-2xl flex items-center justify-center">
                    <svg className="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                  </div>
                  <div>
                    <div className="text-white font-bold">Makkah & Madinah</div>
                    <div className="text-slate-300 text-sm">Holy Cities</div>
                  </div>
                </div>
                <div className="flex items-center space-x-2 rtl:space-x-reverse text-slate-300 text-sm">
                  <svg className="w-4 h-4 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M5 13l4 4L19 7" />
                  </svg>
                  <span>Licensed & Trusted</span>
                </div>
              </div>

              <div className="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-gradient-to-r from-emerald-500 to-teal-500 rounded-full filter blur-3xl opacity-20"></div>
            </div>
          </div>
        </div>
      </div>

      <div className="absolute bottom-0 left-0 right-0">
        <svg className="w-full h-24 fill-current text-gray-50" viewBox="0 0 1440 120" preserveAspectRatio="none">
          <path d="M0,64L48,69.3C96,75,192,85,288,80C384,75,480,53,576,48C672,43,768,53,864,58.7C960,64,1056,64,1152,58.7C1248,53,1344,43,1392,37.3L1440,32L1440,120L1392,120C1344,120,1248,120,1152,120C1056,120,960,120,864,120C768,120,672,120,576,120C480,120,384,120,288,120C192,120,96,120,48,120L0,120Z"></path>
        </svg>
      </div>
    </section>
  );
}

export default HeroSection;
