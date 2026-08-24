import React, { useEffect } from 'react';
import {
  X,
  Monitor,
  Tv,
  Wind,
  Wifi,
  Table,
  Armchair,
  BookOpen,
  Package,
} from 'lucide-react';
import Skeleton from '../common/Skeleton';

const getFacilityIcon = (iconName = '') => {
  const normalized = iconName.toLowerCase().trim();

  switch (normalized) {
    case 'computer':
    case 'monitor':
    case 'laptop':
      return Monitor;
    case 'projector':
    case 'screen':
    case 'tv':
      return Tv;
    case 'air-conditioner':
    case 'ac':
    case 'fan':
      return Wind;
    case 'wifi':
    case 'network':
    case 'internet':
      return Wifi;
    case 'table':
    case 'desk':
      return Table;
    case 'chair':
    case 'armchair':
    case 'seat':
      return Armchair;
    case 'book':
    case 'bookshelf':
    case 'library':
      return BookOpen;
    default:
      return Package;
  }
};

export const FacilityModal = ({
  isOpen,
  onClose,
  room,
  facilities = [],
  isLoading,
}) => {
  useEffect(() => {
    const handleKeyDown = (e) => {
      if (e.key === 'Escape') onClose();
    };
    if (isOpen) {
      window.addEventListener('keydown', handleKeyDown);
      document.body.style.overflow = 'hidden';
    }
    return () => {
      window.removeEventListener('keydown', handleKeyDown);
      document.body.style.overflow = 'unset';
    };
  }, [isOpen, onClose]);

  if (!isOpen) return null;

  return (
    <div className="fixed inset-0 z-50 flex items-center justify-center p-4 overflow-y-auto">
      {/* Backdrop */}
      <div
        onClick={onClose}
        className="fixed inset-0 bg-slate-900/60 backdrop-blur-xs transition-opacity"
      />

      {/* Modal Dialog */}
      <div className="relative w-full max-w-xl bg-white rounded-2xl shadow-xl border border-slate-200 overflow-hidden z-10 my-8">
        
        {/* Header */}
        <div className="flex items-center justify-between p-5 border-b border-slate-100 bg-slate-50">
          <div>
            <span className="text-[11px] font-bold text-blue-600 uppercase tracking-wider">Inventaris Ruangan</span>
            <h3 className="text-lg font-bold text-slate-900 mt-0.5">
              {room?.name || 'Fasilitas Ruangan'}
            </h3>
            <p className="text-xs text-slate-500">{room?.building_name}</p>
          </div>

          <button
            onClick={onClose}
            className="w-8 h-8 rounded-lg bg-white hover:bg-slate-200 text-slate-500 hover:text-slate-800 flex items-center justify-center transition-colors border border-slate-200 cursor-pointer"
            aria-label="Tutup Modal"
          >
            <X className="w-4 h-4" />
          </button>
        </div>

        {/* Body */}
        <div className="p-5 max-h-[60vh] overflow-y-auto custom-scrollbar">
          {isLoading ? (
            <div className="space-y-3">
              {[1, 2, 3, 4].map((i) => (
                <div key={i} className="flex items-center gap-3 p-3 rounded-xl border border-slate-100">
                  <Skeleton className="w-10 h-10 rounded-lg flex-shrink-0" />
                  <div className="w-full space-y-1.5">
                    <Skeleton className="h-4 w-1/3" />
                    <Skeleton className="h-3 w-2/3" />
                  </div>
                </div>
              ))}
            </div>
          ) : facilities.length === 0 ? (
            <div className="text-center py-10">
              <Package className="w-10 h-10 text-slate-300 mx-auto mb-2" />
              <h4 className="text-sm font-semibold text-slate-700">Tidak Ada Fasilitas Terdaftar</h4>
              <p className="text-xs text-slate-500 mt-0.5">
                Data inventaris ruangan ini belum dicatat dalam sistem.
              </p>
            </div>
          ) : (
            <div className="grid grid-cols-1 sm:grid-cols-2 gap-3">
              {facilities.map((facility) => {
                const IconComponent = getFacilityIcon(facility.icon || facility.name);
                return (
                  <div
                    key={facility.id}
                    className="p-3 rounded-xl bg-slate-50 border border-slate-200/80 flex items-start gap-3"
                  >
                    <div className="w-9 h-9 rounded-lg bg-white border border-slate-200 text-blue-600 flex items-center justify-center flex-shrink-0 mt-0.5 shadow-2xs">
                      <IconComponent className="w-4 h-4" />
                    </div>

                    <div className="flex-1 min-w-0">
                      <div className="flex items-center justify-between gap-1">
                        <h4 className="text-xs font-bold text-slate-800 truncate">
                          {facility.name}
                        </h4>
                        {facility.quantity !== null && facility.quantity !== undefined && (
                          <span className="px-2 py-0.5 rounded bg-blue-50 text-blue-700 text-[11px] font-bold flex-shrink-0">
                            {facility.quantity} unit
                          </span>
                        )}
                      </div>

                      {facility.description && (
                        <p className="text-[11px] text-slate-500 mt-0.5 leading-snug line-clamp-2">
                          {facility.description}
                        </p>
                      )}
                    </div>
                  </div>
                );
              })}
            </div>
          )}
        </div>

        {/* Footer */}
        <div className="p-4 bg-slate-50 border-t border-slate-100 flex justify-end">
          <button
            onClick={onClose}
            className="px-4 py-1.5 rounded-lg bg-slate-800 hover:bg-slate-900 text-white text-xs font-semibold cursor-pointer"
          >
            Tutup
          </button>
        </div>

      </div>
    </div>
  );
};

export default FacilityModal;
