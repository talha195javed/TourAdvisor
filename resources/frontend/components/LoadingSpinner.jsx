import React from 'react';

function LoadingSpinner({ size = 'md' }) {
  const sizeClasses = {
    sm: 'h-8 w-8',
    md: 'h-16 w-16',
    lg: 'h-24 w-24',
  };

  return (
    <div className="flex justify-center items-center py-20">
      <div className={`animate-spin rounded-full border-t-4 border-b-4 border-blue-600 ${sizeClasses[size]}`}></div>
    </div>
  );
}

export default LoadingSpinner;
