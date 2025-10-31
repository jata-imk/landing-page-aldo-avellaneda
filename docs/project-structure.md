# Estructura del Proyecto

## Árbol de directorios completo

```
landing-page-astro/
│
├── 📄 CLAUDE.md                    # Este archivo: documentación principal
├── 📄 README.md                    # README original del proyecto
├── 📄 astro.config.mjs             # Configuración de Astro
├── 📄 tsconfig.json                # Configuración de TypeScript
├── 📄 package.json                 # Dependencias del proyecto
├── 📄 package-lock.json
│
├── 📁 .vscode/                     # Configuración de VS Code
│   ├── extensions.json
│   └── launch.json
│
├── 📁 .git/                        # Control de versiones Git
│
├── 📁 .astro/                      # Cache/datos internos de Astro (ignorar)
│
├── 📁 node_modules/                # Dependencias instaladas (ignorar)
│
├── 📁 dist/                        # Build compilado para producción
│   ├── en/                         # Versión en inglés
│   ├── es/                         # Versión en español (generada)
│   └── [archivos estáticos]
│
├── 📁 public/                      # Archivos estáticos (copia directa a dist/)
│   ├── 📁 js/                      # Scripts JavaScript
│   │   ├── jquery-1.12.4.min.js   # jQuery
│   │   ├── jquery.slick.min.js    # Carousel Slick
│   │   ├── isotope.pkg.min.js     # Isotope (gallery filtering)
│   │   ├── lightgallery.min.js    # Light Gallery
│   │   ├── wow.min.js             # Wow animations
│   │   └── jQueryUi.js
│   │
│   ├── 📁 styles/                 # CSS del template original
│   │   ├── bootstrap.min.css
│   │   ├── bootstrap-responsive.min.css
│   │   ├── style.css
│   │   └── [otros]
│   │
│   ├── 📁 fonts/                  # Fuentes web
│   │   ├── font-awesome/
│   │   ├── pe-icon-7-stroke/
│   │   └── [otros]
│   │
│   ├── 📁 icons/                  # Iconos SVG/PNG
│   │
│   ├── 📁 shape/                  # Shapes/decoraciones SVG
│   │
│   ├── 📁 dental/                 # Imágenes de secciones
│   │
│   ├── 🖼️ *.jpg, *.png            # Imágenes del sitio
│   │   ├── hero-img*.png
│   │   ├── avatar*.png
│   │   ├── project*.jpg
│   │   ├── comment*.jpg
│   │   ├── member*.jpg
│   │   └── [más imágenes]
│   │
│   ├── robots.txt
│   ├── sitemap.xml
│   └── favicon.svg
│
├── 📁 src/                         # Código fuente principal
│   │
│   ├── 📁 components/              # Componentes reutilizables
│   │   │
│   │   ├── 📁 layout/              # Componentes de layout
│   │   │   ├── Header.astro       # Encabezado (nav, top bar)
│   │   │   ├── Footer.astro       # Pie de página
│   │   │   └── index.ts           # Exporta componentes
│   │   │
│   │   └── 📁 sections/            # Secciones principales
│   │       ├── HeroSection.astro  # Hero con slider + rotación de palabras
│   │       ├── AboutSection.astro # About + schedule
│   │       ├── AppointmentSection.astro # Formulario de citas
│   │       ├── GallerySection.astro # Galería con filtros
│   │       ├── TestimonialsSection.astro # Testimonios en slider
│   │       └── index.ts
│   │
│   ├── 📁 layouts/                 # Layouts (wrappers de página)
│   │   └── MainLayout.astro       # Layout base: DOCTYPE, head, scripts
│   │
│   ├── 📁 pages/                   # Páginas (router automático)
│   │   ├── index.astro            # Página principal ES (raíz)
│   │   └── 📁 en/
│   │       └── index.astro        # Página principal EN
│   │
│   ├── 📁 styles/                  # CSS global
│   │   └── global.css             # Estilos globales (cuando se necesite)
│   │
│   └── 📁 i18n/                    # Sistema de internacionalización
│       ├── translations.ts        # Función t() para obtener traducciones
│       └── 📁 locales/
│           ├── es.json            # Traducciones en español
│           └── en.json            # Traducciones en inglés
│
├── 📁 template-original/           # Template HTML original para referencia
│   ├── index.html                 # Archivo HTML original completo
│   ├── 📁 assets/
│   │   ├── js/
│   │   │   ├── jquery.slick.min.js
│   │   │   ├── isotope.pkg.min.js
│   │   │   └── [otros]
│   │   ├── css/
│   │   └── images/
│   └── [otros archivos originales]
│
└── 📁 docs/                        # Documentación del proyecto
    ├── project-structure.md        # Este archivo
    ├── setup.md                    # Guía de configuración
    ├── i18n-system.md              # Sistema de traducción
    ├── naming-conventions.md       # Convenciones de código
    ├── styles-guide.md             # Guía de estilos
    ├── components-guide.md         # Guía de componentes
    └── template-original.md        # Referencia del template
```

## Detalles de Cada Carpeta

### `src/`
Código fuente del proyecto. Solo estos archivos se compilan/transpilan.

### `src/components/`
Componentes reutilizables Astro. Se importan en páginas y otros componentes.
- **layout/**: Header, Footer (componentes globales)
- **sections/**: Secciones de contenido principales

### `src/pages/`
Define el router del sitio automáticamente:
- `src/pages/index.astro` → `/` (español por defecto)
- `src/pages/en/index.astro` → `/en/` (inglés)

Astro genera HTML estático para cada página en build time.

### `src/i18n/`
Sistema de traducción personalizado:
- `translations.ts`: Función `t(key, lang)` que busca valores en los JSON
- `locales/`: Archivos JSON con traducciones organizadas por claves

### `public/`
Archivos que se copian tal cual a `dist/` sin procesar:
- **js/**: Scripts jQuery (Slick, Isotope, lightGallery)
- **styles/**: CSS del template original
- **images/**: Todas las imágenes del sitio
- **fonts/**: Fuentes web

⚠️ **Importante**: TODO lo que está en `public/` se incluye en el build, aunque no se use. Limpiar archivos no utilizados manualmente.

### `template-original/`
Los archivos HTML/CSS/JS originales del template. Útil para:
- Copiar clases CSS
- Encontrar estructura HTML
- Buscar scripts JavaScript necesarios

**No se compila**, es solo referencia.

### `dist/`
Output final compilado. Se genera con `npm run build`.
- Contiene HTML estático listo para servir
- Versiones en español e inglés generadas automáticamente

## Orden de Carga

1. **build time**: Astro procesa componentes, traducciones, genera HTML estático
2. **publicación**: Archivos `public/` se copian a `dist/`
3. **browser**:
   - HTML se carga y renderiza
   - Scripts jQuery se cargan (js/)
   - CSS se aplica

## Archivos Importantes para Editar

| Archivo | Para cambiar... |
|---------|-----------------|
| `src/pages/index.astro` | Layout/contenido página ES |
| `src/pages/en/index.astro` | Layout/contenido página EN |
| `src/components/sections/*.astro` | Contenido de secciones |
| `src/i18n/locales/es.json` | Textos en español |
| `src/i18n/locales/en.json` | Textos en inglés |
| `src/layouts/MainLayout.astro` | HTML base (head, scripts) |
| `public/styles/style.css` | Estilos personalizados |

## Archivos a NO Modificar

- `src/i18n/translations.ts` - Sistema de traducción
- `.astro/` - Cache interno de Astro
- `dist/` - Se regenera con cada build

## Convención de Rutas

Astro usa file-based routing:
```
src/pages/index.astro → / (raíz)
src/pages/en/index.astro → /en/
src/pages/about.astro → /about/
src/pages/en/about.astro → /en/about/
```

En este proyecto:
- **Raíz (`/`)**: Español (por config en `astro.config.mjs`)
- **`/en/`**: Inglés

## Importancia de la Estructura

- **src/**: Solo código que se procesa
- **public/**: Archivos estáticos sin procesar
- **template-original/**: Referencia, no afecta build
- **docs/**: Documentación, no afecta build

---

Para más detalles de cada sección, ver documentación específica en `docs/`
