import React, { useState, useEffect } from 'react';
import { Link } from 'react-router-dom';
import { useTranslation } from 'react-i18next';
import { useAuth } from '../context/AuthContext';
import { getMyBookings } from '../services/authAPI';
import LoadingSpinner from '../components/LoadingSpinner';

function MyBookings() {
    const { t } = useTranslation();
    const { client } = useAuth();
    const [bookings, setBookings] = useState([]);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);

    useEffect(() => {
        fetchBookings();
    }, []);

    const fetchBookings = async () => {
        try {
            setLoading(true);
            const response = await getMyBookings();
            setBookings(response.bookings);
            setError(null);
        } catch (err) {
            console.error('Error fetching bookings:', err);
            setError('Failed to load bookings');
        } finally {
            setLoading(false);
        }
    };

    const getStatusColor = (status) => {
        const colors = {
            pending: 'bg-yellow-100 text-yellow-800 border-yellow-200',
            confirmed: 'bg-blue-100 text-blue-800 border-blue-200',
            completed: 'bg-green-100 text-green-800 border-green-200',
            cancelled: 'bg-red-100 text-red-800 border-red-200',
        };
        return colors[status] || 'bg-gray-100 text-gray-800 border-gray-200';
    };

    const getPaymentStatusColor = (status) => {
        const colors = {
            pending: 'bg-yellow-100 text-yellow-800',
            partial: 'bg-orange-100 text-orange-800',
            paid: 'bg-green-100 text-green-800',
            refunded: 'bg-red-100 text-red-800',
        };
        return colors[status] || 'bg-gray-100 text-gray-800';
    };

    const formatDate = (dateString) => {
        if (!dateString) return 'N/A';
        return new Date(dateString).toLocaleDateString('en-US', {
            year: 'numeric',
            month: 'short',
            day: 'numeric'
        });
    };

    const formatCurrency = (amount) => {
        return new Intl.NumberFormat('en-US', {
            style: 'currency',
            currency: 'AED'
        }).format(amount);
    };

    if (loading) {
        return <LoadingSpinner />;
    }

    return (
        <div className="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 pt-24 pb-12">
            <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                {/* Header */}
                <div className="mb-8">
                    <div className="flex items-center justify-between">
                        <div>
                            <h1 className="text-4xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent mb-2">
                                {t('My Bookings') || 'My Bookings'}
                            </h1>
                            <p className="text-gray-600">
                                {t('Welcome back') || 'Welcome back'}, <span className="font-semibold text-gray-900">{client?.name}</span>
                            </p>
                        </div>
                        <div className="hidden md:flex items-center space-x-4">
                            <div className="bg-white rounded-xl shadow-lg px-6 py-4 border border-gray-100">
                                <p className="text-sm text-gray-500">{t('Total Bookings') || 'Total Bookings'}</p>
                                <p className="text-3xl font-bold text-blue-600">{bookings.length}</p>
                            </div>
                        </div>
                    </div>
                </div>

                {error && (
                    <div className="mb-6 bg-red-50 border border-red-200 rounded-xl p-4">
                        <p className="text-red-800">{error}</p>
                    </div>
                )}

                {bookings.length === 0 ? (
                    <div className="bg-white rounded-2xl shadow-xl p-12 text-center">
                        <div className="max-w-md mx-auto">
                            <div className="w-24 h-24 bg-gradient-to-br from-blue-100 to-purple-100 rounded-full flex items-center justify-center mx-auto mb-6">
                                <svg className="w-12 h-12 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            </div>
                            <h3 className="text-2xl font-bold text-gray-900 mb-3">
                                {t('No bookings yet') || 'No bookings yet'}
                            </h3>
                            <p className="text-gray-600 mb-6">
                                {t('Start exploring our amazing packages and create your first booking!') || 'Start exploring our amazing packages and create your first booking!'}
                            </p>
                            <Link
                                to="/packages"
                                className="inline-flex items-center space-x-2 bg-gradient-to-r from-blue-600 to-purple-600 text-white px-8 py-3 rounded-xl font-semibold hover:shadow-xl transition-all duration-300 hover:scale-105"
                            >
                                <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                                <span>{t('Browse Packages') || 'Browse Packages'}</span>
                            </Link>
                        </div>
                    </div>
                ) : (
                    <div className="grid gap-6">
                        {bookings.map((booking) => (
                            <div
                                key={booking.id}
                                className="bg-white rounded-2xl shadow-xl overflow-hidden hover:shadow-2xl transition-all duration-300 border border-gray-100"
                            >
                                <div className="md:flex">
                                    {/* Package Image */}
                                    <div className="md:w-1/3 relative">
                                        <img
                                            src={booking.package?.main_image || '/images/placeholder.jpg'}
                                            alt={booking.package?.title}
                                            className="w-full h-64 md:h-full object-cover"
                                        />
                                        <div className="absolute top-4 left-4">
                                            <span className={`px-4 py-2 rounded-full text-sm font-semibold border ${getStatusColor(booking.status)}`}>
                                                {booking.status?.toUpperCase()}
                                            </span>
                                        </div>
                                    </div>

                                    {/* Booking Details */}
                                    <div className="md:w-2/3 p-6">
                                        <div className="flex justify-between items-start mb-4">
                                            <div>
                                                <h3 className="text-2xl font-bold text-gray-900 mb-2">
                                                    {booking.package?.title}
                                                </h3>
                                                <p className="text-gray-600 flex items-center space-x-2">
                                                    <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    </svg>
                                                    <span>{booking.package?.location}</span>
                                                </p>
                                            </div>
                                            <div className="text-right">
                                                <p className="text-sm text-gray-500 mb-1">{t('Booking Reference') || 'Booking Reference'}</p>
                                                <p className="text-lg font-bold text-blue-600">{booking.booking_reference}</p>
                                            </div>
                                        </div>

                                        <div className="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
                                            <div className="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-4">
                                                <p className="text-xs text-blue-600 font-semibold mb-1">{t('Travel Date') || 'Travel Date'}</p>
                                                <p className="text-sm font-bold text-gray-900">{formatDate(booking.travel_date)}</p>
                                            </div>
                                            <div className="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-4">
                                                <p className="text-xs text-purple-600 font-semibold mb-1">{t('Return Date') || 'Return Date'}</p>
                                                <p className="text-sm font-bold text-gray-900">{formatDate(booking.return_date)}</p>
                                            </div>
                                            <div className="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-4">
                                                <p className="text-xs text-green-600 font-semibold mb-1">{t('Travelers') || 'Travelers'}</p>
                                                <p className="text-sm font-bold text-gray-900">
                                                    {booking.number_of_adults + (booking.number_of_children || 0) + (booking.number_of_infants || 0)}
                                                </p>
                                            </div>
                                            <div className="bg-gradient-to-br from-orange-50 to-orange-100 rounded-xl p-4">
                                                <p className="text-xs text-orange-600 font-semibold mb-1">{t('Total Amount') || 'Total Amount'}</p>
                                                <p className="text-sm font-bold text-gray-900">{formatCurrency(booking.total_amount)}</p>
                                            </div>
                                        </div>

                                        <div className="flex flex-wrap items-center justify-between gap-4 pt-4 border-t border-gray-100">
                                            <div className="flex items-center space-x-4">
                                                <div>
                                                    <p className="text-xs text-gray-500 mb-1">{t('Payment Status') || 'Payment Status'}</p>
                                                    <span className={`px-3 py-1 rounded-full text-xs font-semibold ${getPaymentStatusColor(booking.payment_status)}`}>
                                                        {booking.payment_status?.toUpperCase()}
                                                    </span>
                                                </div>
                                                <div className="h-8 w-px bg-gray-200"></div>
                                                <div>
                                                    <p className="text-xs text-gray-500 mb-1">{t('Paid') || 'Paid'}</p>
                                                    <p className="text-sm font-bold text-green-600">{formatCurrency(booking.paid_amount || 0)}</p>
                                                </div>
                                                <div>
                                                    <p className="text-xs text-gray-500 mb-1">{t('Remaining') || 'Remaining'}</p>
                                                    <p className="text-sm font-bold text-orange-600">{formatCurrency(booking.remaining_amount || 0)}</p>
                                                </div>
                                            </div>

                                            <div className="flex space-x-2">
                                                <Link
                                                    to={`/packages/${booking.package_id}`}
                                                    className="px-4 py-2 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-lg font-semibold hover:shadow-lg transition-all duration-300 flex items-center space-x-2"
                                                >
                                                    <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    </svg>
                                                    <span>{t('View Package') || 'View Package'}</span>
                                                </Link>
                                            </div>
                                        </div>

                                        {booking.special_requests && (
                                            <div className="mt-4 pt-4 border-t border-gray-100">
                                                <p className="text-xs text-gray-500 mb-1">{t('Special Requests') || 'Special Requests'}</p>
                                                <p className="text-sm text-gray-700">{booking.special_requests}</p>
                                            </div>
                                        )}
                                    </div>
                                </div>
                            </div>
                        ))}
                    </div>
                )}
            </div>
        </div>
    );
}

export default MyBookings;
