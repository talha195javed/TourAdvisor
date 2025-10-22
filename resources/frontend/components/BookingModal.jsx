import React, { useState } from 'react';
import { useTranslation } from 'react-i18next';
import { bookingsAPI } from '../services/api';

function BookingModal({ isOpen, onClose, packageData }) {
  const { t } = useTranslation();
  const [loading, setLoading] = useState(false);
  const [success, setSuccess] = useState(false);
  const [error, setError] = useState(null);
  const [bookingReference, setBookingReference] = useState('');

  const [formData, setFormData] = useState({
    customer_name: '',
    customer_email: '',
    customer_phone: '',
    customer_country: '',
    customer_address: '',
    travel_date: '',
    return_date: '',
    number_of_adults: 1,
    number_of_children: 0,
    number_of_infants: 0,
    special_requests: '',
  });

  const [errors, setErrors] = useState({});

  const handleChange = (e) => {
    const { name, value } = e.target;

    // If travel date is changed and package has duration_days, auto-calculate return date
    if (name === 'travel_date' && value && packageData?.duration_days) {
      const travelDate = new Date(value);
      const returnDate = new Date(travelDate);
      returnDate.setDate(returnDate.getDate() + parseInt(packageData.duration_days));

      setFormData(prev => ({
        ...prev,
        [name]: value,
        return_date: returnDate.toISOString().split('T')[0]
      }));
    } else {
      setFormData(prev => ({
        ...prev,
        [name]: value
      }));
    }

    if (errors[name]) {
      setErrors(prev => ({
        ...prev,
        [name]: null
      }));
    }
  };

  const validateForm = () => {
    const newErrors = {};

    if (!formData.customer_name.trim()) {
      newErrors.customer_name = t('nameRequired') || 'Name is required';
    }

    if (!formData.customer_email.trim()) {
      newErrors.customer_email = t('emailRequired') || 'Email is required';
    } else if (!/\S+@\S+\.\S+/.test(formData.customer_email)) {
      newErrors.customer_email = t('emailInvalid') || 'Email is invalid';
    }

    if (!formData.customer_phone.trim()) {
      newErrors.customer_phone = t('phoneRequired') || 'Phone is required';
    }

    if (!formData.travel_date) {
      newErrors.travel_date = t('travelDateRequired') || 'Travel date is required';
    }

    if (formData.number_of_adults < 1) {
      newErrors.number_of_adults = t('adultsRequired') || 'At least 1 adult is required';
    }

    setErrors(newErrors);
    return Object.keys(newErrors).length === 0;
  };

  const calculateTotal = () => {
    if (!packageData) return 0;
    const adults = parseInt(formData.number_of_adults) || 0;
    const children = parseInt(formData.number_of_children) || 0;
    const price = parseFloat(packageData.price) || 0;

    return (adults * price) + (children * price * 0.5);
  };

  const handleSubmit = async (e) => {
    e.preventDefault();

    if (!validateForm()) {
      return;
    }

    setLoading(true);
    setError(null);

    try {
      const bookingData = {
        package_id: packageData.id,
        ...formData,
        number_of_adults: parseInt(formData.number_of_adults),
        number_of_children: parseInt(formData.number_of_children),
        number_of_infants: parseInt(formData.number_of_infants),
      };

      const response = await bookingsAPI.create(bookingData);

      if (response.data.success) {
        setSuccess(true);
        setBookingReference(response.data.booking.booking_reference);

        setTimeout(() => {
          handleClose();
        }, 5000);
      }
    } catch (err) {
      console.error('Booking error:', err);
      if (err.response?.data?.errors) {
        setErrors(err.response.data.errors);
      } else {
        setError(err.response?.data?.message || t('bookingError') || 'Failed to create booking. Please try again.');
      }
    } finally {
      setLoading(false);
    }
  };

  const handleClose = () => {
    setFormData({
      customer_name: '',
      customer_email: '',
      customer_phone: '',
      customer_country: '',
      customer_address: '',
      travel_date: '',
      return_date: '',
      number_of_adults: 1,
      number_of_children: 0,
      number_of_infants: 0,
      special_requests: '',
    });
    setErrors({});
    setError(null);
    setSuccess(false);
    setBookingReference('');
    onClose();
  };

  if (!isOpen) return null;

  const today = new Date().toISOString().split('T')[0];

  return (
    <div className="fixed inset-0 z-50 overflow-y-auto animate-fadeIn" aria-labelledby="modal-title" role="dialog" aria-modal="true">
      <div className="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div
          className="fixed inset-0 bg-gradient-to-br from-gray-900/90 via-blue-900/80 to-purple-900/90 backdrop-blur-sm transition-all duration-300"
          aria-hidden="true"
          onClick={handleClose}
        ></div>

        <div className="inline-block align-bottom bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full animate-slideUp">
          {success ? (
            <div className="p-10 text-center bg-gradient-to-br from-green-50 via-blue-50 to-purple-50">
              <div className="mx-auto flex items-center justify-center h-24 w-24 rounded-full bg-gradient-to-br from-green-400 to-emerald-600 mb-6 shadow-xl animate-bounce">
                <svg className="h-14 w-14 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="3" d="M5 13l4 4L19 7" />
                </svg>
              </div>
              <h3 className="text-4xl font-black text-transparent bg-clip-text bg-gradient-to-r from-green-600 to-blue-600 mb-3">
                {t('bookingSuccess') || 'Booking Successful!'}
              </h3>
              <p className="text-lg text-gray-600 mb-6 max-w-md mx-auto">
                {t('bookingSuccessMessage') || 'Your booking has been created successfully.'}
              </p>
              <div className="bg-white border-2 border-blue-300 rounded-2xl p-6 mb-6 shadow-xl max-w-md mx-auto transform hover:scale-105 transition-transform">
                <div className="flex items-center justify-center mb-3">
                  <svg className="h-6 w-6 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                  </svg>
                  <p className="text-sm font-semibold text-gray-600">{t('bookingReference') || 'Booking Reference'}</p>
                </div>
                <p className="text-3xl font-black text-blue-600 tracking-wide">{bookingReference}</p>
              </div>
              <div className="bg-blue-100 border border-blue-200 rounded-xl p-4 mb-6 max-w-md mx-auto">
                <p className="text-sm text-blue-800 flex items-center justify-center">
                  <svg className="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                  </svg>
                  {t('bookingConfirmationEmail') || 'A confirmation email has been sent to your email address.'}
                </p>
              </div>
              <button
                onClick={handleClose}
                className="bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white px-10 py-4 rounded-xl font-bold text-lg transition-all transform hover:scale-105 shadow-lg"
              >
                {t('close') || 'Close'}
              </button>
            </div>
          ) : (
            <>
              <div className="bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 px-8 py-8 relative overflow-hidden">
                <div className="absolute inset-0 bg-black opacity-10"></div>
                <div className="absolute top-0 right-0 w-64 h-64 bg-white opacity-5 rounded-full -mr-32 -mt-32"></div>
                <div className="absolute bottom-0 left-0 w-48 h-48 bg-white opacity-5 rounded-full -ml-24 -mb-24"></div>
                <div className="relative flex items-center justify-between">
                  <div className="flex-1">
                    <div className="flex items-center mb-2">
                      <svg className="h-8 w-8 text-white mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                      </svg>
                      <h3 className="text-3xl font-black text-white" id="modal-title">
                        {t('bookNow') || 'Book Your Adventure'}
                      </h3>
                    </div>
                    <p className="text-blue-100 text-lg font-medium ml-11">{packageData?.title}</p>
                    {packageData?.location && (
                      <p className="text-blue-200 text-sm mt-1 ml-11 flex items-center">
                        <svg className="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        </svg>
                        {packageData.location}
                      </p>
                    )}
                  </div>
                  <button
                    onClick={handleClose}
                    className="text-white hover:bg-white/20 transition-all p-2 rounded-full"
                  >
                    <svg className="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2.5" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                  </button>
                </div>
              </div>

              <form onSubmit={handleSubmit} className="px-8 py-8 max-h-[70vh] overflow-y-auto bg-gradient-to-b from-gray-50 to-white">
                {error && (
                  <div className="mb-6 bg-red-50 border-l-4 border-red-500 text-red-700 px-6 py-4 rounded-r-lg shadow-md flex items-start">
                    <svg className="h-6 w-6 text-red-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>{error}</span>
                  </div>
                )}

                <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                  <div>
                    <label className="block text-sm font-semibold text-gray-700 mb-2">
                      {t('Full Name') || 'Full Name'} <span className="text-red-500">*</span>
                    </label>
                    <input
                      type="text"
                      name="customer_name"
                      value={formData.customer_name}
                      onChange={handleChange}
                      className={`w-full px-4 py-3 border-2 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all ${
                        errors.customer_name ? 'border-red-500 bg-red-50' : 'border-gray-200 hover:border-gray-300'
                      }`}
                      placeholder={t('Enter Full Name') || 'John Doe'}
                    />
                    {errors.customer_name && (
                      <p className="mt-1 text-sm text-red-500">{errors.customer_name}</p>
                    )}
                  </div>

                  <div>
                    <label className="block text-sm font-semibold text-gray-700 mb-2">
                      {t('Email') || 'Email'} <span className="text-red-500">*</span>
                    </label>
                    <input
                      type="email"
                      name="customer_email"
                      value={formData.customer_email}
                      onChange={handleChange}
                      className={`w-full px-4 py-3 border-2 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all ${
                        errors.customer_email ? 'border-red-500 bg-red-50' : 'border-gray-200 hover:border-gray-300'
                      }`}
                      placeholder={t('Enter Email') || 'john@example.com'}
                    />
                    {errors.customer_email && (
                      <p className="mt-1 text-sm text-red-500">{errors.customer_email}</p>
                    )}
                  </div>

                  <div>
                    <label className="block text-sm font-semibold text-gray-700 mb-2">
                      {t('Phone') || 'Phone'} <span className="text-red-500">*</span>
                    </label>
                    <input
                      type="tel"
                      name="customer_phone"
                      value={formData.customer_phone}
                      onChange={handleChange}
                      className={`w-full px-4 py-3 border-2 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all ${
                        errors.customer_phone ? 'border-red-500 bg-red-50' : 'border-gray-200 hover:border-gray-300'
                      }`}
                      placeholder={t('Enter Phone') || '+971 234 567 890'}
                    />
                    {errors.customer_phone && (
                      <p className="mt-1 text-sm text-red-500">{errors.customer_phone}</p>
                    )}
                  </div>

                  <div>
                    <label className="block text-sm font-semibold text-gray-700 mb-2">
                      {t('Country') || 'Country'}
                    </label>
                    <input
                      type="text"
                      name="customer_country"
                      value={formData.customer_country}
                      onChange={handleChange}
                      className="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 hover:border-gray-300 transition-all"
                      placeholder={t('Enter Country') || 'United States'}
                    />
                  </div>

                  <div>
                    <label className="block text-sm font-semibold text-gray-700 mb-2">
                      {t('travelDate') || 'Travel Date'} <span className="text-red-500">*</span>
                    </label>
                    <input
                      type="date"
                      name="travel_date"
                      value={formData.travel_date}
                      onChange={handleChange}
                      min={today}
                      className={`w-full px-4 py-3 border-2 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all ${
                        errors.travel_date ? 'border-red-500 bg-red-50' : 'border-gray-200 hover:border-gray-300'
                      }`}
                    />
                    {errors.travel_date && (
                      <p className="mt-1 text-sm text-red-500">{errors.travel_date}</p>
                    )}
                    {packageData?.duration_days && (
                      <p className="mt-1 text-xs text-blue-600">
                        ℹ️ Return date will be auto-calculated based on {packageData.duration_days} day package
                      </p>
                    )}
                  </div>

                  <div>
                    <label className="block text-sm font-semibold text-gray-700 mb-2">
                      {t('returnDate') || 'Return Date'}
                    </label>
                    <input
                      type="date"
                      name="return_date"
                      value={formData.return_date}
                      onChange={handleChange}
                      min={formData.travel_date || today}
                      className="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 hover:border-gray-300 transition-all"
                    />
                    <p className="mt-1 text-xs text-gray-500">
                      {t('returnDateNote') || 'You can modify the auto-calculated return date if needed'}
                    </p>
                  </div>

                  <div>
                    <label className="block text-sm font-semibold text-gray-700 mb-2">
                      {t('adults') || 'Adults'} <span className="text-red-500">*</span>
                    </label>
                    <input
                      type="number"
                      name="number_of_adults"
                      value={formData.number_of_adults}
                      onChange={handleChange}
                      min="1"
                      className={`w-full px-4 py-3 border-2 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all ${
                        errors.number_of_adults ? 'border-red-500 bg-red-50' : 'border-gray-200 hover:border-gray-300'
                      }`}
                    />
                    {errors.number_of_adults && (
                      <p className="mt-1 text-sm text-red-500">{errors.number_of_adults}</p>
                    )}
                  </div>

                  <div>
                    <label className="block text-sm font-semibold text-gray-700 mb-2">
                      {t('children') || 'Children'}
                    </label>
                    <input
                      type="number"
                      name="number_of_children"
                      value={formData.number_of_children}
                      onChange={handleChange}
                      min="0"
                      className="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 hover:border-gray-300 transition-all"
                    />
                  </div>

                  <div>
                    <label className="block text-sm font-semibold text-gray-700 mb-2">
                      {t('infants') || 'Infants'}
                    </label>
                    <input
                      type="number"
                      name="number_of_infants"
                      value={formData.number_of_infants}
                      onChange={handleChange}
                      min="0"
                      className="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 hover:border-gray-300 transition-all"
                    />
                  </div>
                </div>

                <div className="mt-6">
                  <label className="block text-sm font-semibold text-gray-700 mb-2">
                    {t('address') || 'Address'}
                  </label>
                  <textarea
                    name="customer_address"
                    value={formData.customer_address}
                    onChange={handleChange}
                    rows="2"
                    className="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 hover:border-gray-300 transition-all resize-none"
                    placeholder={t('Enter Address') || 'Enter your address'}
                  />
                </div>

                <div className="mt-6">
                  <label className="block text-sm font-semibold text-gray-700 mb-2">
                    {t('Special Requests') || 'Special Requests'}
                  </label>
                  <textarea
                    name="special_requests"
                    value={formData.special_requests}
                    onChange={handleChange}
                    rows="3"
                    className="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 hover:border-gray-300 transition-all resize-none"
                    placeholder={t('Any special requests or requirements?') || 'Any special requests or requirements?'}
                  />
                </div>

                <div className="mt-8 bg-gradient-to-br from-blue-50 via-purple-50 to-pink-50 border-2 border-blue-200 rounded-2xl p-6 shadow-lg">
                  <div className="flex justify-between items-center mb-3">
                    <span className="text-gray-700">{t('packagePrice') || 'Package Price'}</span>
                    <span className="font-semibold text-gray-900">${parseFloat(packageData?.price || 0).toFixed(2)}</span>
                  </div>
                  <div className="flex justify-between items-center mb-3">
                    <span className="text-gray-700">{t('adults') || 'Adults'} ({formData.number_of_adults})</span>
                    <span className="font-semibold text-gray-900">${(formData.number_of_adults * parseFloat(packageData?.price || 0)).toFixed(2)}</span>
                  </div>
                  {formData.number_of_children > 0 && (
                    <div className="flex justify-between items-center mb-3">
                      <span className="text-gray-700">{t('children') || 'Children'} ({formData.number_of_children})</span>
                      <span className="font-semibold text-gray-900">${(formData.number_of_children * parseFloat(packageData?.price || 0) * 0.5).toFixed(2)}</span>
                    </div>
                  )}
                  <div className="border-t-2 border-blue-300 pt-4 mt-4">
                    <div className="flex justify-between items-center bg-white rounded-xl p-4 shadow-sm">
                      <span className="text-xl font-black text-gray-900">{t('totalAmount') || 'Total Amount'}</span>
                      <span className="text-3xl font-black bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">${calculateTotal().toFixed(2)}</span>
                    </div>
                  </div>
                </div>

                <div className="mt-8 flex gap-4">
                  <button
                    type="button"
                    onClick={handleClose}
                    className="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 px-6 py-4 rounded-xl font-bold text-lg transition-all transform hover:scale-105 shadow-md"
                  >
                    {t('cancel') || 'Cancel'}
                  </button>
                  <button
                    type="submit"
                    disabled={loading}
                    className="flex-1 bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 hover:from-blue-700 hover:via-purple-700 hover:to-pink-700 text-white px-6 py-4 rounded-xl font-bold text-lg transition-all transform hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none flex items-center justify-center shadow-lg"
                  >
                    {loading ? (
                      <>
                        <svg className="animate-spin h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                          <circle className="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" strokeWidth="4"></circle>
                          <path className="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        {t('processing') || 'Processing...'}
                      </>
                    ) : (
                      t('confirmBooking') || 'Confirm Booking'
                    )}
                  </button>
                </div>
              </form>
            </>
          )}
        </div>
      </div>
    </div>
  );
}

export default BookingModal;

// Add these styles to your global CSS or Tailwind config
// @keyframes fadeIn {
//   from { opacity: 0; }
//   to { opacity: 1; }
// }
// @keyframes slideUp {
//   from { transform: translateY(20px); opacity: 0; }
//   to { transform: translateY(0); opacity: 1; }
// }
// .animate-fadeIn { animation: fadeIn 0.3s ease-out; }
// .animate-slideUp { animation: slideUp 0.4s ease-out; }
