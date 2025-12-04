import React, { useState, useEffect } from 'react';
import { useTranslation } from 'react-i18next';
import { bookingsAPI } from '../services/api';
import api from '../services/api';
import { loadStripe } from '@stripe/stripe-js';
import { Elements, useStripe, useElements, CardNumberElement } from '@stripe/react-stripe-js';
import StripePaymentFields from './StripePaymentFields';

// Debug: Log Stripe key
console.log('Stripe Publishable Key:', import.meta.env.VITE_STRIPE_PUBLISHABLE_KEY);

const stripePromise = loadStripe(import.meta.env.VITE_STRIPE_PUBLISHABLE_KEY);

function BookingModal({ isOpen, onClose, packageData }) {
    const { t } = useTranslation();
    const [loading, setLoading] = useState(false);
    const [success, setSuccess] = useState(false);
    const [error, setError] = useState(null);
    const [bookingReference, setBookingReference] = useState('');
    const [bookingId, setBookingId] = useState(null);
    const [activeSection, setActiveSection] = useState('personal');
    const [paymentMethod, setPaymentMethod] = useState('later');
    const [clientSecret, setClientSecret] = useState('');
    const [paymentIntentId, setPaymentIntentId] = useState('');
    const [cardData, setCardData] = useState({});
    const [stripeInstance, setStripeInstance] = useState(null);

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
        visa_required: false,
        number_of_visas: 0,
    });

    const [passengers, setPassengers] = useState([
        {
            type: 'adult',
            full_name_passport: '',
            date_of_birth: '',
            gender: '',
            nationality: '',
            passport_number: '',
            passport_expiration: '',
        }
    ]);

    const [visaFiles, setVisaFiles] = useState({
        passportImages: [],
        applicantImages: [],
        emiratesIdImages: [],
    });

    const [errors, setErrors] = useState({});

    // Navigation sections with completion status
    const sections = [
        { id: 'personal', label: 'Personal Info', icon: '👤' },
        { id: 'travel', label: 'Travel Details', icon: '✈️' },
        { id: 'passengers', label: 'Passengers', icon: '👥' },
        { id: 'visa', label: 'Visa Services', icon: '📋' },
        { id: 'payment', label: 'Payment Method', icon: '💳' },
        { id: 'review', label: 'Review & Confirm', icon: '✅' },
    ];

    const getCurrentSectionIndex = () => sections.findIndex(section => section.id === activeSection);
    const isFirstSection = () => getCurrentSectionIndex() === 0;
    const isLastSection = () => getCurrentSectionIndex() === sections.length - 1;

    const handleNext = () => {
        const currentIndex = getCurrentSectionIndex();
        if (currentIndex < sections.length - 1) {
            setActiveSection(sections[currentIndex + 1].id);
        }
    };

    const handleBack = () => {
        const currentIndex = getCurrentSectionIndex();
        if (currentIndex > 0) {
            setActiveSection(sections[currentIndex - 1].id);
        }
    };

    const validateCurrentSection = () => {
        const newErrors = {};

        switch (activeSection) {
            case 'personal':
                if (!formData.customer_name.trim()) {
                    newErrors.customer_name = t('Name is required') || 'Name is required';
                }
                if (!formData.customer_email.trim()) {
                    newErrors.customer_email = t('Email is required') || 'Email is required';
                } else if (!/\S+@\S+\.\S+/.test(formData.customer_email)) {
                    newErrors.customer_email = t('Email is invalid') || 'Email is invalid';
                }
                if (!formData.customer_phone.trim()) {
                    newErrors.customer_phone = t('Phone is required') || 'Phone is required';
                }
                if (!formData.customer_country.trim()) {
                    newErrors.customer_country = t('Country is required') || 'Country is required';
                }
                if (!formData.customer_address.trim()) {
                    newErrors.customer_address = t('Address is required') || 'Country is required';
                }
                break;

            case 'travel':
                if (!formData.travel_date) {
                    newErrors.travel_date = t('travelDateRequired') || 'Travel date is required';
                }
                if (formData.number_of_adults < 1) {
                    newErrors.number_of_adults = t('adultsRequired') || 'At least 1 adult is required';
                }
                break;

            case 'passengers':
                // Validate passenger information
                passengers.forEach((passenger, index) => {
                    if (!passenger.full_name_passport.trim()) {
                        newErrors[`passenger_${index}_name`] = `Passenger ${index + 1} name is required`;
                    }
                    if (!passenger.date_of_birth) {
                        newErrors[`passenger_${index}_dob`] = `Passenger ${index + 1} date of birth is required`;
                    }
                    if (!passenger.gender) {
                        newErrors[`passenger_${index}_gender`] = `Passenger ${index + 1} gender is required`;
                    }
                    if (!passenger.nationality.trim()) {
                        newErrors[`passenger_${index}_nationality`] = `Passenger ${index + 1} nationality is required`;
                    }
                    if (!passenger.passport_number.trim()) {
                        newErrors[`passenger_${index}_passport`] = `Passenger ${index + 1} passport number is required`;
                    }
                    if (!passenger.passport_expiration) {
                        newErrors[`passenger_${index}_passport_exp`] = `Passenger ${index + 1} passport expiration is required`;
                    }
                });
                break;

            case 'visa':
                if (formData.visa_required) {
                    if (!formData.number_of_visas || formData.number_of_visas < 1) {
                        newErrors.number_of_visas = 'Number of visas is required';
                    }
                    if (visaFiles.passportImages.length === 0) {
                        newErrors.passportImages = 'Passport images are required';
                    }
                    if (visaFiles.applicantImages.length === 0) {
                        newErrors.applicantImages = 'Applicant photos are required';
                    }
                }
                break;

            case 'payment':
                if (!paymentMethod) {
                    newErrors.paymentMethod = 'Please select a payment method';
                }
                break;
        }

        setErrors(newErrors);
        return Object.keys(newErrors).length === 0;
    };

    const handleNextWithValidation = () => {
        if (validateCurrentSection()) {
            handleNext();
        }
    };

    const handleChange = (e) => {
        const { name, value, type, checked } = e.target;
        const newValue = type === 'checkbox' ? checked : value;

        if (name === 'travel_date' && value && packageData?.duration_days) {
            const travelDate = new Date(value);
            const returnDate = new Date(travelDate);
            returnDate.setDate(returnDate.getDate() + parseInt(packageData.duration_days));

            setFormData(prev => ({
                ...prev,
                [name]: value,
                return_date: returnDate.toISOString().split('T')[0]
            }));
        } else if (name === 'visa_required') {
            setFormData(prev => ({
                ...prev,
                [name]: newValue,
                number_of_visas: newValue ? 1 : 0
            }));
        } else if (name === 'number_of_adults' || name === 'number_of_children') {
            const adults = name === 'number_of_adults' ? parseInt(newValue) : parseInt(formData.number_of_adults);
            const children = name === 'number_of_children' ? parseInt(newValue) : parseInt(formData.number_of_children);
            updatePassengersArray(adults, children);

            setFormData(prev => ({
                ...prev,
                [name]: newValue
            }));
        } else {
            setFormData(prev => ({
                ...prev,
                [name]: newValue
            }));
        }

        if (errors[name]) {
            setErrors(prev => ({
                ...prev,
                [name]: null
            }));
        }
    };

    const updatePassengersArray = (adults, children) => {
        const totalPassengers = adults + children;
        const newPassengers = [];

        for (let i = 0; i < adults; i++) {
            newPassengers.push(passengers[i] || {
                type: 'adult',
                full_name_passport: '',
                date_of_birth: '',
                gender: '',
                nationality: '',
                passport_number: '',
                passport_expiration: '',
            });
        }

        for (let i = 0; i < children; i++) {
            const passengerIndex = adults + i;
            newPassengers.push(passengers[passengerIndex] || {
                type: 'child',
                full_name_passport: '',
                date_of_birth: '',
                gender: '',
                nationality: '',
                passport_number: '',
                passport_expiration: '',
            });
        }

        setPassengers(newPassengers);
    };

    const handlePassengerChange = (index, field, value) => {
        setPassengers(prev => {
            const updated = [...prev];
            updated[index] = {
                ...updated[index],
                [field]: value
            };
            return updated;
        });
    };

    const handleFileChange = (e, fileType) => {
        const files = Array.from(e.target.files);
        setVisaFiles(prev => ({
            ...prev,
            [fileType]: [...prev[fileType], ...files]
        }));

        // Clear file errors when files are added
        if (errors[fileType]) {
            setErrors(prev => ({
                ...prev,
                [fileType]: null
            }));
        }
    };

    const removeFile = (fileType, index) => {
        setVisaFiles(prev => ({
            ...prev,
            [fileType]: prev[fileType].filter((_, i) => i !== index)
        }));
    };

    const calculateTotal = () => {
        if (!packageData) return 0;
        const adults = parseInt(formData.number_of_adults) || 0;
        const children = parseInt(formData.number_of_children) || 0;
        const price = parseFloat(packageData.price) || 0;
        const packageTotal = (adults * price) + (children * price * 0.5);

        let visaTotal = 0;
        if (formData.visa_required && packageData.visa_price) {
            const numberOfVisas = parseInt(formData.number_of_visas) || 0;
            const visaPrice = parseFloat(packageData.visa_price) || 0;
            visaTotal = numberOfVisas * visaPrice;
        }

        return packageTotal + visaTotal;
    };

    const handleSubmit = async (e) => {
        e.preventDefault();

        if (!validateCurrentSection()) {
            return;
        }

        setLoading(true);
        setError(null);

        try {
            const formDataToSend = new FormData();

            // Add basic booking data
            formDataToSend.append('package_id', packageData.id);
            formDataToSend.append('customer_name', formData.customer_name);
            formDataToSend.append('customer_email', formData.customer_email);
            formDataToSend.append('customer_phone', formData.customer_phone);
            formDataToSend.append('customer_country', formData.customer_country);
            formDataToSend.append('customer_address', formData.customer_address);
            formDataToSend.append('travel_date', formData.travel_date);
            formDataToSend.append('return_date', formData.return_date);
            formDataToSend.append('number_of_adults', parseInt(formData.number_of_adults));
            formDataToSend.append('number_of_children', parseInt(formData.number_of_children));
            formDataToSend.append('number_of_infants', parseInt(formData.number_of_infants));
            formDataToSend.append('special_requests', formData.special_requests);

            // Add passengers data as JSON
            formDataToSend.append('passengers', JSON.stringify(passengers));

            // Add payment method information
            const paymentTiming = paymentMethod === 'stripe' ? 'now' : (paymentMethod === 'later' ? 'later' : 'now');
            formDataToSend.append('payment_method_type', paymentMethod);
            formDataToSend.append('payment_timing', paymentTiming);

            // Add visa data
            formDataToSend.append('visa_required', formData.visa_required ? '1' : '0');
            if (formData.visa_required) {
                formDataToSend.append('number_of_visas', parseInt(formData.number_of_visas));

                visaFiles.passportImages.forEach((file) => {
                    formDataToSend.append('passport_images[]', file);
                });
                visaFiles.applicantImages.forEach((file) => {
                    formDataToSend.append('applicant_images[]', file);
                });
                visaFiles.emiratesIdImages.forEach((file) => {
                    formDataToSend.append('emirates_id_images[]', file);
                });
            }

            const response = await bookingsAPI.create(formDataToSend);

            if (response.data.success) {
                const booking = response.data.booking;
                setBookingReference(booking.booking_reference);
                setBookingId(booking.id);

                // If payment method is Stripe, process payment directly
                if (paymentMethod === 'stripe') {
                    await processStripePayment(booking);
                } else {
                    // For cash/personal/later, show success immediately
                    setSuccess(true);
                    setTimeout(() => {
                        handleClose();
                    }, 5000);
                }
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

    const processStripePayment = async (booking) => {
        try {
            console.log('🔵 Processing Stripe payment...');

            // Validate Stripe is ready
            if (!stripeInstance || !stripeInstance.stripe || !stripeInstance.elements) {
                setError('Payment system not ready. Please wait a moment and try again.');
                return;
            }

            // Validate card data
            if (!stripeInstance.cardholderName || stripeInstance.cardholderName.trim() === '') {
                setError('Please enter cardholder name');
                return;
            }

            const totalAmount = calculateTotal();
            console.log('Total amount:', totalAmount);

            // Create payment intent
            console.log('Creating payment intent...');
            const response = await api.post('/stripe/create-payment-intent', {
                amount: totalAmount,
                booking_reference: booking.booking_reference,
            });

            console.log('Payment intent response:', response.data);

            if (response.data.success) {
                console.log('✅ Payment intent created!');
                const clientSecret = response.data.clientSecret;

                // Confirm payment with Stripe
                console.log('Confirming payment with Stripe...');
                const { error: stripeError, paymentIntent } = await stripeInstance.stripe.confirmCardPayment(
                    clientSecret,
                    {
                        payment_method: {
                            card: stripeInstance.elements.getElement(CardNumberElement),
                            billing_details: {
                                name: stripeInstance.cardholderName,
                            },
                        },
                    }
                );

                if (stripeError) {
                    console.error('❌ Stripe payment error:', stripeError);
                    setError(stripeError.message);
                    return;
                }

                if (paymentIntent.status === 'succeeded') {
                    console.log('✅ Payment successful!');

                    // Confirm payment with backend
                    await api.post('/stripe/confirm-payment', {
                        payment_intent_id: paymentIntent.id,
                        booking_id: booking.id,
                    });

                    setSuccess(true);
                    setTimeout(() => {
                        handleClose();
                    }, 5000);
                }
            } else {
                console.error('❌ Payment intent creation failed');
                setError('Failed to create payment intent.');
            }
        } catch (err) {
            console.error('❌ Payment error:', err);
            console.error('Error details:', err.response?.data);
            setError('Failed to process payment. Please try again.');
        }
    };

    const handlePaymentSuccess = async (paymentIntent) => {
        try {
            const response = await api.post('/stripe/confirm-payment', {
                payment_intent_id: paymentIntentId,
                booking_id: bookingId,
            });

            if (response.data.success) {
                setSuccess(true);
                setTimeout(() => {
                    handleClose();
                }, 5000);
            }
        } catch (err) {
            console.error('Payment confirmation error:', err);
            console.error('Error details:', err.response?.data);
            setError('Payment successful but confirmation failed. Please contact support.');
        }
    };

    const handlePaymentError = (errorMessage) => {
        setError(errorMessage);
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
            visa_required: false,
            number_of_visas: 0,
        });
        setPassengers([
            {
                type: 'adult',
                full_name_passport: '',
                date_of_birth: '',
                gender: '',
                nationality: '',
                passport_number: '',
                passport_expiration: '',
            }
        ]);
        setVisaFiles({
            passportImages: [],
            applicantImages: [],
            emiratesIdImages: [],
        });
        setErrors({});
        setError(null);
        setSuccess(false);
        setBookingReference('');
        setBookingId(null);
        setPaymentMethod('later');
        setClientSecret('');
        setPaymentIntentId('');
        setActiveSection('personal');
        onClose();
    };

    if (!isOpen) return null;

    const today = new Date().toISOString().split('T')[0];

    return (
        <div className="fixed inset-0 z-50 overflow-y-auto animate-fadeIn" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div className="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0"  style={{ paddingTop: '10%' }}>
                <div
                    className="fixed inset-0 bg-gradient-to-br from-slate-900/95 via-blue-900/90 to-purple-900/95 backdrop-blur-xl transition-all duration-500"
                    aria-hidden="true"
                    onClick={handleClose}
                ></div>

                <div className="inline-block align-bottom bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-6xl sm:w-full animate-slideUp mt-8">
                    {success ? (
                        <SuccessView bookingReference={bookingReference} onClose={handleClose} t={t} />
                    ) : (
                        <>
                            {/* Enhanced Header */}
                            <div className="bg-gradient-to-r from-blue-600 via-purple-600 to-indigo-700 px-8 py-8 relative overflow-hidden">
                                <div className="absolute inset-0 bg-black/10"></div>
                                <div className="absolute -top-24 -right-24 w-48 h-48 bg-white/10 rounded-full"></div>
                                <div className="absolute -bottom-24 -left-24 w-48 h-48 bg-white/10 rounded-full"></div>

                                <div className="relative flex items-center justify-between">
                                    <div className="flex-1">
                                        <div className="flex items-center mb-3">
                                            <div className="bg-white/20 p-3 rounded-2xl mr-4 backdrop-blur-sm">
                                                <svg className="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                            <div>
                                                <h3 className="text-4xl font-black text-white mb-1" id="modal-title">
                                                    {t('bookNow') || 'Secure Your Booking'}
                                                </h3>
                                                <div className="flex items-center text-blue-100">
                          <span className="bg-white/20 px-3 py-1 rounded-full text-sm font-medium backdrop-blur-sm">
                            {packageData?.title}
                          </span>
                                                    {packageData?.location && (
                                                        <span className="ml-3 flex items-center text-sm">
                              <svg className="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                              </svg>
                                                            {packageData.location}
                            </span>
                                                    )}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button
                                        onClick={handleClose}
                                        className="text-white hover:bg-white/20 transition-all p-3 rounded-2xl backdrop-blur-sm"
                                    >
                                        <svg className="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2.5" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>

                                {/* Progress Navigation */}
                                <div className="relative mt-6">
                                    <div className="flex space-x-2 justify-between">
                                        {sections.map((section, index) => {
                                            const isActive = activeSection === section.id;
                                            const isCompleted = sections.findIndex(s => s.id === activeSection) > index;
                                            return (
                                                <button
                                                    key={section.id}
                                                    onClick={() => setActiveSection(section.id)}
                                                    className={`flex-1 flex flex-col items-center p-3 rounded-2xl transition-all ${
                                                        isActive
                                                            ? 'bg-white/30 backdrop-blur-sm transform scale-105 shadow-lg'
                                                            : isCompleted
                                                                ? 'bg-white/20 hover:bg-white/30'
                                                                : 'bg-white/10 hover:bg-white/20'
                                                    }`}
                                                >
                                                    <span className="text-lg mb-1">{section.icon}</span>
                                                    <span className="text-xs font-semibold text-white">{section.label}</span>
                                                    {isCompleted && (
                                                        <div className="absolute -top-1 -right-1 w-4 h-4 bg-green-400 rounded-full flex items-center justify-center">
                                                            <svg className="h-3 w-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="3" d="M5 13l4 4L19 7" />
                                                            </svg>
                                                        </div>
                                                    )}
                                                </button>
                                            );
                                        })}
                                    </div>
                                </div>
                            </div>

                            <form onSubmit={handleSubmit} className="px-8 py-8 max-h-[70vh] overflow-y-auto bg-gradient-to-b from-slate-50 to-white">
                                {error && (
                                    <div className="mb-6 bg-red-50 border-l-4 border-red-500 text-red-700 px-6 py-4 rounded-r-2xl shadow-lg flex items-start animate-pulse">
                                        <svg className="h-6 w-6 text-red-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span className="font-medium">{error}</span>
                                    </div>
                                )}

                                {/* Personal Information Section */}
                                {activeSection === 'personal' && (
                                    <SectionBox
                                        title="Personal Information"
                                        icon="👤"
                                        description="Tell us about yourself"
                                    >
                                        <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                                            <InputField
                                                label="Full Name"
                                                name="customer_name"
                                                value={formData.customer_name}
                                                onChange={handleChange}
                                                error={errors.customer_name}
                                                required
                                                placeholder="John Doe"
                                            />
                                            <InputField
                                                label="Email"
                                                type="email"
                                                name="customer_email"
                                                value={formData.customer_email}
                                                onChange={handleChange}
                                                error={errors.customer_email}
                                                required
                                                placeholder="john@example.com"
                                            />
                                            <InputField
                                                label="Phone"
                                                type="tel"
                                                name="customer_phone"
                                                value={formData.customer_phone}
                                                onChange={handleChange}
                                                error={errors.customer_phone}
                                                required
                                                placeholder="+971 234 567 890"
                                            />
                                            <InputField
                                                label="Country"
                                                name="customer_country"
                                                value={formData.customer_country}
                                                onChange={handleChange}
                                                error={errors.customer_country}
                                                required
                                                placeholder="United Arab Emirates"
                                            />
                                        </div>
                                        <div className="mt-4">
                                            <InputField
                                                label="Address"
                                                type="textarea"
                                                name="customer_address"
                                                value={formData.customer_address}
                                                onChange={handleChange}
                                                rows="2"
                                                error={errors.customer_address}
                                                required
                                                placeholder="Enter your complete address"
                                            />
                                        </div>
                                    </SectionBox>
                                )}

                                {/* Travel Details Section */}
                                {activeSection === 'travel' && (
                                    <SectionBox
                                        title="Travel Details"
                                        icon="✈️"
                                        description="When are you traveling?"
                                    >
                                        <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                                            <InputField
                                                label="Travel Date"
                                                type="date"
                                                name="travel_date"
                                                value={formData.travel_date}
                                                onChange={handleChange}
                                                error={errors.travel_date}
                                                required
                                                min={today}
                                            />
                                            <InputField
                                                label="Return Date"
                                                type="date"
                                                name="return_date"
                                                value={formData.return_date}
                                                onChange={handleChange}
                                                min={formData.travel_date || today}
                                            />
                                            <InputField
                                                label="Adults"
                                                type="number"
                                                name="number_of_adults"
                                                value={formData.number_of_adults}
                                                onChange={handleChange}
                                                error={errors.number_of_adults}
                                                required
                                                min="1"
                                            />
                                            <InputField
                                                label="Children (less than 3 years)"
                                                type="number"
                                                name="number_of_children"
                                                value={formData.number_of_children}
                                                onChange={handleChange}
                                                min="0"
                                            />
                                            <InputField
                                                label="Infants"
                                                type="number"
                                                name="number_of_infants"
                                                value={formData.number_of_infants}
                                                onChange={handleChange}
                                                min="0"
                                            />
                                        </div>
                                        {packageData?.duration_days && (
                                            <div className="mt-4">
                                                <div className="bg-blue-50 border border-blue-200 rounded-2xl p-4">
                                                    <p className="text-sm text-blue-700 flex items-center">
                                                        <svg className="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                        Return date auto-calculated for {packageData.duration_days} day package
                                                    </p>
                                                </div>
                                            </div>
                                        )}
                                    </SectionBox>
                                )}

                                {/* Passenger Information Section */}
                                {activeSection === 'passengers' && (
                                    <SectionBox
                                        title="Passenger Information"
                                        icon="👥"
                                        description="Details for all travelers"
                                    >
                                        <div className="space-y-4">
                                            {passengers.map((passenger, index) => (
                                                <PassengerCard
                                                    key={index}
                                                    passenger={passenger}
                                                    index={index}
                                                    onChange={handlePassengerChange}
                                                    errors={errors}
                                                />
                                            ))}
                                        </div>
                                    </SectionBox>
                                )}

                                {/* Visa Services Section */}
                                {activeSection === 'visa' && packageData?.visa_price && (
                                    <SectionBox
                                        title="Visa Services"
                                        icon="📋"
                                        description="Optional visa processing"
                                    >
                                        <VisaSection
                                            formData={formData}
                                            onChange={handleChange}
                                            packageData={packageData}
                                            visaFiles={visaFiles}
                                            onFileChange={handleFileChange}
                                            onRemoveFile={removeFile}
                                            errors={errors}
                                        />
                                    </SectionBox>
                                )}

                                {/* Payment Method Section */}
                                {activeSection === 'payment' && (
                                    <SectionBox
                                        title="Payment Method"
                                        icon="💳"
                                        description="Choose how you want to pay"
                                    >
                                        <div className="space-y-4">
                                            <PaymentMethodOption
                                                id="stripe"
                                                title="Pay Now with Card"
                                                description="Secure payment via Stripe - Complete payment now"
                                                icon="💳"
                                                selected={paymentMethod === 'stripe'}
                                                onSelect={() => setPaymentMethod('stripe')}
                                                badge="Recommended"
                                                badgeColor="green"
                                            />
                                            <PaymentMethodOption
                                                id="cash"
                                                title="Cash Payment"
                                                description="Pay in cash when you arrive"
                                                icon="💵"
                                                selected={paymentMethod === 'cash'}
                                                onSelect={() => setPaymentMethod('cash')}
                                            />
                                            <PaymentMethodOption
                                                id="personal"
                                                title="Personal Payment"
                                                description="Arrange payment directly with us"
                                                icon="🤝"
                                                selected={paymentMethod === 'personal'}
                                                onSelect={() => setPaymentMethod('personal')}
                                            />
                                            <PaymentMethodOption
                                                id="later"
                                                title="Pay Later"
                                                description="Complete booking and pay later - You can edit booking details before payment"
                                                icon="⏰"
                                                selected={paymentMethod === 'later'}
                                                onSelect={() => setPaymentMethod('later')}
                                                badge="Flexible"
                                                badgeColor="blue"
                                            />
                                        </div>
                                        {errors.paymentMethod && (
                                            <p className="mt-4 text-sm text-red-500 flex items-center">
                                                <svg className="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                {errors.paymentMethod}
                                            </p>
                                        )}
                                    </SectionBox>
                                )}

                                {/* Debug Info */}
                                {activeSection === 'stripe-payment' && !clientSecret && (
                                    <div className="bg-yellow-50 border-2 border-yellow-300 rounded-2xl p-6 mb-6">
                                        <h4 className="text-lg font-bold text-yellow-800 mb-2">⚠️ Debug Information</h4>
                                        <p className="text-yellow-700">Active Section: {activeSection}</p>
                                        <p className="text-yellow-700">Client Secret: {clientSecret ? 'Present' : 'Missing'}</p>
                                        <p className="text-yellow-700">Booking ID: {bookingId}</p>
                                        <p className="text-yellow-700 mt-2">Waiting for payment intent...</p>
                                    </div>
                                )}

                                {/* Stripe Payment Section */}
                                {activeSection === 'stripe-payment' && clientSecret && (
                                    <SectionBox
                                        title="Complete Payment"
                                        icon="🔒"
                                        description="Enter your card details to complete the booking"
                                    >
                                        <Elements stripe={stripePromise} options={{ clientSecret }}>
                                            <StripePaymentForm
                                                clientSecret={clientSecret}
                                                amount={calculateTotal()}
                                                onSuccess={handlePaymentSuccess}
                                                onError={handlePaymentError}
                                                bookingId={bookingId}
                                            />
                                        </Elements>
                                    </SectionBox>
                                )}

                                {/* Review & Confirm Section */}
                                {activeSection === 'review' && (
                                    <SectionBox
                                        title="Review & Payment"
                                        icon="💰"
                                        description="Finalize your booking"
                                    >
                                        <div className="space-y-6">
                                            <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                                                <SummaryCard
                                                    title="Personal Details"
                                                    items={[
                                                        { label: 'Name', value: formData.customer_name },
                                                        { label: 'Email', value: formData.customer_email },
                                                        { label: 'Phone', value: formData.customer_phone },
                                                        { label: 'Country', value: formData.customer_country },
                                                    ]}
                                                />
                                                <SummaryCard
                                                    title="Travel Details"
                                                    items={[
                                                        { label: 'Travel Date', value: formData.travel_date },
                                                        { label: 'Return Date', value: formData.return_date },
                                                        { label: 'Passengers', value: `${formData.number_of_adults} Adults, ${formData.number_of_children} Children, ${formData.number_of_infants} Infants` },
                                                    ]}
                                                />
                                            </div>

                                            <PricingSummary
                                                packageData={packageData}
                                                formData={formData}
                                                calculateTotal={calculateTotal}
                                            />

                                            <InputField
                                                label="Special Requests"
                                                type="textarea"
                                                name="special_requests"
                                                value={formData.special_requests}
                                                onChange={handleChange}
                                                rows="3"
                                                placeholder="Any special requests or requirements?"
                                            />

                                            {/* Show Stripe Payment Form if Stripe is selected */}
                                            {paymentMethod === 'stripe' && (
                                                <div className="mt-6">
                                                    <div className="bg-gradient-to-r from-blue-50 to-indigo-50 border-2 border-blue-200 rounded-2xl p-6 mb-4">
                                                        <h4 className="text-lg font-bold text-slate-800 mb-2 flex items-center">
                                                            <svg className="h-6 w-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                                            </svg>
                                                            Payment Details
                                                        </h4>
                                                        <p className="text-sm text-slate-600">Enter your card information to complete the payment</p>
                                                    </div>

                                                    {!import.meta.env.VITE_STRIPE_PUBLISHABLE_KEY ? (
                                                        <div className="bg-red-50 border-2 border-red-300 rounded-2xl p-6">
                                                            <h4 className="text-lg font-bold text-red-800 mb-2">⚠️ Stripe Not Configured</h4>
                                                            <p className="text-red-700 mb-2">
                                                                Stripe publishable key is missing. Please add it to your .env file:
                                                            </p>
                                                            <code className="block bg-red-100 p-2 rounded text-sm text-red-900">
                                                                VITE_STRIPE_PUBLISHABLE_KEY="pk_test_..."
                                                            </code>
                                                            <p className="text-red-700 mt-2 text-sm">
                                                                Then rebuild: <code className="bg-red-100 px-2 py-1 rounded">npm run build</code>
                                                            </p>
                                                        </div>
                                                    ) : (
                                                        <Elements stripe={stripePromise}>
                                                            <StripePaymentFields
                                                                onCardChange={(data) => setCardData(prev => ({ ...prev, ...data }))}
                                                                onStripeReady={(stripeData) => setStripeInstance(stripeData)}
                                                                errors={errors}
                                                            />
                                                        </Elements>
                                                    )}
                                                </div>
                                            )}

                                            {/* Payment Method Summary */}
                                            {paymentMethod !== 'stripe' && paymentMethod !== 'later' && (
                                                <div className="bg-green-50 border-2 border-green-200 rounded-2xl p-6">
                                                    <h4 className="text-lg font-bold text-green-800 mb-2">✅ Payment Method Selected</h4>
                                                    <p className="text-green-700">
                                                        {paymentMethod === 'cash' && 'You will pay in cash when you arrive.'}
                                                        {paymentMethod === 'personal' && 'Payment will be arranged directly with us.'}
                                                    </p>
                                                </div>
                                            )}

                                            {paymentMethod === 'later' && (
                                                <div className="bg-blue-50 border-2 border-blue-200 rounded-2xl p-6">
                                                    <h4 className="text-lg font-bold text-blue-800 mb-2">⏰ Pay Later Selected</h4>
                                                    <p className="text-blue-700">
                                                        You can complete payment later and edit your booking details before payment.
                                                    </p>
                                                </div>
                                            )}
                                        </div>
                                    </SectionBox>
                                )}

                                {/* Navigation Buttons */}
                                <div className="mt-8 flex gap-4">
                                    <button
                                        type="button"
                                        onClick={handleClose}
                                        className="flex-1 bg-slate-200 hover:bg-slate-300 text-slate-800 px-6 py-4 rounded-2xl font-bold text-lg transition-all transform hover:scale-105 shadow-lg"
                                    >
                                        {t('cancel') || 'Cancel'}
                                    </button>

                                    {/* Back Button - Show except on first section */}
                                    {!isFirstSection() && (
                                        <button
                                            type="button"
                                            onClick={handleBack}
                                            className="flex-1 bg-slate-500 hover:bg-slate-600 text-white px-6 py-4 rounded-2xl font-bold text-lg transition-all transform hover:scale-105 shadow-lg flex items-center justify-center"
                                        >
                                            <svg className="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M15 19l-7-7 7-7" />
                                            </svg>
                                            Back
                                        </button>
                                    )}

                                    {/* Next Button - Show except on last section */}
                                    {!isLastSection() && (
                                        <button
                                            type="button"
                                            onClick={handleNextWithValidation}
                                            className="flex-1 bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 text-white px-6 py-4 rounded-2xl font-bold text-lg transition-all transform hover:scale-105 shadow-lg flex items-center justify-center"
                                        >
                                            Next
                                            <svg className="h-5 w-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M9 5l7 7-7 7" />
                                            </svg>
                                        </button>
                                    )}

                                    {/* Confirm Booking Button - Show only on last section */}
                                    {isLastSection() && (
                                        <button
                                            type="submit"
                                            disabled={loading}
                                            className="flex-1 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white px-6 py-4 rounded-2xl font-bold text-lg transition-all transform hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none flex items-center justify-center shadow-xl"
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
                                                <>
                                                    <svg className="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M5 13l4 4L19 7" />
                                                    </svg>
                                                    {t('confirmBooking') || 'Confirm Booking'}
                                                </>
                                            )}
                                        </button>
                                    )}
                                </div>
                            </form>
                        </>
                    )}
                </div>
            </div>
        </div>
    );
}

// Reusable Section Component
const SectionBox = ({ title, icon, description, children }) => (
    <div className="bg-white border-2 border-slate-200 rounded-3xl p-8 shadow-lg mb-6 hover:shadow-xl transition-all duration-300">
        <div className="flex items-center mb-6">
            <div className="bg-gradient-to-r from-blue-500 to-purple-600 p-3 rounded-2xl mr-4">
                <span className="text-2xl">{icon}</span>
            </div>
            <div>
                <h4 className="text-2xl font-black text-slate-800">{title}</h4>
                <p className="text-slate-600 mt-1">{description}</p>
            </div>
        </div>
        {children}
    </div>
);

// Reusable Input Field Component
const InputField = ({ label, type = 'text', name, value, onChange, error, required, placeholder, options, ...props }) => (
    <div>
        <label className="block text-sm font-bold text-slate-700 mb-2">
            {label} {required && <span className="text-red-500">*</span>}
        </label>
        {type === 'textarea' ? (
            <textarea
                name={name}
                value={value}
                onChange={onChange}
                className={`w-full px-4 py-3 border-2 rounded-2xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all ${
                    error ? 'border-red-500 bg-red-50' : 'border-slate-200 hover:border-slate-300'
                }`}
                placeholder={placeholder}
                {...props}
            />
        ) : type === 'select' ? (
            <select
                name={name}
                value={value}
                onChange={onChange}
                className={`w-full px-4 py-3 border-2 rounded-2xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all ${
                    error ? 'border-red-500 bg-red-50' : 'border-slate-200 hover:border-slate-300'
                }`}
                {...props}
            >
                {options?.map(option => (
                    <option key={option.value} value={option.value}>
                        {option.label}
                    </option>
                ))}
            </select>
        ) : (
            <input
                type={type}
                name={name}
                value={value}
                onChange={onChange}
                className={`w-full px-4 py-3 border-2 rounded-2xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all ${
                    error ? 'border-red-500 bg-red-50' : 'border-slate-200 hover:border-slate-300'
                }`}
                placeholder={placeholder}
                {...props}
            />
        )}
        {error && (
            <p className="mt-2 text-sm text-red-500 flex items-center">
                <svg className="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                {error}
            </p>
        )}
    </div>
);

// Passenger Card Component
const PassengerCard = ({ passenger, index, onChange, errors }) => (
    <div className="bg-gradient-to-r from-amber-50 to-orange-50 border-2 border-amber-200 rounded-3xl p-6 hover:shadow-lg transition-all">
        <div className="flex items-center justify-between mb-4">
            <h5 className="text-lg font-bold text-slate-800 flex items-center">
        <span className="bg-amber-500 text-white rounded-2xl w-8 h-8 flex items-center justify-center mr-3 text-sm font-black">
          {index + 1}
        </span>
                {passenger.type === 'adult' ? '👨‍💼 Adult' : '👶 Child'} Passenger
            </h5>
        </div>

        <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
            <InputField
                label="Full Name (as per passport)"
                value={passenger.full_name_passport}
                onChange={(e) => onChange(index, 'full_name_passport', e.target.value)}
                error={errors[`passenger_${index}_name`]}
                required
                placeholder="Enter full name"
            />
            <InputField
                label="Date of Birth"
                type="date"
                value={passenger.date_of_birth}
                onChange={(e) => onChange(index, 'date_of_birth', e.target.value)}
                error={errors[`passenger_${index}_dob`]}
                required
            />
            <InputField
                label="Gender"
                type="select"
                value={passenger.gender}
                onChange={(e) => onChange(index, 'gender', e.target.value)}
                error={errors[`passenger_${index}_gender`]}
                required
                options={[
                    { value: '', label: 'Select Gender' },
                    { value: 'male', label: 'Male' },
                    { value: 'female', label: 'Female' },
                    { value: 'other', label: 'Other' },
                ]}
            />
            <InputField
                label="Nationality"
                value={passenger.nationality}
                onChange={(e) => onChange(index, 'nationality', e.target.value)}
                error={errors[`passenger_${index}_nationality`]}
                required
                placeholder="Enter nationality"
            />
            <InputField
                label="Passport Number"
                value={passenger.passport_number}
                onChange={(e) => onChange(index, 'passport_number', e.target.value)}
                error={errors[`passenger_${index}_passport`]}
                required
                placeholder="Enter passport number"
            />
            <InputField
                label="Passport Expiration"
                type="date"
                value={passenger.passport_expiration}
                onChange={(e) => onChange(index, 'passport_expiration', e.target.value)}
                error={errors[`passenger_${index}_passport_exp`]}
                required
                min={new Date().toISOString().split('T')[0]}
            />
        </div>
    </div>
);

// Visa Section Component
const VisaSection = ({ formData, onChange, packageData, visaFiles, onFileChange, onRemoveFile, errors }) => (
    <div className="space-y-6">
        <div className="flex items-center justify-between p-4 bg-teal-50 border-2 border-teal-200 rounded-2xl">
            <div>
                <h5 className="font-bold text-teal-800">Visa Processing Service</h5>
                <p className="text-teal-600 text-sm">${parseFloat(packageData.visa_price).toFixed(2)} per person</p>
            </div>
            <label className="flex items-center cursor-pointer">
                <div className="relative">
                    <input
                        type="checkbox"
                        id="visa_required"
                        name="visa_required"
                        checked={formData.visa_required}
                        onChange={onChange}
                        className="sr-only"
                    />
                    <div className={`block w-14 h-8 rounded-full transition-all ${
                        formData.visa_required ? 'bg-teal-500' : 'bg-slate-300'
                    }`}></div>
                    <div className={`dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition-transform ${
                        formData.visa_required ? 'transform translate-x-6' : ''
                    }`}></div>
                </div>
                <span className="ml-3 text-slate-700 font-medium">Require Visa</span>
            </label>
        </div>

        {formData.visa_required && (
            <div className="space-y-6 animate-slideDown">
                <InputField
                    label="Number of Visas Required"
                    type="number"
                    name="number_of_visas"
                    value={formData.number_of_visas}
                    onChange={onChange}
                    error={errors.number_of_visas}
                    min="1"
                    required
                />

                <FileUploadSection
                    title="Passport Images"
                    fileType="passportImages"
                    files={visaFiles.passportImages}
                    onFileChange={onFileChange}
                    onRemoveFile={onRemoveFile}
                    error={errors.passportImages}
                    icon="📄"
                />

                <FileUploadSection
                    title="Applicant Photos"
                    fileType="applicantImages"
                    files={visaFiles.applicantImages}
                    onFileChange={onFileChange}
                    onRemoveFile={onRemoveFile}
                    error={errors.applicantImages}
                    icon="📷"
                />

                <FileUploadSection
                    title="Emirates ID Images"
                    fileType="emiratesIdImages"
                    files={visaFiles.emiratesIdImages}
                    onFileChange={onFileChange}
                    onRemoveFile={onRemoveFile}
                    error={errors.emiratesIdImages}
                    icon="🆔"
                />
            </div>
        )}
    </div>
);

// File Upload Component
const FileUploadSection = ({ title, fileType, files, onFileChange, onRemoveFile, error, icon }) => (
    <div>
        <label className="block text-sm font-bold text-slate-700 mb-3">
            <span className="mr-2">{icon}</span>
            {title} <span className="text-red-500 text-sm font-normal">* (JPEG, JPG, PNG - 5MB max per file)</span>
        </label>
        <div className={`border-2 border-dashed rounded-2xl p-6 transition-all ${
            error ? 'border-red-300 bg-red-50' : 'border-teal-300 bg-teal-50/50 hover:border-teal-500'
        }`}>
            <input
                type="file"
                accept="image/*"
                multiple
                onChange={(e) => onFileChange(e, fileType)}
                className="hidden"
                id={fileType}
            />
            <label htmlFor={fileType} className="cursor-pointer flex flex-col items-center">
                <svg className="h-12 w-12 text-teal-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                </svg>
                <span className="text-sm text-slate-600 font-medium">Click to upload {title.toLowerCase()}</span>
                <span className="text-xs text-slate-500 mt-1">Drag & drop files here or click to browse</span>
            </label>
        </div>

        {error && (
            <p className="mt-2 text-sm text-red-500 flex items-center">
                <svg className="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                {error}
            </p>
        )}

        {files.length > 0 && (
            <div className="mt-4 space-y-2">
                {files.map((file, index) => (
                    <div key={index} className="flex items-center justify-between bg-white p-3 rounded-xl border border-slate-200">
                        <div className="flex items-center flex-1">
                            <svg className="h-5 w-5 text-teal-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <span className="text-sm text-slate-700 truncate">{file.name}</span>
                        </div>
                        <button
                            type="button"
                            onClick={() => onRemoveFile(fileType, index)}
                            className="ml-2 text-red-500 hover:text-red-700 p-1 rounded-lg hover:bg-red-50 transition-colors"
                        >
                            <svg className="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                ))}
            </div>
        )}
    </div>
);

// Success View Component
const SuccessView = ({ bookingReference, onClose, t }) => (
    <div className="p-12 text-center bg-gradient-to-br from-green-50 via-blue-50 to-purple-50">
        <div className="mx-auto flex items-center justify-center h-32 w-32 rounded-full bg-gradient-to-br from-green-400 to-emerald-600 mb-8 shadow-2xl animate-bounce">
            <svg className="h-16 w-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="3" d="M5 13l4 4L19 7" />
            </svg>
        </div>
        <h3 className="text-5xl font-black text-transparent bg-clip-text bg-gradient-to-r from-green-600 to-blue-600 mb-4">
            {t('bookingSuccess') || 'Booking Confirmed!'}
        </h3>
        <p className="text-xl text-slate-600 mb-8 max-w-md mx-auto leading-relaxed">
            {t('bookingSuccessMessage') || 'Your adventure has been successfully booked. Get ready for an amazing experience!'}
        </p>

        <div className="bg-white border-2 border-blue-200 rounded-3xl p-8 mb-8 shadow-2xl max-w-md mx-auto transform hover:scale-105 transition-transform">
            <div className="flex items-center justify-center mb-4">
                <svg className="h-8 w-8 text-blue-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <p className="text-lg font-bold text-slate-600">{t('bookingReference') || 'Booking Reference'}</p>
            </div>
            <p className="text-4xl font-black text-blue-600 tracking-wider font-mono">{bookingReference}</p>
        </div>

        <div className="bg-blue-100 border border-blue-300 rounded-2xl p-6 mb-8 max-w-md mx-auto">
            <p className="text-blue-800 flex items-center justify-center text-lg">
                <svg className="h-6 w-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                {t('bookingConfirmationEmail') || 'A confirmation email has been sent to your email address.'}
            </p>
        </div>

        <button
            onClick={onClose}
            className="bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white px-12 py-4 rounded-2xl font-bold text-lg transition-all transform hover:scale-105 shadow-xl"
        >
            {t('close') || 'Close Window'}
        </button>
    </div>
);

// Summary Card Component
const SummaryCard = ({ title, items }) => (
    <div className="bg-slate-50 border-2 border-slate-200 rounded-2xl p-6">
        <h5 className="font-bold text-slate-800 mb-4 text-lg">{title}</h5>
        <div className="space-y-3">
            {items.map((item, index) => (
                <div key={index} className="flex justify-between">
                    <span className="text-slate-600">{item.label}:</span>
                    <span className="font-semibold text-slate-800">{item.value || 'Not provided'}</span>
                </div>
            ))}
        </div>
    </div>
);

// Payment Method Option Component
const PaymentMethodOption = ({ id, title, description, icon, selected, onSelect, badge, badgeColor }) => (
    <div
        onClick={onSelect}
        className={`relative border-2 rounded-2xl p-6 cursor-pointer transition-all transform hover:scale-102 ${
            selected
                ? 'border-blue-500 bg-blue-50 shadow-lg'
                : 'border-slate-200 bg-white hover:border-blue-300 hover:shadow-md'
        }`}
    >
        <div className="flex items-start">
            <div className={`text-4xl mr-4 ${selected ? 'scale-110' : ''} transition-transform`}>
                {icon}
            </div>
            <div className="flex-1">
                <div className="flex items-center justify-between mb-2">
                    <h5 className={`text-lg font-bold ${selected ? 'text-blue-700' : 'text-slate-800'}`}>
                        {title}
                    </h5>
                    {badge && (
                        <span className={`px-3 py-1 rounded-full text-xs font-bold ${
                            badgeColor === 'green'
                                ? 'bg-green-100 text-green-700'
                                : 'bg-blue-100 text-blue-700'
                        }`}>
                            {badge}
                        </span>
                    )}
                </div>
                <p className={`text-sm ${selected ? 'text-blue-600' : 'text-slate-600'}`}>
                    {description}
                </p>
            </div>
            <div className={`ml-4 flex-shrink-0 w-6 h-6 rounded-full border-2 flex items-center justify-center ${
                selected
                    ? 'border-blue-500 bg-blue-500'
                    : 'border-slate-300'
            }`}>
                {selected && (
                    <svg className="h-4 w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="3" d="M5 13l4 4L19 7" />
                    </svg>
                )}
            </div>
        </div>
    </div>
);

// Pricing Summary Component
const PricingSummary = ({ packageData, formData, calculateTotal }) => (
    <div className="bg-gradient-to-br from-blue-50 via-purple-50 to-indigo-50 border-2 border-blue-200 rounded-3xl p-8 shadow-lg">
        <h5 className="text-xl font-black text-slate-800 mb-6 flex items-center">
            <svg className="h-6 w-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
            </svg>
            Price Breakdown
        </h5>

        <div className="space-y-4">
            <div className="flex justify-between items-center py-3 border-b border-blue-200">
                <span className="text-slate-700">Package Price</span>
                <span className="font-semibold text-slate-900">${parseFloat(packageData?.price || 0).toFixed(2)}</span>
            </div>

            <div className="flex justify-between items-center py-3 border-b border-blue-200">
                <span className="text-slate-700">Adults ({formData.number_of_adults})</span>
                <span className="font-semibold text-slate-900">
          ${(formData.number_of_adults * parseFloat(packageData?.price || 0)).toFixed(2)}
        </span>
            </div>

            {formData.number_of_children > 0 && (
                <div className="flex justify-between items-center py-3 border-b border-blue-200">
                    <span className="text-slate-700">Children ({formData.number_of_children})</span>
                    <span className="font-semibold text-slate-900">
            ${(formData.number_of_children * parseFloat(packageData?.price || 0) * 0.5).toFixed(2)}
          </span>
                </div>
            )}

            {formData.visa_required && packageData?.visa_price && (
                <div className="flex justify-between items-center py-3 border-b border-blue-200 bg-teal-50 rounded-xl px-4">
          <span className="text-teal-700 font-medium">
            Visa Cost ({formData.number_of_visas} × ${parseFloat(packageData.visa_price).toFixed(2)})
          </span>
                    <span className="font-bold text-teal-700">
            ${(parseInt(formData.number_of_visas || 0) * parseFloat(packageData.visa_price)).toFixed(2)}
          </span>
                </div>
            )}

            <div className="border-t-2 border-blue-300 pt-6 mt-4">
                <div className="flex justify-between items-center bg-white rounded-2xl p-6 shadow-sm">
                    <span className="text-2xl font-black text-slate-900">Total Amount</span>
                    <span className="text-4xl font-black bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
            ${calculateTotal().toFixed(2)}
          </span>
                </div>
            </div>
        </div>
    </div>
);

export default BookingModal;
