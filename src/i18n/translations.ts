import es from './locales/es.json';
import en from './locales/en.json';

type TranslationKey = string;

const translations = {
  es,
  en,
};

export function t(key: TranslationKey, lang: 'es' | 'en' = 'es'): string | string[] | any {
  const keys = key.split('.');
  let value: any = translations[lang];

  for (const k of keys) {
    value = value?.[k];
  }

  return value !== undefined ? value : key;
}

export function getTranslations(lang: 'es' | 'en' = 'es') {
  return translations[lang];
}
