"use client";

import { useState, useEffect, useCallback, useMemo } from "react";
import { roomApi } from "@/lib/api/roomApi";
import { routeApi } from "@/lib/api/routeApi";
import MapCanvas from "./MapCanvas";
import RoomDetailPanel from "./RoomDetailPanel";
import RouteSelector from "./RouteSelector";
import MapSearch from "./MapSearch";
import QuickLocations from "./QuickLocations";
import { buildPreciseSvgPath } from "./RouteLayer";

export default function DenahInteraktif() {
  const [allRooms, setAllRooms] = useState([]);
  const [categories, setCategories] = useState([]);
  const [activeCategory, setActiveCategory] = useState("Semua");
  const [selectedRoom, setSelectedRoom] = useState(null);

  // Search state
  const [searchResults, setSearchResults] = useState([]);

  // Routing state
  const [routeFrom, setRouteFrom] = useState("");
  const [routeTo, setRouteTo] = useState("");
  const [showRoute, setShowRoute] = useState(false);
  const [routeInfo, setRouteInfo] = useState(null);
  const [svgPathD, setSvgPathD] = useState("");
  const [originPoint, setOriginPoint] = useState(null);
  const [destPoint, setDestPoint] = useState(null);

  // Zoom state
  const [mapScale, setMapScale] = useState(1.0);

  // Loading & Error states
  const [isLoading, setIsLoading] = useState(true);
  const [isRouteLoading, setIsRouteLoading] = useState(false);
  const [errorMessage, setErrorMessage] = useState(null);

  // Fetch Route from Backend
  const calculateRoute = useCallback(async (from, to) => {
    if (!from || !to) return;
    if (from === to) {
      alert("Lokasi asal dan tujuan tidak boleh sama.");
      return;
    }

    setIsRouteLoading(true);
    setErrorMessage(null);

    try {
      const data = await routeApi.getRoute(from, to);
      if (data && data.path && data.path.length > 0) {
        setRouteInfo({
          distance: data.distance,
          estimated_minutes: data.estimated_minutes,
        });
        const { d, cleanPoints } = buildPreciseSvgPath(data.path);
        setSvgPathD(d);
        setOriginPoint(cleanPoints[0]);
        setDestPoint(cleanPoints[cleanPoints.length - 1]);
        setShowRoute(true);
      } else {
        alert("Rute tidak dapat ditemukan.");
        setShowRoute(false);
      }
    } catch (err) {
      console.error("Route calculation error:", err);
      alert(err.message || "Gagal menghitung rute perjalanan.");
      setShowRoute(false);
    } finally {
      setIsRouteLoading(false);
    }
  }, []);

  // Initialize data
  useEffect(() => {
    let isMounted = true;

    async function loadData() {
      setIsLoading(true);
      try {
        const [cats, rooms] = await Promise.all([
          roomApi.getCategories().catch(() => []),
          roomApi.getRooms().catch(() => []),
        ]);

        if (!isMounted) return;

        setCategories(cats);
        setAllRooms(rooms);

        if (rooms.length > 0) {
          // Default destination: Lapangan Olahraga or Lab RPL or first room
          const defaultDest =
            rooms.find((r) => r.slug.includes("lapangan") || r.slug.includes("rpl")) ||
            rooms[0];
          setSelectedRoom(defaultDest);
          const destSlug = defaultDest.slug || defaultDest.id;
          setRouteTo(destSlug);

          // Default origin: Gerbang Utama
          const defaultOrigin =
            rooms.find((r) => r.slug.includes("gerbang")) || rooms[0];
          const originSlug = defaultOrigin.slug || defaultOrigin.id;
          setRouteFrom(originSlug);

          // Initial route display
          if (originSlug && destSlug && originSlug !== destSlug) {
            calculateRoute(originSlug, destSlug);
          }
        }
      } catch (err) {
        console.error("Failed to load denah data:", err);
        setErrorMessage("Gagal memuat data ruangan.");
      } finally {
        if (isMounted) setIsLoading(false);
      }
    }

    loadData();

    return () => {
      isMounted = false;
    };
  }, [calculateRoute]);

  // Global event listeners for Chatbot integration
  useEffect(() => {
    const handleSadaSelectRoom = (e) => {
      const slug = e.detail?.slug;
      if (!slug) return;

      const found = allRooms.find((r) => r.slug === slug || String(r.id) === String(slug));
      if (found) {
        handleSelectRoom(found);
        const el = document.getElementById("denah");
        if (el) el.scrollIntoView({ behavior: "smooth", block: "start" });
      }
    };

    const handleSadaShowRoute = (e) => {
      const { from, to } = e.detail || {};
      if (from && to) {
        setRouteFrom(from);
        setRouteTo(to);
        calculateRoute(from, to);
        const el = document.getElementById("denah");
        if (el) el.scrollIntoView({ behavior: "smooth", block: "start" });
      }
    };

    window.addEventListener("sada:select-room", handleSadaSelectRoom);
    window.addEventListener("sada:show-route", handleSadaShowRoute);

    return () => {
      window.removeEventListener("sada:select-room", handleSadaSelectRoom);
      window.removeEventListener("sada:show-route", handleSadaShowRoute);
    };
  }, [allRooms, calculateRoute]);

  // Filtered rooms by category
  const filteredRooms = useMemo(() => {
    return allRooms.filter((r) => {
      if (activeCategory === "Semua") return true;
      return (
        r.category &&
        r.category.name.toLowerCase() === activeCategory.toLowerCase()
      );
    });
  }, [allRooms, activeCategory]);

  // Popular rooms
  const popularRooms = useMemo(() => allRooms.slice(0, 6), [allRooms]);

  // Handlers
  const handleSelectRoom = async (room) => {
    setSelectedRoom(room);
    setRouteTo(room.slug || room.id);

    try {
      const detail = await roomApi.getRoomDetail(room.slug || room.id);
      if (detail) {
        setSelectedRoom(detail);
      }
    } catch (e) {
      console.error("Error fetching room detail:", e);
    }
  };

  const handleSetAsOrigin = (slugOrId) => {
    setRouteFrom(slugOrId);
    if (slugOrId && routeTo && slugOrId !== routeTo) {
      calculateRoute(slugOrId, routeTo);
    }
  };

  const handleNavigateToSelected = (room) => {
    const dest = room?.slug || room?.id;
    if (!dest) return;
    setRouteTo(dest);

    let origin = routeFrom;
    if (!origin) {
      const gate = allRooms.find((r) => r.slug.includes("gerbang")) || allRooms[0];
      origin = gate ? gate.slug || gate.id : "";
      setRouteFrom(origin);
    }

    if (origin && dest) {
      calculateRoute(origin, dest);
    }
  };

  const handleRouteChange = (type, value) => {
    if (type === "from") setRouteFrom(value);
    if (type === "to") setRouteTo(value);

    // Clear active route visually until user hits "Tampilkan Rute"
    setShowRoute(false);
    setSvgPathD("");
    setOriginPoint(null);
    setDestPoint(null);
    setRouteInfo(null);
  };

  const handleCancelRoute = () => {
    setShowRoute(false);
    setSvgPathD("");
    setOriginPoint(null);
    setDestPoint(null);
    setRouteInfo(null);
  };

  const handleSearch = useCallback(async (query) => {
    if (!query || !query.trim()) {
      setSearchResults([]);
      return;
    }
    try {
      const results = await roomApi.searchRooms(query);
      setSearchResults(results);
    } catch (e) {
      console.error("Search error:", e);
      setSearchResults([]);
    }
  }, []);

  const handleZoomIn = () => {
    setMapScale((prev) => (prev < 2.0 ? Math.min(2.0, prev + 0.2) : prev));
  };

  const handleZoomOut = () => {
    setMapScale((prev) => (prev > 0.8 ? Math.max(0.8, prev - 0.2) : prev));
  };

  const handleResetZoom = () => {
    setMapScale(1.0);
  };

  const openChatbot = () => {
    if (typeof window !== "undefined") {
      window.dispatchEvent(new CustomEvent("sada:toggle-chatbot", { detail: { open: true } }));
    }
  };

  return (
    <section id="denah" className="relative z-10 py-10 sm:py-14 px-4 sm:px-6 lg:px-8 bg-[#f0f6fc]">
      <div className="mx-auto w-full max-w-[1360px] space-y-6">
        {/* Section Header */}
        <div className="flex flex-col md:flex-row md:items-center justify-between gap-4">
          <div className="flex items-center gap-3.5">
            <div className="h-11 w-11 rounded-2xl bg-[#05529E] text-white flex items-center justify-center text-xl shadow-md shadow-blue-900/20 shrink-0">
              <svg className="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path
                  strokeLinecap="round"
                  strokeLinejoin="round"
                  strokeWidth="2"
                  d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"
                />
              </svg>
            </div>
            <div>
              <h2 className="text-2xl sm:text-3xl font-black text-[#102a43] tracking-tight">
                Denah Interaktif
              </h2>
              <p className="text-xs sm:text-sm text-slate-500 font-normal">
                Jelajahi denah sekolah kami dan temukan berbagai ruang serta fasilitas dengan mudah.
              </p>
            </div>
          </div>

          {/* Top Right: Search Bar with Autocomplete */}
          <MapSearch
            onSearch={handleSearch}
            searchResults={searchResults}
            onSelectResult={handleSelectRoom}
          />
        </div>

        {errorMessage && (
          <div className="rounded-2xl bg-rose-50 border border-rose-200 p-4 text-xs font-semibold text-rose-700">
            {errorMessage}
          </div>
        )}

        {/* Main 2-Column Content Layout: Map Canvas (8 cols) + Detail & Chatbot (4 cols) */}
        <div className="grid grid-cols-1 lg:grid-cols-12 gap-5 sm:gap-6 items-stretch">
          {/* 1. Map Canvas */}
          <div className="lg:col-span-8 flex flex-col h-full space-y-3">
            <MapCanvas
              rooms={filteredRooms}
              selectedRoom={selectedRoom}
              onSelectRoom={handleSelectRoom}
              originPoint={originPoint}
              destPoint={destPoint}
              svgPathD={svgPathD}
              showRoute={showRoute}
              mapScale={mapScale}
              onZoomIn={handleZoomIn}
              onZoomOut={handleZoomOut}
              onResetZoom={handleResetZoom}
              isLoading={isLoading}
            />
          </div>

          {/* 2. Right Detail Panel */}
          <RoomDetailPanel
            selectedRoom={selectedRoom}
            onNavigateToSelected={handleNavigateToSelected}
            onSetAsOrigin={handleSetAsOrigin}
            onOpenChatbot={openChatbot}
          />
        </div>

        {/* Bottom Row 1: Route Selector Bar */}
        <RouteSelector
          allRooms={allRooms}
          routeFrom={routeFrom}
          routeTo={routeTo}
          onRouteChange={handleRouteChange}
          onFetchRoute={() => calculateRoute(routeFrom, routeTo)}
          onCancelRoute={handleCancelRoute}
          isRouteLoading={isRouteLoading}
          showRoute={showRoute}
          routeInfo={routeInfo}
        />

        {/* Bottom Row 2: Popular Facilities Quick Access */}
        <QuickLocations
          popularRooms={popularRooms}
          selectedRoom={selectedRoom}
          onSelectRoom={handleSelectRoom}
          onResetCategory={() => setActiveCategory("Semua")}
        />
      </div>
    </section>
  );
}
