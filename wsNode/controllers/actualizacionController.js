const database = require('../database/connection');

class ActualizacionController {
  // Migración de ActualizaLatLonSupCom.php
  async actualizaLatLonSupCom(req, res) {
    try {
      const {
        id,
        id_municipio,
        id_proceso_tramites,
        estatus,
        superficie_establecimiento,
        capacidad_comensales_personas,
        latitud,
        longitud
      } = req.body;

      // Validar parámetros requeridos
      if (!id || !id_municipio || !id_proceso_tramites || !estatus || 
          !superficie_establecimiento || !capacidad_comensales_personas || 
          !latitud || !longitud) {
        return res.status(400).json({
          success: false,
          data: null,
          message: 'Todos los parámetros son requeridos',
          error: 'Parámetros faltantes'
        });
      }

      // Configurar zona horaria (equivalente a date_default_timezone_set en PHP)
      const today = new Date();
      const todayAMD = today.toISOString().split('T')[0]; // Formato Y-m-d

      // Actualizar tabla inspeccion
      const sqlUpdateInspeccion = `
        UPDATE inspeccion 
        SET superficie_establecimiento = ?, 
            capacidad_comensales_personas = ?, 
            fecha_fin = ? 
        WHERE id_principal = ? AND id_proceso_tramites = ?
      `;

      await database.query(sqlUpdateInspeccion, [
        superficie_establecimiento,
        capacidad_comensales_personas,
        todayAMD,
        id,
        id_proceso_tramites
      ]);

      // Actualizar tabla principal según el estatus
      let sqlUpdatePrincipal;
      
      if (estatus === 'RAD Realizado') {
        sqlUpdatePrincipal = `
          UPDATE principal 
          SET latitud = ?, longitud = ? 
          WHERE id = ?
        `;
      } else if (estatus === 'Pagos IRAD' || estatus === 'Pagos-IRAD-Cambio') {
        sqlUpdatePrincipal = `
          UPDATE principal 
          SET latitud = ?, longitud = ? 
          WHERE id = ?
        `;
      } else {
        sqlUpdatePrincipal = `
          UPDATE principal 
          SET latitud = ?, longitud = ? 
          WHERE id = ?
        `;
      }

      await database.query(sqlUpdatePrincipal, [latitud, longitud, id]);

      const resultado = "Proceso : Inspeccion Registrada Exitosamente";

      return res.json({
        success: true,
        data: resultado,
        message: 'OK',
        errors: null
      });

    } catch (error) {
      console.error('Error en actualizaLatLonSupCom:', error);
      return res.status(500).json({
        success: false,
        data: null,
        message: 'HTTP/1.1 500 Internal Server Error',
        error: 'Error al actualizar coordenadas y datos'
      });
    }
  }
}

module.exports = new ActualizacionController(); 