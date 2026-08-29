"use client";

import MapImage from "./MapImage";
import RouteLayer from "./RouteLayer";
import MarkerLayer from "./MarkerLayer";
import HotspotLayer from "./HotspotLayer";
import MapZoomControls from "./MapZoomControls";

export default function MapCanvas({
  rooms = [],
  selectedRoom = null,
  onSelectRoom,
  originPoint = null,
  destPoint = null,
  svgPathD = "",
  showRoute = false,
  mapScale = 1.0,
  onZoomIn,
  onZoomOut,
  onResetZoom,
  isLoading = false,
}) {
  return (
    <div
      id="interactive-map-canvas"
      className="map-container relative w-full h-full rounded-3xl border border-slate-200/80 bg-white overflow-hidden select-none shadow-sm flex flex-col justify-center items-center p-2 sm:p-3.5"
    >
      {/* Loading Skeleton Overlay */}
      {isLoading && (
        <div className="absolute inset-0 z-40 flex items-center justify-center bg-white/80 backdrop-blur-2xs">
          <div className="flex items-center gap-2.5 rounded-full bg-white px-5 py-2.5 shadow-lg border border-slate-200 text-xs font-bold text-slate-800">
            <svg
              className="animate-spin h-4 w-4 text-[#05529E]"
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 24 24"
            >
              <circle
                className="opacity-25"
                cx="12"
                cy="12"
                r="10"
                stroke="currentColor"
                strokeWidth="4"
              />
              <path className="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z" />
            </svg>
            <span>Memuat denah dan jalur navigasi...</span>
          </div>
        </div>
      )}

      {/* Map Zoom Controls */}
      <MapZoomControls
        onZoomIn={onZoomIn}
        onZoomOut={onZoomOut}
        onResetZoom={onResetZoom}
      />

      {/* Aspect-Ratio-Locked Canvas (1024 / 584) ensures 100% pixel-perfect alignment of image, boxes, and lines */}
      <div
        className="relative w-full aspect-[1024/584] max-h-full transition-transform duration-300 origin-center rounded-xl overflow-hidden shadow-xs bg-slate-50 border border-slate-100"
        style={{ transform: `scale(${mapScale})` }}
      >
        {/* 1. Base Real Map Image - fills 100% of the 1024x584 container */}
        <MapImage />

        {/* 2. Route SVG Layer */}
        <RouteLayer svgPathD={svgPathD} showRoute={showRoute} />

        {/* 3. Dynamic Origin & Destination Markers */}
        <MarkerLayer
          originPoint={originPoint}
          destPoint={destPoint}
          showRoute={showRoute}
        />

        {/* 4. Interactive Clickable Hotspots */}
        <HotspotLayer
          rooms={rooms}
          selectedRoom={selectedRoom}
          onSelectRoom={onSelectRoom}
        />
      </div>
    </div>
  );
}
