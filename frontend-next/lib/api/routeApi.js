import { apiClient } from "./client";

export const routeApi = {
  async getRoute(from, to) {
    if (!from || !to) {
      throw new Error("Origin dan destination wajib ditentukan.");
    }
    const json = await apiClient(
      `/api/v1/public/map/route?from=${encodeURIComponent(from)}&to=${encodeURIComponent(to)}`
    );
    return json.data;
  },
};
