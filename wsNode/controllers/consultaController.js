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

      // Construir el domicilio completo del establecimiento
      let domicilioEstablecimiento = '';
      if (datos.calle_establecimiento && datos.numero_establecimiento) {
        domicilioEstablecimiento = `${datos.calle_establecimiento} #${datos.numero_establecimiento}`;
        if (datos.numerointerno_local_establecimiento) {
          domicilioEstablecimiento += ` Int. ${datos.numerointerno_local_establecimiento}`;
        }
      }

      // Construir colonia/delegación/ciudad/CP
      const ubicacionCompleta = `${datos.colonia_desc || 'N/A'} ${datos.delegacion_desc || ''} / ${datos.municipio_desc || ''} / ${datos.cp_establecimiento || ''}`;

      // Construir comensales/superficie
      const comensalesSuperficie = `${datos.capacidad_comensales_personas || 'N/A'} Personas / ${datos.superficie_establecimiento || 'N/A'} (m²)`;

      // Retornar solo los campos específicos mostrados en la imagen
      const datosLimitados = {
        // Información básica
        folio: datos.folio,
        
        // Tipo de trámite
        tipo_tramite: {
          operacion: datos.operacion || 'N/A',
          giro: datos.giro_desc || 'N/A',
          modalidad_graduacion_alcoholica: datos.modalidad_graduacion_alcoholica || 'N/A',
          numero_modalidad_graduacion_alcoholica: datos.numero_modalidad_graduacion_alcoholica || 'N/A',
          servicios_adicionales: datos.servicios_adicionales || 'N/A',
          numero_servicios_adicionales: datos.numero_servicios_adicionales || 'N/A',
          fecha_registro: datos.fecha_alta || 'N/A'
        },

        // Datos del establecimiento
        establecimiento: {
          nombre_comercial: datos.nombre_comercial_establecimiento || 'N/A',
          domicilio: domicilioEstablecimiento || 'N/A',
          colonia_delegacion_ciudad_cp: ubicacionCompleta,
          clave_catastral: datos.clave_catastral || 'N/A',
          comensales_superficie: comensalesSuperficie,
          horario_funcionamiento: datos.horario_funcionamiento || 'N/A'
        },

        // Datos del solicitante
        solicitante: {
          persona_fisica_moral: datos.nombre_persona_fisicamoral_solicitante || 'N/A',
          representante_legal: datos.nombre_representante_legal_solicitante || 'N/A',
          rfc: datos.rfc || 'N/A',
          tipo_persona: datos.fisica_o_moral || 'N/A',
          domicilio: datos.domicilio_solicitante || 'N/A',
          email: datos.email_solicitante || 'N/A',
          telefono: datos.telefono_solicitante || 'N/A'
        }
      };

      // Retornar los datos en formato JSON
      return res.json({
        success: true,
        data: datosLimitados,
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