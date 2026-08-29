"use client";

import { useState, useEffect, useRef } from "react";
import { chatbotApi } from "@/lib/api/chatbotApi";

const QUICK_PROMPTS = [
  { label: "🎓 Jurusan SMKN 2", prompt: "Apa saja program keahlian / jurusan di SMKN 2 Mojokerto?" },
  { label: "📋 Info PPDB", prompt: "Bagaimana jalur dan syarat pendaftaran PPDB di SMKN 2 Mojokerto?" },
  { label: "🏫 Fasilitas & Lab", prompt: "Fasilitas dan laboratorium apa saja yang tersedia di SMKN 2?" },
  { label: "🗺️ Denah Interaktif", prompt: "Bagaimana cara melihat dan mencari rute denah ruangan di website ini?" },
  { label: "🏆 Ekstrakurikuler", prompt: "Apa saja kegiatan ekstrakurikuler unggulan di SMKN 2 Mojokerto?" },
  { label: "🎯 Visi & Misi", prompt: "Apa visi, misi, dan tujuan SMK Negeri 2 Kota Mojokerto?" },
  { label: "📍 Kontak & Lokasi", prompt: "Di mana alamat dan kontak resmi SMK Negeri 2 Kota Mojokerto?" },
];

const CLIENT_TOXIC_WORDS = [
  "anjing", "babi", "bangsat", "kontol", "memek", "jembut", "tolol", "goblok",
  "bajingan", "pantek", "kampret", "asu", "bgst", "idiot", "lonte", "ngentot"
];

// Helper to format bold and linebreaks cleanly
function renderFormattedMessage(text) {
  if (!text) return "";
  const lines = text.split("\n");
  return lines.map((line, idx) => {
    // Replace **text** with bold tags
    const parts = line.split(/(\*\*.*?\*\*)/g);
    return (
      <span key={idx} className="block min-h-[1.1em]">
        {parts.map((part, pIdx) => {
          if (part.startsWith("**") && part.endsWith("**")) {
            return (
              <strong key={pIdx} className="font-bold text-[#05529E]">
                {part.slice(2, -2)}
              </strong>
            );
          }
          return part;
        })}
      </span>
    );
  });
}

export default function ChatbotWidget({ schoolName = "SMKN 2 Kota Mojokerto" }) {
  const [isOpen, setIsOpen] = useState(false);
  const [messages, setMessages] = useState([
    {
      id: "welcome",
      role: "bot",
      content: "Halo sahabat SMKN 2! 👋\nSelamat datang di **SADA Virtual Assistant**.\nSADA siap membantu Anda menemukan informasi jurusan, denah ruangan, maupun info PPDB di **SMK Negeri 2 Kota Mojokerto** dengan senang hati. Ada yang bisa SADA bantu hari ini? 😊",
      time: "Online",
    },
  ]);
  const [inputValue, setInputValue] = useState("");
  const [isTyping, setIsTyping] = useState(false);
  const [cooldown, setCooldown] = useState(0);
  const [spamAlert, setSpamAlert] = useState(null);
  const [showChips, setShowChips] = useState(true);

  const messagesEndRef = useRef(null);
  const lastMessageRef = useRef("");
  const timestampsRef = useRef([]);

  // Auto scroll to bottom
  useEffect(() => {
    if (isOpen) {
      messagesEndRef.current?.scrollIntoView({ behavior: "smooth" });
    }
  }, [messages, isOpen, isTyping]);

  // Listen to external toggle event
  useEffect(() => {
    const handleToggle = (e) => {
      const shouldOpen = e.detail?.open !== undefined ? e.detail.open : true;
      setIsOpen(shouldOpen);
    };

    window.addEventListener("sada:toggle-chatbot", handleToggle);
    return () => window.removeEventListener("sada:toggle-chatbot", handleToggle);
  }, []);

  // Cooldown timer interval
  useEffect(() => {
    if (cooldown <= 0) return;
    const timer = setInterval(() => {
      setCooldown((prev) => Math.max(0, prev - 1));
    }, 1000);
    return () => clearInterval(timer);
  }, [cooldown]);

  const showSpamWarning = (msg) => {
    setSpamAlert(msg);
    setTimeout(() => setSpamAlert(null), 5000);
  };

  const checkRateLimit = () => {
    const now = Date.now();
    timestampsRef.current = timestampsRef.current.filter((t) => now - t < 60000);
    if (timestampsRef.current.length >= 5) {
      const wait = Math.ceil((60000 - (now - timestampsRef.current[0])) / 1000);
      showSpamWarning(`Batas pesan tercapai (5/menit). Harap tunggu ${wait} detik.`);
      return false;
    }
    timestampsRef.current.push(now);
    return true;
  };

  const handleSendMessage = async (textToSend) => {
    const text = (textToSend || inputValue).trim();
    if (!text) return;

    if (cooldown > 0) {
      showSpamWarning(`Harap tunggu ${cooldown} detik sebelum mengirim pesan lagi.`);
      return;
    }

    if (!checkRateLimit()) return;

    // Check toxic words
    const lower = text.toLowerCase();
    const containsToxic = CLIENT_TOXIC_WORDS.some((word) => lower.includes(word));
    if (containsToxic) {
      const userMsg = {
        id: Date.now().toString(),
        role: "user",
        content: text,
        time: new Date().toLocaleTimeString([], { hour: "2-digit", minute: "2-digit" }),
      };
      const botGuard = {
        id: (Date.now() + 1).toString(),
        role: "bot",
        content:
          "Mohon maaf dengan hormat, SADA siap membantu menjawab informasi positif seputar **SMK Negeri 2 Kota Mojokerto** dengan tutur kata yang santun dan bersahabat 😊.\n\nAda yang bisa kami bantu terkait informasi jurusan, fasilitas, atau pendaftaran PPDB?",
        time: new Date().toLocaleTimeString([], { hour: "2-digit", minute: "2-digit" }),
      };
      setMessages((prev) => [...prev, userMsg, botGuard]);
      setInputValue("");
      return;
    }

    // Check duplicate
    if (text === lastMessageRef.current) {
      showSpamWarning("Pertanyaan yang sama baru saja diajukan. Coba pertanyaan lain.");
      return;
    }
    lastMessageRef.current = text;

    const userMsg = {
      id: Date.now().toString(),
      role: "user",
      content: text,
      time: new Date().toLocaleTimeString([], { hour: "2-digit", minute: "2-digit" }),
    };

    setMessages((prev) => [...prev, userMsg]);
    setInputValue("");
    setIsTyping(true);
    setCooldown(2);

    try {
      // Build history
      const historyPayload = messages
        .filter((m) => m.id !== "welcome")
        .slice(-6)
        .map((m) => ({
          role: m.role === "user" ? "user" : "assistant",
          content: m.content,
        }));

      const res = await chatbotApi.sendMessage(text, historyPayload);

      const replyText =
        res?.reply ||
        res?.answer ||
        (typeof res === "string" ? res : "Terima kasih atas pertanyaannya! SADA siap membantu.");

      // Check if response suggests viewing a room or route
      let actions = null;
      if (res?.room_slug || res?.target_room) {
        actions = {
          type: "select-room",
          slug: res.room_slug || res.target_room,
          label: "Lihat di Denah Interaktif",
        };
      } else if (res?.route_from && res?.route_to) {
        actions = {
          type: "show-route",
          from: res.route_from,
          to: res.route_to,
          label: "Buka Jalur Rute di Denah",
        };
      }

      const botMsg = {
        id: (Date.now() + 1).toString(),
        role: "bot",
        content: replyText,
        actions,
        time: new Date().toLocaleTimeString([], { hour: "2-digit", minute: "2-digit" }),
      };

      setMessages((prev) => [...prev, botMsg]);
    } catch (err) {
      console.error("Chat error:", err);
      const errMsg = {
        id: (Date.now() + 1).toString(),
        role: "bot",
        content:
          err.message ||
          "Maaf, terjadi kendala saat menghubungkan ke sistem SADA. Silakan coba beberapa saat lagi.",
        time: new Date().toLocaleTimeString([], { hour: "2-digit", minute: "2-digit" }),
      };
      setMessages((prev) => [...prev, errMsg]);
    } finally {
      setIsTyping(false);
    }
  };

  const handleActionClick = (action) => {
    if (!action) return;
    if (action.type === "select-room") {
      window.dispatchEvent(new CustomEvent("sada:select-room", { detail: { slug: action.slug } }));
    } else if (action.type === "show-route") {
      window.dispatchEvent(
        new CustomEvent("sada:show-route", { detail: { from: action.from, to: action.to } })
      );
    }
  };

  const handleReset = () => {
    setMessages([
      {
        id: "welcome",
        role: "bot",
        content: "Halo sahabat SMKN 2! 👋\nSelamat datang di **SADA Virtual Assistant**.\nSADA siap membantu Anda menemukan informasi jurusan, denah ruangan, maupun info PPDB di **SMK Negeri 2 Kota Mojokerto** dengan senang hati. Ada yang bisa SADA bantu hari ini? 😊",
        time: "Online",
      },
    ]);
    setShowChips(true);
  };

  return (
    <div id="sada-chatbot" className="fixed bottom-5 right-5 z-50 font-sans text-slate-800 antialiased">
      {/* Floating Toggle Launcher */}
      <div id="chatbot-launcher-container" className="flex items-center justify-end">
        {/* Tooltip speech bubble */}
        {!isOpen && (
          <div
            onClick={() => setIsOpen(true)}
            className="hidden sm:flex relative items-center mr-3 cursor-pointer select-none rounded-2xl bg-white/95 backdrop-blur-md px-4 py-2 text-xs font-bold text-slate-900 shadow-xl border border-slate-200/80 transition-all duration-300 hover:scale-105 hover:shadow-2xl hover:border-blue-400 group"
          >
            <span>Butuh Bantuan?</span>
            <span className="absolute -right-2 top-1/2 -translate-y-1/2 h-0 w-0 border-y-[6px] border-y-transparent border-l-[8px] border-l-white drop-shadow-xs" />
          </div>
        )}

        {/* Floating Launcher Button */}
        <button
          type="button"
          onClick={() => setIsOpen(!isOpen)}
          className="group relative flex h-16 w-16 items-center justify-center rounded-full bg-white p-1 shadow-2xl shadow-blue-600/35 transition-all duration-300 hover:scale-110 focus:outline-none ring-4 ring-white/90 hover:ring-blue-400 cursor-pointer"
          aria-label="Buka SADA Roomchat"
        >
          {/* Online Glowing Pulse Dot */}
          <span className="absolute top-0.5 right-0.5 z-10 flex h-4 w-4">
            <span className="absolute inline-flex h-full w-full animate-ping rounded-full bg-emerald-400 opacity-75" />
            <span className="relative inline-flex h-4 w-4 rounded-full border-2 border-white bg-emerald-500 shadow-sm" />
          </span>

          {!isOpen ? (
            <div className="relative flex h-full w-full items-center justify-center rounded-full overflow-hidden bg-gradient-to-br from-blue-50 to-sky-100 p-1">
              <img
                src="/images/sada-avatar.svg"
                alt="SADA"
                className="h-full w-full object-contain drop-shadow-sm transition-transform group-hover:scale-110 group-hover:rotate-6 duration-300"
              />
            </div>
          ) : (
            <div className="flex h-full w-full items-center justify-center rounded-full bg-gradient-to-br from-[#03315F] via-[#05529E] to-[#0284c7] text-white shadow-lg">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                fill="currentColor"
                className="h-6 w-6 transition-transform group-hover:rotate-90 duration-200"
              >
                <path
                  fillRule="evenodd"
                  d="M5.47 5.47a.75.75 0 0 1 1.06 0L12 10.94l5.47-5.47a.75.75 0 1 1 1.06 1.06L13.06 12l5.47 5.47a.75.75 0 1 1-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 0 1-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 0 1 0-1.06Z"
                  clipRule="evenodd"
                />
              </svg>
            </div>
          )}
        </button>
      </div>

      {/* Chatbot Window Container */}
      {isOpen && (
        <div className="fixed bottom-24 right-3 sm:right-6 z-50 flex h-[600px] max-h-[85vh] w-[94vw] sm:w-[400px] flex-col overflow-hidden rounded-[28px] border border-slate-200/90 bg-[#f4f7fb] shadow-2xl shadow-slate-900/25 transition-all duration-300 ring-1 ring-slate-300/60 animate-in fade-in slide-in-from-bottom-4 duration-250">
          {/* Header */}
          <div className="flex items-center justify-between px-5 py-4 shadow-md bg-gradient-to-r from-[#022b54] via-[#05529E] to-[#0284c7] text-white relative overflow-hidden">
            {/* Header Ambient Glow */}
            <div className="absolute -right-8 -top-8 h-28 w-28 rounded-full bg-cyan-400/20 blur-2xl pointer-events-none" />

            <div className="flex items-center gap-3 relative z-10">
              <div className="relative flex h-10 w-10 shrink-0 items-center justify-center rounded-2xl bg-white/15 backdrop-blur-md p-1.5 border border-white/25 shadow-inner">
                <img src="/images/sada-avatar.svg" alt="SADA" className="h-full w-full object-contain" />
                <span className="absolute -bottom-0.5 -right-0.5 h-3 w-3 rounded-full bg-emerald-400 border-2 border-[#05529E]" />
              </div>
              <div>
                <div className="flex items-center gap-1.5">
                  <h3 className="text-sm font-black tracking-tight leading-none text-white">
                    SADA Assistant
                  </h3>
                  <span className="rounded-full bg-cyan-300/20 px-1.5 py-0.5 text-[9px] font-extrabold uppercase tracking-wider text-cyan-200 border border-cyan-300/30">
                    AI
                  </span>
                </div>
                <p className="mt-1 flex items-center gap-1.5 text-[11px] font-semibold text-sky-100">
                  <span className="h-1.5 w-1.5 rounded-full bg-emerald-400 animate-pulse" />
                  Online • Siap Membantu
                </p>
              </div>
            </div>

            <div className="flex items-center gap-1 relative z-10 text-white">
              <button
                type="button"
                onClick={handleReset}
                title="Reset Percakapan"
                className="rounded-full p-2 hover:bg-white/20 transition cursor-pointer active:scale-95"
              >
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" className="h-4 w-4">
                  <path
                    fillRule="evenodd"
                    d="M15.312 11.424a5.5 5.5 0 0 1-9.201 2.466l-.312-.311h2.451a.75.75 0 0 0 0-1.5H4.5a.75.75 0 0 0-.75.75v3.75a.75.75 0 0 0 1.5 0v-2.146l.513.513a7 7 0 1 0 1.637-8.23.75.75 0 1 0 1.06 1.06 5.5 5.5 0 0 1 6.852 3.608Z"
                    clipRule="evenodd"
                  />
                </svg>
              </button>
              <button
                type="button"
                onClick={() => setIsOpen(false)}
                title="Tutup Chatbot"
                className="rounded-full p-2 hover:bg-white/20 transition cursor-pointer active:scale-95"
              >
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" className="h-4 w-4">
                  <path
                    fillRule="evenodd"
                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                    clipRule="evenodd"
                  />
                </svg>
              </button>
            </div>
          </div>

          {/* Sub-Banner Pill */}
          <div className="px-3.5 pt-3">
            <div className="flex items-center gap-2.5 rounded-2xl bg-white/90 backdrop-blur-sm px-3.5 py-2 text-xs text-slate-700 shadow-xs border border-slate-200/90">
              <span className="flex h-6 w-6 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600 font-black text-xs">
                ✦
              </span>
              <p className="text-[11px] leading-tight text-slate-600">
                Pusat informasi cerdas & panduan rute denah <strong>{schoolName}</strong>.
              </p>
            </div>
          </div>

          {/* Chat Messages Scroll Area */}
          <div className="flex-1 space-y-4 overflow-y-auto p-4 text-xs">
            {messages.map((msg) => (
              <div key={msg.id} className="space-y-1">
                {msg.role === "bot" ? (
                  <div className="space-y-1">
                    <div className="flex items-center gap-2 pl-9">
                      <span className="text-[11px] font-black text-[#05529E]">SADA AI</span>
                      <span className="text-[10px] text-slate-400 font-normal">{msg.time}</span>
                    </div>
                    <div className="flex items-start gap-2.5">
                      <div className="flex h-7 w-7 shrink-0 items-center justify-center rounded-xl bg-white border border-slate-200/90 shadow-2xs p-1 mt-0.5">
                        <img src="/images/sada-avatar.svg" alt="SADA" className="h-full w-full object-contain" />
                      </div>
                      <div className="max-w-[86%] rounded-2xl rounded-tl-xs bg-white p-3.5 shadow-sm border border-slate-200/90 text-slate-900 leading-relaxed space-y-1">
                        {renderFormattedMessage(msg.content)}

                        {/* Optional Action Button */}
                        {msg.actions && (
                          <div className="mt-3 pt-2.5 border-t border-slate-100">
                            <button
                              type="button"
                              onClick={() => handleActionClick(msg.actions)}
                              className="group inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-[#05529E] to-[#0284c7] text-white px-3.5 py-2 text-[11px] font-bold shadow-xs hover:shadow-md hover:scale-[1.02] transition-all cursor-pointer"
                            >
                              <span>📍</span>
                              <span>{msg.actions.label}</span>
                              <span className="transition-transform group-hover:translate-x-0.5">→</span>
                            </button>
                          </div>
                        )}
                      </div>
                    </div>
                  </div>
                ) : (
                  <div className="flex flex-col items-end space-y-1 pl-8">
                    <div className="max-w-[88%] rounded-2xl rounded-tr-xs bg-gradient-to-br from-[#05529E] via-[#044a8e] to-[#0284c7] p-3.5 text-white shadow-md shadow-blue-900/10 leading-relaxed font-medium">
                      {msg.content}
                    </div>
                    <span className="text-[10px] text-slate-400 pr-1">{msg.time}</span>
                  </div>
                )}
              </div>
            ))}

            {/* Quick Chips Drawer */}
            {showChips && (
              <div className="pt-2 pl-9">
                <p className="text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-1.5">
                  Rekomendasi Pertanyaan:
                </p>
                <div className="flex flex-wrap gap-1.5">
                  {QUICK_PROMPTS.map((chip, idx) => (
                    <button
                      key={idx}
                      type="button"
                      onClick={() => handleSendMessage(chip.prompt)}
                      className="rounded-xl border border-sky-200/90 bg-white/90 px-3 py-1.5 text-[11px] font-semibold text-slate-800 shadow-2xs hover:bg-sky-50 hover:border-blue-500 hover:text-blue-700 transition-all hover:scale-[1.02] cursor-pointer"
                    >
                      {chip.label}
                    </button>
                  ))}
                </div>
              </div>
            )}

            {/* Typing Indicator */}
            {isTyping && (
              <div className="flex items-center gap-2 pl-9 py-1">
                <div className="inline-flex items-center gap-2 rounded-full bg-white px-3.5 py-1.5 text-[11px] font-medium text-slate-600 shadow-xs border border-slate-200/90">
                  <div className="flex h-4 w-4 items-center justify-center rounded-full bg-[#05529E]">
                    <span className="flex gap-0.5">
                      <span className="h-0.5 w-0.5 rounded-full bg-white" />
                      <span className="h-0.5 w-0.5 rounded-full bg-white" />
                    </span>
                  </div>
                  <span>SADA sedang mengetik...</span>
                  <span className="flex items-center gap-1">
                    <span className="h-1.5 w-1.5 rounded-full bg-blue-600 animate-bounce" />
                    <span className="h-1.5 w-1.5 rounded-full bg-blue-600 animate-bounce [animation-delay:0.2s]" />
                    <span className="h-1.5 w-1.5 rounded-full bg-blue-600 animate-bounce [animation-delay:0.4s]" />
                  </span>
                </div>
              </div>
            )}

            <div ref={messagesEndRef} />
          </div>

          {/* Spam Alert Bar */}
          {spamAlert && (
            <div className="mx-3.5 mb-2 flex items-center justify-between gap-2 rounded-2xl bg-amber-50 border border-amber-200 px-3.5 py-2 text-[11px] font-semibold text-amber-900 shadow-xs transition-all duration-300">
              <div className="flex items-center gap-2">
                <span className="flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-amber-500 text-white text-xs font-black">
                  !
                </span>
                <span>{spamAlert}</span>
              </div>
              <button
                type="button"
                onClick={() => setSpamAlert(null)}
                className="text-amber-600 hover:text-amber-800 text-sm font-bold leading-none p-0.5 cursor-pointer"
              >
                ×
              </button>
            </div>
          )}

          {/* Input Bar */}
          <form
            onSubmit={(e) => {
              e.preventDefault();
              handleSendMessage();
            }}
            className="border-t border-slate-200/80 bg-white p-3"
          >
            <div className="flex items-center gap-2 rounded-2xl bg-slate-100/90 px-3 py-2 border border-slate-200 focus-within:border-blue-600 focus-within:bg-white focus-within:ring-2 focus-within:ring-blue-100 transition-all duration-200">
              <button
                type="button"
                onClick={() => setShowChips(!showChips)}
                title="Pilihan Topik Cepat"
                className={`flex h-7 w-7 items-center justify-center rounded-xl transition cursor-pointer ${
                  showChips
                    ? "bg-blue-100 text-blue-700"
                    : "text-slate-500 hover:text-blue-600 hover:bg-slate-200"
                }`}
              >
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" className="h-4 w-4">
                  <path d="M10.75 4.75a.75.75 0 0 0-1.5 0v4.5h-4.5a.75.75 0 0 0 0 1.5h4.5v4.5a.75.75 0 0 0 1.5 0v-4.5h4.5a.75.75 0 0 0 0-1.5h-4.5v-4.5Z" />
                </svg>
              </button>
              <input
                type="text"
                value={inputValue}
                onChange={(e) => setInputValue(e.target.value)}
                placeholder="Tanyakan sesuatu ke SADA..."
                className="w-full bg-transparent text-xs text-slate-900 placeholder-slate-400 focus:outline-none px-1"
                autoComplete="off"
                maxLength={350}
              />
              <button
                type="submit"
                disabled={cooldown > 0 || !inputValue.trim()}
                className="flex h-8 w-8 shrink-0 items-center justify-center rounded-xl bg-gradient-to-br from-[#05529E] to-[#0284c7] text-white shadow-md shadow-blue-600/20 transition-all hover:scale-105 active:scale-95 disabled:opacity-40 disabled:cursor-not-allowed cursor-pointer"
              >
                {cooldown > 0 ? (
                  <span className="text-[10px] font-bold text-white">{cooldown}s</span>
                ) : (
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 20 20"
                    fill="currentColor"
                    className="h-4 w-4 -rotate-45 translate-x-0.5 text-white"
                  >
                    <path d="M3.105 2.288a.75.75 0 0 0-.826.95l1.414 4.926A1.5 1.5 0 0 0 5.135 9.25h6.115a.75.75 0 0 1 0 1.5H5.135a1.5 1.5 0 0 0-1.442 1.086l-1.414 4.926a.75.75 0 0 0 .826.95 28.897 28.897 0 0 0 15.293-7.155.75.75 0 0 0 0-1.114A28.897 28.897 0 0 0 3.105 2.288Z" />
                  </svg>
                )}
              </button>
            </div>
          </form>
        </div>
      )}
    </div>
  );
}
