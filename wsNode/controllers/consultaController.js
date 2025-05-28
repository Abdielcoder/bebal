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
}

module.exports = new ConsultaController(); 