import React from 'react';
import { Award, CheckCircle2, ShieldCheck } from 'lucide-react';
import Skeleton from '../common/Skeleton';

export const SchoolProfileSection = ({ profileData, isLoading }) => {
  if (isLoading) {
    return (
      <section id="profil" className="py-20 bg-white px-4 sm:px-6 lg:px-8">
        <div className="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
          <div className="lg:col-span-5">
            <Skeleton className="h-80 w-full rounded-2xl" />
          </div>
          <div className="lg:col-span-7 space-y-3">
            <Skeleton className="h-5 w-28" />
            <Skeleton className="h-8 w-3/4" />
            <Skeleton className="h-24 w-full" />
          </div>
        </div>
      </section>
    );
  }

  const schoolName = profileData?.school_name || 'Jakarta Honors International College';
  const principalName = profileData?.principal_name || 'Dr. H. Muhammad Arifin, M.Pd.';
  const principalPosition = profileData?.principal_position || 'Kepala Sekolah';
  const principalPhoto = profileData?.principal_photo || 'https://images.unsplash.com/photo-1560250097-0b93528c311a?q=80&w=800&auto=format&fit=crop';
  const welcomeMessage = profileData?.welcome_message || 
    'Selamat datang di website resmi Jakarta Honors International College (JHIC). Kami berkomitmen memberikan pengalaman belajar terbaik yang memadukan keunggulan akademik, teknologi modern, dan penanaman nilai budi pekerti luhur bagi seluruh peserta didik kami.';

  return (
    <section id="profil" className="py-20 bg-white border-b border-slate-200/80">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-14 items-center">
          
          {/* Principal Photo */}
          <div className="lg:col-span-5">
            <div className="relative rounded-2xl overflow-hidden shadow-lg border border-slate-200 bg-slate-50">
              <div className="aspect-[4/5] w-full overflow-hidden bg-slate-100">
                <img
                  src={principalPhoto}
                  alt={principalName}
                  className="w-full h-full object-cover object-top"
                  onError={(e) => {
                    e.target.src = 'https://images.unsplash.com/photo-1560250097-0b93528c311a?q=80&w=800&auto=format&fit=crop';
                  }}
                />
              </div>

              <div className="p-5 bg-slate-900 text-white">
                <h3 className="text-base font-bold text-white">{principalName}</h3>
                <p className="text-xs text-blue-400 font-medium mt-0.5">{principalPosition} — {schoolName}</p>
              </div>
            </div>
          </div>

          {/* Welcome Text */}
          <div className="lg:col-span-7 space-y-5">
            <div className="inline-block px-3 py-1 rounded bg-blue-50 text-blue-700 text-xs font-semibold uppercase tracking-wider">
              Sambutan Kepala Sekolah
            </div>

            <h2 className="text-2xl sm:text-3xl font-bold text-slate-900 tracking-tight leading-snug">
              Mewujudkan Pendidikan Vokasi Berdaya Saing Global
            </h2>

            <p className="text-sm sm:text-base text-slate-600 leading-relaxed">
              "{welcomeMessage}"
            </p>

            <div className="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-3 border-t border-slate-100">
              <div className="flex items-start gap-3 p-3.5 rounded-xl bg-slate-50 border border-slate-200/70">
                <CheckCircle2 className="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" />
                <div>
                  <h4 className="text-xs font-bold text-slate-900 uppercase">Kurikulum Terapan</h4>
                  <p className="text-xs text-slate-500 mt-0.5">Diselaraskan dengan kebutuhan industri terkemuka.</p>
                </div>
              </div>

              <div className="flex items-start gap-3 p-3.5 rounded-xl bg-slate-50 border border-slate-200/70">
                <ShieldCheck className="w-5 h-5 text-emerald-600 flex-shrink-0 mt-0.5" />
                <div>
                  <h4 className="text-xs font-bold text-slate-900 uppercase">Sertifikasi BNSP</h4>
                  <p className="text-xs text-slate-500 mt-0.5">Uji kompetensi profesi terstandar nasional.</p>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
    </section>
  );
};

export default SchoolProfileSection;
