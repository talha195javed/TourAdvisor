import React, { useState, useEffect, useRef } from 'react';
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
  const { t, i18n } = useTranslation();
  const [currentSlide, setCurrentSlide] = useState(0);
  const [mousePosition, setMousePosition] = useState({ x: 0, y: 0 });
  const heroRef = useRef(null);

  useEffect(() => {
    const interval = setInterval(() => {
      setCurrentSlide((prev) => (prev + 1) % heroImages.length);
    }, 6000);
    return () => clearInterval(interval);
  }, []);

  useEffect(() => {
    const handleMouseMove = (e) => {
      if (heroRef.current) {
        const rect = heroRef.current.getBoundingClientRect();
        setMousePosition({
          x: (e.clientX - rect.left) / rect.width,
          y: (e.clientY - rect.top) / rect.height,
        });
      }
    };
    window.addEventListener('mousemove', handleMouseMove);
    return () => window.removeEventListener('mousemove', handleMouseMove);
  }, []);

  const isRTL = i18n.language === 'ar';

  return (
    <section ref={heroRef} className="relative min-h-screen flex items-center justify-center overflow-hidden">
      {/* Animated Background Gradient Orbs */}
      <div className="absolute inset-0 overflow-hidden">
        <div 
          className="absolute w-[800px] h-[800px] rounded-full opacity-30 blur-3xl transition-transform duration-1000 ease-out"
          style={{
            background: 'radial-gradient(circle, rgba(59,130,246,0.4) 0%, transparent 70%)',
            top: '10%',
            left: '10%',
            transform: `translate(${mousePosition.x * 50}px, ${mousePosition.y * 50}px)`,
          }}
        />
        <div 
          className="absolute w-[600px] h-[600px] rounded-full opacity-20 blur-3xl transition-transform duration-1000 ease-out"
          style={{
            background: 'radial-gradient(circle, rgba(99,102,241,0.5) 0%, transparent 70%)',
            bottom: '10%',
            right: '10%',
            transform: `translate(${-mousePosition.x * 30}px, ${-mousePosition.y * 30}px)`,
          }}
        />
        <div 
          className="absolute w-[500px] h-[500px] rounded-full opacity-25 blur-3xl animate-pulse"
          style={{
            background: 'radial-gradient(circle, rgba(234,179,8,0.3) 0%, transparent 70%)',
            top: '50%',
            left: '50%',
            transform: 'translate(-50%, -50%)',
          }}
        />
      </div>

      {/* Image Slider with Ken Burns Effect */}
      <div className="absolute inset-0">
        {heroImages.map((image, index) => (
          <div
            key={index}
            className={`absolute inset-0 transition-all duration-[2000ms] ease-in-out ${
              index === currentSlide ? 'opacity-100 scale-105' : 'opacity-0 scale-100'
            }`}
          >
            <img
              src={image.url}
              alt={image.title}
              className="w-full h-full object-cover"
              style={{
                animation: index === currentSlide ? 'kenburns 20s ease-out infinite' : 'none',
              }}
            />
          </div>
        ))}
        {/* Premium Gradient Overlay */}
        <div className="absolute inset-0 bg-gradient-to-br from-black/80 via-blue-950/70 to-indigo-950/80"></div>
        <div className="absolute inset-0 bg-gradient-to-t from-black/90 via-transparent to-black/40"></div>
        {/* Noise Texture */}
        <div className="absolute inset-0 opacity-[0.03]" style={{
          backgroundImage: `url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)'/%3E%3C/svg%3E")`,
        }}></div>
      </div>

      {/* Floating Particles */}
      <div className="absolute inset-0 overflow-hidden pointer-events-none">
        {[...Array(20)].map((_, i) => (
          <div
            key={i}
            className="absolute w-1 h-1 bg-white/30 rounded-full animate-float"
            style={{
              left: `${Math.random() * 100}%`,
              top: `${Math.random() * 100}%`,
              animationDelay: `${Math.random() * 5}s`,
              animationDuration: `${10 + Math.random() * 10}s`,
            }}
          />
        ))}
      </div>

      {/* Main Content */}
      <div className="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div className="grid lg:grid-cols-2 gap-16 items-center">
          {/* Left Content */}
          <div className={`space-y-8 ${isRTL ? 'text-right' : 'text-left'}`}>
            {/* Premium Badge */}
            <div className="inline-flex items-center gap-3 bg-white/5 backdrop-blur-2xl border border-white/10 rounded-full px-5 py-2.5 animate-fade-in-down">
              <div className="relative flex items-center justify-center">
                <div className="absolute w-8 h-8 bg-gradient-to-r from-amber-400 to-yellow-500 rounded-full animate-ping opacity-20"></div>
                <span className="text-2xl relative z-10">🕋</span>
              </div>
              <div className="h-4 w-px bg-white/20"></div>
              <span className="text-amber-300 font-medium text-sm tracking-wider uppercase">Premium Umrah & Hajj</span>
            </div>

            {/* Main Heading with Gradient Animation */}
            <div className="space-y-4 animate-fade-in-up">
              <h1 className="text-5xl md:text-6xl lg:text-7xl font-black leading-[1.1] tracking-tight">
                <span className="block text-white drop-shadow-2xl">{t('heroTitle')}</span>
                <span className="block mt-2 bg-gradient-to-r from-blue-300 via-indigo-200 to-amber-200 bg-clip-text text-transparent animate-gradient-x bg-[length:200%_auto]">
                  {t('dreamDestination')}
                </span>
              </h1>
            </div>

            {/* Subtitle */}
            <p className="text-lg md:text-xl text-white/70 leading-relaxed max-w-xl animate-fade-in-up" style={{ animationDelay: '0.2s' }}>
              {t('heroSubtitle')}
            </p>

            {/* Feature Pills */}
            <div className="flex flex-wrap gap-3 animate-fade-in-up" style={{ animationDelay: '0.3s' }}>
              {[
                { icon: '✓', text: t('bestPrice'), color: 'blue' },
                { icon: '⏰', text: t('support247'), color: 'indigo' },
                { icon: '⚡', text: t('instantConfirmation'), color: 'amber' },
              ].map((feature, idx) => (
                <div 
                  key={idx}
                  className={`group flex items-center gap-2 bg-gradient-to-r from-${feature.color}-500/10 to-${feature.color}-500/5 backdrop-blur-xl border border-${feature.color}-500/20 rounded-full px-4 py-2 hover:border-${feature.color}-400/40 transition-all duration-300 hover:scale-105`}
                >
                  <span className={`text-${feature.color}-400 text-sm`}>{feature.icon}</span>
                  <span className="text-white/80 text-sm font-medium">{feature.text}</span>
                </div>
              ))}
            </div>

            {/* CTA Buttons */}
            <div className="flex flex-col sm:flex-row gap-4 animate-fade-in-up" style={{ animationDelay: '0.4s' }}>
              <Link
                to="/packages"
                className="group relative inline-flex items-center justify-center gap-3 overflow-hidden rounded-2xl px-8 py-4 font-bold text-lg transition-all duration-500"
              >
                {/* Button Background */}
                <div className="absolute inset-0 bg-gradient-to-r from-blue-500 via-indigo-500 to-blue-500 bg-[length:200%_auto] animate-gradient-x"></div>
                <div className="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-500 bg-gradient-to-r from-indigo-400 via-blue-400 to-indigo-400 bg-[length:200%_auto] animate-gradient-x"></div>
                {/* Shine Effect */}
                <div className="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity">
                  <div className="absolute inset-0 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-1000 bg-gradient-to-r from-transparent via-white/20 to-transparent"></div>
                </div>
                {/* Button Content */}
                <span className="relative z-10 text-white">{t('explorePackages')}</span>
                <svg className="relative z-10 w-5 h-5 text-white group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                </svg>
                {/* Glow Effect */}
                <div className="absolute -inset-1 bg-gradient-to-r from-blue-500 to-indigo-500 rounded-2xl blur-xl opacity-40 group-hover:opacity-60 transition-opacity -z-10"></div>
              </Link>

              <a
                href="https://wa.me/971506003766"
                target="_blank"
                rel="noopener noreferrer"
                className="group relative inline-flex items-center justify-center gap-3 bg-white/5 backdrop-blur-2xl border border-white/10 text-white px-8 py-4 rounded-2xl font-bold text-lg hover:bg-white/10 hover:border-white/20 transition-all duration-300 overflow-hidden"
              >
                <div className="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity">
                  <div className="absolute inset-0 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-1000 bg-gradient-to-r from-transparent via-white/10 to-transparent"></div>
                </div>
                <svg className="w-5 h-5 text-green-400" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                </svg>
                <span className="relative z-10">{t('chatOnWhatsApp')}</span>
              </a>
            </div>

            {/* Social Proof */}
            <div className="flex items-center gap-8 pt-6 animate-fade-in-up" style={{ animationDelay: '0.5s' }}>
              <div className="flex items-center gap-3">
                <div className="flex -space-x-3">
                  {[1, 2, 3, 4].map((i) => (
                    <div 
                      key={i} 
                      className="w-10 h-10 rounded-full border-2 border-black/50 overflow-hidden"
                      style={{
                        background: `linear-gradient(135deg, hsl(${210 + i * 15}, 70%, 50%), hsl(${230 + i * 15}, 70%, 40%))`,
                      }}
                    >
                      <img 
                        src={`https://i.pravatar.cc/100?img=${i + 10}`} 
                        alt="Customer"
                        className="w-full h-full object-cover"
                      />
                    </div>
                  ))}
                  <div className="w-10 h-10 rounded-full border-2 border-black/50 bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white text-xs font-bold">
                    +5K
                  </div>
                </div>
                <div>
                  <p className="text-white font-bold">5,000+</p>
                  <p className="text-white/50 text-sm">{t('happyTravelers')}</p>
                </div>
              </div>
              <div className="h-12 w-px bg-white/10"></div>
              <div className="flex items-center gap-2">
                <div className="flex">
                  {[...Array(5)].map((_, i) => (
                    <svg key={i} className="w-5 h-5 text-amber-400 drop-shadow-glow" fill="currentColor" viewBox="0 0 20 20">
                      <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                    </svg>
                  ))}
                </div>
                <div>
                  <p className="text-white font-bold">4.9/5</p>
                  <p className="text-white/50 text-sm">{t('averageRating')}</p>
                </div>
              </div>
            </div>
          </div>

          {/* Right Content - 3D Cards */}
          <div className="hidden lg:block relative perspective-1000">
            <div className="relative h-[500px] w-full">
              {/* Floating Card 1 */}
              <div 
                className="absolute top-0 right-0 w-80 animate-float"
                style={{ 
                  animationDelay: '0s',
                  transform: `rotateY(${mousePosition.x * 10 - 5}deg) rotateX(${-mousePosition.y * 10 + 5}deg)`,
                  transition: 'transform 0.3s ease-out',
                }}
              >
                <div className="bg-white/10 backdrop-blur-2xl border border-white/20 rounded-3xl p-6 shadow-2xl hover:bg-white/15 transition-all duration-500 group">
                  <div className="flex items-center gap-4 mb-4">
                    <div className="w-14 h-14 bg-gradient-to-br from-amber-400 to-orange-500 rounded-2xl flex items-center justify-center shadow-lg shadow-amber-500/30 group-hover:scale-110 transition-transform">
                      <span className="text-2xl">🕌</span>
                    </div>
                    <div>
                      <h3 className="text-white font-bold text-lg">Hotels Near Haram</h3>
                      <p className="text-white/60 text-sm">Walking Distance</p>
                    </div>
                  </div>
                  <div className="space-y-3">
                    <div className="flex justify-between text-sm">
                      <span className="text-white/60">Availability</span>
                      <span className="text-blue-400 font-semibold">95%</span>
                    </div>
                    <div className="h-2 bg-white/10 rounded-full overflow-hidden">
                      <div className="h-full w-[95%] bg-gradient-to-r from-blue-400 to-indigo-400 rounded-full relative">
                        <div className="absolute inset-0 bg-gradient-to-r from-transparent via-white/30 to-transparent animate-shimmer"></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              {/* Floating Card 2 */}
              <div 
                className="absolute bottom-0 left-0 w-80 animate-float"
                style={{ 
                  animationDelay: '1s',
                  transform: `rotateY(${mousePosition.x * 10 - 5}deg) rotateX(${-mousePosition.y * 10 + 5}deg)`,
                  transition: 'transform 0.3s ease-out',
                }}
              >
                <div className="bg-white/10 backdrop-blur-2xl border border-white/20 rounded-3xl p-6 shadow-2xl hover:bg-white/15 transition-all duration-500 group">
                  <div className="flex items-center gap-4 mb-4">
                    <div className="w-14 h-14 bg-gradient-to-br from-blue-400 to-indigo-500 rounded-2xl flex items-center justify-center shadow-lg shadow-blue-500/30 group-hover:scale-110 transition-transform">
                      <svg className="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                      </svg>
                    </div>
                    <div>
                      <h3 className="text-white font-bold text-lg">Licensed & Trusted</h3>
                      <p className="text-white/60 text-sm">Government Approved</p>
                    </div>
                  </div>
                  <div className="flex items-center gap-2">
                    <div className="flex -space-x-1">
                      {['🇸🇦', '🇦🇪', '🇬🇧', '🇺🇸'].map((flag, i) => (
                        <span key={i} className="text-lg">{flag}</span>
                      ))}
                    </div>
                    <span className="text-white/60 text-sm">Serving 50+ Countries</span>
                  </div>
                </div>
              </div>

              {/* Center Glow */}
              <div className="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-80 h-80 bg-gradient-to-r from-blue-500/30 to-indigo-500/30 rounded-full blur-3xl animate-pulse"></div>
            </div>
          </div>
        </div>
      </div>

      {/* Slide Indicators */}
      <div className="absolute bottom-24 left-1/2 -translate-x-1/2 z-20 flex items-center gap-3">
        {heroImages.map((image, index) => (
          <button
            key={index}
            onClick={() => setCurrentSlide(index)}
            className={`group relative transition-all duration-500 ${
              index === currentSlide ? 'w-16' : 'w-3'
            }`}
          >
            <div className={`h-3 rounded-full transition-all duration-500 ${
              index === currentSlide 
                ? 'bg-gradient-to-r from-blue-400 to-indigo-400' 
                : 'bg-white/30 group-hover:bg-white/50'
            }`}></div>
            {index === currentSlide && (
              <div className="absolute -bottom-6 left-0 right-0 text-center">
                <p className="text-white/60 text-xs whitespace-nowrap">{image.location}</p>
              </div>
            )}
          </button>
        ))}
      </div>

      {/* Bottom Wave */}
      <div className="absolute bottom-0 left-0 right-0">
        <svg className="w-full h-32 fill-gray-50" viewBox="0 0 1440 120" preserveAspectRatio="none">
          <path d="M0,40 C480,120 960,0 1440,80 L1440,120 L0,120 Z"></path>
        </svg>
      </div>

      {/* Custom Styles */}
      <style jsx>{`
        @keyframes kenburns {
          0% { transform: scale(1); }
          50% { transform: scale(1.1); }
          100% { transform: scale(1); }
        }
        @keyframes float {
          0%, 100% { transform: translateY(0px); }
          50% { transform: translateY(-20px); }
        }
        @keyframes gradient-x {
          0% { background-position: 0% 50%; }
          50% { background-position: 100% 50%; }
          100% { background-position: 0% 50%; }
        }
        @keyframes shimmer {
          0% { transform: translateX(-100%); }
          100% { transform: translateX(100%); }
        }
        .animate-float {
          animation: float 6s ease-in-out infinite;
        }
        .animate-gradient-x {
          animation: gradient-x 3s ease infinite;
        }
        .animate-shimmer {
          animation: shimmer 2s infinite;
        }
        .perspective-1000 {
          perspective: 1000px;
        }
        .drop-shadow-glow {
          filter: drop-shadow(0 0 6px rgba(251, 191, 36, 0.5));
        }
      `}</style>
    </section>
  );
}

export default HeroSection;
