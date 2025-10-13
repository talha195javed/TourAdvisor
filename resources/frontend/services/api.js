import axios from 'axios';

const API_BASE_URL = '/api';

const api = axios.create({
  baseURL: API_BASE_URL,
  headers: {
    'Content-Type': 'application/json',
    'Accept': 'application/json',
  },
});

export const packagesAPI = {
  // Get all packages with optional filters
  getAll: (params = {}) => api.get('/packages', { params }),
  
  // Get single package by ID
  getById: (id) => api.get(`/packages/${id}`),
  
  // Get featured packages
  getFeatured: () => api.get('/packages/featured/list'),
};

export const categoriesAPI = {
  // Get all categories
  getAll: () => api.get('/categories'),
};

export const hotelsAPI = {
  // Get all hotels
  getAll: () => api.get('/hotels'),
};

export default api;
