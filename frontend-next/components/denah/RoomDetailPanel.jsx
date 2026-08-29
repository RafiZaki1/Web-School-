"use client";

import { getAssetUrl } from "@/lib/api/client";

export default function RoomDetailPanel({
  selectedRoom = null,
  onNavigateToSelected,
  onSetAsOrigin,
  onOpenChatbot,
}) {
  const roomImageUrl = selectedRoom?.image
    ? getAssetUrl(selectedRoom.image)
    : "/hero-bg.jpg";

  return (
    <div className="lg:col-span-4 flex flex-col h-full space-y-3 justify-between">
      {/* Room Detail Card */}
      <div className="bg-white rounded-3xl border border-slate-200/80 p-5 space-y-4 flex flex-col justify-between flex-1 shadow-sm">
        {selectedRoom ? (
          <div className="space-y-3.5">
            {/* Top Pill Badge */}
            <div className="flex items-center justify-between">
              <span className="inline-flex items-center rounded-full bg-[#05529E] text-white px-3 py-1 text-[11px] font-bold tracking-wide shadow-xs">
                Tujuan Anda
              </span>
              <span className="text-[11px] font-bold px-2.5 py-0.5 rounded-full bg-sky-100 text-sky-800">
                {selectedRoom.category ? selectedRoom.category.name : "Ruangan"}
              </span>
            </div>

            {/* Room Title & Subtitle */}
            <div>
              <h3 className="text-xl font-black text-slate-900 tracking-tight leading-snug">
                {selectedRoom.name}
              </h3>
              <p className="text-xs font-bold text-[#05529E] mt-0.5">
                {selectedRoom.building_name || "SMKN 2 Mojokerto"}
              </p>
            </div>

            {/* Photo / Visual Preview Card */}
            <div className="relative w-full h-32 rounded-2xl overflow-hidden bg-slate-100 border border-slate-200/80 shadow-inner group">
              <img
                src={roomImageUrl}
                alt={selectedRoom.name}
                className="w-full h-full object-cover group-hover:scale-105 transition duration-500"
                onError={(e) => {
                  e.currentTarget.src = "/hero-bg.jpg";
                }}
              />
              <div className="absolute inset-0 bg-gradient-to-t from-slate-950/60 via-transparent to-transparent pointer-events-none" />
              <div className="absolute bottom-2 left-2.5 right-2.5 flex items-center justify-between text-white text-[10px] font-bold">
                <span>{selectedRoom.building_name || "Gedung Sekolah"}</span>
                <span className="bg-white/20 backdrop-blur-xs px-2 py-0.5 rounded-full">SKANEDA</span>
              </div>
            </div>

            {/* Short Description */}
            <p className="text-xs text-slate-600 leading-relaxed font-normal">
              {selectedRoom.description ||
                "Fasilitas pembelajaran resmi pada lingkungan SMK Negeri 2 Kota Mojokerto."}
            </p>

            {/* Meta Details */}
            <div className="border-t border-slate-100 pt-3 space-y-2 text-xs">
              <div className="flex items-start justify-between gap-2">
                <span className="text-slate-500 font-medium shrink-0 flex items-center gap-1.5">
                  <span>❖</span> Lokasi
                </span>
                <span className="text-slate-800 font-semibold text-right">
                  {selectedRoom.building_name || "-"}
                </span>
              </div>
              <div className="flex items-start justify-between gap-2">
                <span className="text-slate-500 font-medium shrink-0 flex items-center gap-1.5">
                  <span>▣</span> Kategori
                </span>
                <span className="text-slate-800 font-semibold text-right">
                  {selectedRoom.category ? selectedRoom.category.name : "Ruangan"}
                </span>
              </div>
              <div className="flex items-start justify-between gap-2">
                <span className="text-slate-500 font-medium shrink-0 flex items-center gap-1.5">
                  <span>🕒</span> Jam Operasional
                </span>
                <span className="text-slate-800 font-semibold text-right">
                  {selectedRoom.open_hours || "07.00 - 16.00 WIB"}
                </span>
              </div>
            </div>

            {/* Facilities Chips */}
            {selectedRoom.facilities && selectedRoom.facilities.length > 0 && (
              <div className="pt-1">
                <p className="text-[11px] font-bold text-slate-700 mb-1.5">Fasilitas:</p>
                <div className="flex flex-wrap gap-1">
                  {selectedRoom.facilities.map((fac) => (
                    <span
                      key={fac.id}
                      className="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-slate-100 text-slate-700 text-[10px] font-medium border border-slate-200"
                    >
                      <span>{fac.name}</span>
                    </span>
                  ))}
                </div>
              </div>
            )}
          </div>
        ) : (
          /* Empty State */
          <div className="flex-1 flex flex-col items-center justify-center text-center p-6 space-y-3">
            <div className="h-12 w-12 rounded-full bg-sky-50 text-sky-600 flex items-center justify-center text-xl">
              🗺️
            </div>
            <p className="font-bold text-slate-800 text-sm">Pilih Ruangan</p>
            <p className="text-xs text-slate-500 leading-relaxed">
              Silakan klik ruangan pada denah atau gunakan pencarian untuk melihat detail informasi.
            </p>
          </div>
        )}

        {/* Dynamic Routing Action Buttons */}
        <div className="pt-2 space-y-2">
          {selectedRoom && (
            <>
              <button
                type="button"
                onClick={() => onNavigateToSelected(selectedRoom)}
                className="w-full inline-flex items-center justify-center gap-2 rounded-2xl bg-[#05529E] hover:bg-[#0766c6] text-white py-2.5 px-4 text-xs font-bold shadow-md hover:shadow-lg transition-all cursor-pointer"
              >
                <span>Arahkan Rute ke Sini</span>
                <span>→</span>
              </button>

              <button
                type="button"
                onClick={() => onSetAsOrigin(selectedRoom.slug || selectedRoom.id)}
                className="w-full inline-flex items-center justify-center gap-1.5 rounded-2xl border border-slate-200 hover:bg-slate-50 text-slate-700 py-1.5 px-3 text-[11px] font-semibold transition cursor-pointer"
              >
                <span>● Mulai Rute dari Sini</span>
              </button>
            </>
          )}
        </div>
      </div>

      {/* Chatbot Promo Card */}
      <div className="bg-white border border-slate-200/80 rounded-3xl p-4 text-xs text-slate-800 flex items-center justify-between gap-3 shadow-sm">
        <div className="space-y-1">
          <div className="flex items-center gap-1.5 font-bold text-slate-900">
            <span className="text-[#05529E]">💬</span>
            <span>Butuh bantuan navigasi?</span>
          </div>
          <p className="text-[11px] text-slate-600">
            Tanyakan ruangan atau rute langsung kepada SADA AI.
          </p>
        </div>
        <button
          type="button"
          onClick={onOpenChatbot}
          className="shrink-0 text-center py-2 px-3.5 rounded-2xl bg-[#05529E] hover:bg-[#0766c6] text-white font-bold text-xs transition shadow-sm cursor-pointer"
        >
          Tanya Chatbot
        </button>
      </div>
    </div>
  );
}
