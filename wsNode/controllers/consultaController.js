const database = require('../database/connection');

class ConsultaController {
  // Migración de consultaTableRows.php
  async consultaTableRows(req, res) {
    try {
      const { id_municipio } = req.body;

      if (!id_municipio) {
        return res.status(400).json({
          success: false,
          data: null,
          message: 'id_municipio es requerido',
          error: 'Parámetros faltantes'
        });
      }

      const sql = `
        SELECT * FROM principal 
        WHERE id_municipio = ? 
        AND (
          estatus = 'RAD Realizado' OR 
          estatus = 'Pagos IRAD' OR 
          estatus = 'Pago RAD-Cambio' OR 
          estatus = 'Pagos-IRAD-Cambio' OR 
          estatus = 'Pago INSP-Revalidacion' OR 
          estatus = 'Pago IRAD-CierreTemporal'
        )
      `;

      const rows = await database.query(sql, [id_municipio]);

      return res.json({
        success: true,
        data: rows,
        message: 'OK',
        errors: null
      });

    } catch (error) {
      console.error('Error en consultaTableRows:', error);
      return res.status(500).json({
        success: false,
        data: null,
        message: 'HTTP/1.1 500 Internal Server Error',
        error: 'Error al Consultar rows de la tabla'
      });
    }
  }

  // Migración de consultaTableRowsCount.php
  async consultaTableRowsCount(req, res) {
    try {
      const { id_municipio } = req.body;

      if (!id_municipio) {
        return res.status(400).json({
          success: false,
          data: null,
          message: 'id_municipio es requerido',
          error: 'Parámetros faltantes'
        });
      }

      const sql = `
        SELECT * FROM principal 
        WHERE id_municipio = ? 
        AND (
          estatus = 'RAD Realizado' OR 
          estatus = 'Pagos IRAD' OR 
          estatus = 'Pago RAD-Cambio' OR 
          estatus = 'Pagos-IRAD-Cambio' OR 
          estatus = 'Pago INSP-Revalidacion' OR 
          estatus = 'Pago IRAD-CierreTemporal'
        )
      `;

      const rows = await database.query(sql, [id_municipio]);

      return res.json({
        success: true,
        data: rows,
        message: 'OK',
        errors: null
      });

    } catch (error) {
      console.error('Error en consultaTableRowsCount:', error);
      return res.status(500).json({
        success: false,
        data: null,
        message: 'HTTP/1.1 500 Internal Server Error',
        error: 'Error al Consultar count_rows de la tabla'
      });
    }
  }

  // Migración de consultaUnRowXfolio.php
  async consultaUnRowXfolio(req, res) {
    try {
      const { id_municipio, folio } = req.body;

      if (!id_municipio || !folio) {
        return res.status(400).json({
          success: false,
          data: null,
          message: 'id_municipio y folio son requeridos',
          error: 'Parámetros faltantes'
        });
      }

      // Primero verificar si existe el registro
      const sqlCuenta = `
        SELECT COUNT(*) as count FROM principal 
        WHERE id_municipio = ? 
        AND (
          estatus = 'RAD Realizado' OR 
          estatus = 'Pagos IRAD' OR 
          estatus = 'Pago RAD-Cambio' OR 
          estatus = 'Pagos-IRAD-Cambio' OR 
          estatus = 'Pago IRAD-CierreTemporal'
        ) 
        AND folio = ?
      `;

      const countResult = await database.query(sqlCuenta, [id_municipio, folio]);
      const count = countResult[0].count;

      if (count > 0) {
        // Si existe, obtener el registro completo
        const sqlRow = `
          SELECT * FROM principal 
          WHERE id_municipio = ? 
          AND (
            estatus = 'RAD Realizado' OR 
            estatus = 'Pagos IRAD' OR 
            estatus = 'Pago RAD-Cambio' OR 
            estatus = 'Pagos-IRAD-Cambio' OR 
            estatus = 'Pago IRAD-CierreTemporal'
          ) 
          AND folio = ?
        `;

        const rows = await database.query(sqlRow, [id_municipio, folio]);

        return res.json({
          success: true,
          data: rows,
          message: 'OK',
          errors: null
        });

      } else {
        return res.json({
          success: true,
          data: "No Existe Resultado para esta Seleccion",
          message: 'OK',
          errors: null
        });
      }

    } catch (error) {
      console.error('Error en consultaUnRowXfolio:', error);
      return res.status(500).json({
        success: false,
        data: null,
        message: 'HTTP/1.1 500 Internal Server Error',
        error: 'Error al consultar registro por folio'
      });
    }
  }

  // Migración de generar_pdf_html.php - Obtener datos de establecimiento
  async obtenerDatosEstablecimiento(req, res) {
    try {
      const { id } = req.params;

      // Validar que se recibió el ID
      if (!id || isNaN(parseInt(id))) {
        return res.status(400).json({
          success: false,
          data: null,
          message: 'Error: No se especificó un ID válido',
          error: 'ID requerido y debe ser numérico'
        });
      }

      const idEstablecimiento = parseInt(id);

      // Consultar datos del establecimiento (misma consulta que en generar_pdf_html.php)
      const sql = `
        SELECT p.*, 
               g.descripcion_giro AS giro_desc, 
               g.horario_funcionamiento AS horario_funcionamiento, 
               mu.municipio AS municipio_desc,
               d.delegacion AS delegacion_desc,
               c.colonia AS colonia_desc
        FROM principal p
        LEFT JOIN giro g ON p.giro = g.id
        LEFT JOIN municipio mu ON p.id_municipio = mu.id
        LEFT JOIN delegacion d ON p.id_delegacion = d.id
        LEFT JOIN colonias c ON p.id_colonia = c.id
        WHERE p.id = ?
      `;

      const resultado = await database.query(sql, [idEstablecimiento]);

      if (!resultado || resultado.length === 0) {
        return res.status(404).json({
          success: false,
          data: null,
          message: 'Error: No se encontró el registro solicitado',
          error: 'Establecimiento no encontrado'
        });
      }

      const datos = resultado[0];

      // Retornar los datos en formato JSON
      return res.json({
        success: true,
        data: {
          establecimiento: datos,
          metadata: {
            consulta_fecha: new Date().toISOString(),
            id_consultado: idEstablecimiento
          }
        },
        message: 'Datos del establecimiento obtenidos correctamente',
        error: null
      });

    } catch (error) {
      console.error('Error en obtenerDatosEstablecimiento:', error);
      return res.status(500).json({
        success: false,
        data: null,
        message: 'Error interno del servidor',
        error: 'Error al consultar datos del establecimiento'
      });
    }
  }
}

module.exports = new ConsultaController(); 