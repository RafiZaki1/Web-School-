export default function MarkerLayer({ originPoint, destPoint, showRoute }) {
  if (!showRoute) return null;

  return (
    <div className="marker-layer absolute inset-0 pointer-events-none z-25">
      {/* Origin Start Marker */}
      {originPoint && (
        <div
          style={{ left: `${originPoint.x}%`, top: `${originPoint.y}%` }}
          className="absolute -translate-x-1/2 -translate-y-1/2 flex items-center justify-center pointer-events-none"
        >
          <div className="h-6 w-6 rounded-full bg-blue-500/30 animate-ping absolute" />
          <div className="h-4 w-4 rounded-full bg-white border-2 border-[#05529E] shadow-xl relative z-10 flex items-center justify-center">
            <div className="h-1.5 w-1.5 rounded-full bg-[#05529E]" />
          </div>
        </div>
      )}

      {/* Destination Target Marker (Location Pin) */}
      {destPoint && (
        <div
          style={{ left: `${destPoint.x}%`, top: `${destPoint.y}%` }}
          className="absolute -translate-x-1/2 -translate-y-full flex flex-col items-center pointer-events-none"
        >
          <div className="h-8 w-8 rounded-full bg-[#05529E] text-white shadow-2xl flex items-center justify-center border-2 border-white animate-bounce">
            <svg className="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
              <path
                fillRule="evenodd"
                d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                clipRule="evenodd"
              />
            </svg>
          </div>
          <div className="w-2 h-1 bg-slate-900/30 rounded-full blur-2xs mt-0.5" />
        </div>
      )}
    </div>
  );
}
