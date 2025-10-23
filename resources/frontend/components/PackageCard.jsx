import React from 'react';
import { useTranslation } from 'react-i18next';
import { Link } from 'react-router-dom';
// Icons replaced with inline SVG

function PackageCard({ package: pkg }) {
  const { t } = useTranslation();

  return (
    <div className="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
      <div className="relative h-56 overflow-hidden">
        <img
          src={pkg.main_image || 'https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?w=800'}
          alt={pkg.title}
          className="w-full h-full object-cover hover:scale-110 transition-transform duration-300"
        />
        {pkg.category && (
          <div className="absolute top-4 left-4 rtl:left-auto rtl:right-4">
            <span className="bg-blue-600 text-white px-3 py-1 rounded-full text-sm font-medium">
              {pkg.category.name}
            </span>
          </div>
        )}
      </div>

      <div className="p-6">
        <h3 className="text-xl font-bold text-gray-900 mb-3 line-clamp-2">
          {pkg.title}
        </h3>

        <p className="text-gray-600 text-sm mb-4 line-clamp-2">
          {pkg.description}
        </p>
        <div className="space-y-2 mb-4">
          {pkg.location && (
            <div className="flex items-center text-gray-700 text-sm">
              <svg className="h-4 w-4 mr-2 rtl:mr-0 rtl:ml-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
              </svg>
              <span>{pkg.location}</span>
            </div>
          )}

          {pkg.duration_days && (
            <div className="flex items-center text-gray-700 text-sm">
              <svg className="h-4 w-4 mr-2 rtl:mr-0 rtl:ml-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
              </svg>
              <span>{pkg.duration_days} {t('days')}</span>
            </div>
          )}

          {pkg.hotel && (
            <div className="flex items-center text-gray-700 text-sm">
              <svg className="h-4 w-4 mr-2 rtl:mr-0 rtl:ml-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
              </svg>
              <span>{pkg.hotel.name}</span>
              {pkg.hotel.star_rating && (
                <div className="flex items-center ml-2 rtl:ml-0 rtl:mr-2">
                  {[...Array(pkg.hotel.star_rating)].map((_, i) => (
                    <svg key={i} className="h-3 w-3 text-yellow-400 fill-current" viewBox="0 0 24 24">
                      <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                    </svg>
                  ))}
                </div>
              )}
            </div>
          )}
        </div>

        <div className="flex items-center justify-between pt-4 border-t border-gray-200">
          <div>
            <p className="text-sm text-gray-600">{t('startingFrom')}</p>
            <p className="text-2xl font-bold text-blue-600">
              ${parseFloat(pkg.price).toFixed(2)}
            </p>
          </div>
          <Link
            to={`/packages/${pkg.id}`}
            className="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition-colors inline-block text-center"
          >
            {t('viewDetails')}
          </Link>
        </div>
      </div>
    </div>
  );
}

export default PackageCard;
