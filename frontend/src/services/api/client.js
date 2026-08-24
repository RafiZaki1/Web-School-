import axios from 'axios';

// Get API base URL from environment variable or fallback to default Laravel server port
const API_BASE_URL = import.meta.env.VITE_API_BASE_URL || 'http://localhost:8000/api/v1/public';

export const apiClient = axios.create({
  baseURL: API_BASE_URL,
  timeout: 15000,
  headers: {
    'Accept': 'application/json',
    'Content-Type': 'application/json',
  },
});

// Response interceptor to unwrap data and handle standard response format
apiClient.interceptors.response.use(
  (response) => {
    // If standardized ApiResponse is used: { success: true, message: '...', data: ... }
    if (response.data && typeof response.data === 'object' && 'data' in response.data) {
      return response.data.data;
    }
    return response.data;
  },
  (error) => {
    const customError = {
      message: error.response?.data?.message || error.message || 'Terjadi kesalahan pada server',
      status: error.response?.status || 500,
      errors: error.response?.data?.errors || null,
    };
    return Promise.reject(customError);
  }
);

export default apiClient;
