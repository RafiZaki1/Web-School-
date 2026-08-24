import React, { useState, useEffect } from 'react';
import { Menu, X, GraduationCap, Phone, Mail, MapPin } from 'lucide-react';

export const Navbar = ({ schoolName = 'Jakarta Honors International College', logoUrl = null }) => {
  const [isScrolled, setIsScrolled] = useState(false);
  const [mobileMenuOpen, setMobileMenuOpen] = useState(false);
  const [activeSection, setActiveSection] = useState('beranda');

  const navLinks = [
    { name: 'Beranda', href: '#beranda' },
    { name: 'Profil', href: '#profil' },
    { name: 'Jurusan', href: '#jurusan' },
    { name: 'Statistik', href: '#informasi' },
    { name: 'Galeri', href: '#galeri' },
    { name: 'Denah Kampus', href: '#denah' },
    { name: 'Kontak', href: '#kontak' },
  ];

  useEffect(() => {
    const handleScroll = () => {
      setIsScrolled(window.scrollY > 30);

      const sections = navLinks.map(link => link.href.substring(1));
      const scrollPosition = window.scrollY + 140;

      for (const sectionId of sections) {
        const el = document.getElementById(sectionId);
        if (el) {
          const top = el.offsetTop;
          const height = el.offsetHeight;
          if (scrollPosition >= top && scrollPosition < top + height) {
            setActiveSection(sectionId);
            break;
          }
        }
      }
    };

    window.addEventListener('scroll', handleScroll);
    return () => window.removeEventListener('scroll', handleScroll);
  }, []);

  const handleLinkClick = (e, href) => {
    e.preventDefault();
    setMobileMenuOpen(false);
    const targetId = href.substring(1);
    const element = document.getElementById(targetId);
    if (element) {
      element.scrollIntoView({ behavior: 'smooth' });
    }
  };

  return (
    <header className="fixed top-0 left-0 right-0 z-40">
      {/* Top utility bar */}
      <div className={`hidden lg:block bg-slate-900 text-slate-300 text-xs transition-all duration-300 ${
        isScrolled ? 'h-0 opacity-0 overflow-hidden py-0' : 'py-2 border-b border-slate-800'
      }`}>
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between">
          <div className="flex items-center gap-6">
            <span className="flex items-center gap-1.5">
              <MapPin className="w-3.5 h-3.5 text-blue-400" />
              Kampus Terpadu JHIC
            </span>
            <span className="flex items-center gap-1.5">
              <Phone className="w-3.5 h-3.5 text-blue-400" />
              (021) 8876-5432
            </span>
            <span className="flex items-center gap-1.5">
              <Mail className="w-3.5 h-3.5 text-blue-400" />
              info@jhic.sch.id
            </span>
          </div>
          <div className="flex items-center gap-4">
            <span className="text-slate-400">NPSN: 20108920</span>
            <span className="px-2 py-0.5 rounded bg-blue-900/60 text-blue-300 font-semibold border border-blue-700/50">
              Akreditasi A
            </span>
          </div>
        </div>
      </div>

      {/* Main Navbar */}
      <div className={`transition-all duration-300 ${
        isScrolled
          ? 'bg-white/95 backdrop-blur-md shadow-md py-3 border-b border-slate-200/80'
          : 'bg-gradient-to-b from-black/80 via-black/40 to-transparent py-4'
      }`}>
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="flex items-center justify-between">
            
            {/* Brand Logo & Name */}
            <a
              href="#beranda"
              onClick={(e) => handleLinkClick(e, '#beranda')}
              className="flex items-center gap-3"
            >
              <div className="w-10 h-10 rounded-lg bg-blue-600 flex items-center justify-center text-white shadow-sm overflow-hidden flex-shrink-0">
                {logoUrl ? (
                  <img src={logoUrl} alt={schoolName} className="w-full h-full object-cover" />
                ) : (
                  <GraduationCap className="w-6 h-6" />
                )}
              </div>
              <div className="flex flex-col">
                <span className={`text-base sm:text-lg font-bold tracking-tight leading-none ${
                  isScrolled ? 'text-slate-900' : 'text-white'
                }`}>
                  JHIC
                </span>
                <span className={`text-[11px] font-medium tracking-wide mt-1 ${
                  isScrolled ? 'text-slate-500' : 'text-slate-300'
                }`}>
                  Honors College & Vocational
                </span>
              </div>
            </a>

            {/* Desktop Navigation Links */}
            <nav className="hidden md:flex items-center gap-1">
              {navLinks.map((link) => {
                const isActive = activeSection === link.href.substring(1);
                return (
                  <a
                    key={link.name}
                    href={link.href}
                    onClick={(e) => handleLinkClick(e, link.href)}
                    className={`px-3.5 py-2 rounded-lg text-sm font-medium transition-colors ${
                      isActive
                        ? isScrolled
                          ? 'bg-blue-50 text-blue-600 font-semibold'
                          : 'bg-white/20 text-white font-semibold'
                        : isScrolled
                        ? 'text-slate-600 hover:text-blue-600 hover:bg-slate-50'
                        : 'text-slate-200 hover:text-white hover:bg-white/10'
                    }`}
                  >
                    {link.name}
                  </a>
                );
              })}
            </nav>

            {/* CTA Button */}
            <div className="hidden lg:flex items-center">
              <a
                href="#denah"
                onClick={(e) => handleLinkClick(e, '#denah')}
                className="px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold shadow-sm transition-all"
              >
                Denah Ruangan
              </a>
            </div>

            {/* Mobile Menu Button */}
            <div className="flex md:hidden">
              <button
                onClick={() => setMobileMenuOpen(!mobileMenuOpen)}
                className={`p-2 rounded-lg ${
                  isScrolled ? 'text-slate-700 hover:bg-slate-100' : 'text-white hover:bg-white/10'
                }`}
                aria-label="Toggle Menu"
              >
                {mobileMenuOpen ? <X className="w-6 h-6" /> : <Menu className="w-6 h-6" />}
              </button>
            </div>

          </div>
        </div>
      </div>

      {/* Mobile Drawer */}
      {mobileMenuOpen && (
        <div className="md:hidden bg-white border-b border-slate-200 shadow-xl px-4 py-4 space-y-1">
          {navLinks.map((link) => {
            const isActive = activeSection === link.href.substring(1);
            return (
              <a
                key={link.name}
                href={link.href}
                onClick={(e) => handleLinkClick(e, link.href)}
                className={`block px-4 py-2.5 rounded-lg text-sm font-medium ${
                  isActive
                    ? 'bg-blue-50 text-blue-600 font-semibold'
                    : 'text-slate-700 hover:bg-slate-50'
                }`}
              >
                {link.name}
              </a>
            );
          })}
        </div>
      )}
    </header>
  );
};

export default Navbar;
