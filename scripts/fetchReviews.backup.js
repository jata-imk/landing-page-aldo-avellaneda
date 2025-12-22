/**
 * Google Reviews Fetcher Script
 *
 * Este script obtiene reviews de Google Maps usando la API de Outscraper (free tier).
 *
 * INSTRUCCIONES PARA USAR ESTE SCRIPT:
 *
 * 1. Registrarse en Outscraper (GRATIS):
 *    - Ir a: https://outscraper.com
 *    - Crear cuenta gratuita
 *    - Obtener API key desde el dashboard
 *    - Free tier: 100 requests/mes (suficiente para actualizaciones mensuales)
 *
 * 2. Configurar este script:
 *    - Reemplazar 'YOUR_OUTSCRAPER_API_KEY_HERE' con tu API key
 *    - Reemplazar 'YOUR_GOOGLE_MAPS_URL_HERE' con la URL de Google Maps de tu negocio
 *
 * 3. Ejecutar el script:
 *    cd scripts
 *    node fetchReviews.js
 *
 * 4. El script creará/actualizará:
 *    - src/data/googleReviews.json (datos de reviews)
 *    - Descargará avatares en public/reviews/avatars/
 *
 * 5. Después de ejecutar el script:
 *    npm run build
 *    (Las reviews se actualizarán en el sitio)
 *
 * FRECUENCIA RECOMENDADA: 1-3 meses
 */

const fs = require('fs');
const path = require('path');
const https = require('https');

// ============================================
// CONFIGURACIÓN - EDITAR AQUÍ
// ============================================

const CONFIG = {
  // 1. Obtener API key gratuita de https://outscraper.com
  OUTSCRAPER_API_KEY: 'c2MjNjVjNTAzOGNiOTExNDIzMmE3MWNkN2E2NzBlMzIxZjV8NmM0NWM0ZjIzYg',

  // 2. URL de Google Maps de tu negocio
  // Ejemplo: 'https://www.google.com/maps/place/Hospital+Faro+del+Mayab/@21.0307694,-89.6145844,17z/...'
  GOOGLE_MAPS_URL: 'https://www.google.com/maps/place/Ortopedista,+Traumat%C3%B3log%C3%ADa+M%C3%A9rida,+Canc%C3%BAn+%7C+Dr.+Aldo+Avellaneda+%7C+Especialista+en+Columna+%7C+Cirug%C3%ADa+M%C3%ADnima+Invasi%C3%B3n/@21.0161907,-89.5850012,17z/data=!4m6!3m5!1s0x8f5676f669555555:0xd6a48100ff0e2fe7!8m2!3d21.0161907!4d-89.5850012!16s%2Fg%2F11kjh881jg?hl=es&entry=ttu&g_ep=EgoyMDI1MTIwOS4wIKXMDSoASAFQAw%3D%3D',

  // 3. Máximo de reviews a obtener (recomendado: 15-20)
  MAX_REVIEWS: 20,

  // 4. Idioma de las reviews (es = español)
  LANGUAGE: 'es',

  // Rutas de salida (no modificar a menos que sepas lo que haces)
  OUTPUT_PATH: path.join(__dirname, '../src/data/googleReviews.json'),
  AVATARS_DIR: path.join(__dirname, '../public/reviews/avatars'),
};

// ============================================
// FUNCIONES AUXILIARES
// ============================================

/**
 * Descargar imagen de avatar
 */
function downloadAvatar(url, filename) {
  return new Promise((resolve, reject) => {
    if (!url || url === 'undefined') {
      console.log(`  ⊘ Avatar no disponible para ${filename}`);
      resolve('/reviews/default-avatar.png');
      return;
    }

    const filePath = path.join(CONFIG.AVATARS_DIR, filename);

    // Verificar si ya existe
    if (fs.existsSync(filePath)) {
      console.log(`  ✓ Avatar ya existe: ${filename}`);
      resolve(`/reviews/avatars/${filename}`);
      return;
    }

    // Descargar imagen
    https.get(url, (response) => {
      if (response.statusCode !== 200) {
        console.log(`  ⊘ Error descargando avatar: ${response.statusCode}`);
        resolve('/reviews/default-avatar.png');
        return;
      }

      const fileStream = fs.createWriteStream(filePath);
      response.pipe(fileStream);

      fileStream.on('finish', () => {
        fileStream.close();
        console.log(`  ✓ Avatar descargado: ${filename}`);
        resolve(`/reviews/avatars/${filename}`);
      });
    }).on('error', (err) => {
      console.error(`  ✗ Error descargando avatar: ${err.message}`);
      resolve('/reviews/default-avatar.png');
    });
  });
}

/**
 * Generar ID único para review
 */
function generateReviewId(review) {
  const text = review.review_text || '';
  const author = review.author_title || '';
  const date = review.review_datetime_utc || '';
  const combined = `${author}-${date}-${text.substring(0, 50)}`;
  return 'review-' + Buffer.from(combined).toString('base64').substring(0, 12);
}

/**
 * Formatear fecha relativa en español
 */
function formatDateES(dateString) {
  const reviewDate = new Date(dateString);
  const now = new Date();
  const diffTime = Math.abs(now - reviewDate);
  const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

  if (diffDays < 7) return 'hace pocos días';
  if (diffDays < 30) return 'hace unas semanas';
  if (diffDays < 60) return 'hace 1 mes';
  if (diffDays < 90) return 'hace 2 meses';
  if (diffDays < 120) return 'hace 3 meses';
  if (diffDays < 180) return `hace ${Math.floor(diffDays / 30)} meses`;
  if (diffDays < 365) return 'hace más de 6 meses';
  return `hace ${Math.floor(diffDays / 365)} año${Math.floor(diffDays / 365) > 1 ? 's' : ''}`;
}

/**
 * Formatear fecha relativa en inglés
 */
function formatDateEN(dateString) {
  const reviewDate = new Date(dateString);
  const now = new Date();
  const diffTime = Math.abs(now - reviewDate);
  const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

  if (diffDays < 7) return 'a few days ago';
  if (diffDays < 30) return 'a few weeks ago';
  if (diffDays < 60) return '1 month ago';
  if (diffDays < 90) return '2 months ago';
  if (diffDays < 120) return '3 months ago';
  if (diffDays < 180) return `${Math.floor(diffDays / 30)} months ago`;
  if (diffDays < 365) return 'over 6 months ago';
  return `${Math.floor(diffDays / 365)} year${Math.floor(diffDays / 365) > 1 ? 's' : ''} ago`;
}

/**
 * Sanitizar nombre de archivo
 */
function sanitizeFilename(name) {
  return name
    .toLowerCase()
    .replace(/[^a-z0-9]+/g, '-')
    .replace(/^-+|-+$/g, '')
    .substring(0, 50);
}

// ============================================
// FUNCIÓN PRINCIPAL
// ============================================

async function fetchGoogleReviews() {
  console.log('🔍 Obteniendo reviews de Google Maps...\n');

  // Validar configuración
  if (CONFIG.OUTSCRAPER_API_KEY === 'YOUR_OUTSCRAPER_API_KEY_HERE') {
    console.error('❌ ERROR: Debes configurar tu API key de Outscraper en CONFIG.OUTSCRAPER_API_KEY');
    console.error('   Obtén tu API key gratuita en: https://outscraper.com\n');
    process.exit(1);
  }

  if (CONFIG.GOOGLE_MAPS_URL === 'YOUR_GOOGLE_MAPS_URL_HERE') {
    console.error('❌ ERROR: Debes configurar la URL de Google Maps de tu negocio en CONFIG.GOOGLE_MAPS_URL\n');
    process.exit(1);
  }

  // Crear directorio de avatares si no existe
  if (!fs.existsSync(CONFIG.AVATARS_DIR)) {
    fs.mkdirSync(CONFIG.AVATARS_DIR, { recursive: true });
    console.log('✓ Directorio de avatares creado\n');
  }

  try {
    // Llamar a la API de Outscraper
    const apiUrl = `https://api.app.outscraper.com/maps/reviews-v3?query=${encodeURIComponent(CONFIG.GOOGLE_MAPS_URL)}&reviewsLimit=${CONFIG.MAX_REVIEWS}&language=${CONFIG.LANGUAGE}`;

    console.log('📡 Conectando con Outscraper API...');

    const response = await fetch(apiUrl, {
      headers: {
        'X-API-KEY': CONFIG.OUTSCRAPER_API_KEY
      }
    });

    if (!response.ok) {
      throw new Error(`API error: ${response.status} ${response.statusText}`);
    }

    const data = await response.json();

    if (!data.data || !data.data[0] || !data.data[0].reviews_data) {
      throw new Error('No se encontraron reviews en la respuesta de la API');
    }

    console.log('✓ Reviews obtenidas de la API\n');

    // Procesar reviews
    const businessData = data.data[0];
    const reviewsData = businessData.reviews_data;

    console.log(`📊 Procesando ${reviewsData.length} reviews...\n`);

    const processedReviews = [];

    for (const review of reviewsData) {
      const reviewId = generateReviewId(review);
      const authorSlug = sanitizeFilename(review.author_title || 'user');
      const avatarFilename = `${authorSlug}-${reviewId}.jpg`;

      // Descargar avatar
      const avatarPath = await downloadAvatar(review.author_image, avatarFilename);

      // Procesar review
      const processedReview = {
        id: reviewId,
        author: review.author_title || 'Usuario Anónimo',
        authorImage: avatarPath,
        rating: review.review_rating || 5,
        date: review.review_datetime_utc || new Date().toISOString(),
        dateDisplay: {
          es: formatDateES(review.review_datetime_utc),
          en: formatDateEN(review.review_datetime_utc)
        },
        text: {
          es: review.review_text || '',
          en: review.review_text || '' // TODO: Traducir si es necesario
        }
      };

      processedReviews.push(processedReview);
    }

    // Crear objeto final
    const finalData = {
      businessInfo: {
        name: businessData.name || 'Dr. José Aldo Avellaneda',
        googleMapsUrl: CONFIG.GOOGLE_MAPS_URL,
        averageRating: businessData.rating || 4.9,
        totalReviews: businessData.reviews || processedReviews.length,
        lastUpdated: new Date().toISOString().split('T')[0]
      },
      reviews: processedReviews
    };

    // Guardar JSON
    fs.writeFileSync(
      CONFIG.OUTPUT_PATH,
      JSON.stringify(finalData, null, 2),
      'utf-8'
    );

    console.log('\n✅ ¡Proceso completado exitosamente!\n');
    console.log(`📝 Reviews guardadas: ${CONFIG.OUTPUT_PATH}`);
    console.log(`🖼️  Avatares descargados: ${CONFIG.AVATARS_DIR}`);
    console.log(`📊 Total de reviews: ${processedReviews.length}\n`);
    console.log('📌 PRÓXIMOS PASOS:');
    console.log('   1. Ejecuta: npm run build');
    console.log('   2. Verifica el sitio con: npm run preview');
    console.log('   3. Las reviews aparecerán en el widget de Google Reviews\n');

  } catch (error) {
    console.error('\n❌ ERROR al obtener reviews:');
    console.error(error.message);
    console.error('\nRevisa que:');
    console.error('  - Tu API key de Outscraper sea válida');
    console.error('  - La URL de Google Maps sea correcta');
    console.error('  - Tengas requests disponibles en tu cuenta (100/mes gratis)\n');
    process.exit(1);
  }
}

// ============================================
// EJECUTAR
// ============================================

// Verificar que estamos usando Node.js 18+ (para fetch)
const nodeVersion = parseInt(process.version.split('.')[0].replace('v', ''));
if (nodeVersion < 18) {
  console.error('❌ ERROR: Este script requiere Node.js 18 o superior');
  console.error(`   Tu versión actual: ${process.version}`);
  console.error('   Actualiza Node.js desde: https://nodejs.org\n');
  process.exit(1);
}

// Ejecutar función principal
fetchGoogleReviews().catch((error) => {
  console.error('Error fatal:', error);
  process.exit(1);
});
