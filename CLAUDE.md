# Landing Page Medical - Proyecto Astro

## Descripción General

Este es un sitio web médico responsivo construido con **Astro** como generador de sitios estáticos. El proyecto es bilingüe (español e inglés) y utiliza un sistema de traducción personalizado.

**Stack tecnológico:**
- Astro 5.x (Static Site Generation)
- TypeScript
- CSS vanilla + clases Bootstrap del template original
- jQuery para funcionalidades interactivas (Slick, Isotope, lightGallery)
- Sistema de traducción personalizado

## Estructura Rápida

```
landing-page-astro/
├── src/
│   ├── components/        # Componentes Astro reutilizables
│   │   ├── layout/       # Header, Footer
│   │   └── sections/     # Secciones principales (Hero, About, etc.)
│   ├── layouts/          # Layouts base (MainLayout)
│   ├── pages/            # Páginas (ES en raíz, EN en /en/)
│   ├── styles/           # CSS global
│   ├── i18n/             # Sistema de traducción
│   │   ├── locales/      # JSON de traducciones (es.json, en.json)
│   │   └── translations.ts # Función t() para acceder a traducciones
├── public/               # Archivos estáticos (imágenes, JS, CSS)
│   ├── js/              # Scripts jQuery (jquery.slick.min.js, etc.)
│   ├── styles/          # CSS del template original
│   └── [imágenes]
├── template-original/    # Referencia del template HTML original
├── docs/                # Documentación del proyecto (archivos modulares)
└── astro.config.mjs     # Configuración de Astro
```

Para detalles completos de la estructura, ver: **[docs/project-structure.md](./docs/project-structure.md)**

## Sistema de Traducción

El proyecto utiliza un **sistema de traducción personalizado y simple** (no usa i18next):

- Función `t(key, lang)` en `src/i18n/translations.ts`
- Traducciones en JSON: `src/i18n/locales/es.json` y `en.json`
- Los componentes Astro acceden a las traducciones en build time
- Resultado: HTML estático optimizado sin carga dinámica

```typescript
// Ejemplo de uso en componentes
import { t } from '../../i18n/translations';
const { lang = 'es' } = Astro.props;
<h1>{t('sections.hero.title', lang)}</h1>
```

Para más detalles: **[docs/i18n-system.md](./docs/i18n-system.md)**

## Configuración Rápida

### Instalar dependencias
```bash
npm install
```

### Desarrollo local
```bash
npm run dev
```
Abre http://localhost:3000

### Compilar para producción
```bash
npm run build
```
Los archivos se generan en `dist/`

Para guía completa: **[docs/setup.md](./docs/setup.md)**

## Archivos Importantes

| Archivo | Propósito |
|---------|-----------|
| `astro.config.mjs` | Configuración de Astro (i18n, output, etc.) |
| `src/i18n/translations.ts` | Función de traducción |
| `src/layouts/MainLayout.astro` | Layout base (carga jQuery, estilos) |
| `src/pages/index.astro` | Página principal en español |
| `src/pages/en/index.astro` | Página principal en inglés |
| `public/js/` | Scripts jQuery necesarios |

## Referencia del Template Original

Los archivos HTML/CSS/JS originales están en `template-original/`. Útiles para:
- Copiar clases CSS y estructura HTML
- Encontrar scripts JavaScript
- Referencia de diseño y componentes

Ver: **[docs/template-original.md](./docs/template-original.md)**

## Convenciones del Proyecto

- **Componentes:** Nombres en PascalCase (`HeroSection.astro`)
- **Props:** Interfaz `Props` para tipado
- **Traduciones:** Claves con formato `sections.hero.title` (notación de puntos)
- **Estilos:** Clases CSS del template original (ej: `st-hero`, `st-btn`)

Para más detalles: **[docs/naming-conventions.md](./docs/naming-conventions.md)**

## Características Principales

✅ **Bilingüe** - Español (raíz) e Inglés (/en/)
✅ **SSG Estático** - Mejor rendimiento y SEO
✅ **Responsive** - Bootstrap + CSS personalizado
✅ **Componentes Interactivos** - Slick carousel, Isotope gallery, lightGallery
✅ **Optimizado** - HTML comprimido, carga de JS en orden correcto

## Secciones del Sitio

- **Hero** - Slider de imágenes + rotación de palabras
- **About** - Información de la clínica + horarios
- **Appointment** - Formulario de citas
- **Gallery** - Galería de proyectos con filtros
- **Testimonials** - Slider de testimonios

## Documentación Modular

Para tareas específicas, consulta:

1. **[docs/project-structure.md](./docs/project-structure.md)** - Estructura completa del proyecto
2. **[docs/setup.md](./docs/setup.md)** - Configuración del entorno
3. **[docs/i18n-system.md](./docs/i18n-system.md)** - Sistema de traducción
4. **[docs/naming-conventions.md](./docs/naming-conventions.md)** - Convenciones de código
5. **[docs/styles-guide.md](./docs/styles-guide.md)** - Guía de estilos CSS
6. **[docs/components-guide.md](./docs/components-guide.md)** - Estructura de componentes
7. **[docs/template-original.md](./docs/template-original.md)** - Referencia del template

## Próximos Pasos

- [ ] Customizar colores y branding
- [ ] Reemplazar imágenes con las del proyecto
- [ ] Configurar servidor de correos para formulario
- [ ] Revisar SEO y metadatos
- [ ] Deploy a producción

## Notas Importantes

- **No hay React en producción** - Se eliminaron todas las dependencias de React
- **Slick está en `/public/js/`** - No se importa desde npm
- **Traducciones en build time** - No hay carga dinámica de idiomas
- **Template original como referencia** - En `template-original/` para copiar código/estilos

---

**Última actualización:** Octubre 31, 2024
**Mantenedor:** Claude Code
