import React, { useState } from 'react';
import { useTranslation } from 'react-i18next';
import { Link } from 'react-router-dom';

function PackageCard({ package: pkg }) {
  const { t } = useTranslation();
  const [isHovered, setIsHovered] = useState(false);

  return (
    <div
      className="group relative bg-white rounded-3xl overflow-hidden transition-all duration-500 hover:shadow-2xl hover:shadow-blue-500/10"
      onMouseEnter={() => setIsHovered(true)}
      onMouseLeave={() => setIsHovered(false)}
    >
      {/* Gradient Border Effect */}
      <div className="absolute inset-0 bg-gradient-to-br from-blue-500/20 via-transparent to-indigo-500/20 opacity-0 group-hover:opacity-100 transition-opacity duration-500 rounded-3xl"></div>

      {/* Card Content */}
      <div className="relative bg-white rounded-3xl overflow-hidden m-[1px]">
        {/* Image Section */}
        <div className="relative h-64 overflow-hidden">
          <img
            src={pkg.main_image || 'https://images.unsplash.com/photo-1591604129939-f1efa4d9f7fa?w=800'}
            alt={pkg.title}
            className={`w-full h-full object-cover transition-all duration-700 ${isHovered ? 'scale-110 blur-[1px]' : 'scale-100'}`}
          />

          {/* Overlay Gradient */}
          <div className="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>

          {/* Category Badge */}
          {pkg.category && (
            <div className="absolute top-4 left-4 rtl:left-auto rtl:right-4">
              <span className="inline-flex items-center gap-1.5 bg-white/90 backdrop-blur-md text-blue-700 px-3 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider shadow-lg">
                <span className="w-1.5 h-1.5 bg-blue-500 rounded-full animate-pulse"></span>
                {pkg.category.name}
              </span>
            </div>
          )}

          {/* Duration Badge */}
          {pkg.duration_days && (
            <div className="absolute top-4 right-4 rtl:right-auto rtl:left-4">
              <span className="inline-flex items-center gap-1 bg-black/50 backdrop-blur-md text-white px-3 py-1.5 rounded-full text-xs font-semibold">
                <svg className="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                {pkg.duration_days} {t('days')}
              </span>
            </div>
          )}

          {/* Bottom Info on Image */}
          <div className="absolute bottom-0 left-0 right-0 p-5">
            <h3 className="text-xl font-bold text-white mb-2 line-clamp-2 drop-shadow-lg">
              {pkg.title}
            </h3>
            {pkg.location && (
              <div className="flex items-center text-white/90 text-sm">
                <svg className="h-4 w-4 mr-1.5 rtl:mr-0 rtl:ml-1.5 text-blue-400" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                </svg>
                <span>{pkg.location}</span>
              </div>
            )}
          </div>

          {/* Hover Overlay with Quick Actions */}
          <div className={`absolute inset-0 bg-blue-900/80 backdrop-blur-sm flex items-center justify-center transition-all duration-500 ${isHovered ? 'opacity-100' : 'opacity-0 pointer-events-none'}`}>
            <Link
              to={`/packages/${pkg.id}`}
              className="group/btn relative inline-flex items-center gap-2 bg-white text-blue-700 px-6 py-3 rounded-full font-bold text-sm hover:bg-blue-50 transition-all duration-300 shadow-xl hover:shadow-2xl hover:scale-105"
            >
              <span>{t('viewDetails')}</span>
              <svg className="w-4 h-4 group-hover/btn:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
              </svg>
            </Link>
          </div>
        </div>

        {/* Content Section */}
        <div className="p-5">
          {/* Description */}
          <p className="text-gray-500 text-sm mb-4 line-clamp-2 leading-relaxed">
            {pkg.description}
          </p>

          {/* Features Row */}
          <div className="flex flex-wrap gap-2 mb-4">
            {pkg.hotel && (
              <div className="inline-flex items-center gap-1.5 bg-amber-50 text-amber-700 px-2.5 py-1 rounded-lg text-xs font-medium">
                <svg className="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M19 7h-8v7H3V5H1v15h2v-3h18v3h2v-9c0-2.21-1.79-4-4-4zm2 8h-8V9h6c1.1 0 2 .9 2 2v4z"/>
                </svg>
                <span>{pkg.hotel.name}</span>
                {pkg.hotel.star_rating && (
                  <div className="flex ml-1">
                    {[...Array(Math.min(pkg.hotel.star_rating, 5))].map((_, i) => (
                      <svg key={i} className="h-3 w-3 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                      </svg>
                    ))}
                  </div>
                )}
              </div>
            )}
            <div className="inline-flex items-center gap-1.5 bg-blue-50 text-blue-700 px-2.5 py-1 rounded-lg text-xs font-medium">
              <svg className="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
              </svg>
              <span>Verified</span>
            </div>
          </div>

          {/* Price & CTA Section */}
          <div className="flex items-center justify-between pt-4 border-t border-gray-100">
            <div>
              <p className="text-xs text-gray-400 uppercase tracking-wider font-medium">{t('startingFrom')}</p>
              <div className="flex items-baseline gap-1">
                <span className="text-3xl font-black bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">
                  ${parseFloat(pkg.price).toLocaleString()}
                </span>
                <span className="text-gray-400 text-sm">/person</span>
              </div>
            </div>
            <Link
              to={`/packages/${pkg.id}`}
              className="group/cta relative inline-flex items-center gap-2 overflow-hidden bg-gradient-to-r from-blue-500 to-indigo-500 text-white px-5 py-2.5 rounded-xl font-semibold text-sm transition-all duration-300 hover:shadow-lg hover:shadow-blue-500/30 hover:scale-105"
            >
                <span>{t('viewDetails')}</span>
              <svg className="w-4 h-4 relative z-10 group-hover/cta:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
              </svg>
              {/* Shine effect */}
              <div className="absolute inset-0 translate-x-[-100%] group-hover/cta:translate-x-[100%] transition-transform duration-700 bg-gradient-to-r from-transparent via-white/20 to-transparent"></div>
            </Link>
          </div>
        </div>
      </div>
    </div>
  );
}

export default PackageCard;
