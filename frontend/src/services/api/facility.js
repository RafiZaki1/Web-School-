import apiClient from './client';

/**
 * Fetch facilities associated with a specific room.
 * @param {number|string} roomId
 */
export const getRoomFacilities = async (roomId) => {
  return await apiClient.get(`/rooms/${roomId}/facilities`);
};

export default {
  getRoomFacilities,
};
