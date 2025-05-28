const sharp = require('sharp');
const path = require('path');
const fs = require('fs').promises;
const config = require('../config');

class ImageProcessor {
  constructor() {
    this.config = config.upload;
  }

  // Función equivalente a superscaleimage() en PHP
  async superscaleImage(inputPath, outputPath, width, height, quality = 95) {
    try {
      // Crear directorio si no existe
      const outputDir = path.dirname(outputPath);
      await fs.mkdir(outputDir, { recursive: true });

      await sharp(inputPath)
        .resize(width, height, {
          fit: 'inside',
          withoutEnlargement: false
        })
        .jpeg({ quality: quality })
        .toFile(outputPath);

      return true;
    } catch (error) {
      console.error('Error procesando imagen:', error);
      throw error;
    }
  }

  // Procesar imagen completa (original, media, thumb)
  async processUploadedImage(inputPath, filename) {
    try {
      const basePath = this.config.path;
      const originalPath = path.join(basePath, this.config.fotosOriginales, filename);
      const mediaPath = path.join(basePath, this.config.fotosMedias, filename);
      const thumbPath = path.join(basePath, this.config.fotosThumb, filename);

      // Crear directorios si no existen
      await fs.mkdir(path.dirname(originalPath), { recursive: true });
      await fs.mkdir(path.dirname(mediaPath), { recursive: true });
      await fs.mkdir(path.dirname(thumbPath), { recursive: true });

      // Mover archivo original
      await fs.copyFile(inputPath, originalPath);

      // Crear versión media
      await this.superscaleImage(
        originalPath,
        mediaPath,
        this.config.anchoMedio,
        this.config.altoMedio,
        95
      );

      // Crear thumbnail
      await this.superscaleImage(
        originalPath,
        thumbPath,
        this.config.anchoThumb,
        this.config.altoThumb,
        95
      );

      return {
        original: originalPath,
        media: mediaPath,
        thumb: thumbPath
      };
    } catch (error) {
      console.error('Error procesando imagen completa:', error);
      throw error;
    }
  }

  // Validar imagen
  async validateImage(filePath) {
    try {
      const metadata = await sharp(filePath).metadata();
      
      const errors = [];

      // Verificar resolución mínima
      if (metadata.width < 640 || metadata.height < 480) {
        errors.push(`Imagen con poca resolución. Imagen actual: ${metadata.width}x${metadata.height}px. Mínimo 640x480px`);
      }

      return {
        valid: errors.length === 0,
        errors: errors,
        metadata: metadata
      };
    } catch (error) {
      return {
        valid: false,
        errors: ['Error el archivo es NULL o no es una imagen válida'],
        metadata: null
      };
    }
  }
}

module.exports = new ImageProcessor(); 