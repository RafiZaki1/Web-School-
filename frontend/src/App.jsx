import React, { useState, useEffect, useCallback } from 'react';
import Navbar from './components/common/Navbar';
import Footer from './components/common/Footer';
import ErrorState from './components/common/ErrorState';
import HeroSection from './components/sections/HeroSection';
import GallerySection from './components/sections/GallerySection';
import SchoolProfileSection from './components/sections/SchoolProfileSection';
import StatisticsSection from './components/sections/StatisticsSection';
import MajorsSection from './components/sections/MajorsSection';
import InteractiveMapSection from './components/sections/InteractiveMapSection';
import FacilityModal from './components/sections/FacilityModal';

import { getHomeData } from './services/api/home';
import { getRooms, getRoomDetail } from './services/api/room';
import { getRoomFacilities } from './services/api/facility';

export function App() {
  // Global & Landing States
  const [homeData, setHomeData] = useState(null);
  const [rooms, setRooms] = useState([]);
  const [isLoading, setIsLoading] = useState(true);
  const [error, setError] = useState(null);

  // Selected Room States
  const [selectedRoom, setSelectedRoom] = useState(null);
  const [selectedRoomId, setSelectedRoomId] = useState(null);
  const [isRoomLoading, setIsRoomLoading] = useState(false);

  // Facility Modal States
  const [facilities, setFacilities] = useState([]);
  const [isFacilityLoading, setIsFacilityLoading] = useState(false);
  const [isFacilityModalOpen, setIsFacilityModalOpen] = useState(false);

  // Initial Data Fetching (Home and Rooms list)
  const fetchInitialData = useCallback(async () => {
    setIsLoading(true);
    setError(null);

    try {
      // Parallel requests for optimal speed
      const [homeRes, roomsRes] = await Promise.all([
        getHomeData().catch(err => {
          console.warn('Home data fetch warning:', err);
          return null;
        }),
        getRooms().catch(err => {
          console.warn('Rooms fetch warning:', err);
          return [];
        }),
      ]);

      setHomeData(homeRes);
      
      const roomList = Array.isArray(roomsRes) ? roomsRes : (roomsRes?.data || []);
      setRooms(roomList);

      // Auto-select first room to display default details
      if (roomList.length > 0) {
        const first = roomList[0];
        setSelectedRoomId(first.id);
        setSelectedRoom(first);
        // Also fetch complete details if needed
        try {
          const detail = await getRoomDetail(first.id);
          if (detail) setSelectedRoom(detail);
        } catch (detailErr) {
          console.warn('First room detail error:', detailErr);
        }
      }
    } catch (err) {
      console.error('Failed to load initial data:', err);
      setError(err.message || 'Gagal memuat data dari server backend');
    } finally {
      setIsLoading(false);
    }
  }, []);

  useEffect(() => {
    fetchInitialData();
  }, [fetchInitialData]);

  // Handler when user clicks a room on the floor plan or button
  const handleSelectRoom = async (room) => {
    if (!room || room.id === selectedRoomId) return;

    setSelectedRoomId(room.id);
    setIsRoomLoading(true);

    try {
      const roomDetail = await getRoomDetail(room.id);
      setSelectedRoom(roomDetail || room);
    } catch (err) {
      console.error('Failed to load room details:', err);
      // Fallback to existing room object
      setSelectedRoom(room);
    } finally {
      setIsRoomLoading(false);
    }
  };

  // Handler when user clicks "Lihat Fasilitas Lengkap"
  const handleOpenFacilities = async (room) => {
    const targetRoom = room || selectedRoom;
    if (!targetRoom) return;

    setIsFacilityModalOpen(true);
    setIsFacilityLoading(true);
    setFacilities([]);

    try {
      const facilitiesData = await getRoomFacilities(targetRoom.id);
      setFacilities(Array.isArray(facilitiesData) ? facilitiesData : (facilitiesData?.data || []));
    } catch (err) {
      console.error('Failed to fetch room facilities:', err);
      setFacilities([]);
    } finally {
      setIsFacilityLoading(false);
    }
  };

  const handleCloseFacilities = () => {
    setIsFacilityModalOpen(false);
  };

  const schoolName = homeData?.school_profile?.school_name || homeData?.hero?.school_name || 'SMK JHIC';
  const logoUrl = homeData?.school_profile?.school_logo || null;

  return (
    <div className="min-h-screen bg-slate-50 text-slate-800 flex flex-col selection:bg-indigo-500 selection:text-white">
      {/* 1. Navbar */}
      <Navbar schoolName={schoolName} logoUrl={logoUrl} />

      {/* Main Content Sections */}
      <main className="flex-grow">
        {error && (
          <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-28">
            <ErrorState
              title="Koneksi Backend Terkendala"
              message={error}
              onRetry={fetchInitialData}
            />
          </div>
        )}

        {/* 2. Hero Section */}
        <HeroSection
          heroData={homeData?.hero}
          isLoading={isLoading}
        />

        {/* 3. Sambutan Kepala Sekolah & Profil */}
        <SchoolProfileSection
          profileData={homeData?.school_profile}
          isLoading={isLoading}
        />

        {/* 4. Program Keahlian / Jurusan */}
        <MajorsSection />

        {/* 5. Statistik Sekolah */}
        <StatisticsSection
          statsData={homeData?.statistics}
          isLoading={isLoading}
        />

        {/* 6. Gallery Section (Carousel Otomatis & Manual) */}
        <GallerySection
          galleries={homeData?.galleries || []}
          isLoading={isLoading}
        />

        {/* 7. Denah Interaktif & Detail Ruangan */}
        <InteractiveMapSection
          rooms={rooms}
          selectedRoom={selectedRoom}
          selectedRoomId={selectedRoomId}
          onSelectRoom={handleSelectRoom}
          isRoomLoading={isRoomLoading}
          onOpenFacilities={handleOpenFacilities}
          isLoading={isLoading}
        />
      </main>

      {/* 8. Facility Modal / Drawer */}
      <FacilityModal
        isOpen={isFacilityModalOpen}
        onClose={handleCloseFacilities}
        room={selectedRoom}
        facilities={facilities}
        isLoading={isFacilityLoading}
      />

      {/* 9. Footer */}
      <Footer
        schoolName={schoolName}
        profileData={homeData?.school_profile}
      />
    </div>
  );
}

export default App;
