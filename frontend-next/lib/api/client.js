const API_BASE = process.env.NEXT_PUBLIC_API_BASE_URL || "http://127.0.0.1:8000";

export async function apiClient(endpoint, options = {}) {
  const url = endpoint.startsWith("http") ? endpoint : `${API_BASE}${endpoint}`;
  
  const defaultHeaders = {
    "Accept": "application/json",
    ...(options.body && typeof options.body === "string" ? { "Content-Type": "application/json" } : {}),
  };

  const response = await fetch(url, {
    ...options,
    headers: {
      ...defaultHeaders,
      ...options.headers,
    },
    // For server components / fetch caching
    next: options.next || undefined,
    cache: options.cache || (options.method === "POST" ? "no-store" : undefined),
  });

  if (!response.ok) {
    let errorData = null;
    try {
      errorData = await response.json();
    } catch {
      // not json
    }
    const message = errorData?.message || `HTTP error! status: ${response.status}`;
    const error = new Error(message);
    error.status = response.status;
    error.data = errorData;
    throw error;
  }

  return response.json();
}

export function getAssetUrl(path) {
  if (!path) return null;
  if (path.startsWith("http://") || path.startsWith("https://")) return path;
  if (path.startsWith("/")) return path;
  return `${API_BASE}/storage/${path.replace(/^storage\//, "")}`;
}
