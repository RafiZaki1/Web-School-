import React from 'react';
import { Building2, Clock, ArrowRight } from 'lucide-react';
import Skeleton from '../common/Skeleton';

export const RoomDetailCard = ({
  room,
  isLoading,
  onOpenFacilities,
}) => {
  if (isLoading) {
    return (
      <div className="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-4">
        <Skeleton className="h-5 w-28" />
        <Skeleton className="h-7 w-3/4" />
        <Skeleton className="h-48 w-full rounded-xl" />
        <Skeleton className="h-16 w-full" />
        <Skeleton className="h-11 w-full rounded-lg" />
      </div>
    );
  }

  if (!room) {
    return (
      <div className="bg-white rounded-2xl border border-slate-200 p-8 text-center flex flex-col items-center justify-center min-h-[360px]">
        <Building2 className="w-10 h-10 text-slate-400 mb-3" />
        <h3 className="text-base font-bold text-slate-800">Pilih Ruangan</h3>
        <p className="text-xs text-slate-500 max-w-xs mt-1">
          Silakan klik lokasi ruangan pada denah atau tombol di samping untuk melihat detail ruangan.
        </p>
      </div>
    );
  }

  const roomImage = room.image || 'https://images.unsplash.com/photo-1580582932707-520aed937b7b?q=80&w=800&auto=format&fit=crop';

  return (
    <div className="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
      <div className="flex items-center justify-between gap-3 mb-3">
        <span className="px-2.5 py-1 rounded bg-blue-50 text-blue-700 text-xs font-bold uppercase tracking-wider">
          {room.building_name}
        </span>
        {room.open_hours && (
          <div className="flex items-center gap-1 text-xs text-slate-500">
            <Clock className="w-3.5 h-3.5 text-slate-400" />
            <span>{room.open_hours}</span>
          </div>
        )}
      </div>

      <h3 className="text-xl font-bold text-slate-900 mb-4">
        {room.name}
      </h3>

      <div className="relative aspect-video w-full rounded-xl overflow-hidden bg-slate-100 mb-4 border border-slate-200">
        <img
          src={roomImage}
          alt={room.name}
          className="w-full h-full object-cover"
          onError={(e) => {
            e.target.src = 'https://images.unsplash.com/photo-1580582932707-520aed937b7b?q=80&w=800&auto=format&fit=crop';
          }}
        />
      </div>

      <p className="text-xs sm:text-sm text-slate-600 leading-relaxed mb-6">
        {room.description || 'Fasilitas pembelajaran dan sarana pendukung kegiatan siswa.'}
      </p>

      <button
        onClick={() => onOpenFacilities(room)}
        className="w-full inline-flex items-center justify-center gap-2 px-4 py-3 rounded-lg bg-blue-600 hover:bg-blue-700 active:scale-[0.99] text-white font-medium text-xs sm:text-sm shadow-sm transition-all cursor-pointer"
      >
        <span>Lihat Fasilitas Lengkap</span>
        <ArrowRight className="w-4 h-4" />
      </button>
    </div>
  );
};

export default RoomDetailCard;
