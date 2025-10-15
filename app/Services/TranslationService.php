<?php

namespace App\Services;

use Stichoza\GoogleTranslate\GoogleTranslate;
use Illuminate\Support\Facades\Cache;

class TranslationService
{
    protected $translator;

    public function __construct()
    {
        $this->translator = new GoogleTranslate();
        $this->translator->setSource('en');
        $this->translator->setTarget('ar');
    }

    /**
     * Translate text from English to Arabic with caching
     */
    public function translate(string $text, string $targetLang = 'ar'): string
    {
        if (empty($text)) {
            return '';
        }

        // Create cache key based on text and language
        $cacheKey = 'translation_' . md5($text . $targetLang);

        // Check cache first (cache for 30 days)
        return Cache::remember($cacheKey, 60 * 60 * 24 * 30, function () use ($text, $targetLang) {
            try {
                $this->translator->setTarget($targetLang);
                return $this->translator->translate($text);
            } catch (\Exception $e) {
                // If translation fails, return original text
                \Log::error('Translation failed: ' . $e->getMessage());
                return $text;
            }
        });
    }

    /**
     * Translate an object/array with specific fields
     */
    public function translateFields($item, array $fields, string $targetLang = 'ar')
    {
        foreach ($fields as $field) {
            $arField = $field . '_ar';
            
            // Only translate if Arabic field is empty and English field exists
            if (empty($item->$arField) && !empty($item->$field)) {
                $item->$arField = $this->translate($item->$field, $targetLang);
            }
        }

        return $item;
    }

    /**
     * Get translated value with fallback
     */
    public function getTranslatedValue($englishValue, $arabicValue, string $currentLang = 'en'): string
    {
        if ($currentLang === 'ar') {
            // If Arabic value exists, use it; otherwise auto-translate
            if (!empty($arabicValue)) {
                return $arabicValue;
            }
            return $this->translate($englishValue, 'ar');
        }

        return $englishValue;
    }
}
