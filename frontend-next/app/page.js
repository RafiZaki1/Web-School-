import { homeApi } from "@/lib/api/homeApi";
import Navbar from "@/components/layout/Navbar";
import Footer from "@/components/layout/Footer";
import HeroSection from "@/components/home/HeroSection";
import SambutanSection from "@/components/home/SambutanSection";
import VisiMisiSection from "@/components/home/VisiMisiSection";
import JurusanSection from "@/components/home/JurusanSection";
import MitraSection from "@/components/home/MitraSection";
import EkstrakurikulerSection from "@/components/home/EkstrakurikulerSection";
import PrestasiSection from "@/components/home/PrestasiSection";
import BeritaSection from "@/components/home/BeritaSection";
import PpdbModal from "@/components/home/PpdbModal";
import DenahInteraktif from "@/components/denah/DenahInteraktif";

export const revalidate = 60; // Revalidate every 60 seconds (ISR)

export async function generateMetadata() {
  const homeData = await homeApi.getHomeData();
  const schoolName =
    homeData?.school_profile?.school_name ||
    homeData?.hero?.school_name ||
    "SMK Negeri 2 Kota Mojokerto";

  return {
    title: `${schoolName} - Disiplin, Berakhlak, Berprestasi`,
    description:
      homeData?.school_profile?.description ||
      "Pusat keunggulan vokasi, teknologi, rekayasa perangkat lunak, dan seni kuliner di Kota Mojokerto.",
  };
}

export default async function HomePage() {
  const homeData = await homeApi.getHomeData();

  const hero = homeData?.hero || null;
  const schoolProfile = homeData?.school_profile || null;
  const statistics = homeData?.statistics || {};
  const schoolName =
    schoolProfile?.school_name || hero?.school_name || "SMK NEGERI 2 KOTA MOJOKERTO";

  return (
    <>
      <Navbar variant="transparent" schoolName={schoolName} />

      <main className="flex-1">
        {/* 1. Hero Section + Arc Carousel */}
        <HeroSection hero={hero} schoolProfile={schoolProfile} />

        {/* 2. Sambutan Kepala Sekolah + Stats Bar */}
        <SambutanSection statistics={statistics} />

        {/* 3. Visi, Misi, Tujuan */}
        <VisiMisiSection />

        {/* 4. Program Keahlian / Jurusan */}
        <JurusanSection />

        {/* 5. Denah Interaktif Sekolah */}
        <DenahInteraktif />

        {/* 6. Mitra Industri Kami */}
        <MitraSection />

        {/* 7. Ekstrakurikuler */}
        <EkstrakurikulerSection />

        {/* 8. Prestasi & Kejuaraan */}
        <PrestasiSection />

        {/* 9. Berita Terbaru */}
        <BeritaSection />
      </main>

      {/* 10. Interactive PPDB News & Info Modal (Opens upon user click) */}
      <PpdbModal />

      {/* 11. Footer */}
      <Footer />
    </>
  );
}
