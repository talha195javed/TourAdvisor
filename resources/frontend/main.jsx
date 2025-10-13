import React from 'react';
import ReactDOM from 'react-dom/client';
import { BrowserRouter } from 'react-router-dom';
import App from './App';
import TestApp from './TestApp';
import './i18n';
import '../css/app.css';

console.log('React app starting...');

const rootElement = document.getElementById('app');
console.log('Root element:', rootElement);

// Temporarily use TestApp to verify React is working
const USE_TEST_APP = false; // Set to true to test basic React rendering

if (rootElement) {
  if (USE_TEST_APP) {
    ReactDOM.createRoot(rootElement).render(
      <React.StrictMode>
        <TestApp />
      </React.StrictMode>
    );
  } else {
    ReactDOM.createRoot(rootElement).render(
      <React.StrictMode>
        <BrowserRouter>
          <App />
        </BrowserRouter>
      </React.StrictMode>
    );
  }
  console.log('React app rendered');
} else {
  console.error('Root element #app not found!');
}
