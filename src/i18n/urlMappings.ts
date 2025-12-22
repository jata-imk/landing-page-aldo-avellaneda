/**
 * Mapeo bidireccional de URLs entre español e inglés
 *
 * Este archivo centraliza todas las rutas del sitio y sus traducciones
 * correspondientes para facilitar el cambio de idioma.
 */
export const urlMappings: Record<string, string> = {
  // Español → Inglés
  "/": "/en",
  "/acerca-del-dr-aldo-avellaneda": "/en/about-dr-aldo-avellaneda",
  "/cirugia-de-columna": "/en/spine-surgery",
  "/contacto": "/en/contact",

  // Inglés → Español
  "/en": "/",
  "/en/about-dr-aldo-avellaneda": "/acerca-del-dr-aldo-avellaneda",
  "/en/spine-surgery": "/cirugia-de-columna",
  "/en/contact": "/contacto",
};

/**
 * Obtiene la URL traducida para el idioma opuesto
 *
 * @param currentPath - Ruta actual (pathname)
 * @returns Ruta traducida o la misma ruta si no hay mapeo disponible
 *
 * @example
 * getTranslatedUrl("/acerca-del-dr-aldo-avellaneda")
 * // Returns: "/en/about-dr-aldo-avellaneda"
 *
 * getTranslatedUrl("/en/about-dr-aldo-avellaneda")
 * // Returns: "/acerca-del-dr-aldo-avellaneda"
 */
export function getTranslatedUrl(currentPath: string): string {
  // Normalizar path (remover trailing slash si existe, excepto para root)
  const normalizedPath = currentPath === "/" ? "/" : currentPath.replace(/\/$/, "");

  // Buscar mapeo exacto
  if (urlMappings[normalizedPath]) {
    return urlMappings[normalizedPath];
  }

  // Si no hay mapeo, usar lógica fallback (agregar/quitar /en)
  const isEnglish = normalizedPath.startsWith("/en");
  if (isEnglish) {
    // Remover /en del inicio
    return normalizedPath.replace(/^\/en/, "") || "/";
  } else {
    // Agregar /en al inicio
    return normalizedPath === "/" ? "/en" : `/en${normalizedPath}`;
  }
}
