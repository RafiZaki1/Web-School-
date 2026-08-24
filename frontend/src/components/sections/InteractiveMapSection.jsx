import React, { useState } from 'react';
import { Compass, Navigation, Building, ArrowRight, Layers } from 'lucide-react';
import RoomDetailCard from './RoomDetailCard';
import Skeleton from '../common/Skeleton';

const FLOOR_LAYOUT = [
  { slug: 'laboratorium-rpl', x: 25, y: 30, w: 145, h: 100, code: 'RPL-01', label: 'Lab RPL & Software' },
  { slug: 'perpustakaan-digital', x: 185, y: 30, w: 150, h: 100, code: 'LIB-01', label: 'Perpustakaan Digital' },
  { slug: 'mushola-al-kautsar', x: 350, y: 30, w: 145, h: 100, code: 'MSH-01', label: 'Mushola Kampus' },
  { slug: 'lapangan-olahraga', x: 25, y: 155, w: 220, h: 125, code: 'FLD-01', label: 'Lapangan Olahraga' },
  { slug: 'uks', x: 260, y: 155, w: 110, h: 125, code: 'UKS-01', label: 'Ruang UKS' },
  { slug: 'kantin-sehat', x: 385, y: 155, w: 110, h: 125, code: 'KTN-01', label: 'Kantin Sekolah' },
];

export const InteractiveMapSection = ({
  rooms = [],
  selectedRoom,
  selectedRoomId,
  onSelectRoom,
  isRoomLoading,
  onOpenFacilities,
  isLoading,
}) => {
  const [hoveredSlug, setHoveredSlug] = useState(null);

  const getLayout = (room, index) => {
    const preset = FLOOR_LAYOUT.find(p => p.slug === room.slug);
    if (preset) return preset;
    const col = index % 3;
    const row = Math.floor(index / 3);
    return {
      slug: room.slug,
      x: 25 + col * 160,
      y: 30 + row * 125,
      w: 145,
      h: 100,
      code: `RM-0${index + 1}`,
      label: room.name,
    };
  };

  return (
    <section id="denah" className="py-20 bg-slate-100/80 border-b border-slate-200">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {/* Header */}
        <div className="max-w-2xl mb-12">
          <div className="inline-flex items-center gap-1.5 px-3 py-1 rounded bg-blue-50 text-blue-700 text-xs font-semibold uppercase tracking-wider mb-2">
            <Compass className="w-3.5 h-3.5" />
            <span>Fasilitas & Denah</span>
          </div>
          <h2 className="text-2xl sm:text-3xl font-bold text-slate-900 tracking-tight">
            DENAH INTERAKTIF
          </h2>
          <p className="mt-2 text-sm sm:text-base text-slate-600">
            Jelajahi lingkungan sekolah dan temukan berbagai ruang serta fasilitas dengan mudah.
          </p>
        </div>

        {/* 2 Column Layout */}
        <div className="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
          
          {/* Left Column: Interactive Map & Buttons */}
          <div className="lg:col-span-7 space-y-5">
            
            {/* SVG Map Card */}
            <div className="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">
              <div className="flex items-center justify-between pb-3 mb-3 border-b border-slate-100">
                <div className="flex items-center gap-2">
                  <Navigation className="w-4 h-4 text-blue-600" />
                  <span className="text-xs font-bold text-slate-800 uppercase tracking-wide">Peta Gedung & Lokasi</span>
                </div>
                <span className="text-[11px] text-slate-500">Klik area pada denah</span>
              </div>

              <div className="relative aspect-[16/10] w-full rounded-xl bg-slate-900 overflow-hidden border border-slate-800 p-3">
                <svg
                  viewBox="0 0 520 310"
                  className="w-full h-full select-none"
                  preserveAspectRatio="xMidYMid meet"
                >
                  {/* Grid lines */}
                  <defs>
                    <pattern id="plan-grid" width="20" height="20" patternUnits="userSpaceOnUse">
                      <path d="M 20 0 L 0 0 0 20" fill="none" stroke="rgba(255,255,255,0.04)" strokeWidth="1" />
                    </pattern>
                  </defs>
                  <rect width="520" height="310" fill="url(#plan-grid)" />

                  {/* Outer boundary */}
                  <rect x="15" y="15" width="490" height="280" rx="8" fill="none" stroke="rgba(255,255,255,0.15)" strokeWidth="1.5" strokeDasharray="3 3" />
                  
                  {/* Main Gate */}
                  <rect x="220" y="282" width="80" height="15" rx="3" fill="#2563eb" />
                  <text x="260" y="292" fill="#ffffff" fontSize="8" fontWeight="bold" textAnchor="middle" alignmentBaseline="middle">
                    GERBANG UTAMA
                  </text>

                  {/* Room Nodes */}
                  {rooms.map((room, idx) => {
                    const zone = getLayout(room, idx);
                    const isSelected = selectedRoomId === room.id || selectedRoom?.slug === room.slug;
                    const isHovered = hoveredSlug === room.slug;

                    return (
                      <g
                        key={room.id}
                        onClick={() => onSelectRoom(room)}
                        onMouseEnter={() => setHoveredSlug(room.slug)}
                        onMouseLeave={() => setHoveredSlug(null)}
                        className="cursor-pointer"
                      >
                        <rect
                          x={zone.x}
                          y={zone.y}
                          width={zone.w}
                          height={zone.h}
                          rx="6"
                          className={`transition-all duration-200 ${
                            isSelected
                              ? 'fill-blue-600 stroke-white stroke-2'
                              : isHovered
                              ? 'fill-slate-700 stroke-blue-400 stroke-1'
                              : 'fill-slate-800/90 stroke-slate-700 hover:stroke-slate-500'
                          }`}
                        />
                        <text
                          x={zone.x + 8}
                          y={zone.y + 16}
                          fill={isSelected ? '#93c5fd' : '#64748b'}
                          fontSize="7.5"
                          fontWeight="bold"
                        >
                          {zone.code}
                        </text>
                        <text
                          x={zone.x + zone.w / 2}
                          y={zone.y + zone.h / 2}
                          fill="#ffffff"
                          fontSize="10"
                          fontWeight="bold"
                          textAnchor="middle"
                          alignmentBaseline="middle"
                        >
                          {room.name.length > 18 ? room.name.substring(0, 16) + '...' : room.name}
                        </text>
                        <text
                          x={zone.x + zone.w / 2}
                          y={zone.y + zone.h / 2 + 14}
                          fill={isSelected ? '#dbeafe' : '#94a3b8'}
                          fontSize="8"
                          textAnchor="middle"
                          alignmentBaseline="middle"
                        >
                          {room.building_name}
                        </text>
                      </g>
                    );
                  })}
                </svg>
              </div>
            </div>

            {/* Location Selector Buttons */}
            <div className="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">
              <div className="text-xs font-bold text-slate-700 uppercase tracking-wider mb-3">
                Daftar Ruangan & Gedung
              </div>

              {isLoading ? (
                <div className="flex flex-wrap gap-2">
                  {[1, 2, 3, 4, 5, 6].map(i => (
                    <Skeleton key={i} className="h-9 w-28 rounded-lg" />
                  ))}
                </div>
              ) : (
                <div className="flex flex-wrap gap-2">
                  {rooms.map((room) => {
                    const isSelected = selectedRoomId === room.id || selectedRoom?.slug === room.slug;
                    return (
                      <button
                        key={room.id}
                        onClick={() => onSelectRoom(room)}
                        className={`px-3.5 py-2 rounded-lg text-xs font-semibold transition-all cursor-pointer ${
                          isSelected
                            ? 'bg-blue-600 text-white shadow-sm'
                            : 'bg-slate-50 hover:bg-slate-100 text-slate-700 border border-slate-200'
                        }`}
                      >
                        [ {room.name} ]
                      </button>
                    );
                  })}
                </div>
              )}
            </div>

          </div>

          {/* Right Column: Room Detail Card */}
          <div className="lg:col-span-5 sticky top-24">
            <RoomDetailCard
              room={selectedRoom}
              isLoading={isRoomLoading}
              onOpenFacilities={onOpenFacilities}
            />
          </div>

        </div>

      </div>
    </section>
  );
};

export default InteractiveMapSection;
