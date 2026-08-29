import { Outfit } from "next/font/google";
import "./globals.css";
import ChatbotWidget from "@/components/chatbot/ChatbotWidget";

const outfit = Outfit({
  subsets: ["latin"],
  variable: "--font-outfit",
  weight: ["300", "400", "500", "600", "700", "800", "900"],
});

export const viewport = {
  width: "device-width",
  initialScale: 1,
  maximumScale: 5,
  viewportFit: "cover",
  themeColor: "#022140",
};

export const metadata = {
  title: "SMK Negeri 2 Kota Mojokerto",
  description: "Website Resmi SMK Negeri 2 Kota Mojokerto - Disiplin, Berakhlak, Berprestasi",
  icons: {
    icon: "/images/logo-smkn2.png",
    shortcut: "/favicon.ico",
    apple: "/images/logo-smkn2.png",
  },
};

export default function RootLayout({ children }) {
  return (
    <html lang="id" className={`scroll-smooth ${outfit.variable}`}>
      <body className="bg-slate-50 text-slate-800 antialiased min-h-screen flex flex-col font-sans selection:bg-[#05529E] selection:text-white">
        {children}
        <ChatbotWidget schoolName="SMKN 2 Kota Mojokerto" />
      </body>
    </html>
  );
}
