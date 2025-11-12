import React, { useState, useEffect } from 'react';
import { CardNumberElement, CardExpiryElement, CardCvcElement, useStripe, useElements } from '@stripe/react-stripe-js';

const StripePaymentFields = ({ onCardChange, errors, onStripeReady }) => {
    const stripe = useStripe();
    const elements = useElements();
    const [cardholderName, setCardholderName] = useState('');
    const [cardErrors, setCardErrors] = useState({});
    const [isReady, setIsReady] = useState(false);

    // Pass stripe and elements to parent when ready
    useEffect(() => {
        if (stripe && elements) {
            console.log('✅ Stripe is ready!');
            setIsReady(true);
            if (onStripeReady) {
                onStripeReady({ stripe, elements, cardholderName });
            }
        } else {
            console.log('⏳ Waiting for Stripe to load...');
        }
    }, [stripe, elements, cardholderName, onStripeReady]);

    // Show loading state if Stripe not ready
    if (!stripe || !elements) {
        return (
            <div className="text-center py-8">
                <div className="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
                <p className="mt-4 text-slate-600">Loading payment form...</p>
            </div>
        );
    }

    const cardElementOptions = {
        style: {
            base: {
                fontSize: '16px',
                color: '#1e293b',
                fontFamily: '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif',
                fontWeight: '400',
                '::placeholder': {
                    color: '#94a3b8',
                },
                iconColor: '#1e293b',
            },
            invalid: {
                color: '#ef4444',
                iconColor: '#ef4444',
            },
            complete: {
                color: '#059669',
                iconColor: '#059669',
            },
        },
        disabled: false,
        hidePostalCode: true,
    };

    const handleCardholderNameChange = (e) => {
        const name = e.target.value;
        setCardholderName(name);
        onCardChange({ cardholderName: name });
    };

    const handleCardElementChange = (elementType) => (event) => {
        if (event.error) {
            setCardErrors(prev => ({ ...prev, [elementType]: event.error.message }));
        } else {
            setCardErrors(prev => {
                const newErrors = { ...prev };
                delete newErrors[elementType];
                return newErrors;
            });
        }
        onCardChange({ [elementType]: event.complete });
    };

    return (
        <div className="space-y-4">
            {/* Cardholder Name */}
            <div>
                <label className="block text-sm font-bold text-slate-700 mb-2">
                    Cardholder Name *
                </label>
                <input
                    type="text"
                    value={cardholderName}
                    onChange={handleCardholderNameChange}
                    placeholder="John Doe"
                    className="w-full px-4 py-3 border-2 border-slate-200 rounded-xl focus:border-blue-500 focus:outline-none transition-colors"
                    required
                />
                {errors?.cardholderName && (
                    <p className="mt-1 text-sm text-red-500">{errors.cardholderName}</p>
                )}
            </div>

            {/* Card Number */}
            <div>
                <label className="block text-sm font-bold text-slate-700 mb-2">
                    Card Number *
                </label>
                <div className="w-full px-4 py-3 border-2 border-slate-200 rounded-xl focus-within:border-blue-500 transition-colors bg-white">
                    <CardNumberElement
                        options={cardElementOptions}
                        onChange={handleCardElementChange('cardNumber')}
                    />
                </div>
                {cardErrors.cardNumber && (
                    <p className="mt-1 text-sm text-red-500">{cardErrors.cardNumber}</p>
                )}
            </div>

            {/* Card Expiry and CVC */}
            <div className="grid grid-cols-2 gap-4">
                {/* Card Expiry */}
                <div>
                    <label className="block text-sm font-bold text-slate-700 mb-2">
                        Expiry Date *
                    </label>
                    <div className="w-full px-4 py-3 border-2 border-slate-200 rounded-xl focus-within:border-blue-500 transition-colors bg-white">
                        <CardExpiryElement
                            options={cardElementOptions}
                            onChange={handleCardElementChange('cardExpiry')}
                        />
                    </div>
                    {cardErrors.cardExpiry && (
                        <p className="mt-1 text-sm text-red-500">{cardErrors.cardExpiry}</p>
                    )}
                </div>

                {/* CVC */}
                <div>
                    <label className="block text-sm font-bold text-slate-700 mb-2">
                        CVC *
                    </label>
                    <div className="w-full px-4 py-3 border-2 border-slate-200 rounded-xl focus-within:border-blue-500 transition-colors bg-white">
                        <CardCvcElement
                            options={cardElementOptions}
                            onChange={handleCardElementChange('cardCvc')}
                        />
                    </div>
                    {cardErrors.cardCvc && (
                        <p className="mt-1 text-sm text-red-500">{cardErrors.cardCvc}</p>
                    )}
                </div>
            </div>

            {/* Security Badge */}
            <div className="flex items-center justify-center text-sm text-slate-500 pt-2">
                <svg className="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
                Secured by Stripe - Your payment information is encrypted
            </div>
        </div>
    );
};

export default StripePaymentFields;
