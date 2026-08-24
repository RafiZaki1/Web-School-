import apiClient from './client';

/**
 * Fetch all active rooms for floor plan and directory.
 */
export const getRooms = async () => {
  return await apiClient.get('/rooms');
};

/**
 * Fetch single room details by ID or slug.
 * @param {number|string} roomId
 */
export const getRoomDetail = async (roomId) => {
  return await apiClient.get(`/rooms/${roomId}`);
};

export default {
  getRooms,
  getRoomDetail,
};
