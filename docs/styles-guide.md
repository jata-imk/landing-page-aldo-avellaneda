# Guía de Estilos CSS

## Estructura CSS del Proyecto

### Archivos CSS principales

```
public/styles/
├── bootstrap.min.css              # Bootstrap base
├── bootstrap-responsive.min.css   # Responsive
└── style.css                      # Estilos personalizados del template

src/styles/
└── global.css                     # Estilos globales adicionales (si es necesario)
```

### Orden de carga (en MainLayout.astro)

```html
<link rel="stylesheet" href="/styles/bootstrap.min.css" />
<link rel="stylesheet" href="/styles/bootstrap-responsive.min.css" />
<link rel="stylesheet" href="/styles/style.css" />
```

La cascada es: Bootstrap → Bootstrap Responsive → Estilos personalizados

## Clases del Template Original

El proyecto usa un **sistema de clases personalizado** del template original con prefijo `st-`.

### Patrón de clases

```html
<!-- Patrón: st-[nombre]-[variante] -->

<!-- Ejemplo Hero -->
<div class="st-hero-wrap">
  <div class="st-hero st-style1">
    <h1 class="st-hero-title">Título</h1>
  </div>
</div>

<!-- Ejemplo Botones -->
<a href="#" class="st-btn st-style1 st-color1">
  Click
</a>

<!-- Ejemplo Secciones -->
<section class="st-about-wrap">
  <div class="st-section-heading st-style1">
    <h2 class="st-section-heading-title">About</h2>
  </div>
</section>
```

### Clases Más Usadas

#### Layout y Contenedor

```html
<!-- Contenedor principal -->
<div class="st-content">
  <!-- Contenido -->
</div>

<!-- Espaciadores -->
<div class="st-height-b40"><!-- 40px --></div>
<div class="st-height-b60"><!-- 60px --></div>
<div class="st-height-b120"><!-- 120px --></div>

<!-- Versión responsive (lg = large) -->
<div class="st-height-lg-b40"><!-- 40px en desktop --></div>
```

#### Tipografía y Headings

```html
<!-- Títulos de sección -->
<div class="st-section-heading st-style1">
  <h2 class="st-section-heading-title">Título</h2>
  <div class="st-seperator">
    <!-- líneas decorativas -->
  </div>
  <p class="st-section-heading-subtitle">Subtítulo</p>
</div>
```

#### Botones

```html
<!-- Botón básico -->
<a href="#" class="st-btn st-style1 st-color1">Botón</a>

<!-- Variantes de tamaño -->
<a href="#" class="st-btn st-style1 st-color1 st-size-medium">Medio</a>
<a href="#" class="st-btn st-style1 st-color1 st-size-large">Grande</a>

<!-- Colores -->
<a href="#" class="st-btn st-color1">Color primario</a>
<a href="#" class="st-btn st-color2">Color secundario</a>
```

#### Fondos y Colores

```html
<!-- Fondos -->
<div class="st-gray-bg"><!-- fondo gris --></div>
<div class="st-white-bg"><!-- fondo blanco --></div>
<div class="st-dark-bg"><!-- fondo oscuro --></div>

<!-- Dinámico (con imagen de fondo) -->
<div class="st-dynamic-bg st-fixed-bg" data-src="/imagen.jpg">
  <!-- el CSS maneja la imagen -->
</div>

<!-- Opacidad/transparencia -->
<div class="st-overlay"><!-- capa semi-transparente --></div>
```

#### Componentes

```html
<!-- Cards -->
<div class="st-testimonial st-style1">
  <div class="st-testimonial-info">
    <img src="" alt="" class="st-testimonial-img" />
    <h4 class="st-testimonial-name">Nombre</h4>
  </div>
  <div class="st-testimonial-text">Texto</div>
</div>

<!-- Forms -->
<div class="st-form-field st-style1">
  <label>Nombre</label>
  <input type="text" />
</div>

<!-- Gallery/Isotope -->
<div class="st-isotop st-style1">
  <div class="st-isotop-item">
    <a href="#" class="st-lightbox-item">
      <img src="" alt="" />
    </a>
  </div>
</div>
```

#### Header y Navigation

```html
<!-- Header -->
<header class="st-site-header st-style1 st-sticky-header">
  <!-- Top header con contacto -->
  <div class="st-top-header">
    <ul class="st-top-header-list">
      <li><a href="...">Email</a></li>
      <li><a href="...">Teléfono</a></li>
    </ul>
  </div>

  <!-- Main header con navegación -->
  <div class="st-main-header">
    <div class="st-nav">
      <ul class="st-nav-list st-onepage-nav">
        <li><a href="#home">Home</a></li>
        <li><a href="#about">About</a></li>
      </ul>
    </div>
  </div>
</header>

<!-- Logo -->
<a class="st-site-branding" href="#home">
  <img src="/logo.png" alt="Logo" />
</a>
```

## Estilos Personalizados

### Dónde agregar estilos personalizados

**Opción 1: En el componente (recomendado)**

```astro
<!-- HeroSection.astro -->
<div class="custom-hero">
  <!-- Contenido -->
</div>

<style>
  .custom-hero {
    padding: 2rem;
    background-color: #f5f5f5;
  }
</style>
```

**Opción 2: En `src/styles/global.css`**

```css
/* Para estilos que afecten múltiples componentes */
.custom-spacing {
  margin-bottom: 2rem;
}

.text-white {
  color: white;
}
```

### Estructura CSS recomendada

```astro
<style>
  /* Variables CSS */
  :root {
    --primary-color: #fa6b47;
    --secondary-color: #333;
  }

  /* Estilos base */
  .component-name {
    padding: 1rem;
    background-color: var(--primary-color);
  }

  /* Estados */
  .component-name:hover {
    opacity: 0.9;
  }

  .component-name.active {
    border-bottom: 3px solid var(--primary-color);
  }

  /* Responsive */
  @media (max-width: 768px) {
    .component-name {
      padding: 0.5rem;
    }
  }
</style>
```

## Sistema de Colores

### Colores principales del template

Basado en clases `st-color[N]`:

```css
/* Color primario (naranja) */
.st-color1 {
  color: #fa6b47;
  background-color: #fa6b47;
}

/* Color secundario */
.st-color2 {
  color: #333;
  background-color: #333;
}

/* Otros colores están definidos en style.css */
```

### Usar colores en tu CSS

```css
/* Opción 1: Copiar valores del template */
.my-element {
  background-color: #fa6b47;
}

/* Opción 2: Usar CSS variables */
:root {
  --primary: #fa6b47;
}

.my-element {
  background-color: var(--primary);
}

/* Opción 3: Combinar con clases del template */
<a class="st-btn st-color1">Botón</a>
```

## Responsive Design

### Breakpoints de Bootstrap (en uso)

```css
/* Dispositivos pequeños (teléfonos) */
@media (max-width: 576px) {
  /* Estilos para mobile */
}

/* Dispositivos medianos (tablets) */
@media (min-width: 576px) and (max-width: 768px) {
  /* Estilos para tablet */
}

/* Dispositivos grandes (desktops) */
@media (min-width: 768px) {
  /* Estilos para desktop */
}

/* Dispositivos extra grandes */
@media (min-width: 1200px) {
  /* Estilos para XL */
}
```

### Clases responsive del template

```html
<!-- Clases con sufijo -lg para desktop -->
<div class="st-height-b120 st-height-lg-b50">
  <!-- 50px en desktop, 120px en mobile -->
</div>

<!-- Display responsive -->
<div class="st-hidden-mobile">
  <!-- Solo visible en desktop -->
</div>

<div class="st-hidden-desktop">
  <!-- Solo visible en mobile -->
</div>
```

## Grid/Layout

### Bootstrap Grid

El proyecto incluye Bootstrap, así que puedes usar su grid:

```html
<div class="container">
  <div class="row">
    <div class="col-md-6">
      <!-- 50% ancho en tablet y desktop -->
    </div>
    <div class="col-md-6">
      <!-- 50% ancho en tablet y desktop -->
    </div>
  </div>
</div>

<div class="container">
  <div class="row">
    <div class="col-lg-4"><!-- 33% en desktop --></div>
    <div class="col-lg-4"><!-- 33% en desktop --></div>
    <div class="col-lg-4"><!-- 33% en desktop --></div>
  </div>
</div>
```

### Grid del Template

El template también tiene clases propias:

```html
<div class="st-container">
  <!-- Contenedor con padding -->
</div>

<div class="container">
  <!-- Contenedor Bootstrap estándar -->
</div>
```

## Animaciones

### WOW.js (ya incluido)

El template incluye WOW.js para animaciones al scroll:

```html
<div class="wow fadeInUp" data-wow-duration="0.8s" data-wow-delay="0.2s">
  <!-- Se anima al entrar en viewport -->
</div>

<!-- Animaciones disponibles -->
fadeIn, fadeInUp, fadeInDown, fadeInLeft, fadeInRight
slideInLeft, slideInRight, slideInUp, slideInDown
zoomIn, zoomInUp
bounceIn, bounceInUp
```

### CSS personalizadas

```css
@keyframes customFadeIn {
  from {
    opacity: 0;
    transform: translateY(10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.fade-in {
  animation: customFadeIn 0.6s ease-out;
}
```

## Sombras y Efectos

### Box Shadow

```css
.elevated {
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.deep-shadow {
  box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
}
```

### Transiciones

```css
.transition-all {
  transition: all 0.3s ease;
}

.hover-lift:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
}
```

## Tipografía

### Fuentes del template

El template incluye:
- Google Fonts (revisar en HTML original)
- Font Awesome (iconos)
- Pe-icon-7-stroke (iconos)

### Usar iconos

```html
<!-- Font Awesome -->
<i class="fas fa-heart"></i>
<i class="fab fa-facebook"></i>

<!-- Pe Icon 7 Stroke -->
<i class="pe-7s-menu"></i>
<i class="pe-7s-search"></i>
```

### Estilos de texto

```html
<p class="st-text-large">Texto grande</p>
<p class="st-text-small">Texto pequeño</p>

<strong>Negrita</strong>
<em>Itálica</em>
```

## Performance de CSS

### ✅ DO

```css
/* Reutiliza clases del template */
<a class="st-btn st-color1">Botón</a>

/* Agrupa valores comunes */
.my-component {
  padding: 1rem;
  border-radius: 4px;
}

/* Especificidad mínima */
.card { }
.card__title { }
```

### ❌ DON'T

```css
/* No duplicar estilos del template */
.my-btn {
  padding: 10px 20px;
  background: #fa6b47;
}
/* Usa st-btn en lugar */

/* No usar !important */
.element {
  color: red !important;
}

/* No usar selectores muy específicos */
div > section.main > article > p.text {
  color: blue;
}
```

## Debugging CSS

### Inspeccionar estilos

1. Abre DevTools (F12)
2. Selecciona elemento
3. Ve a "Styles" para ver qué CSS se aplica
4. Busca conflictos de estilos

### Problemas comunes

```
Problema: Mi estilo no se aplica
Soluciones:
1. Verifica especificidad (clases vs IDs)
2. Revisa si hay estilos que lo sobrescriben
3. Usa !important como último recurso
4. Revisa el order de archivos CSS

Problema: Estilos diferentes en mobile/desktop
Soluciones:
1. Usa media queries correctamente
2. Revisa clases responsive del template
3. Inspecciona en modo responsive del navegador
```

## Ejemplos Prácticos

### Botón personalizado

```astro
<a href="#" class="st-btn st-style1 st-color1 btn-custom">
  Click aquí
</a>

<style>
  .btn-custom {
    text-transform: uppercase;
    font-weight: 600;
    letter-spacing: 1px;
    transition: all 0.3s ease;
  }

  .btn-custom:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(250, 107, 71, 0.3);
  }
</style>
```

### Card personalizada

```astro
<div class="card-custom">
  <img src="/image.jpg" alt="image" class="card-custom__image" />
  <div class="card-custom__body">
    <h3 class="card-custom__title">Título</h3>
    <p class="card-custom__text">Descripción</p>
  </div>
</div>

<style>
  .card-custom {
    background: white;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease;
  }

  .card-custom:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
  }

  .card-custom__image {
    width: 100%;
    height: 200px;
    object-fit: cover;
  }

  .card-custom__body {
    padding: 1.5rem;
  }

  .card-custom__title {
    font-size: 1.25rem;
    margin-bottom: 0.5rem;
  }

  .card-custom__text {
    color: #666;
    font-size: 0.95rem;
  }
</style>
```

---

**Última actualización:** Octubre 31, 2024

Para referencia CSS completa, ver: `public/styles/style.css` en el proyecto
