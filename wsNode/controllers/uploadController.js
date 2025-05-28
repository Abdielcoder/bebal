const database = require('../database/connection');
const imageProcessor = require('../utils/imageProcessor');
const multer = require('multer');
const path = require('path');
const fs = require('fs').promises;

// Configuración de multer para subida de archivos
const storage = multer.diskStorage({
  destination: async (req, file, cb) => {
    const uploadDir = path.join(__dirname, '../uploads/temp');
    try {
      await fs.mkdir(uploadDir, { recursive: true });
      cb(null, uploadDir);
    } catch (error) {
      cb(error);
    }
  },
  filename: (req, file, cb) => {
    const uniqueSuffix = Date.now() + '-' + Math.round(Math.random() * 1E9);
    cb(null, 'temp-' + uniqueSuffix + path.extname(file.originalname));
  }
});

const upload = multer({
  storage: storage,
  limits: {
    fileSize: 5 * 1024 * 1024 // 5MB
  },
  fileFilter: (req, file, cb) => {
    if (file.mimetype === 'image/jpeg' || file.mimetype === 'image/jpg') {
      cb(null, true);
    } else {
      cb(new Error('La foto debe estar en formato jpg'));
    }
  }
});

class UploadController {
  constructor() {
    this.upload = upload.single('nuevafoto');
  }

  // Migración de SubirFoto.php
  async subirFoto(req, res) {
    try {
      // Usar multer para procesar el archivo
      this.upload(req, res, async (err) => {
        if (err) {
          return res.status(400).json({
            success: false,
            data: null,
            message: 'Error en la subida del archivo',
            error: err.message
          });
        }

        try {
          const {
            id,
            id_municipio,
            id_proceso_tramites,
            estatus
          } = req.body;

          // Validar parámetros requeridos
          if (!id || !id_municipio || !id_proceso_tramites || !estatus) {
            return res.status(400).json({
              success: false,
              data: null,
              message: 'Todos los parámetros son requeridos',
              error: 'Parámetros faltantes'
            });
          }

          if (!req.file) {
            return res.status(400).json({
              success: false,
              data: null,
              message: 'No se proporcionó archivo',
              error: 'Archivo faltante'
            });
          }

          // Verificar estatus del principal
          const sqlEstatus = `SELECT estatus FROM principal WHERE id = ?`;
          const estatusResult = await database.query(sqlEstatus, [id]);
          
          if (estatusResult.length === 0) {
            return res.status(404).json({
              success: false,
              data: null,
              message: 'Registro no encontrado',
              error: 'ID principal no existe'
            });
          }

          const principalEstatus = estatusResult[0].estatus;

          if (principalEstatus !== 'RAD Realizado' && 
              principalEstatus !== 'Pagos IRAD' && 
              principalEstatus !== 'Pagos-IRAD-Cambio') {
            return res.status(400).json({
              success: false,
              data: null,
              message: 'Error: El estatus no es el correcto',
              error: `Error: El estatus no es el correcto !!! estatus actual=${principalEstatus}`
            });
          }

          // Insertar registro en tabla fotos
          const sqlInsert = `
            INSERT INTO fotos (descripcion, idprincipal, id_proceso_tramites) 
            VALUES (?, ?, ?)
          `;
          
          await database.query(sqlInsert, [
            `Inserta Row, idprincipal=${id}`,
            id,
            id_proceso_tramites
          ]);

          // Obtener el ID de la foto recién insertada
          const sqlMax = `SELECT MAX(idfoto) as maxId FROM fotos`;
          const maxResult = await database.query(sqlMax);
          const nextidf = maxResult[0].maxId;

          // Generar nombre del archivo
          const filename = `${id}-${id_proceso_tramites}-${nextidf}.jpg`;

          // Validar imagen
          const validation = await imageProcessor.validateImage(req.file.path);
          
          if (!validation.valid) {
            // Actualizar registro con error
            const sqlUpdateError = `
              UPDATE fotos 
              SET descripcion = ?, idprincipal = 0 
              WHERE idfoto = ? AND idprincipal = ?
            `;
            
            await database.query(sqlUpdateError, [
              validation.errors.join(', '),
              nextidf,
              id
            ]);

            // Eliminar archivo temporal
            await fs.unlink(req.file.path);

            return res.status(400).json({
              success: false,
              data: null,
              message: 'Error en validación de imagen',
              error: validation.errors.join(', ')
            });
          }

          try {
            // Procesar imagen (crear versiones original, media y thumb)
            await imageProcessor.processUploadedImage(req.file.path, filename);

            // Actualizar registro como exitoso
            const sqlUpdateSuccess = `
              UPDATE fotos 
              SET descripcion = 'OK' 
              WHERE idfoto = ? AND idprincipal = ? AND id_proceso_tramites = ?
            `;
            
            await database.query(sqlUpdateSuccess, [nextidf, id, id_proceso_tramites]);

            // Verificar si es la primera foto para establecerla como principal
            const sqlFotosCuantos = `
              SELECT COUNT(*) as count FROM fotos 
              WHERE idprincipal = ? AND id_proceso_tramites = ?
            `;
            
            const countResult = await database.query(sqlFotosCuantos, [id, id_proceso_tramites]);
            const rowsFotosCuantos = countResult[0].count;

            if (rowsFotosCuantos === 1) {
              const sqlUpdatePrincipal = `UPDATE principal SET foto = ? WHERE id = ?`;
              await database.query(sqlUpdatePrincipal, [nextidf, id]);
            }

            // Eliminar archivo temporal
            await fs.unlink(req.file.path);

            return res.json({
              success: true,
              data: 'El Archivo se subio con Exito !!',
              message: 'OK',
              errors: null
            });

          } catch (processError) {
            // Error al procesar imagen
            const sqlUpdateError = `
              UPDATE fotos 
              SET descripcion = ?, idprincipal = 0 
              WHERE idfoto = ? AND idprincipal = ?
            `;
            
            await database.query(sqlUpdateError, [
              'Error al subir la foto',
              nextidf,
              id
            ]);

            // Eliminar archivo temporal
            await fs.unlink(req.file.path);

            throw processError;
          }

        } catch (error) {
          console.error('Error en subirFoto:', error);
          
          // Limpiar archivo temporal si existe
          if (req.file && req.file.path) {
            try {
              await fs.unlink(req.file.path);
            } catch (unlinkError) {
              console.error('Error eliminando archivo temporal:', unlinkError);
            }
          }

          return res.status(500).json({
            success: false,
            data: null,
            message: 'HTTP/1.1 500 Internal Server Error',
            error: 'Error al subir la foto'
          });
        }
      });

    } catch (error) {
      console.error('Error general en subirFoto:', error);
      return res.status(500).json({
        success: false,
        data: null,
        message: 'HTTP/1.1 500 Internal Server Error',
        error: 'Error interno del servidor'
      });
    }
  }
}

module.exports = new UploadController(); 