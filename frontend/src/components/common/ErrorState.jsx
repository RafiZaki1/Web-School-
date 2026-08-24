import React from 'react';
import { AlertCircle, RefreshCw } from 'lucide-react';

export const ErrorState = ({
  title = 'Gagal Memuat Data',
  message = 'Terjadi kendala saat menghubungkan ke server. Silakan coba kembali.',
  onRetry,
}) => {
  return (
    <div className="flex flex-col items-center justify-center p-8 text-center bg-rose-50/70 border border-rose-200/80 rounded-2xl">
      <div className="w-12 h-12 flex items-center justify-center rounded-full bg-rose-100 text-rose-600 mb-4">
        <AlertCircle className="w-6 h-6" />
      </div>
      <h4 className="text-lg font-semibold text-slate-800 mb-1">{title}</h4>
      <p className="text-sm text-slate-600 max-w-md mb-5">{message}</p>
      {onRetry && (
        <button
          onClick={onRetry}
          className="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-rose-600 hover:bg-rose-700 active:scale-95 transition-all rounded-lg shadow-sm shadow-rose-200 cursor-pointer"
        >
          <RefreshCw className="w-4 h-4" />
          Coba Lagi
        </button>
      )}
    </div>
  );
};

export default ErrorState;
