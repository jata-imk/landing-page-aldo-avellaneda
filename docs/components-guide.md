# Guía de Componentes Astro

## Estructura Base de un Componente

### Anatomía de un componente `.astro`

```astro
---
// Importaciones
import { t } from '../../i18n/translations';
import SomeComponent from './SomeComponent.astro';

// Tipos
interface Props {
  lang?: 'es' | 'en';
  title: string;
  items?: Item[];
  isActive?: boolean;
}

// Destructuring
const { lang = 'es', title, items = [], isActive = false } = Astro.props;

// Lógica del componente
const processedItems = items.filter(item => item.visible);
const itemCount = processedItems.length;
---

<!-- Template HTML -->
<section class="component-name">
  <h2>{title}</h2>
  {processedItems.map(item => (
    <div>{item.name}</div>
  ))}
</section>

<!-- Estilos scoped (solo para este componente) -->
<style>
  .component-name {
    padding: 1rem;
  }
</style>

<!-- Scripts (ejecutados en el navegador) -->
<script>
  console.log('Component mounted');
</script>
```

## Sección 1: Frontmatter (---)

### Props

```astro
---
interface Props {
  // String requerido
  title: string;

  // String opcional
  description?: string;

  // Booleano con valor por defecto
  isVisible?: boolean = true;

  // Número
  maxItems?: number;

  // Array
  items?: Array<{ id: string; name: string }>;

  // Enum/Union
  size?: 'small' | 'medium' | 'large';

  // Function
  onClose?: () => void;
}

const { title, description, isVisible = true } = Astro.props;
---
```

**Reglas:**
- Define interfaz `Props` siempre
- Propiedades obligatorios primero
- Propiedades opcionales con `?` después
- Usa tipos específicos (no `any`)

### Imports

```astro
---
// Componentes
import Header from '../components/Header.astro';
import { Button } from '../components/Button.astro';

// Funciones/Utilidades
import { t } from '../i18n/translations';
import { formatDate } from '../utils/date';

// Tipos
import type { BlogPost } from '../types';

// Astro
import { getCollection } from 'astro:content';
---
```

### Lógica

```astro
---
const { lang = 'es' } = Astro.props;

// Variables locales
const title = t('sections.hero.title', lang);
const items = [1, 2, 3];

// Condicionales
const isProduction = import.meta.env.MODE === 'production';

// Funciones
function processData(data: any[]) {
  return data.filter(item => item.visible);
}

// Async (fetch, queries)
const posts = await getCollection('blog');
---
```

## Sección 2: Template HTML

### Sintaxis Básica

```astro
<!-- Interpolación -->
<h1>{title}</h1>

<!-- Atributos -->
<img src={imagePath} alt={description} />
<a href={url} class={activeClass}>Link</a>

<!-- Condicionales -->
{isVisible && <p>Visible</p>}

{isVisible ? <p>Sí</p> : <p>No</p>}

<!-- Loops -->
{items.map(item => (
  <div>{item.name}</div>
))}

<!-- Clases dinámicas -->
<div class={`base ${isActive ? 'active' : ''}`}>
  Content
</div>

<!-- HTML raw (cuidado) -->
<div set:html={htmlContent} />
```

### Componentes Hijos

```astro
---
import Header from '../components/Header.astro';
import { Footer } from '../components/Footer.astro';
---

<div>
  <!-- Pasar props -->
  <Header title="Mi Página" lang="es" />

  <!-- Slot (contenido hijo) -->
  <Card>
    <h2>Contenido dentro de Card</h2>
  </Card>

  <!-- Múltiples slots -->
  <Container>
    <div slot="header">Encabezado</div>
    <div slot="content">Contenido</div>
    <div slot="footer">Pie</div>
  </Container>

  <Footer lang="es" />
</div>
```

### Slots

```astro
<!-- Componente: Card.astro -->
<div class="card">
  <header class="card-header">
    <slot name="header" />
  </header>

  <div class="card-body">
    <slot />  {/* Slot por defecto */}
  </div>

  <footer class="card-footer">
    <slot name="footer" />
  </footer>
</div>

<!-- Uso: -->
<Card>
  <div slot="header">Título</div>
  <p>Contenido principal</p>
  <div slot="footer">Pie</div>
</Card>
```

## Sección 3: Estilos

### Estilos Scoped

```astro
<style>
  /* Solo afecta a este componente */
  .title {
    color: red;
  }
</style>

<!-- En otro componente con misma clase -->
<style>
  .title {
    color: blue;  /* No afecta al primer componente */
  }
</style>
```

### Variables CSS

```astro
<style define:vars={{ primaryColor: '#fa6b47' }}>
  .element {
    background-color: var(--primaryColor);
  }
</style>
```

### Importar CSS

```astro
---
import '../styles/component.css';
---

<div class="my-component">
  <!-- Usa clases del CSS importado -->
</div>
```

## Sección 4: Scripts

### Script Básico

```astro
<script>
  // Ejecuta en el navegador cuando el componente monta
  console.log('Component mounted');

  // Accede al DOM local
  const title = document.querySelector('h1');
  if (title) {
    title.addEventListener('click', () => {
      console.log('Title clicked');
    });
  }
</script>
```

### Script con Variables

```astro
---
const MAX_ITEMS = 10;
---

<div id="container"></div>

<script define:vars={{ MAX_ITEMS }}>
  // Acceso a variables del frontmatter
  console.log('Max items:', MAX_ITEMS);

  const container = document.getElementById('container');
  for (let i = 0; i < MAX_ITEMS; i++) {
    const item = document.createElement('div');
    item.textContent = `Item ${i + 1}`;
    container.appendChild(item);
  }
</script>
```

### Script Externo

```astro
<script src="/js/jquery.slick.min.js"></script>
<script src="/js/wow.min.js"></script>

<script>
  // Aquí puedes usar jQuery y WOW
  const $ = window.$;
  $('.slider').slick({...});
</script>
```

## Componentes Comunes en el Proyecto

### 1. HeroSection.astro

```astro
---
import { t } from '../../i18n/translations';

interface Props {
  lang?: 'es' | 'en';
}

const { lang = 'es' } = Astro.props;
const words = t('sections.hero.words', lang) as string[];
---

<div class="st-hero-wrap">
  <!-- Contenido -->
</div>

<script>
  // Script del slider
</script>
```

**Características:**
- Rotación de palabras
- Slider de imágenes (Slick)
- Animaciones (WOW)

### 2. Header.astro

```astro
---
import { t } from '../../i18n/translations';

interface Props {
  lang?: 'es' | 'en';
}

const { lang = 'es' } = Astro.props;
---

<header class="st-site-header st-style1">
  <!-- Navigation -->
  {t('header.nav.home', lang)}
</header>
```

**Características:**
- Navegación multi-idioma
- Top header con contacto
- Cambio de idioma

### 3. AppointmentSection.astro

```astro
---
import { t } from '../../i18n/translations';

interface Props {
  lang?: 'es' | 'en';
}

const { lang = 'es' } = Astro.props;
---

<section id="appointment" class="st-shape-wrap st-gray-bg">
  <form class="st-appointment-form" id="appointment-form">
    <!-- Campos del formulario -->
  </form>
</section>

<script>
  // Validación y envío del formulario
</script>
```

**Características:**
- Formulario de citas
- Validación client-side
- Soporte para traducción

### 4. GallerySection.astro

```astro
---
import { t } from '../../i18n/translations';

interface Props {
  lang?: 'es' | 'en';
}

const { lang = 'es' } = Astro.props;

const galleryItems = [
  { id: '1', src: '/project1.jpg', categories: ['cardiology'] },
  // ...
];
---

<section id="gallery">
  <div class="st-isotop">
    {galleryItems.map(item => (
      <div class={`st-isotop-item ${item.categories.join(' ')}`}>
        <a href={item.src} class="st-lightbox-item">
          <img src={item.thumb} alt="" />
        </a>
      </div>
    ))}
  </div>
</section>

<script>
  // Isotope + lightGallery
</script>
```

**Características:**
- Isotope para filtrado
- lightGallery para lightbox
- Categorías dinámicas

## Props Patterns

### Pattern 1: Strings y Booleanos

```astro
---
interface Props {
  title: string;
  subtitle?: string;
  isActive?: boolean;
  variant?: 'primary' | 'secondary';
}

const {
  title,
  subtitle,
  isActive = false,
  variant = 'primary'
} = Astro.props;
---

<div class={`component ${variant} ${isActive ? 'active' : ''}`}>
  <h2>{title}</h2>
  {subtitle && <p>{subtitle}</p>}
</div>
```

### Pattern 2: Arrays

```astro
---
interface Item {
  id: string;
  name: string;
  icon?: string;
}

interface Props {
  items: Item[];
  maxItems?: number;
}

const { items, maxItems = 5 } = Astro.props;
const displayed = items.slice(0, maxItems);
---

<ul>
  {displayed.map(item => (
    <li>
      {item.icon && <i class={item.icon} />}
      {item.name}
    </li>
  ))}
</ul>
```

### Pattern 3: Objetos

```astro
---
interface Config {
  title: string;
  description: string;
  color?: string;
}

interface Props {
  config: Config;
  enabled?: boolean;
}

const { config, enabled = true } = Astro.props;
---

{enabled && (
  <div style={{ borderColor: config.color }}>
    <h3>{config.title}</h3>
    <p>{config.description}</p>
  </div>
)}
```

## Componentes con Traducción

### Pattern: Pasar lang como prop

```astro
<!-- src/pages/index.astro -->
<HeroSection lang="es" />
<AboutSection lang="es" />
<Footer lang="es" />

<!-- src/pages/en/index.astro -->
<HeroSection lang="en" />
<AboutSection lang="en" />
<Footer lang="en" />
```

```astro
<!-- src/components/sections/HeroSection.astro -->
---
import { t } from '../../i18n/translations';

interface Props {
  lang?: 'es' | 'en';
}

const { lang = 'es' } = Astro.props;

const title = t('sections.hero.title', lang);
const words = t('sections.hero.words', lang) as string[];
---

<h1>{title}</h1>
```

## Composición de Componentes

### Componente Padre

```astro
<!-- ParentComponent.astro -->
---
interface Props {
  lang?: 'es' | 'en';
}

const { lang = 'es' } = Astro.props;
---

<div class="parent">
  <h1>Padre</h1>
  <slot />
</div>

<style>
  .parent {
    padding: 2rem;
  }
</style>
```

### Componente Hijo

```astro
<!-- ChildComponent.astro -->
---
interface Props {
  lang?: 'es' | 'en';
  title?: string;
}

const { lang = 'es', title = 'Hijo' } = Astro.props;
---

<div class="child">
  <h2>{title}</h2>
  <p>Soy un componente hijo</p>
</div>

<style>
  .child {
    background: #f5f5f5;
  }
</style>
```

### Uso

```astro
<ParentComponent lang="es">
  <ChildComponent lang="es" title="Mi Hijo" />
</ParentComponent>
```

## Best Practices

### ✅ DO

```astro
---
// 1. Define Props interface
interface Props {
  title: string;
  isActive?: boolean;
}

// 2. Destructure con defaults
const { title, isActive = false } = Astro.props;

// 3. Lógica clara
const displayText = isActive ? 'Activo' : 'Inactivo';
---

<!-- 4. HTML semántico -->
<section class="component">
  <h2>{title}</h2>
  <p>{displayText}</p>
</section>

<!-- 5. Estilos scoped -->
<style>
  .component {
    padding: 1rem;
  }
</style>
```

### ❌ DON'T

```astro
---
// 1. Props sin tipado
const props = Astro.props;

// 2. Props anidados sin usar
const { config: { deep: { value } } } = Astro.props;
---

<!-- 3. HTML sin semántica -->
<div class="component">
  <div>{props.title}</div>
</div>

<!-- 4. Estilos globales en componente -->
<style is:global>
  body { color: red; }
</style>
```

## Debug de Componentes

### Logs en build time

```astro
---
console.log('Building component...');
console.log('Props:', Astro.props);
---
```

### Logs en runtime

```astro
<script>
  console.log('Component mounted');
  const element = document.querySelector('.component');
  console.log('Element:', element);
</script>
```

### DevTools

- Abre F12 en navegador
- Ve a Console para ver logs
- Ve a Elements para inspeccionar DOM
- Ve a Network para ver cargas

---

**Última actualización:** Octubre 31, 2024

Para más info: [docs.astro.build/components](https://docs.astro.build/en/basics/astro-components/)
