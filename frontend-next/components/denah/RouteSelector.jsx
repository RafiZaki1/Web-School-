"use client";

export default function RouteSelector({
  allRooms = [],
  routeFrom = "",
  routeTo = "",
  onRouteChange,
  onFetchRoute,
  onCancelRoute,
  isRouteLoading = false,
  showRoute = false,
  routeInfo = null,
}) {
  return (
    <div className="bg-white rounded-3xl border border-slate-200/80 p-4 sm:p-5 flex flex-col lg:flex-row items-center justify-between gap-4 shadow-sm">
      {/* Title */}
      <div className="flex items-center gap-2 text-slate-900 font-bold text-sm shrink-0 w-full lg:w-auto">
        <span className="text-[#05529E] text-base">✦</span>
        <span>Cari rute ke ruangan</span>
      </div>

      {/* Dynamic Dari & Tujuan Dropdowns & Action Button */}
      <div className="flex flex-col sm:flex-row items-center gap-3 w-full lg:w-auto flex-1 max-w-3xl">
        {/* Dari (Origin) */}
        <div className="w-full sm:w-1/2">
          <label className="text-[10px] uppercase font-bold text-slate-400 block mb-1">
            Dari
          </label>
          <div className="relative">
            <select
              value={routeFrom}
              onChange={(e) => onRouteChange("from", e.target.value)}
              className="w-full rounded-2xl border border-slate-200 bg-white py-2.5 pl-3 pr-8 text-xs text-slate-800 focus:border-[#05529E] focus:outline-none shadow-xs cursor-pointer"
            >
              <option value="" disabled>
                -- Pilih Lokasi Asal --
              </option>
              {allRooms.map((r) => (
                <option key={`from-${r.id}`} value={r.slug || r.id}>
                  {r.name}
                </option>
              ))}
            </select>
          </div>
        </div>

        {/* Tujuan (Destination) */}
        <div className="w-full sm:w-1/2">
          <label className="text-[10px] uppercase font-bold text-slate-400 block mb-1">
            Tujuan
          </label>
          <div className="relative">
            <select
              value={routeTo}
              onChange={(e) => onRouteChange("to", e.target.value)}
              className="w-full rounded-2xl border border-slate-200 bg-white py-2.5 pl-3 pr-8 text-xs text-slate-800 focus:border-[#05529E] focus:outline-none shadow-xs cursor-pointer"
            >
              <option value="" disabled>
                -- Pilih Lokasi Tujuan --
              </option>
              {allRooms.map((r) => (
                <option key={`to-${r.id}`} value={r.slug || r.id}>
                  {r.name}
                </option>
              ))}
            </select>
          </div>
        </div>

        {/* Buttons */}
        <div className="w-full sm:w-auto self-end flex gap-2">
          <button
            type="button"
            onClick={onFetchRoute}
            disabled={isRouteLoading || !routeFrom || !routeTo}
            className="w-full sm:w-auto whitespace-nowrap rounded-2xl bg-[#05529E] hover:bg-[#0766c6] disabled:opacity-50 text-white px-5 py-2.5 text-xs font-bold shadow-md hover:shadow-lg transition cursor-pointer flex items-center justify-center gap-1.5"
          >
            {isRouteLoading && <span className="animate-spin text-xs">⏳</span>}
            <span>{isRouteLoading ? "Menghitung..." : "➔ Tampilkan Rute"}</span>
          </button>

          {showRoute && (
            <button
              type="button"
              onClick={onCancelRoute}
              className="whitespace-nowrap rounded-2xl bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200 px-4 py-2.5 text-xs font-bold transition cursor-pointer"
            >
              Batalkan Rute
            </button>
          )}
        </div>
      </div>

      {/* Route Stats Info */}
      {showRoute && routeInfo && (
        <div className="text-xs text-slate-700 bg-sky-50 px-4 py-2.5 rounded-2xl border border-sky-200 shadow-2xs shrink-0 flex items-center gap-2.5">
          <span className="text-lg">🚶</span>
          <div>
            <p className="font-bold text-[#05529E]">
              Jarak: ± {routeInfo.distance} meter
            </p>
            <p className="text-[11px] text-slate-500">
              Estimasi waktu: ± {routeInfo.estimated_minutes} menit
            </p>
          </div>
        </div>
      )}
    </div>
  );
}
