import React, { useRef, useState, useEffect } from 'react';
import { ChevronLeft, ChevronRight, Image as ImageIcon, Sparkles } from 'lucide-react';
import Skeleton from '../common/Skeleton';

export const GallerySection = ({ galleries = [], isLoading }) => {
  const scrollContainerRef = useRef(null);
  const [isPaused, setIsPaused] = useState(false);
  const [activeCategory, setActiveCategory] = useState('Semua');

  // Filter categories
  const categories = ['Semua', ...new Set(galleries.map(item => item.category).filter(Boolean))];
  const filteredGalleries = activeCategory === 'Semua' 
    ? galleries 
    : galleries.filter(item => item.category === activeCategory);

  // Auto-scroll loop effect
  useEffect(() => {
    if (isPaused || filteredGalleries.length === 0) return;

    const interval = setInterval(() => {
      if (scrollContainerRef.current) {
        const { scrollLeft, scrollWidth, clientWidth } = scrollContainerRef.current;
        if (scrollLeft + clientWidth >= scrollWidth - 10) {
          scrollContainerRef.current.scrollTo({ left: 0, behavior: 'smooth' });
        } else {
          scrollContainerRef.current.scrollBy({ left: 320, behavior: 'smooth' });
        }
      }
    }, 3500);

    return () => clearInterval(interval);
  }, [isPaused, filteredGalleries]);

  const handleManualScroll = (direction) => {
    if (scrollContainerRef.current) {
      const scrollAmount = direction === 'left' ? -340 : 340;
      scrollContainerRef.current.scrollBy({ left: scrollAmount, behavior: 'smooth' });
    }
  };

  return (
    <section id="galeri" className="py-20 bg-slate-900 text-white relative overflow-hidden">
      {/* Decorative backdrop gradients */}
      <div className="absolute top-0 right-0 w-96 h-96 bg-indigo-600/10 rounded-full blur-3xl pointer-events-none" />
      <div className="absolute bottom-0 left-0 w-96 h-96 bg-blue-600/10 rounded-full blur-3xl pointer-events-none" />

      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        {/* Header */}
        <div className="flex flex-col md:flex-row md:items-end justify-between mb-10 gap-6">
          <div>
            <div className="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-indigo-500/20 border border-indigo-500/30 text-indigo-300 text-xs font-semibold uppercase tracking-wider mb-3">
              <Sparkles className="w-3.5 h-3.5" />
              <span>Dokumentasi Sekolah</span>
            </div>
            <h2 className="text-3xl sm:text-4xl font-bold tracking-tight text-white">
              Galeri Kegiatan & Lingkungan
            </h2>
            <p className="mt-2 text-base text-slate-300 max-w-xl">
              Potret aktivitas pembelajaran, prestasi siswa, fasilitas, dan momen berharga di sekolah.
            </p>
          </div>

          {/* Navigation Controls */}
          <div className="flex items-center gap-2">
            <button
              onClick={() => handleManualScroll('left')}
              className="w-11 h-11 rounded-xl bg-slate-800 hover:bg-slate-700 text-white flex items-center justify-center border border-slate-700 active:scale-95 transition-all shadow-sm cursor-pointer"
              aria-label="Previous Slide"
            >
              <ChevronLeft className="w-5 h-5" />
            </button>
            <button
              onClick={() => handleManualScroll('right')}
              className="w-11 h-11 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white flex items-center justify-center border border-indigo-500 active:scale-95 transition-all shadow-md shadow-indigo-600/20 cursor-pointer"
              aria-label="Next Slide"
            >
              <ChevronRight className="w-5 h-5" />
            </button>
          </div>
        </div>

        {/* Category Filters (if multiple categories exist) */}
        {categories.length > 1 && (
          <div className="flex items-center gap-2 pb-4 overflow-x-auto no-scrollbar mb-6">
            {categories.map((cat) => (
              <button
                key={cat}
                onClick={() => setActiveCategory(cat)}
                className={`px-4 py-1.5 rounded-full text-xs font-medium whitespace-nowrap transition-all cursor-pointer ${
                  activeCategory === cat
                    ? 'bg-indigo-600 text-white shadow-sm'
                    : 'bg-slate-800 text-slate-300 hover:bg-slate-700'
                }`}
              >
                {cat}
              </button>
            ))}
          </div>
        )}

        {/* Carousel Content */}
        {isLoading ? (
          <div className="flex gap-6 overflow-hidden py-4">
            {[1, 2, 3, 4].map((i) => (
              <div key={i} className="min-w-[300px] sm:min-w-[360px] h-72 rounded-2xl overflow-hidden bg-slate-800 animate-pulse" />
            ))}
          </div>
        ) : filteredGalleries.length === 0 ? (
          <div className="text-center py-16 bg-slate-800/40 rounded-2xl border border-slate-800">
            <ImageIcon className="w-12 h-12 text-slate-500 mx-auto mb-3" />
            <p className="text-slate-400 text-sm">Belum ada foto galeri yang ditampilkan.</p>
          </div>
        ) : (
          <div
            ref={scrollContainerRef}
            onMouseEnter={() => setIsPaused(true)}
            onMouseLeave={() => setIsPaused(false)}
            onTouchStart={() => setIsPaused(true)}
            onTouchEnd={() => setIsPaused(false)}
            className="flex gap-6 overflow-x-auto no-scrollbar py-4 scroll-smooth cursor-grab active:cursor-grabbing"
          >
            {filteredGalleries.map((item) => (
              <div
                key={item.id}
                className="group relative min-w-[280px] sm:min-w-[340px] md:min-w-[380px] h-80 rounded-2xl overflow-hidden bg-slate-800 border border-slate-700/60 shadow-lg flex-shrink-0 transition-transform duration-300 hover:-translate-y-1.5"
              >
                <img
                  src={item.image || 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?q=80&w=800&auto=format&fit=crop'}
                  alt={item.title || 'Galeri Sekolah'}
                  className="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-700"
                  onError={(e) => {
                    e.target.src = 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?q=80&w=800&auto=format&fit=crop';
                  }}
                />

                {/* Dark Gradient Overlay */}
                <div className="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/40 to-transparent opacity-80 group-hover:opacity-90 transition-opacity" />

                {/* Badge Category */}
                {item.category && (
                  <div className="absolute top-4 left-4">
                    <span className="px-3 py-1 rounded-full bg-slate-900/80 backdrop-blur-md text-indigo-300 text-xs font-semibold border border-indigo-500/30">
                      {item.category}
                    </span>
                  </div>
                )}

                {/* Text Content */}
                <div className="absolute bottom-0 inset-x-0 p-5">
                  <h3 className="text-lg font-bold text-white group-hover:text-indigo-200 transition-colors">
                    {item.title}
                  </h3>
                  {item.description && (
                    <p className="mt-1 text-xs sm:text-sm text-slate-300 line-clamp-2">
                      {item.description}
                    </p>
                  )}
                </div>
              </div>
            ))}
          </div>
        )}
      </div>
    </section>
  );
};

export default GallerySection;
