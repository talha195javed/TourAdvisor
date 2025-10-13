import React, { useState, useEffect } from 'react';
import { useParams, Link } from 'react-router-dom';
import { useTranslation } from 'react-i18next';
import { packagesAPI } from '../services/api';
import LoadingSpinner from '../components/LoadingSpinner';

function PackageDetail() {
  const { id } = useParams();
  const { t } = useTranslation();
  const [pkg, setPkg] = useState(null);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  useEffect(() => {
    fetchPackage();
  }, [id]);

  const fetchPackage = async () => {
    try {
      setLoading(true);
      const response = await packagesAPI.getById(id);
      setPkg(response.data);
      setError(null);
    } catch (err) {
      console.error('Error fetching package:', err);
      setError(t('error'));
    } finally {
      setLoading(false);
    }
  };

  const handleWhatsAppClick = () => {
    const phoneNumber = '971561325543'; // WhatsApp number without + or spaces
    const packageUrl = window.location.href;
    const message = `Hi, I want to know more about this package:\n${packageUrl}`;
    const whatsappUrl = `https://wa.me/${phoneNumber}?text=${encodeURIComponent(message)}`;
    window.open(whatsappUrl, '_blank');
  };

  if (loading) {
    return (
      <div className="min-h-screen flex items-center justify-center">
        <LoadingSpinner size="lg" />
      </div>
    );
  }

  if (error || !pkg) {
    return (
      <div className="min-h-screen flex items-center justify-center">
        <div className="text-center">
          <p className="text-red-600 text-lg mb-4">{error || 'Package not found'}</p>
          <Link to="/packages" className="text-blue-600 hover:underline">
            {t('backToPackages')}
          </Link>
        </div>
      </div>
    );
  }

  return (
    <div className="min-h-screen bg-gray-50">
      {/* Breadcrumb */}
      <div className="bg-white border-b">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
          <div className="flex items-center space-x-2 rtl:space-x-reverse text-sm text-gray-600">
            <Link to="/" className="hover:text-blue-600">{t('home')}</Link>
            <span>/</span>
            <Link to="/packages" className="hover:text-blue-600">{t('packages')}</Link>
            <span>/</span>
            <span className="text-gray-900">{pkg.title}</span>
          </div>
        </div>
      </div>

      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div className="grid grid-cols-1 lg:grid-cols-3 gap-8">
          {/* Main Content */}
          <div className="lg:col-span-2">
            {/* Hero Image */}
            <div className="bg-white rounded-xl shadow-lg overflow-hidden mb-8">
              <img
                src={pkg.main_image || 'https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?w=1200'}
                alt={pkg.title}
                className="w-full h-96 object-cover"
              />
            </div>

            {/* Package Info */}
            <div className="bg-white rounded-xl shadow-lg p-8 mb-8">
              <div className="flex items-start justify-between mb-6">
                <div>
                  <h1 className="text-3xl md:text-4xl font-bold text-gray-900 mb-2">
                    {pkg.title}
                  </h1>
                  {pkg.category && (
                    <span className="inline-block bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-medium">
                      {pkg.category.name}
                    </span>
                  )}
                </div>
              </div>

              {/* Quick Info */}
              <div className="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6 pb-6 border-b">
                {pkg.location && (
                  <div className="flex items-center text-gray-700">
                    <svg className="h-5 w-5 mr-2 rtl:mr-0 rtl:ml-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <div>
                      <p className="text-sm text-gray-500">{t('location')}</p>
                      <p className="font-semibold">{pkg.location}</p>
                    </div>
                  </div>
                )}

                {pkg.duration_days && (
                  <div className="flex items-center text-gray-700">
                    <svg className="h-5 w-5 mr-2 rtl:mr-0 rtl:ml-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <div>
                      <p className="text-sm text-gray-500">{t('duration')}</p>
                      <p className="font-semibold">{pkg.duration_days} {t('days')}</p>
                    </div>
                  </div>
                )}

                {pkg.transfer_type && (
                  <div className="flex items-center text-gray-700">
                    <svg className="h-5 w-5 mr-2 rtl:mr-0 rtl:ml-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                    </svg>
                    <div>
                      <p className="text-sm text-gray-500">{t('transfer')}</p>
                      <p className="font-semibold">{pkg.transfer_type}</p>
                    </div>
                  </div>
                )}
              </div>

              {/* Description */}
              <div className="mb-6">
                <h2 className="text-2xl font-bold text-gray-900 mb-4">{t('description')}</h2>
                <p className="text-gray-700 leading-relaxed">{pkg.description}</p>
              </div>

              {/* Features */}
              {pkg.features && pkg.features.length > 0 && (
                <div className="mb-6">
                  <h2 className="text-2xl font-bold text-gray-900 mb-4">{t('included')}</h2>
                  <div className="grid grid-cols-1 md:grid-cols-2 gap-3">
                    {pkg.features.map((feature, index) => (
                      <div key={index} className="flex items-center text-gray-700">
                        <svg className="h-5 w-5 mr-2 rtl:mr-0 rtl:ml-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span>{feature}</span>
                      </div>
                    ))}
                  </div>
                </div>
              )}

              {/* Hotel Info */}
              {pkg.hotel && (
                <div className="bg-gray-50 rounded-lg p-6">
                  <h2 className="text-2xl font-bold text-gray-900 mb-4">{t('accommodation')}</h2>
                  <div className="flex items-start">
                    <svg className="h-6 w-6 mr-3 rtl:mr-0 rtl:ml-3 text-blue-600 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    <div>
                      <h3 className="text-xl font-semibold text-gray-900">{pkg.hotel.name}</h3>
                      <p className="text-gray-600">{pkg.hotel.location}</p>
                      {pkg.hotel.star_rating && (
                        <div className="flex items-center mt-2">
                          {[...Array(pkg.hotel.star_rating)].map((_, i) => (
                            <svg key={i} className="h-4 w-4 text-yellow-400 fill-current" viewBox="0 0 24 24">
                              <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                            </svg>
                          ))}
                        </div>
                      )}
                      {pkg.hotel.description && (
                        <p className="text-gray-700 mt-2">{pkg.hotel.description}</p>
                      )}
                    </div>
                  </div>
                </div>
              )}
            </div>
          </div>

          {/* Sidebar */}
          <div className="lg:col-span-1">
            <div className="bg-white rounded-xl shadow-lg p-6 sticky top-4">
              <div className="mb-6">
                <p className="text-sm text-gray-600 mb-2">{t('startingFrom')}</p>
                <p className="text-4xl font-bold text-blue-600">
                  ${parseFloat(pkg.price).toFixed(2)}
                </p>
                <p className="text-sm text-gray-500 mt-1">{t('perPerson')}</p>
              </div>

              <button
                onClick={handleWhatsAppClick}
                className="w-full bg-green-600 hover:bg-green-700 text-white px-6 py-4 rounded-lg font-semibold text-lg transition-colors flex items-center justify-center space-x-2 rtl:space-x-reverse mb-4"
              >
                <svg className="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                </svg>
                <span>{t('knowMore')}</span>
              </button>

              <div className="border-t pt-4">
                <h3 className="font-semibold text-gray-900 mb-3">{t('needHelp')}</h3>
                <p className="text-sm text-gray-600 mb-2">{t('contactUs')}</p>
                <p className="text-blue-600 font-semibold">+971 56 132 5543</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
}

export default PackageDetail;
