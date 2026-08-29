"use client";

import { useState, useEffect, useRef } from "react";

export default function MapSearch({ onSearch, searchResults = [], onSelectResult }) {
  const [query, setQuery] = useState("");
  const [showDropdown, setShowDropdown] = useState(false);
  const containerRef = useRef(null);

  // Debounced search
  useEffect(() => {
    const timer = setTimeout(() => {
      onSearch(query);
      if (query.trim().length > 0) {
        setShowDropdown(true);
      } else {
        setShowDropdown(false);
      }
    }, 300);

    return () => clearTimeout(timer);
  }, [query, onSearch]);

  // Click outside to close dropdown
  useEffect(() => {
    const handleClickOutside = (e) => {
      if (containerRef.current && !containerRef.current.contains(e.target)) {
        setShowDropdown(false);
      }
    };
    document.addEventListener("mousedown", handleClickOutside);
    return () => document.removeEventListener("mousedown", handleClickOutside);
  }, []);

  const handleClear = () => {
    setQuery("");
    setShowDropdown(false);
    onSearch("");
  };

  return (
    <div ref={containerRef} className="relative w-full md:w-80">
      <div className="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
        <svg className="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path
            strokeLinecap="round"
            strokeLinejoin="round"
            strokeWidth="2"
            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
          />
        </svg>
      </div>

      <input
        type="text"
        value={query}
        onChange={(e) => setQuery(e.target.value)}
        onFocus={() => {
          if (searchResults.length > 0) setShowDropdown(true);
        }}
        placeholder="Cari ruangan atau fasilitas..."
        className="w-full rounded-2xl border border-slate-200 bg-white py-2.5 pl-10 pr-9 text-xs sm:text-[13px] text-slate-800 placeholder-slate-400 focus:border-[#05529E] focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#05529E]/15 shadow-xs transition"
      />

      {query.length > 0 && (
        <button
          type="button"
          onClick={handleClear}
          className="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 cursor-pointer"
        >
          <svg className="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      )}

      {/* Autocomplete Dropdown */}
      {showDropdown && searchResults.length > 0 && (
        <div className="absolute left-0 right-0 top-full mt-1.5 z-50 max-h-64 overflow-y-auto rounded-2xl bg-white p-2 shadow-2xl border border-slate-200 divide-y divide-slate-100 text-xs">
          {searchResults.map((item) => (
            <div
              key={item.id}
              onClick={() => {
                onSelectResult(item);
                setShowDropdown(false);
              }}
              className="flex items-center justify-between p-2.5 rounded-xl hover:bg-sky-50 cursor-pointer transition"
            >
              <div>
                <p className="font-bold text-slate-900">{item.name}</p>
                <p className="text-[11px] text-slate-500">
                  {item.building_name || (item.category ? item.category.name : "")}
                </p>
              </div>
              <span className="text-[10px] font-semibold text-sky-700 bg-sky-100 px-2 py-0.5 rounded-full">
                {item.category ? item.category.name : "Ruangan"}
              </span>
            </div>
          ))}
        </div>
      )}
    </div>
  );
}
