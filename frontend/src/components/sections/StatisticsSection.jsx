import React, { useEffect, useState } from 'react';
import { Users, GraduationCap, Calendar, BookOpen, UserCheck } from 'lucide-react';
import Skeleton from '../common/Skeleton';

const Counter = ({ targetValue = 0, duration = 1500 }) => {
  const [count, setCount] = useState(0);

  useEffect(() => {
    const target = Number(targetValue) || 0;
    if (target === 0) {
      setCount(0);
      return;
    }

    let current = 0;
    const step = 20;
    const increment = Math.ceil(target / (duration / step));

    const timer = setInterval(() => {
      current += increment;
      if (current >= target) {
        setCount(target);
        clearInterval(timer);
      } else {
        setCount(current);
      }
    }, step);

    return () => clearInterval(timer);
  }, [targetValue, duration]);

  return <span>{count.toLocaleString('id-ID')}</span>;
};

export const StatisticsSection = ({ statsData, isLoading }) => {
  const items = [
    {
      id: 'students',
      label: 'Siswa Aktif',
      value: statsData?.total_students ?? 1250,
      suffix: '+',
      icon: Users,
    },
    {
      id: 'teachers',
      label: 'Guru & Staf Pengajar',
      value: statsData?.total_teachers ?? 75,
      suffix: '+',
      icon: UserCheck,
    },
    {
      id: 'year',
      label: 'Tahun Berdiri',
      value: statsData?.established_year ?? 2014,
      suffix: '',
      icon: Calendar,
    },
    {
      id: 'majors',
      label: 'Program Keahlian',
      value: statsData?.total_majors ?? 4,
      suffix: '',
      icon: BookOpen,
    },
    {
      id: 'alumni',
      label: 'Alumni Terserap Kerja',
      value: statsData?.total_alumni ?? 3500,
      suffix: '+',
      icon: GraduationCap,
    },
  ];

  return (
    <section id="informasi" className="py-16 bg-slate-900 text-white">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
          {isLoading ? (
            [1, 2, 3, 4, 5].map((i) => (
              <div key={i} className="p-4 rounded-xl bg-slate-800 animate-pulse h-28" />
            ))
          ) : (
            items.map((item) => {
              const Icon = item.icon;
              return (
                <div
                  key={item.id}
                  className="p-5 rounded-xl bg-slate-800/80 border border-slate-700/80 flex flex-col justify-between"
                >
                  <div className="flex items-center justify-between mb-3">
                    <span className="text-xs font-semibold text-slate-400 uppercase tracking-wider">{item.label}</span>
                    <Icon className="w-5 h-5 text-blue-400" />
                  </div>
                  <div className="text-2xl sm:text-3xl font-bold text-white tracking-tight">
                    <Counter targetValue={item.value} />
                    <span className="text-blue-400 text-xl font-normal ml-0.5">{item.suffix}</span>
                  </div>
                </div>
              );
            })
          )}
        </div>
      </div>
    </section>
  );
};

export default StatisticsSection;
