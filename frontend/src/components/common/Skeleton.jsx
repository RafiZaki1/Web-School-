import React from 'react';

export const Skeleton = ({ className = '', variant = 'rect' }) => {
  const baseClasses = 'animate-pulse bg-slate-200';
  
  if (variant === 'circle') {
    return <div className={`${baseClasses} rounded-full ${className}`} />;
  }
  
  if (variant === 'text') {
    return <div className={`${baseClasses} h-4 rounded ${className}`} />;
  }

  return <div className={`${baseClasses} rounded-xl ${className}`} />;
};

export default Skeleton;
