export default function VisiMisiSection() {
  const visiMisiTujuan = [
    {
      icon: "eye",
      title: "Visi",
      text: "Menjadi lembaga pendidikan dan pelatihan vokasi yang unggul, berkarakter, berwawasan lingkungan, dan berstandar internasional.",
    },
    {
      icon: "sprout",
      title: "Misi",
      text: "Menyelenggarakan pembelajaran berbasis proyek industri, membekal peserta didik dengan kompetensi abad 21, dan membangun kemitraan strategis.",
    },
    {
      icon: "flag",
      title: "Tujuan",
      text: "Menghasilkan lulusan yang kompeten, kompetitif, adaptif, dan siap kerja atau berwirausaha sesuai kebutuhan Dunia Usaha dan Industri (DUDI).",
    },
  ];

  return (
    <section id="profil" className="mx-auto max-w-5xl px-5 py-16 lg:px-8">
      <div className="grid gap-5 sm:grid-cols-3">
        {visiMisiTujuan.map((item, idx) => (
          <div
            key={idx}
            className="rounded-2xl border border-slate-100 bg-white p-6 shadow-sm hover:shadow-md transition duration-300"
          >
            <span className="flex h-10 w-10 items-center justify-center rounded-full bg-lime-50 text-lime-600">
              {item.icon === "eye" && (
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" className="h-5 w-5">
                  <path d="M10 12.5a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z" />
                  <path fillRule="evenodd" d="M.664 10.59a1.651 1.651 0 0 1 0-1.186A10.004 10.004 0 0 1 10 3c4.257 0 7.893 2.66 9.336 6.41.147.381.146.804 0 1.186A10.004 10.004 0 0 1 10 17c-4.257 0-7.893-2.66-9.336-6.41ZM14 10a4 4 0 1 1-8 0 4 4 0 0 1 8 0Z" clipRule="evenodd" />
                </svg>
              )}
              {item.icon === "sprout" && (
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" className="h-5 w-5">
                  <path d="M10 2a6 6 0 0 0-6 6c0 3.5 3 6.5 6 10 3-3.5 6-6.5 6-10a6 6 0 0 0-6-6Zm0 8a2 2 0 1 1 0-4 2 2 0 0 1 0 4Z" />
                </svg>
              )}
              {item.icon === "flag" && (
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" className="h-5 w-5">
                  <path d="M4 2.75A.75.75 0 0 1 4.75 2h1.5a.75.75 0 0 1 0 1.5H5.5v13a.75.75 0 0 1-1.5 0v-13.75ZM6.5 4h8.086a1 1 0 0 1 .707 1.707L13 8l2.293 2.293A1 1 0 0 1 14.586 12H6.5V4Z" />
                </svg>
              )}
            </span>
            <h3 className="mt-4 font-bold text-slate-950">{item.title}</h3>
            <p className="mt-2 text-sm leading-6 text-slate-600">{item.text}</p>
          </div>
        ))}
      </div>
    </section>
  );
}
