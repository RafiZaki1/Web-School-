"use client";

import { useState, useEffect, useRef } from "react";

export default function StatCounter({
  target = 0,
  duration = 2600,
  suffix = "",
  formatThousands = true,
  label = "",
  icon = null,
  iconBg = "bg-sky-500/20 text-sky-400 border-sky-400/30",
}) {
  const [display, setDisplay] = useState("0" + suffix);
  const [hasAnimated, setHasAnimated] = useState(false);
  const elementRef = useRef(null);

  useEffect(() => {
    const formatNum = (num) => {
      if (formatThousands) {
        return new Intl.NumberFormat("id-ID").format(num);
      }
      return String(num);
    };

    const startAnimation = () => {
      const startTime = performance.now();
      const startVal = 0;
      const endVal = Number(target) || 0;
      const easeOutCubic = (t) => 1 - Math.pow(1 - t, 3);

      const step = (currentTime) => {
        const elapsed = currentTime - startTime;
        const progress = Math.min(elapsed / duration, 1);
        const currentVal = Math.round(startVal + (endVal - startVal) * easeOutCubic(progress));

        setDisplay(formatNum(currentVal) + suffix);

        if (progress < 1) {
          requestAnimationFrame(step);
        } else {
          setDisplay(formatNum(endVal) + suffix);
        }
      };
      requestAnimationFrame(step);
    };

    if ("IntersectionObserver" in window) {
      const observer = new IntersectionObserver(
        (entries) => {
          entries.forEach((entry) => {
            if (entry.isIntersecting && !hasAnimated) {
              setHasAnimated(true);
              startAnimation();
              observer.disconnect();
            }
          });
        },
        { threshold: 0.1 }
      );

      if (elementRef.current) {
        observer.observe(elementRef.current);
      }

      return () => observer.disconnect();
    } else {
      startAnimation();
    }
  }, [target, duration, suffix, formatThousands, hasAnimated]);

  return (
    <div ref={elementRef} className="flex items-center gap-3 py-1">
      <span
        className={`flex h-10 w-10 shrink-0 items-center justify-center rounded-full border ${iconBg}`}
      >
        {icon}
      </span>
      <div>
        <p className="text-base sm:text-lg font-extrabold text-white leading-none tabular-nums">
          {display}
        </p>
        <p className="mt-1 text-xs font-medium text-slate-300 leading-none">{label}</p>
      </div>
    </div>
  );
}
