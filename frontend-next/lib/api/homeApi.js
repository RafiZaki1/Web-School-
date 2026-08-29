import { apiClient } from "./client";

export const homeApi = {
  async getHomeData() {
    try {
      const json = await apiClient("/api/v1/public/home", {
        next: { revalidate: 60 }, // ISR 60s
      });
      return json.data || null;
    } catch (err) {
      console.error("Failed to fetch home data:", err);
      return null;
    }
  },

  async getStatistics() {
    try {
      const json = await apiClient("/api/v1/public/statistics", {
        next: { revalidate: 60 },
      });
      return json.data || null;
    } catch (err) {
      console.error("Failed to fetch statistics:", err);
      return null;
    }
  },

  async getSchoolProfile() {
    try {
      const json = await apiClient("/api/v1/public/school-profile", {
        next: { revalidate: 60 },
      });
      return json.data || null;
    } catch (err) {
      console.error("Failed to fetch school profile:", err);
      return null;
    }
  },
};
