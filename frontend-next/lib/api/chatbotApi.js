import { apiClient } from "./client";

export const chatbotApi = {
  async sendMessage(message, history = []) {
    const json = await apiClient("/api/v1/public/chatbot", {
      method: "POST",
      body: JSON.stringify({
        message,
        history,
      }),
    });
    return json.data;
  },
};
