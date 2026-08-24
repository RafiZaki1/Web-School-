import apiClient from './client';

/**
 * Fetch combined landing page data (Hero, Galleries, School Profile, Statistics).
 */
export const getHomeData = async () => {
  return await apiClient.get('/home');
};

/**
 * Fetch active hero banners.
 */
export const getHeroes = async () => {
  return await apiClient.get('/heroes');
};

/**
 * Fetch active galleries.
 */
export const getGalleries = async () => {
  return await apiClient.get('/galleries');
};

/**
 * Fetch school profile (vision, mission, principal message, accreditation, etc.).
 */
export const getSchoolProfile = async () => {
  return await apiClient.get('/school-profile');
};

/**
 * Fetch school statistics.
 */
export const getStatistics = async () => {
  return await apiClient.get('/statistics');
};

export default {
  getHomeData,
  getHeroes,
  getGalleries,
  getSchoolProfile,
  getStatistics,
};
