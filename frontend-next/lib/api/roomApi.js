import { apiClient } from "./client";

export const roomApi = {
  async getRooms() {
    const json = await apiClient("/api/v1/public/rooms");
    return json.data || [];
  },

  async getRoomDetail(slugOrId) {
    const json = await apiClient(`/api/v1/public/rooms/${encodeURIComponent(slugOrId)}`);
    return json.data || null;
  },

  async searchRooms(query) {
    if (!query || !query.trim()) return [];
    const json = await apiClient(`/api/v1/public/rooms/search?q=${encodeURIComponent(query.trim())}`);
    return json.data || [];
  },

  async getCategories() {
    const json = await apiClient("/api/v1/public/map/categories");
    return json.data || [];
  },

  async getMapNodes() {
    const json = await apiClient("/api/v1/public/map/nodes");
    return json.data || [];
  },
};
