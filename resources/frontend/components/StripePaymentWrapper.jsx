import React from 'react';
import { Elements } from '@stripe/react-stripe-js';
import StripePaymentFields from './StripePaymentFields';

const StripePaymentWrapper = ({ stripePromise, onCardChange, errors }) => {
    return (
        <Elements stripe={stripePromise}>
            <StripePaymentFields
                onCardChange={onCardChange}
                errors={errors}
            />
        </Elements>
    );
};

export default StripePaymentWrapper;
