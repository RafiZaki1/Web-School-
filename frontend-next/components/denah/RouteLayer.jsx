"use client";

/**
 * Builds clean orthogonal corridor navigation path without cutting through walls or jumping over rooms.
 */
export function buildPreciseSvgPath(points) {
  if (!points || points.length === 0) return { d: "", cleanPoints: [] };
  if (points.length === 1) return { d: `M ${points[0].x} ${points[0].y}`, cleanPoints: points };

  const cleanPoints = [points[0]];

  for (let i = 1; i < points.length; i++) {
    const prev = cleanPoints[cleanPoints.length - 1];
    const curr = points[i];

    const isFirstStep = i === 1;
    const isLastStep = i === points.length - 1;

    // Transition from/to room center to hallway corridor
    if (isFirstStep || isLastStep) {
      const dx = Math.abs(curr.x - prev.x);
      const dy = Math.abs(curr.y - prev.y);

      // If diagonal, step orthogonally to prevent slicing through neighboring classrooms
      if (dx > 0.8 && dy > 0.8) {
        if (isFirstStep) {
          // Major vertical hallway corridors in SMKN 2 campus:
          // x = 14 (Parkir), 23 (BKK), 28.5 (DKV/LPS), 39 (Kantor/Barat), 46.5 (Tengah), 51.5 (Gerbang), 57 (Aula/Lab), 69/75 (Timur), 88.5 (Lapangan)
          const isVerticalCorridor = [14, 23, 28.5, 39, 46.5, 51.5, 57, 69, 75, 88.5].some(
            (cx) => Math.abs(curr.x - cx) < 2.0
          );
          if (isVerticalCorridor) {
            cleanPoints.push({ x: curr.x, y: prev.y });
          } else {
            cleanPoints.push({ x: prev.x, y: curr.y });
          }
        } else {
          // Entering destination room from hallway corridor
          const fromVerticalCorridor = [14, 23, 28.5, 39, 46.5, 51.5, 57, 69, 75, 88.5].some(
            (cx) => Math.abs(prev.x - cx) < 2.0
          );
          if (fromVerticalCorridor) {
            cleanPoints.push({ x: prev.x, y: curr.y });
          } else {
            cleanPoints.push({ x: curr.x, y: prev.y });
          }
        }
      }
    }

    cleanPoints.push(curr);
  }

  // Draw clean straight corridor segments
  let d = `M ${cleanPoints[0].x} ${cleanPoints[0].y}`;
  for (let i = 1; i < cleanPoints.length; i++) {
    d += ` L ${cleanPoints[i].x} ${cleanPoints[i].y}`;
  }

  return { d, cleanPoints };
}

// Backward compatibility helper
export function buildCurvedSvgPath(points) {
  return buildPreciseSvgPath(points).d;
}

export default function RouteLayer({ svgPathD, showRoute }) {
  if (!showRoute || !svgPathD) return null;

  return (
    <svg
      viewBox="0 0 100 100"
      preserveAspectRatio="none"
      className="route-layer absolute inset-0 w-full h-full pointer-events-none z-20 transition-all duration-300"
    >
      {/* Route Outer Halo / Glow */}
      <path
        d={svgPathD}
        fill="none"
        stroke="#38bdf8"
        strokeWidth="3.2"
        strokeLinecap="round"
        strokeLinejoin="round"
        opacity="0.5"
      />

      {/* Main Solid Corridor Navigation Line */}
      <path
        d={svgPathD}
        fill="none"
        stroke="#0284c7"
        strokeWidth="1.6"
        strokeLinecap="round"
        strokeLinejoin="round"
      />

      {/* Animated Walking Direction Dashes */}
      <path
        d={svgPathD}
        fill="none"
        stroke="#ffffff"
        strokeWidth="0.8"
        strokeDasharray="2, 2"
        strokeLinecap="round"
        strokeLinejoin="round"
        opacity="0.9"
      />
    </svg>
  );
}
