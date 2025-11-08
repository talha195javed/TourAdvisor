import React, { createContext, useState, useContext, useEffect } from 'react';
import { login as loginAPI, register as registerAPI, logout as logoutAPI, getMe } from '../services/authAPI';

const AuthContext = createContext(null);

export const useAuth = () => {
    const context = useContext(AuthContext);
    if (!context) {
        throw new Error('useAuth must be used within an AuthProvider');
    }
    return context;
};

export const AuthProvider = ({ children }) => {
    const [client, setClient] = useState(null);
    const [loading, setLoading] = useState(true);
    const [token, setToken] = useState(localStorage.getItem('auth_token'));

    // Check if user is authenticated on mount
    useEffect(() => {
        const checkAuth = async () => {
            const storedToken = localStorage.getItem('auth_token');
            if (storedToken) {
                try {
                    const response = await getMe();
                    setClient(response.client);
                    setToken(storedToken);
                } catch (error) {
                    console.error('Auth check failed:', error);
                    localStorage.removeItem('auth_token');
                    localStorage.removeItem('client');
                    setToken(null);
                    setClient(null);
                }
            }
            setLoading(false);
        };

        checkAuth();
    }, []);

    const login = async (credentials) => {
        try {
            const response = await loginAPI(credentials);
            localStorage.setItem('auth_token', response.token);
            localStorage.setItem('client', JSON.stringify(response.client));
            setToken(response.token);
            setClient(response.client);
            return response;
        } catch (error) {
            throw error;
        }
    };

    const register = async (data) => {
        try {
            const response = await registerAPI(data);
            localStorage.setItem('auth_token', response.token);
            localStorage.setItem('client', JSON.stringify(response.client));
            setToken(response.token);
            setClient(response.client);
            return response;
        } catch (error) {
            throw error;
        }
    };

    const logout = async () => {
        try {
            await logoutAPI();
        } catch (error) {
            console.error('Logout error:', error);
        } finally {
            localStorage.removeItem('auth_token');
            localStorage.removeItem('client');
            setToken(null);
            setClient(null);
        }
    };

    const value = {
        client,
        token,
        loading,
        isAuthenticated: !!token && !!client,
        login,
        register,
        logout,
    };

    return <AuthContext.Provider value={value}>{children}</AuthContext.Provider>;
};
