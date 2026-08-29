"use client";

export default function HotspotLayer({ rooms = [], selectedRoom = null, onSelectRoom }) {
  return (
    <div className="hotspot-layer absolute inset-0 z-15 pointer-events-auto">
      {rooms.map((room) => {
        if (!room.hotspot || typeof room.hotspot.x === "undefined") return null;

        const isSelected =
          selectedRoom &&
          (selectedRoom.id === room.id || selectedRoom.slug === room.slug);

        const style = {
          left: `${room.hotspot.x}%`,
          top: `${room.hotspot.y}%`,
          width: `${room.hotspot.width}%`,
          height: `${room.hotspot.height}%`,
        };

        const className = isSelected
          ? "absolute border-2 border-blue-700 bg-blue-600/35 ring-2 ring-blue-400/60 rounded-[3px] shadow-md z-30 cursor-pointer group transition-all duration-150"
          : "absolute border border-blue-500/20 hover:border-2 hover:border-sky-500 hover:bg-sky-400/30 rounded-[3px] transition-all duration-150 cursor-pointer group z-10";

        return (
          <div
            key={room.id}
            onClick={() => onSelectRoom(room)}
            style={style}
            className={className}
            title={room.name}
          >
            {/* Tooltip on Hover */}
            <div className="absolute bottom-full left-1/2 -translate-x-1/2 mb-1.5 hidden group-hover:flex flex-col items-center whitespace-nowrap rounded-lg bg-slate-900/95 backdrop-blur-xs px-2.5 py-1 text-[11px] font-semibold text-white shadow-xl z-40 pointer-events-none">
              <span>{room.name}</span>
              {room.building_name && (
                <span className="text-[9px] text-slate-300 font-normal">
                  {room.building_name}
                </span>
              )}
            </div>
          </div>
        );
      })}
    </div>
  );
}
