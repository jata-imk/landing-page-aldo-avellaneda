# Referencia del Template Original

## ¿Qué es template-original/?

La carpeta `template-original/` contiene los **archivos HTML/CSS/JS originales del template** comprado.

Es una **referencia** útil para:
- Copiar clases CSS y estructura HTML
- Encontrar scripts JavaScript necesarios
- Ver cómo está diseñada una sección
- Buscar íconos o decoraciones

**NO se compila ni se incluye en el build.**

## Estructura

```
template-original/
├── index.html              # Página completa en HTML
├── 📁 assets/
│   ├── 📁 js/              # Scripts JavaScript
│   │   ├── jquery-1.12.4.min.js
│   │   ├── jquery.slick.min.js     ← Copiado a public/js/
│   │   ├── isotope.pkg.min.js      ← Copiado a public/js/
│   │   ├── lightgallery.min.js     ← Copiado a public/js/
│   │   ├── wow.min.js              ← Copiado a public/js/
│   │   └── [otros...]
│   │
│   ├── 📁 css/              # Estilos CSS
│   │   ├── bootstrap.min.css        ← Copiado a public/styles/
│   │   ├── bootstrap-responsive.min.css
│   │   ├── style.css                ← Copiado a public/styles/
│   │   └── [otros...]
│   │
│   ├── 📁 images/           # Imágenes
│   └── [otros archivos]
│
└── [otros archivos HTML]
```

## Cómo Usar la Referencia

### 1. Buscar Estructura HTML

**Problema:** ¿Cómo está estructurado el hero?

**Solución:**
1. Abre `template-original/index.html` en navegador
2. Inspecciona con DevTools (F12)
3. Copia la estructura que necesitas
4. Adapta a componente Astro

```html
<!-- Ejemplo: Estructura Hero del template original -->
<div class="st-hero-wrap st-gray-bg st-dynamic-bg">
  <div class="st-hero st-style1">
    <div class="st-hero-text">
      <h1 class="st-hero-title cd-headline slide">
        <span class="cd-words-wrapper">
          <b class="is-visible">Palabra 1</b>
          <b class="is-hidden">Palabra 2</b>
        </span>
      </h1>
    </div>
  </div>
</div>
```

### 2. Encontrar Clases CSS

**Problema:** ¿Qué clases se usan para botones?

**Solución:**
1. Abre `public/styles/style.css` (o desde template-original/)
2. Busca `.st-btn`
3. Copia las clases que necesitas

```css
/* De style.css */
.st-btn {
  display: inline-block;
  padding: 10px 30px;
  border-radius: 5px;
  transition: all 0.3s;
}

.st-btn.st-style1 {
  /* Variante de estilo */
}

.st-btn.st-color1 {
  /* Color primario */
  background-color: #fa6b47;
}
```

### 3. Copiar Scripts Necesarios

**Problema:** Necesito el slider de Slick

**Solución:**
1. El archivo ya está copiado: `public/js/jquery.slick.min.js`
2. Se carga automáticamente en `MainLayout.astro`
3. Úsalo en tus componentes

```astro
<script>
  // En tu componente
  const $ = (window as any).$;
  $('.slider').slick({
    autoplay: true,
    infinite: true,
  });
</script>
```

### 4. Buscar Íconos o Decoraciones

**Problema:** ¿Dónde están los íconos?

**Solución:**
1. En template-original, busca referencias a íconos
2. Font Awesome: `<i class="fas fa-..."></i>`
3. Pe Icon: `<i class="pe-7s-..."></i>`

```html
<!-- Font Awesome -->
<i class="fas fa-heart"></i>
<i class="fab fa-facebook"></i>

<!-- Pe Icon 7 Stroke -->
<i class="pe-7s-menu"></i>
<i class="pe-7s-search"></i>

<!-- SVG customizado -->
<svg>...</svg>
```

## Archivos Importantes a Revisar

### Para Estructura General

Abre `template-original/index.html` y revisa:
- Header y navegación
- Secciones principales
- Footer
- Orden de scripts al final

### Para Estilos

Lee `template-original/assets/css/style.css`:
- Clases disponibles
- Variables de color
- Espaciadores
- Variantes

### Para Scripts

Lee `template-original/assets/js/`:
- `jquery.slick.min.js` - Carousel
- `isotope.pkg.min.js` - Gallery filtering
- `lightgallery.min.js` - Lightbox
- `wow.min.js` - Scroll animations

## Caso de Uso: Replicar una Sección

### Paso 1: Entender la sección

```html
<!-- En template-original/index.html, busca la sección About -->
<section class="st-about-wrap" id="about">
  <div class="container">
    <div class="st-section-heading st-style1">
      <h2>Quiénes Somos</h2>
    </div>
    <!-- Contenido -->
  </div>
</section>
```

### Paso 2: Copiar estructura

```astro
<!-- src/components/sections/AboutSection.astro -->
<section class="st-about-wrap" id="about">
  <div class="container">
    <div class="st-section-heading st-style1">
      <h2>{t('sections.about.title', lang)}</h2>
    </div>
    <!-- Contenido adaptado -->
  </div>
</section>
```

### Paso 3: Agregar traducciones

En `src/i18n/locales/es.json`:
```json
{
  "sections": {
    "about": {
      "title": "Quiénes Somos"
    }
  }
}
```

En `src/i18n/locales/en.json`:
```json
{
  "sections": {
    "about": {
      "title": "Who We Are"
    }
  }
}
```

### Paso 4: Usar el componente

```astro
<!-- src/pages/index.astro -->
<AboutSection lang="es" />
```

## Clases Más Usadas (del template)

### Contenedor y Layout

```
st-content        - Contenedor principal
st-height-b[N]    - Espaciador (N = 20, 40, 60, 120)
st-gray-bg        - Fondo gris
st-dynamic-bg     - Fondo con imagen dinámico
```

### Secciones

```
st-[seccion]-wrap - Wrapper de sección (st-hero-wrap, st-about-wrap)
st-section-heading - Encabezado de sección
st-seperator       - Línea decorativa
```

### Componentes

```
st-btn            - Botón
st-btn st-style1  - Variante de estilo
st-btn st-color1  - Color primario
st-form-field     - Campo de formulario
st-isotop         - Grid de isotope
st-lightbox-item  - Item para lightbox
```

### Tipografía

```
st-text-large     - Texto grande
st-text-small     - Texto pequeño
st-hero-title     - Título del hero
```

## Búsqueda Rápida en el Template

### Con VS Code

1. Abre `template-original/index.html`
2. Ctrl+F para buscar
3. Busca la sección o clase que necesitas

```
Buscar: class="st-
Buscar: data-wow
Buscar: id="
Buscar: script src
```

### Con navegador

1. Abre `template-original/index.html` en navegador
2. F12 para DevTools
3. Ctrl+F en DevTools
4. Busca elementos

## Importante: NO Copiar Todo

⚠️ **Cuidado:** No necesitas copiar TODO el HTML.

Adapta según tu necesidad:
- ✅ Copia la estructura HTML
- ✅ Copia los nombres de clases CSS
- ✅ Copia los datos/atributos data-*
- ❌ NO copies inline styles (usa CSS)
- ❌ NO copies scripts completos (adapta a Astro)

## Diferencias Entre Template y Proyecto Actual

| Aspecto | Template Original | Proyecto Actual |
|---------|-----------------|-----------------|
| **Formato** | HTML estático | Astro SSG |
| **Idiomas** | Uno (hardcodeado) | Multiidioma |
| **Scripts** | HTML inline | Astro + Scripts |
| **Estilos** | CSS inline + CSS file | CSS scoped + CSS global |
| **Traducciones** | Hardcodeadas | JSON + función t() |

## Donde Está Cada Cosa

| Elemento | Template Original | Proyecto Actual |
|----------|------------------|-----------------|
| HTML | `/template-original/index.html` | `src/components/` + `src/pages/` |
| CSS | `/template-original/assets/css/` | `/public/styles/` |
| JS | `/template-original/assets/js/` | `/public/js/` |
| Imágenes | `/template-original/assets/images/` | `/public/` |

## Ejemplo: Agregar Nueva Sección

### Fase 1: Investigación

1. Abre template-original/index.html
2. Busca la sección que quieres
3. Copia su HTML en DevTools

### Fase 2: Crear Componente

```astro
<!-- src/components/sections/NewSection.astro -->
---
import { t } from '../../i18n/translations';

interface Props {
  lang?: 'es' | 'en';
}

const { lang = 'es' } = Astro.props;
---

<!-- Usa estructura del template original, pero adaptada -->
<section class="st-newsection-wrap" id="newsection">
  <div class="container">
    <div class="st-section-heading st-style1">
      <h2>{t('sections.newsection.title', lang)}</h2>
    </div>
    <!-- Contenido -->
  </div>
</section>

<style>
  /* Estilos si es necesario -->
</style>
```

### Fase 3: Agregar Traducciones

En ambos JSON (es.json y en.json):
```json
{
  "sections": {
    "newsection": {
      "title": "Mi Nueva Sección"
    }
  }
}
```

### Fase 4: Usar el Componente

```astro
<!-- En index.astro -->
import NewSection from '../components/sections/NewSection.astro';

<!-- En el template -->
<NewSection lang="es" />
```

## Preguntas Frecuentes

**P: ¿Puedo ver el template original en navegador?**
R: Sí, abre `template-original/index.html` directamente en el navegador.

**P: ¿Qué Scripts necesito agregar?**
R: Ya están copiados en `public/js/`. Solo haz referencia en MainLayout.

**P: ¿Puedo cambiar las clases CSS?**
R: No es recomendado. El CSS está optimizado. Crea clases nuevas si necesitas.

**P: ¿Dónde están las imágenes originales?**
R: En `template-original/assets/images/` (para referencia).
Las imágenes del proyecto están en `public/`.

**P: ¿Necesito mantener template-original?**
R: Solo es referencia. Puedes eliminarlo si ya no lo necesitas.

---

**Nota:** Siempre que agregues algo del template original, adáptalo al sistema Astro + multiidioma.
