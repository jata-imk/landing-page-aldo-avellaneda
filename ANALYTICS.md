# 📊 Guía de Configuración de Analytics y Tracking

Esta guía te ayudará a configurar Google Tag Manager, Google Analytics 4 y Facebook Pixel en tu sitio web.

## 🎯 ¿Qué necesitas obtener?

Para activar el sistema de métricas completo, necesitas los siguientes IDs:

1. **Google Tag Manager (GTM)** - Container ID
2. **Google Analytics 4 (GA4)** - Measurement ID
3. **Facebook Pixel** - Pixel ID
4. **Google Search Console** - Verificación

---

## 📋 Paso 1: Google Tag Manager (Recomendado)

Google Tag Manager (GTM) es un contenedor que gestiona todos tus tags de seguimiento. **Es la forma más profesional** de gestionar analytics.

### Crear cuenta de GTM:

1. Ve a: https://tagmanager.google.com
2. Haz clic en **"Crear cuenta"**
3. Llena el formulario:
   - **Nombre de cuenta:** Dr. Aldo Avellaneda
   - **País:** México
   - **Nombre del contenedor:** draldoavellaneda.com
   - **Plataforma:** Web
4. Acepta los términos
5. **Copia el Container ID** (formato: `GTM-XXXXXXX`)

### Agregar GA4 y Facebook Pixel desde GTM:

Una vez creado GTM, puedes agregar Google Analytics y Facebook Pixel desde el dashboard de GTM sin necesidad de código adicional.

**Tutorial:** https://support.google.com/tagmanager/answer/6103696

---

## 📈 Paso 2: Google Analytics 4 (GA4)

### Crear propiedad de GA4:

1. Ve a: https://analytics.google.com
2. Haz clic en **"Administrar"** (engranaje en la parte inferior izquierda)
3. Haz clic en **"Crear propiedad"**
4. Llena el formulario:
   - **Nombre de la propiedad:** Dr. Aldo Avellaneda - Sitio Web
   - **Zona horaria:** (GMT-06:00) Hora central - Ciudad de México
   - **Moneda:** Peso mexicano (MXN)
5. Configura detalles del negocio:
   - **Sector:** Salud y medicina
   - **Tamaño:** Pequeña (1-10 empleados)
6. Crea un **flujo de datos web**:
   - URL del sitio: https://www.draldoavellaneda.com
   - Nombre del flujo: Sitio Web Principal
7. **Copia el Measurement ID** (formato: `G-XXXXXXXXXX`)

**Tutorial:** https://support.google.com/analytics/answer/9304153

---

## 📱 Paso 3: Facebook Pixel

### Crear Facebook Pixel:

1. Ve a: https://business.facebook.com
2. Ve a **"Eventos"** en el menú lateral
3. Haz clic en **"Conectar orígenes de datos"**
4. Selecciona **"Web"**
5. Haz clic en **"Conectar"**
6. Elige **"Píxel de Facebook"**
7. Ponle nombre: **Dr. Aldo Avellaneda - Website**
8. Ingresa la URL: https://www.draldoavellaneda.com
9. **Copia el Pixel ID** (número de ~15 dígitos)

**Tutorial:** https://www.facebook.com/business/help/952192354843755

---

## 🔍 Paso 4: Google Search Console

### Verificar sitio en Search Console:

1. Ve a: https://search.google.com/search-console
2. Haz clic en **"Agregar propiedad"**
3. Elige **"Prefijo de URL"**
4. Ingresa: https://www.draldoavellaneda.com
5. Selecciona método de verificación: **"Etiqueta HTML"**
6. **Copia el código de verificación** (meta tag)
7. Envía el código al desarrollador para agregarlo al sitio

**Tutorial:** https://support.google.com/webmasters/answer/9008080

---

## ⚙️ Configuración Local (Para el desarrollador)

### 1. Crear archivo `.env` en la raíz del proyecto:

```bash
# Copia el archivo .env.example
cp .env.example .env
```

### 2. Editar `.env` con los IDs reales:

```env
# Google Tag Manager
PUBLIC_GTM_ID=GTM-XXXXXXX

# Google Analytics 4 (opcional si usas GTM)
PUBLIC_GA_MEASUREMENT_ID=G-XXXXXXXXXX

# Facebook Pixel (opcional si usas GTM)
PUBLIC_FB_PIXEL_ID=123456789012345
```

### 3. Reiniciar el servidor de desarrollo:

```bash
npm run dev
```

---

## ✅ Verificar que funciona

### Método 1: Extensiones de navegador

Instala estas extensiones en Chrome/Firefox:

- **Tag Assistant (by Google):** Verifica GTM y GA4
- **Facebook Pixel Helper:** Verifica Facebook Pixel

### Método 2: Consola del navegador

1. Abre el sitio en Chrome
2. Presiona `F12` para abrir Developer Tools
3. Ve a la pestaña **"Consola"**
4. Busca mensajes de:
   - `Google Tag Manager`
   - `fbq` (Facebook Pixel)

### Método 3: Dashboards oficiales

- **GTM:** https://tagmanager.google.com (modo Preview)
- **GA4:** https://analytics.google.com (Tiempo real)
- **Facebook:** https://business.facebook.com/events_manager (Test Events)

---

## 🎯 Eventos personalizados (Opcional)

### Ejemplo: Tracking de formulario de contacto

Puedes configurar eventos personalizados en GTM para trackear:

- **Envío de formulario de contacto**
- **Clics en botón de WhatsApp**
- **Clics en números de teléfono**
- **Descargas de documentos**

**Tutorial:** Configurar eventos en GTM Dashboard

---

## 🔒 Seguridad

- ✅ El archivo `.env` está en `.gitignore` y NO se sube al repositorio
- ✅ Los IDs son públicos y seguros (no son secretos)
- ✅ Solo funcionan en tu dominio configurado

---

## 🆘 ¿Necesitas ayuda?

### Recursos útiles:

- **GTM:** https://support.google.com/tagmanager
- **GA4:** https://support.google.com/analytics
- **Facebook Pixel:** https://www.facebook.com/business/help

### Soporte:

Contacta al desarrollador si tienes dudas sobre la implementación técnica.

---

## 📊 Métricas importantes a revisar

Una vez configurado, revisa semanalmente:

1. **GA4 - Tráfico:**
   - Usuarios nuevos vs recurrentes
   - Ubicación geográfica (México, USA, Canadá)
   - Páginas más visitadas
   - Tiempo en el sitio

2. **GA4 - Conversiones:**
   - Formularios enviados
   - Clics en WhatsApp
   - Llamadas telefónicas

3. **Facebook Pixel:**
   - PageView
   - Conversiones personalizadas
   - Audiencias de remarketing

4. **Search Console:**
   - Palabras clave que generan tráfico
   - Posición promedio en Google
   - CTR (Click Through Rate)

---

**Última actualización:** Enero 2025
