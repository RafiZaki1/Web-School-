import React from 'react';
import { Code2, Cpu, Wrench, Palette, Globe, Layers, ArrowUpRight } from 'lucide-react';

export const MajorsSection = () => {
  const majors = [
    {
      id: 'rpl',
      name: 'Rekayasa Perangkat Lunak (RPL)',
      tagline: 'Software Engineering & Web Development',
      description: 'Mempelajari pemrograman modern, pengembangan web, mobile app, API backend, dan arsitektur database skala industri.',
      icon: Code2,
      color: 'from-blue-600 to-indigo-600',
      badgeColor: 'bg-blue-50 text-blue-700 border-blue-100',
      careers: ['Fullstack Developer', 'Frontend Engineer', 'Backend Engineer', 'QA Tester'],
    },
    {
      id: 'tkj',
      name: 'Teknik Komputer & Jaringan (TKJ)',
      tagline: 'Network Architecture & Cyber Security',
      description: 'Mendalami perancangan jaringan komputer, server enterprise, cloud computing, routing mikrotik/cisco, dan keamanan sistem.',
      icon: Cpu,
      color: 'from-indigo-600 to-purple-600',
      badgeColor: 'bg-indigo-50 text-indigo-700 border-indigo-100',
      careers: ['Network Engineer', 'System Administrator', 'DevOps Specialist', 'IT Support'],
    },
    {
      id: 'dkv',
      name: 'Desain Komunikasi Visual (DKV)',
      tagline: 'Creative Design & Multimedia',
      description: 'Mengasah kreativitas dalam desain grafis, animasi 2D/3D, UI/UX design, fotografi, videografi, dan branding visual.',
      icon: Palette,
      color: 'from-purple-600 to-pink-600',
      badgeColor: 'bg-purple-50 text-purple-700 border-purple-100',
      careers: ['UI/UX Designer', 'Motion Graphic Designer', 'Brand Strategist', 'Video Editor'],
    },
  ];

  return (
    <section id="jurusan" className="py-24 bg-white relative">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {/* Section Header */}
        <div className="text-center max-w-3xl mx-auto mb-16">
          <div className="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-indigo-50 border border-indigo-100 text-indigo-700 text-xs font-bold uppercase tracking-wider mb-3">
            <Layers className="w-3.5 h-3.5" />
            <span>Program Unggulan</span>
          </div>
          <h2 className="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">
            Program Keahlian Masa Depan
          </h2>
          <p className="mt-3 text-base sm:text-lg text-slate-600">
            Kurikulum berbasis industri dengan sertifikasi kompetensi untuk mempersiapkan siswa langsung terjun ke dunia kerja.
          </p>
        </div>

        {/* Majors Grid */}
        <div className="grid grid-cols-1 md:grid-cols-3 gap-8">
          {majors.map((major) => {
            const Icon = major.icon;
            return (
              <div
                key={major.id}
                className="group relative rounded-3xl bg-white border border-slate-200/80 p-8 shadow-sm hover:shadow-2xl hover:border-indigo-200 transition-all duration-300 flex flex-col justify-between hover:-translate-y-1.5"
              >
                <div>
                  <div className="w-14 h-14 rounded-2xl bg-gradient-to-tr text-white flex items-center justify-center mb-6 shadow-md shadow-indigo-100 group-hover:scale-110 transition-transform duration-300 bg-indigo-600">
                    <Icon className="w-7 h-7" />
                  </div>

                  <div className={`inline-block px-3 py-1 rounded-full text-xs font-bold border mb-3 ${major.badgeColor}`}>
                    {major.tagline}
                  </div>

                  <h3 className="text-xl font-bold text-slate-900 mb-3 group-hover:text-indigo-600 transition-colors">
                    {major.name}
                  </h3>

                  <p className="text-sm text-slate-600 leading-relaxed mb-6">
                    {major.description}
                  </p>
                </div>

                <div>
                  <h4 className="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Prospek Karir:</h4>
                  <div className="flex flex-wrap gap-1.5">
                    {major.careers.map((career, i) => (
                      <span key={i} className="text-xs px-2.5 py-1 rounded-lg bg-slate-100 text-slate-700 font-medium">
                        {career}
                      </span>
                    ))}
                  </div>
                </div>
              </div>
            );
          })}
        </div>

      </div>
    </section>
  );
};

export default MajorsSection;
