import axios from 'axios';

const API_BASE_URL = '/api/auth';

// Create axios instance with default config
const authAPI = axios.create({
    baseURL: API_BASE_URL,
    headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
    },
});

// Add token to requests if available
authAPI.interceptors.request.use((config) => {
    const token = localStorage.getItem('auth_token');
    if (token) {
        config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
});

// Handle 401 errors (unauthorized)
authAPI.interceptors.response.use(
    (response) => response,
    (error) => {
        if (error.response?.status === 401) {
            localStorage.removeItem('auth_token');
            localStorage.removeItem('client');
            window.location.href = '/login';
        }
        return Promise.reject(error);
    }
);

export const register = async (data) => {
    const response = await authAPI.post('/register', data);
    return response.data;
};

export const login = async (credentials) => {
    const response = await authAPI.post('/login', credentials);
    return response.data;
};

export const logout = async () => {
    const response = await authAPI.post('/logout');
    return response.data;
};

export const getMe = async () => {
    const response = await authAPI.get('/me');
    return response.data;
};

export const getMyBookings = async () => {
    const response = await authAPI.get('/my-bookings');
    return response.data;
};

export default authAPI;
