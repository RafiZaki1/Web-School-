import React from 'react';
import { GraduationCap, MapPin, Phone, Mail, Clock } from 'lucide-react';

export const Footer = ({ schoolName = 'Jakarta Honors International College', profileData }) => {
  return (
    <footer id="kontak" className="bg-slate-900 text-slate-300 pt-16 pb-10 border-t border-slate-800">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-10 pb-12 border-b border-slate-800">
          
          {/* Col 1 */}
          <div className="lg:col-span-4 space-y-3">
            <div className="flex items-center gap-2.5">
              <div className="w-8 h-8 rounded-lg bg-blue-600 flex items-center justify-center text-white">
                <GraduationCap className="w-5 h-5" />
              </div>
              <span className="text-base font-bold text-white tracking-tight">{schoolName}</span>
            </div>
            <p className="text-xs sm:text-sm text-slate-400 leading-relaxed">
              Mendidik generasi muda berintegritas dan siap kerja melalui pembelajaran vokasi terapan serta sertifikasi industri nasional & global.
            </p>
            <div className="pt-1">
              <span className="text-xs px-2.5 py-1 rounded bg-slate-800 text-slate-300 border border-slate-700 font-medium">
                Akreditasi A Unggul (BAN-SM)
              </span>
            </div>
          </div>

          {/* Col 2 */}
          <div className="lg:col-span-2 space-y-2">
            <h4 className="text-xs font-bold text-white uppercase tracking-wider">Tautan Navigasi</h4>
            <ul className="space-y-1.5 text-xs text-slate-400">
              <li><a href="#beranda" className="hover:text-white transition-colors">Beranda</a></li>
              <li><a href="#profil" className="hover:text-white transition-colors">Profil Sekolah</a></li>
              <li><a href="#jurusan" className="hover:text-white transition-colors">Program Keahlian</a></li>
              <li><a href="#informasi" className="hover:text-white transition-colors">Statistik</a></li>
              <li><a href="#galeri" className="hover:text-white transition-colors">Galeri</a></li>
              <li><a href="#denah" className="hover:text-white transition-colors">Denah Kampus</a></li>
            </ul>
          </div>

          {/* Col 3 */}
          <div className="lg:col-span-3 space-y-2">
            <h4 className="text-xs font-bold text-white uppercase tracking-wider">Program Keahlian</h4>
            <ul className="space-y-1.5 text-xs text-slate-400">
              <li>Rekayasa Perangkat Lunak (RPL)</li>
              <li>Teknik Komputer & Jaringan (TKJ)</li>
              <li>Desain Komunikasi Visual (DKV)</li>
              <li>Uji Kompetensi & Sertifikasi BNSP</li>
            </ul>
          </div>

          {/* Col 4 */}
          <div className="lg:col-span-3 space-y-2.5">
            <h4 className="text-xs font-bold text-white uppercase tracking-wider">Sekretariat & Kontak</h4>
            <ul className="space-y-2 text-xs text-slate-400">
              <li className="flex items-start gap-2">
                <MapPin className="w-4 h-4 text-blue-400 flex-shrink-0 mt-0.5" />
                <span>Jl. Pendidikan Vokasi No. 88, Kampus Terpadu JHIC</span>
              </li>
              <li className="flex items-center gap-2">
                <Phone className="w-4 h-4 text-blue-400 flex-shrink-0" />
                <span>(021) 8876-5432</span>
              </li>
              <li className="flex items-center gap-2">
                <Mail className="w-4 h-4 text-blue-400 flex-shrink-0" />
                <span>info@jhic.sch.id</span>
              </li>
              <li className="flex items-center gap-2">
                <Clock className="w-4 h-4 text-blue-400 flex-shrink-0" />
                <span>Senin - Jumat: 07.00 - 16.00 WIB</span>
              </li>
            </ul>
          </div>

        </div>

        {/* Bottom */}
        <div className="pt-6 flex flex-col sm:flex-row items-center justify-between gap-2 text-xs text-slate-500">
          <p>© {new Date().getFullYear()} {schoolName}. Hak Cipta Dilindungi.</p>
          <p>Sistem Informasi Profil Sekolah</p>
        </div>
      </div>
    </footer>
  );
};

export default Footer;
