// Google-like Auto Translator
let isArabic = false;
let originalTexts = new Map();

// Translate text using Google Translate API
async function translateText(text, targetLang) {
    try {
        const url = `https://translate.googleapis.com/translate_a/single?client=gtx&sl=auto&tl=${targetLang}&dt=t&q=${encodeURIComponent(text)}`;
        const response = await fetch(url);
        const data = await response.json();
        
        if (data && data[0] && data[0][0] && data[0][0][0]) {
            return data[0][0][0];
        }
        return text;
    } catch (error) {
        console.error('Translation error:', error);
        return text;
    }
}

// Get all text nodes
function getTextNodes(element) {
    const textNodes = [];
    const walker = document.createTreeWalker(element, NodeFilter.SHOW_TEXT, {
        acceptNode: function(node) {
            const parent = node.parentElement;
            if (!parent || parent.tagName === 'SCRIPT' || parent.tagName === 'STYLE' || 
                parent.tagName === 'NOSCRIPT' || !node.textContent.trim()) {
                return NodeFilter.FILTER_REJECT;
            }
            return NodeFilter.FILTER_ACCEPT;
        }
    });
    
    let node;
    while (node = walker.nextNode()) {
        textNodes.push(node);
    }
    return textNodes;
}

// Translate page to Arabic
async function translateToArabic() {
    showLoader();
    
    // Apply RTL
    document.documentElement.setAttribute('dir', 'rtl');
    document.documentElement.setAttribute('lang', 'ar');
    
    // Load Arabic font
    if (!document.getElementById('arabic-font')) {
        const link = document.createElement('link');
        link.id = 'arabic-font';
        link.href = 'https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&display=swap';
        link.rel = 'stylesheet';
        document.head.appendChild(link);
    }
    
    document.body.style.fontFamily = "'Cairo', sans-serif";
    addRTLStyles();
    
    // Translate all text
    const textNodes = getTextNodes(document.body);
    for (const node of textNodes) {
        const text = node.textContent.trim();
        if (text) {
            originalTexts.set(node, node.textContent);
            const translated = await translateText(text, 'ar');
            node.textContent = translated;
        }
    }
    
    // Translate placeholders
    document.querySelectorAll('[placeholder]').forEach(async el => {
        if (el.placeholder) {
            el.setAttribute('data-original-placeholder', el.placeholder);
            el.placeholder = await translateText(el.placeholder, 'ar');
        }
    });
    
    updateButton('English');
    hideLoader();
    isArabic = true;
    localStorage.setItem('lang', 'ar');
}

// Translate back to English
function translateToEnglish() {
    document.documentElement.setAttribute('dir', 'ltr');
    document.documentElement.setAttribute('lang', 'en');
    document.body.style.fontFamily = "'Inter', sans-serif";
    removeRTLStyles();
    
    // Restore original texts
    originalTexts.forEach((original, node) => {
        if (node.parentNode) {
            node.textContent = original;
        }
    });
    
    // Restore placeholders
    document.querySelectorAll('[data-original-placeholder]').forEach(el => {
        el.placeholder = el.getAttribute('data-original-placeholder');
        el.removeAttribute('data-original-placeholder');
    });
    
    updateButton('العربية');
    isArabic = false;
    localStorage.setItem('lang', 'en');
}

// Toggle language
async function toggleLanguage() {
    if (isArabic) {
        translateToEnglish();
    } else {
        await translateToArabic();
    }
}

// Add RTL styles
function addRTLStyles() {
    if (document.getElementById('rtl-styles')) return;
    const style = document.createElement('style');
    style.id = 'rtl-styles';
    style.textContent = `
        html[dir="rtl"] aside { 
            right: 0 !important; 
            left: auto !important; 
            transform: translateX(0) !important;
        }
        html[dir="rtl"] .md\\:translate-x-0 { 
            transform: translateX(0) !important; 
        }
        html[dir="rtl"] .-translate-x-full { 
            right: 0 !important;
            left: auto !important;
            transform: translateX(0) !important; 
        }
        html[dir="rtl"] .ml-auto { 
            margin-left: 0 !important; 
            margin-right: auto !important; 
        }
        html[dir="rtl"] .mr-auto { 
            margin-right: 0 !important; 
            margin-left: auto !important; 
        }
        html[dir="rtl"] .mr-2 { 
            margin-right: 0 !important; 
            margin-left: 0.5rem !important; 
        }
        html[dir="rtl"] .mr-3 { 
            margin-right: 0 !important; 
            margin-left: 0.75rem !important; 
        }
        html[dir="rtl"] .ml-2 { 
            margin-left: 0 !important; 
            margin-right: 0.5rem !important; 
        }
        html[dir="rtl"] .ml-3 { 
            margin-left: 0 !important; 
            margin-right: 0.75rem !important; 
        }
        html[dir="rtl"] .space-x-4 > * + * {
            margin-left: 0 !important;
            margin-right: 1rem !important;
        }
        html[dir="rtl"] .space-x-3 > * + * {
            margin-left: 0 !important;
            margin-right: 0.75rem !important;
        }
        html[dir="rtl"] .pl-4 {
            padding-left: 0 !important;
            padding-right: 1rem !important;
        }
        html[dir="rtl"] .pr-4 {
            padding-right: 0 !important;
            padding-left: 1rem !important;
        }
    `;
    document.head.appendChild(style);
}

function removeRTLStyles() {
    const style = document.getElementById('rtl-styles');
    if (style) style.remove();
}

function updateButton(text) {
    const btn = document.getElementById('lang-btn');
    if (btn) btn.querySelector('span').textContent = text;
}

function showLoader() {
    const loader = document.createElement('div');
    loader.id = 'loader';
    loader.style.cssText = 'position:fixed;top:50%;left:50%;transform:translate(-50%,-50%);background:rgba(0,0,0,0.9);color:white;padding:20px 40px;border-radius:10px;z-index:99999;';
    loader.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Translating...';
    document.body.appendChild(loader);
}

function hideLoader() {
    const loader = document.getElementById('loader');
    if (loader) loader.remove();
}

// Auto-load saved language
document.addEventListener('DOMContentLoaded', () => {
    if (localStorage.getItem('lang') === 'ar') {
        translateToArabic();
    }
});
