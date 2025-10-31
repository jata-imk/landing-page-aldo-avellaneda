# Convenciones de Nombres y Código

## Archivos y Carpetas

### Componentes Astro

**Patrón:** `PascalCase.astro`

```
✅ HeroSection.astro
✅ AppointmentForm.astro
✅ Header.astro

❌ hero-section.astro
❌ heroSection.astro
❌ herosection.astro
```

**Regla:** Cada palabra comienza con mayúscula, sin guiones.

### Archivos TypeScript

**Patrón:** `camelCase.ts` o `PascalCase.ts` (según contexto)

```
✅ translations.ts         # Archivos de utilidad: camelCase
✅ useWindowSize.ts        # Hooks: camelCase con prefijo 'use'
✅ ConfigService.ts        # Clases: PascalCase

❌ Translations.ts
❌ UseWindowSize.ts
```

### Carpetas

**Patrón:** `lowercase` o `kebab-case`

```
✅ src/components/
✅ src/layouts/
✅ src/i18n/
✅ public/js/
✅ public/styles/

❌ src/Components/
❌ src/Layouts/
❌ public/JS/
```

### Imágenes y Assets

**Patrón:** `kebab-case.extensión`

```
✅ hero-img.png
✅ avatar-1.jpg
✅ project-thumbnail.png
✅ icon-check.svg

❌ HeroImg.png
❌ avatar_1.jpg
❌ projectThumbnail.png
```

## Nombres de Componentes

### Componentes Principales

```typescript
// Secciones de página
✅ HeroSection.astro
✅ AboutSection.astro
✅ AppointmentSection.astro
✅ GallerySection.astro
✅ TestimonialsSection.astro

// Layout
✅ Header.astro
✅ Footer.astro
✅ MainLayout.astro

// Componentes reutilizables
✅ Button.astro
✅ FormField.astro
✅ Card.astro
```

### Reglas

1. **Secciones**: Termina con `Section`
2. **Layouts**: Termina con `Layout` o sin sufijo si es obvio (Header, Footer)
3. **Componentes**: Nombre descriptivo, PascalCase
4. **Componentes auxiliares**: Puede ser más corto (Btn, Img, etc. si es común)

## Variables y Constantes

### Variables en TypeScript

**Patrón:** `camelCase`

```typescript
✅ const userName = "Juan";
✅ let currentSlide = 0;
✅ const isLoading = false;
✅ const maxAttempts = 100;

❌ const user_name = "Juan";
❌ const UserName = "Juan";
❌ const currentslide = 0;
```

### Constantes

**Patrón:** `UPPER_SNAKE_CASE` (si es verdaderamente constante)

```typescript
✅ const MAX_RETRIES = 3;
✅ const DEFAULT_LANG = 'es';
✅ const API_TIMEOUT = 5000;

// Pero si no es "verdadera" constante, usa camelCase
✅ const products = [];  // Se puede mutar
```

### Booleanos

**Patrón:** Prefijo `is`, `has`, `can`, `should`

```typescript
✅ const isVisible = true;
✅ const hasError = false;
✅ const canSubmit = true;
✅ const shouldRotate = false;
✅ const isLoading = true;

❌ const visible = true;
❌ const error = false;
❌ const submit = true;
```

## Propiedades de Componentes

### Props Interface

```typescript
interface Props {
  // Booleanos con prefijo
  isActive?: boolean;
  hasIcon?: boolean;

  // Strings
  title: string;
  subtitle?: string;
  className?: string;

  // Números
  duration?: number;
  maxItems?: number;

  // Arrays/Objetos
  items?: Item[];
  config?: Record<string, any>;

  // Functions
  onClick?: (e: MouseEvent) => void;
  onSubmit?: (data: FormData) => Promise<void>;
}
```

**Reglas:**
- Props obligatorios primero
- Props opcionales con `?`
- Usa tipos específicos, no `any`
- Booleanos con prefijo `is/has/can/should`

## Traducciones (JSON)

### Claves de Traducción

**Patrón:** `seccion.subseccion.clave` (snake_case o camelCase)

```json
✅ {
  "header": {
    "nav": {
      "home": "Inicio",
      "aboutUs": "Sobre Nosotros"
    }
  },
  "sections": {
    "hero": {
      "mainTitle": "Bienvenido",
      "subTitle": "Subtítulo"
    }
  }
}

❌ {
  "header_nav_home": "Inicio",
  "HEADER.NAV.HOME": "Inicio"
}
```

**Reglas:**
- Agrupa por contexto (header, sections, forms, etc.)
- Usa notación de puntos para acceder: `t('header.nav.home')`
- camelCase o snake_case consistente dentro del archivo
- Mantén el mismo nivel en ambos idiomas

## CSS Classes

### Clases del Template Original

El proyecto usa clases del template original. **NO las cambies** a menos que entiendas las dependencias.

```html
<!-- Clases del template: -->
✅ <div class="st-hero-wrap">
✅ <div class="st-btn st-style1">
✅ <div class="st-section-heading">

<!-- Patrón: st-[nombre]-[variante] -->
```

Si necesitas agregar clases personalizadas:

```html
<!-- Combina con las originales -->
<div class="st-section-heading custom-spacing">
  <!-- ... -->
</div>
```

```css
/* En src/styles/global.css o component style -->
.custom-spacing {
  margin-bottom: 2rem;
}
```

### BEM para clases personalizadas

Si defines nuevas clases, usa **BEM** (Block Element Modifier):

```css
/* Block */
.form-appointment { }

/* Element */
.form-appointment__field { }
.form-appointment__label { }

/* Modifier */
.form-appointment__field--error { }
.form-appointment__field--disabled { }
```

```html
<div class="form-appointment">
  <div class="form-appointment__field form-appointment__field--error">
    <label class="form-appointment__label">Nombre</label>
    <input type="text" />
  </div>
</div>
```

## Identificadores (IDs)

### Patrón para IDs

**Patrón:** `kebab-case`

```html
✅ <div id="appointment-form">
✅ <section id="hero">
✅ <div id="testimonials-slider">

❌ <div id="AppointmentForm">
❌ <section id="Hero">
```

**Regla:** Usa IDs para:
- Anclas de navegación (ej: `#appointment`)
- Scripts que necesitan seleccionar elementos
- Formularios principales

Evita IDs para estilos (usa classes).

## Funciones y Métodos

### Funciones Astro

```typescript
// Funciones que obtienen datos
✅ getTranslations()
✅ fetchBlogPosts()
✅ calculateTotal()

// Funciones que hacen
✅ initSlider()
✅ submitForm()
✅ toggleMenu()

// Predicados (retornan boolean)
✅ isValidEmail()
✅ hasElement()
✅ canSubmit()
```

### Nombres descriptivos

```typescript
❌ function handle() { }
❌ function process() { }
❌ function get() { }

✅ function handleFormSubmit() { }
✅ function processImageUpload() { }
✅ function getFilteredProducts() { }
```

## Eventos

### Handlers de eventos

```typescript
// Patrón: on[Evento]
✅ const handleClick = () => { }
✅ const handleSubmit = () => { }
✅ const handleScroll = () => { }

❌ const onClick = () => { }
❌ const onSubmit = () => { }
```

### En HTML

```html
<!-- Atributos de evento -->
✅ onclick="handleClick()"
✅ @click="handleClick"     (si es framework)
✅ onClick={handleClick}    (en JSX)
```

## Estructura de Código

### Orden en componentes Astro

```astro
---
// 1. Imports
import { t } from '../../i18n/translations';
import SomeComponent from '../../components/SomeComponent.astro';

// 2. Interfaces
interface Props {
  lang?: 'es' | 'en';
  title?: string;
}

// 3. Destructuring props
const { lang = 'es', title } = Astro.props;

// 4. Constants
const MAX_ITEMS = 10;

// 5. Variables
const items = getItems();
const filtered = items.filter(...);

// 6. Functions (si es necesario)
function processData() { }
---

<!-- HTML template -->
<div>
  <!-- Contenido aquí -->
</div>

<!-- Estilos scoped -->
<style>
  /* CSS aquí */
</style>

<!-- Scripts -->
<script>
  // JS aquí
</script>
```

## Ejemplos Prácticos

### ✅ Ejemplo Correcto

**Archivo:** `src/components/sections/BlogPostCard.astro`

```astro
---
import { t } from '../../i18n/translations';

interface Props {
  lang?: 'es' | 'en';
  title: string;
  excerpt: string;
  authorName: string;
  isPublished?: boolean;
  publishedDate?: Date;
}

const {
  lang = 'es',
  title,
  excerpt,
  authorName,
  isPublished = true,
  publishedDate
} = Astro.props;

const formattedDate = publishedDate?.toLocaleDateString(lang);
---

<article class="blog-post-card">
  <h3>{title}</h3>
  <p>{excerpt}</p>
  <footer>
    <span>{authorName}</span>
    {formattedDate && <span>{formattedDate}</span>}
  </footer>
</article>

<style>
  .blog-post-card {
    padding: 1rem;
    border: 1px solid #ccc;
  }
</style>
```

### ❌ Ejemplo Incorrecto

```astro
---
interface Props {
  l?: string;           // ❌ Abreviado sin razón
  TITLE: string;        // ❌ UPPER_CASE para variable normal
  excerpt: string;
  author_name: string;  // ❌ snake_case en TS
  pub?: boolean;        // ❌ Abreviado
  pDate?: Date;         // ❌ Abreviado
}

const { l = 'es', TITLE, excerpt, author_name, pub = true, pDate } = Astro.props;
const fmtDate = pDate?.toLocaleDateString(l);  // ❌ Abreviado
---

<article className="BlogPostCard">
  <h3>{TITLE}</h3>
  <!-- ... -->
</article>
```

## Resumen de Patrones

| Tipo | Patrón | Ejemplo |
|------|--------|---------|
| Archivos `.astro` | PascalCase | `HeroSection.astro` |
| Carpetas | lowercase | `src/components/` |
| Imágenes | kebab-case | `hero-img.png` |
| Variables | camelCase | `userName` |
| Constantes | UPPER_SNAKE_CASE | `MAX_ITEMS` |
| Booleanos | is/has/can/should | `isActive` |
| IDs HTML | kebab-case | `id="hero-section"` |
| Clases CSS | kebab-case o BEM | `.st-hero` o `.form__field` |
| Funciones | camelCase + verbo | `handleSubmit()` |
| Traducción | kebab-case o camelCase | `header.nav.home` |

---

**Objetivo:** Código predecible, fácil de leer y mantener.
