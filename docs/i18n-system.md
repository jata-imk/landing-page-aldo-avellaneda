# Sistema de Traducción (i18n)

## Visión General

El proyecto usa un **sistema de traducción personalizado y simple** en lugar de librerías externas como `i18next`.

**Ventajas:**
- ✅ Sin dependencias externas
- ✅ Traducciones en build time (generan HTML estático)
- ✅ Rendimiento excelente
- ✅ Fácil de entender y mantener

## Estructura

### 1. Archivos JSON de Traducciones

```
src/i18n/locales/
├── es.json     # Traducción español
└── en.json     # Traducción inglés
```

#### Ejemplo: `es.json`

```json
{
  "header": {
    "nav": {
      "home": "Inicio",
      "about": "Acerca",
      "contact": "Contacto"
    }
  },
  "sections": {
    "hero": {
      "title": "Bienvenido",
      "words": ["Palabra1", "Palabra2", "Palabra3"],
      "subtitle": "Subtítulo con <br /> HTML"
    }
  }
}
```

**Estructura de claves:**
- Usa notación de puntos: `header.nav.home`
- Puede tener valores string o arrays
- Puede contener HTML (usarás `set:html` en Astro)

### 2. Función de Traducción

Archivo: `src/i18n/translations.ts`

```typescript
import es from './locales/es.json';
import en from './locales/en.json';

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
```

**Cómo funciona:**
1. Importa ambos JSONs
2. Busca el valor usando la clave (ej: `sections.hero.title`)
3. Si no encuentra, retorna la clave (para debugging)
4. Soporta strings, arrays, objetos

### 3. Rutas y Configuración

Astro maneja el routing multiidioma:

```
Configuración (astro.config.mjs):
├── defaultLocale: 'es'        → / es español
├── locales: ['es', 'en']      → /en/ es inglés
└── prefixDefaultLocale: false → NO agrega /es/ en la raíz
```

**Resultado de rutas:**
```
src/pages/index.astro → /        (español)
src/pages/en/index.astro → /en/  (inglés)
```

## Uso en Componentes

### Componentes Astro

```astro
---
import { t } from '../../i18n/translations';

interface Props {
  lang?: 'es' | 'en';
}

const { lang = 'es' } = Astro.props;
---

<div>
  <!-- Texto simple -->
  <h1>{t('sections.hero.title', lang)}</h1>

  <!-- HTML (úsalo con cuidado) -->
  <p set:html={t('sections.hero.subtitle', lang)} />

  <!-- Arrays (ej: palabras para rotación) -->
  {(() => {
    const words = t('sections.hero.words', lang) as string[];
    return words.map(word => <span>{word}</span>);
  })()}
</div>
```

### Paso de `lang` entre componentes

```astro
<!-- En src/pages/index.astro -->
<MainLayout>
  <Header lang="es" />
  <HeroSection lang="es" />
  <Footer lang="es" />
</MainLayout>
```

```astro
<!-- En componentes -->
interface Props {
  lang?: 'es' | 'en';
}

const { lang = 'es' } = Astro.props;
```

## Traducción en Tiempo de Build

Las traducciones ocurren **en build time**, NO en runtime:

```
Build:
1. Astro procesa componentes
2. t('sections.hero.title', 'es') → "Bienvenido"
3. HTML generado: <h1>Bienvenido</h1>

Resultado:
- Dos archivos HTML separados (index.html y en/index.html)
- Ambos con textos finales, SIN traducción dinámica
- Rendimiento perfecto en el navegador
```

## Actualizar Traducciones

### 1. Agregar una nueva clave

**es.json:**
```json
{
  "sections": {
    "services": {
      "title": "Nuestros Servicios"
    }
  }
}
```

**en.json:**
```json
{
  "sections": {
    "services": {
      "title": "Our Services"
    }
  }
}
```

### 2. Usar en componente

```astro
<h2>{t('sections.services.title', lang)}</h2>
```

### 3. Recompilar

```bash
npm run dev  # Si estás en desarrollo
npm run build  # Para producción
```

## Buenas Prácticas

### ✅ DO - Haz esto

```json
{
  "sections": {
    "hero": {
      "title": "El título",
      "subtitle": "El subtítulo",
      "button": "Botón"
    }
  }
}
```

```astro
<h1>{t('sections.hero.title', lang)}</h1>
<p>{t('sections.hero.subtitle', lang)}</p>
<button>{t('sections.hero.button', lang)}</button>
```

### ❌ DON'T - No hagas esto

```json
{
  "es": {
    "title": "..."  // Redundante, la estructura ya está separada
  }
}
```

```astro
// ❌ Hardcodear texto en lugar de traducción
<h1>Título en español</h1>

// ❌ No pasar lang correctamente
<h1>{t('title')}</h1>  // Asume 'es'
```

## Caso de Uso: Arrays en Traducciones

Para listas de elementos (ej: palabras rotativas):

**es.json:**
```json
{
  "sections": {
    "hero": {
      "words": ["Palabra1", "Palabra2", "Palabra3"]
    }
  }
}
```

**Componente:**
```astro
---
const words = t('sections.hero.words', lang) as string[];
---

<span class="cd-words-wrapper">
  {words.map((word, idx) => (
    <b class={idx === 0 ? 'is-visible' : ''}>
      {word}
    </b>
  ))}
</span>
```

## Caso de Uso: Contenido con HTML

Para textos que contienen HTML (ej: `<br />`, `<strong>`):

**es.json:**
```json
{
  "subtitle": "Línea 1<br />Línea 2<br />Línea 3"
}
```

**Componente:**
```astro
<div set:html={t('sections.hero.subtitle', lang)} />
```

⚠️ **Cuidado**: Solo usa `set:html` con HTML que controles. Nunca con input de usuarios.

## Debugging

### Si una traducción no aparece

1. **Verifica la clave existe en ambos JSONs**
   ```bash
   grep "sections.hero.title" src/i18n/locales/es.json
   grep "sections.hero.title" src/i18n/locales/en.json
   ```

2. **Verifica la sintaxis JSON**
   - Abre JSONs en VS Code
   - Busca errores (comillas faltantes, comas)

3. **Verifica el componente recibe `lang`**
   ```astro
   <!-- Debug: muestra el lang actual -->
   <span>{lang}</span>
   ```

4. **Reconstruye el proyecto**
   ```bash
   npm run build
   npm run preview
   ```

### Placeholder que aparece

Si ves `sections.hero.title` en lugar del texto:
- La clave NO existe en el JSON
- El JSON tiene error de sintaxis
- El componente no pasa `lang` correctamente

## Agregar un Nuevo Idioma

Para agregar, ej., francés:

### 1. Crear `fr.json`
```bash
cp src/i18n/locales/es.json src/i18n/locales/fr.json
```

### 2. Actualizar `translations.ts`
```typescript
import fr from './locales/fr.json';

const translations = {
  es,
  en,
  fr,
};

export function t(key: TranslationKey, lang: 'es' | 'en' | 'fr' = 'es') {
  // ...
}
```

### 3. Actualizar `astro.config.mjs`
```javascript
i18n: {
  defaultLocale: 'es',
  locales: ['es', 'en', 'fr'],
  routing: {
    prefixDefaultLocale: false,
  },
},
```

### 4. Crear página `/fr/`
```bash
mkdir src/pages/fr
cp src/pages/en/index.astro src/pages/fr/index.astro
```

### 5. Actualizar el componente `fr/index.astro`
```astro
const lang = 'fr';
```

### 6. Traducir textos en `fr.json`

### 7. Recompilar
```bash
npm run build
```

Resultado: `/fr/` será la versión en francés.

## Estructura Recomendada de JSON

Para mantener consistencia:

```json
{
  "header": {
    "topHeader": { ... },
    "nav": { ... }
  },
  "sections": {
    "hero": { ... },
    "about": { ... },
    "appointment": { ... },
    "gallery": { ... },
    "testimonials": { ... }
  },
  "forms": {
    "appointment": { ... }
  },
  "departments": { ... },
  "doctors": { ... },
  "footer": { ... }
}
```

Agrupa por:
- Componente/sección
- Funcionalidad
- Área de la página

## Rendimiento

- ✅ **Build time**: Mínimo impacto (búsquedas en JSON)
- ✅ **Runtime**: Cero impacto (es HTML estático)
- ✅ **Tamaño**: Pequeño (solo JSON importados)
- ✅ **Caching**: HTML estático cachea perfectamente

## Migración desde i18next

Si necesitas cambiar a `react-i18next` u otro sistema:

1. Mantén la estructura de `locales/es.json` y `locales/en.json`
2. Implementa el nuevo adaptador de traducción
3. Actualiza componentes para usar nuevo sistema
4. Mantén `astro.config.mjs` igual (routing a nivel de Astro)

---

**Última actualización:** Octubre 31, 2024
