"use client";

export default function MapZoomControls({ onZoomIn, onZoomOut, onResetZoom }) {
  return (
    <div className="absolute left-3.5 bottom-3.5 z-30 flex flex-col gap-1 bg-white/95 backdrop-blur-xs p-1 rounded-2xl shadow-lg border border-slate-200/80">
      <button
        type="button"
        onClick={onZoomIn}
        title="Perbesar Peta"
        className="h-7 w-7 flex items-center justify-center rounded-xl hover:bg-slate-100 text-slate-700 font-bold text-sm transition cursor-pointer"
      >
        +
      </button>
      <button
        type="button"
        onClick={onZoomOut}
        title="Perkecil Peta"
        className="h-7 w-7 flex items-center justify-center rounded-xl hover:bg-slate-100 text-slate-700 font-bold text-sm transition cursor-pointer"
      >
        −
      </button>
      <button
        type="button"
        onClick={onResetZoom}
        title="Reset Tampilan"
        className="h-7 w-7 flex items-center justify-center rounded-xl hover:bg-slate-100 text-slate-700 text-xs transition cursor-pointer"
      >
        ⊙
      </button>
    </div>
  );
}
