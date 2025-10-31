# Guía de Setup y Configuración

## Requisitos Previos

- **Node.js** 18.x o superior
- **npm** 9.x o superior (incluido con Node.js)
- **Git** (para control de versiones)
- Editor: **VS Code** (recomendado)

Verifica las versiones:
```bash
node --version    # v18.17.0 o superior
npm --version     # 9.6.7 o superior
git --version     # 2.x o superior
```

## Instalación Inicial

### 1. Clonar o descargar el proyecto

```bash
# Si es un repositorio Git
git clone <url-repositorio>
cd landing-page-astro

# O si descargaste el ZIP
unzip landing-page-astro.zip
cd landing-page-astro
```

### 2. Instalar dependencias

```bash
npm install
```

Esto:
- Descarga `astro` y sus dependencias
- Crea la carpeta `node_modules/`
- Genera `package-lock.json`

### 3. Verificar la instalación

```bash
npm run --version
```

Debería mostrar los scripts disponibles:
```
dev    - Inicia servidor de desarrollo
build  - Compila para producción
preview - Sirve el build como producción
astro   - CLI de Astro
```

## Desarrollo Local

### Iniciar servidor de desarrollo

```bash
npm run dev
```

Salida esperada:
```
🚀  Server running at: http://localhost:3000/
```

Abre tu navegador en http://localhost:3000

### Features del servidor de desarrollo

✅ **Hot Module Reload (HMR)**: Los cambios se reflejan automáticamente
✅ **Error messages mejorados**: Errores claros en consola
✅ **TypeScript checking**: Validación de tipos
✅ **Debug mode**: Acceso a información adicional

### Cambios que se actualizan automáticamente

- Componentes `.astro`
- TypeScript en `src/`
- Traducciones en `src/i18n/locales/`
- CSS en `src/styles/`

⚠️ **Nota**: Si cambias `package.json` o scripts, reinicia el servidor.

## Compilación para Producción

### Generar build estático

```bash
npm run build
```

Esto:
1. Procesa todos los componentes Astro
2. Genera HTML estático para cada página
3. Minifica CSS/HTML
4. Crea versiones en ES e EN automáticamente
5. Copia `public/` a `dist/`
6. Salida en carpeta `dist/`

Tiempo esperado: 5-15 segundos

### Resultado

```
dist/
├── en/
│   └── index.html
├── index.html
├── js/
├── styles/
└── [imágenes y recursos]
```

### Preview del build (local)

```bash
npm run build
npm run preview
```

Abre http://localhost:3000 para ver el build como si fuera producción.

## Estructura de package.json

```json
{
  "name": "medical-landing-page-astro",
  "type": "module",
  "version": "0.0.1",
  "scripts": {
    "dev": "astro dev",
    "build": "astro build",
    "preview": "astro preview",
    "astro": "astro"
  },
  "dependencies": {
    "astro": "^5.15.3"
  }
}
```

**Dependencias mínimas:**
- Solo `astro` - No necesita React, Vue, etc.
- Más ligero que alternativas con frameworks

## Configuración de Astro

Archivo: `astro.config.mjs`

```javascript
export default defineConfig({
  integrations: [react()],  // ⚠️ Sin usar actualmente
  i18n: {
    defaultLocale: 'es',           // Idioma por defecto
    locales: ['es', 'en'],        // Idiomas soportados
    routing: {
      prefixDefaultLocale: false,  // / es ES, /en es EN
    },
  },
  output: 'static',               // SSG (Static Site Generation)
  compressHTML: true,             // Minificar HTML
});
```

### Parámetros Importantes

- **defaultLocale**: Idioma por defecto (español en este proyecto)
- **locales**: Idiomas disponibles
- **output**: 'static' = SSG (mejor rendimiento)
- **compressHTML**: Minificar HTML (reducir tamaño)

## Configuración de TypeScript

Archivo: `tsconfig.json`

```json
{
  "extends": "astro/tsconfigs/strict"
}
```

- Basado en configuración estricta de Astro
- Validación de tipos para `.astro` y `.ts`

## Configuración de VS Code

### Extensiones Recomendadas

```json
// .vscode/extensions.json
{
  "recommendations": [
    "astro.astro",
    "esbenp.prettier-vscode",
    "dbaeumer.vscode-eslint"
  ]
}
```

### Instalar extensión Astro

1. Abre VS Code
2. Extensions → Busca "Astro"
3. Instala la extensión oficial de Astro
4. Recarga VS Code

### Snippets útiles en VS Code

```
// Snippet para componente Astro
---
interface Props {
  title?: string;
}

const { title } = Astro.props;
---

<div>
  <h1>{title}</h1>
</div>
```

## Troubleshooting

### Problema: "node_modules not found"

**Solución:**
```bash
rm -rf node_modules package-lock.json
npm install
```

### Problema: Puerto 3000 en uso

**Solución:**
```bash
npm run dev -- --port 3001
```

### Problema: Cambios no se reflejan

**Solución:**
```bash
1. Cierra el servidor (Ctrl+C)
2. npm install
3. npm run dev
```

### Problema: Error de compilación

**Solución:**
```bash
npm run build
# Lee los errores que salgan
# Revisa los archivos mencionados
# Corrige y reintenta
```

### Problema: TypeScript errors

**Solución:**
```bash
# Reconstruye types
npm run astro -- --version

# O reinicia VS Code
```

## Comandos Útiles

```bash
# Desarrollo
npm run dev                 # Servidor local con HMR

# Compilación
npm run build              # Generar build para producción
npm run preview            # Previewsuizar build localmente

# Astro CLI
npm run astro check        # Verificar tipos
npm run astro add react    # Agregar integración
npm run astro telemetry    # Ver/controlar telemetría
```

## Optimizaciones en Build

El proyecto ya está optimizado:

✅ **HTML comprimido** - `compressHTML: true`
✅ **CSS del template** - Incluido en build
✅ **JS en public/** - Se copia directamente
✅ **Imágenes** - Se copian sin procesar
✅ **Sin assets JS innecesarios** - Solo jQuery y plugins necesarios

## Deploy

### Preparar para producción

```bash
npm run build
```

### Subir a hosting

1. Sube contenido de `dist/` a tu servidor
2. Configura servidor web para servir `index.html` en rutas no encontradas (para SPA-like behavior, aunque aquí es SSG)

### Hosting Recomendado

- **Vercel**: Soporte nativo para Astro
- **Netlify**: Deploy automático desde Git
- **AWS S3 + CloudFront**: Control total
- **GitHub Pages**: Gratuito para repositorios públicos

### Variables de Entorno

Actualmente no hay variables de entorno configuradas.

Si necesitas agregar:

```bash
# Crear .env.local (no commitear)
VITE_API_URL=https://api.ejemplo.com
```

```astro
<!-- Usar en componentes -->
const apiUrl = import.meta.env.VITE_API_URL;
```

## Workflow Recomendado

```
1. npm run dev                    # Inicia desarrollo
2. Haz cambios en src/
3. Verifica en http://localhost:3000
4. Cuando esté listo:
   npm run build                  # Compila
   npm run preview                # Verifica build
5. Commit y push
6. Deploy desde hosting
```

---

Más información: [docs.astro.build](https://docs.astro.build/)
