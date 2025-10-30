// Auto Translation System - Like Google Translate
let isArabic = false;
let originalContent = new Map();

// Initialize
function initAutoTranslator() {
    const savedLang = localStorage.getItem('adminLanguage');
    if (savedLang === 'ar') {
        translatePageToArabic();
    }
}

// Translate entire page to Arabic
async function translatePageToArabic() {
    isArabic = true;
    localStorage.setItem('adminLanguage', 'ar');
    
    showLoadingIndicator();
    
    document.documentElement.setAttribute('dir', 'rtl');
    document.documentElement.setAttribute('lang', 'ar');
    document.body.style.fontFamily = "'Cairo', sans-serif";
    
    loadArabicFont();
    addRTLStyles();
    
    const textNodes = getAllTextNodes(document.body);
    
    for (const node of textNodes) {
        const text = node.textContent.trim();
        if (text && text.length > 0) {
            if (!originalContent.has(node)) {
                originalContent.set(node, node.textContent);
            }
            
            const translated = await translateText(text, 'ar');
            if (translated) {
                node.textContent = translated;
            }
        }
    }
    
    await translatePlaceholders('ar');
    
    updateLanguageButton('English');
    hideLoadingIndicator();
    flipIcons();
}

// Translate back to English
function translatePageToEnglish() {
    isArabic = false;
    localStorage.setItem('adminLanguage', 'en');
    
    document.documentElement.setAttribute('dir', 'ltr');
    document.documentElement.setAttribute('lang', 'en');
    document.body.style.fontFamily = "'Inter', sans-serif";
    
    removeRTLStyles();
    
    originalContent.forEach((original, node) => {
        if (node.parentNode) {
            node.textContent = original;
        }
    });
    
    document.querySelectorAll('[data-original-placeholder]').forEach(el => {
        el.placeholder = el.getAttribute('data-original-placeholder');
        el.removeAttribute('data-original-placeholder');
    });
    
    updateLanguageButton('العربية');
    restoreIcons();
}

// Get all text nodes
function getAllTextNodes(element) {
    const textNodes = [];
    const walker = document.createTreeWalker(
        element,
        NodeFilter.SHOW_TEXT,
        {
            acceptNode: function(node) {
                if (node.parentElement.tagName === 'SCRIPT' || 
                    node.parentElement.tagName === 'STYLE' ||
                    node.parentElement.tagName === 'NOSCRIPT' ||
                    !node.textContent.trim()) {
                    return NodeFilter.FILTER_REJECT;
                }
                return NodeFilter.FILTER_ACCEPT;
            }
        }
    );
    
    let node;
    while (node = walker.nextNode()) {
        textNodes.push(node);
    }
    
    return textNodes;
}

// Translate text using Google Translate API
async function translateText(text, targetLang) {
    try {
        const url = `https://translate.googleapis.com/translate_a/single?client=gtx&sl=en&tl=${targetLang}&dt=t&q=${encodeURIComponent(text)}`;
        
        const response = await fetch(url);
        const data = await response.json();
        
        if (data && data[0] && data[0][0] && data[0][0][0]) {
            return data[0][0][0];
        }
        
        return null;
    } catch (error) {
        console.error('Translation error:', error);
        return null;
    }
}

// Translate placeholders
async function translatePlaceholders(targetLang) {
    const elements = document.querySelectorAll('[placeholder]');
    
    for (const el of elements) {
        if (el.placeholder && el.placeholder.trim()) {
            if (!el.getAttribute('data-original-placeholder')) {
                el.setAttribute('data-original-placeholder', el.placeholder);
            }
            
            const translated = await translateText(el.placeholder, targetLang);
            if (translated) {
                el.placeholder = translated;
            }
        }
    }
}

// Load Arabic font
function loadArabicFont() {
    if (!document.getElementById('arabic-font')) {
        const link = document.createElement('link');
        link.id = 'arabic-font';
        link.href = 'https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&display=swap';
        link.rel = 'stylesheet';
        document.head.appendChild(link);
    }
}

// Add RTL styles
function addRTLStyles() {
    if (document.getElementById('rtl-styles')) return;
    
    const style = document.createElement('style');
    style.id = 'rtl-styles';
    style.textContent = `
        html[dir="rtl"] aside { right: 0; left: auto; }
        html[dir="rtl"] .sidebar-transition { transform: translateX(100%); }
        html[dir="rtl"] .md\\:translate-x-0 { transform: translateX(0) !important; }
        html[dir="rtl"] .-translate-x-full { transform: translateX(100%) !important; }
        html[dir="rtl"] .active-nav-item::before { left: auto; right: 0; border-radius: 4px 0 0 4px; }
        html[dir="rtl"] .ml-auto { margin-left: 0 !important; margin-right: auto !important; }
        html[dir="rtl"] .mr-auto { margin-right: 0 !important; margin-left: auto !important; }
    `;
    document.head.appendChild(style);
}

// Remove RTL styles
function removeRTLStyles() {
    const style = document.getElementById('rtl-styles');
    if (style) style.remove();
}

// Flip icons
function flipIcons() {
    document.querySelectorAll('.mr-2, .mr-3, .ml-2, .ml-3').forEach(icon => {
        const classes = icon.className;
        if (classes.includes('mr-2')) {
            icon.className = classes.replace('mr-2', 'ml-2');
            icon.setAttribute('data-original-class', 'mr-2');
        } else if (classes.includes('mr-3')) {
            icon.className = classes.replace('mr-3', 'ml-3');
            icon.setAttribute('data-original-class', 'mr-3');
        }
    });
}

// Restore icons
function restoreIcons() {
    document.querySelectorAll('[data-original-class]').forEach(icon => {
        const originalClass = icon.getAttribute('data-original-class');
        const currentClass = icon.className;
        
        if (originalClass === 'mr-2') {
            icon.className = currentClass.replace('ml-2', 'mr-2');
        } else if (originalClass === 'mr-3') {
            icon.className = currentClass.replace('ml-3', 'mr-3');
        }
        
        icon.removeAttribute('data-original-class');
    });
}

// Update language button
function updateLanguageButton(text) {
    const btn = document.getElementById('language-switcher');
    if (btn) {
        const span = btn.querySelector('span');
        if (span) span.textContent = text;
    }
}

// Show loading indicator
function showLoadingIndicator() {
    const loader = document.createElement('div');
    loader.id = 'translation-loader';
    loader.style.cssText = 'position:fixed;top:50%;left:50%;transform:translate(-50%,-50%);background:rgba(0,0,0,0.8);color:white;padding:20px 40px;border-radius:10px;z-index:9999;font-size:16px;';
    loader.innerHTML = '<div style="text-align:center;"><i class="fas fa-spinner fa-spin" style="font-size:24px;margin-bottom:10px;"></i><div>Translating...</div></div>';
    document.body.appendChild(loader);
}

// Hide loading indicator
function hideLoadingIndicator() {
    const loader = document.getElementById('translation-loader');
    if (loader) loader.remove();
}

// Toggle language
async function toggleLanguage() {
    if (isArabic) {
        translatePageToEnglish();
    } else {
        await translatePageToArabic();
    }
}

// Initialize on load
document.addEventListener('DOMContentLoaded', () => {
    initAutoTranslator();
    console.log('Auto Translator loaded!');
});
