"use client";

export default function QuickLocations({
  popularRooms = [],
  selectedRoom = null,
  onSelectRoom,
  onResetCategory,
}) {
  return (
    <div className="flex items-center gap-2 overflow-x-auto pb-2 scrollbar-none">
      {popularRooms.map((r) => {
        const isSelected = selectedRoom && selectedRoom.id === r.id;
        return (
          <button
            key={`chip-${r.id}`}
            type="button"
            onClick={() => onSelectRoom(r)}
            className={`inline-flex items-center px-4 py-2 rounded-2xl border text-xs shadow-2xs transition whitespace-nowrap cursor-pointer ${
              isSelected
                ? "bg-[#ebf4fd] border-[#b9d9f9] text-[#05529E] font-bold ring-1 ring-sky-300"
                : "bg-white border-slate-200 text-slate-700 hover:bg-slate-50 font-semibold"
            }`}
          >
            <span>{r.name}</span>
          </button>
        );
      })}

      <button
        type="button"
        onClick={onResetCategory}
        className="inline-flex items-center gap-1.5 px-4 py-2 rounded-2xl text-xs font-bold text-[#05529E] hover:text-[#0766c6] transition whitespace-nowrap cursor-pointer"
      >
        <span>Lainnya</span>
        <span>→</span>
      </button>
    </div>
  );
}
