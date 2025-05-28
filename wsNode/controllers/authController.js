const database = require('../database/connection');
const jwtUtils = require('../utils/jwt');

class AuthController {
  // Migración de validar_usuario.php
  async validarUsuario(req, res) {
    try {
      const { usuario, password } = req.body;

      if (!usuario || !password) {
        return res.status(400).json({
          success: false,
          data: null,
          message: 'Usuario y contraseña son requeridos',
          error: 'Parámetros faltantes'
        });
      }

      // Consulta equivalente a la del PHP
      const query = `
        SELECT profile, user_id, id_municipio 
        FROM users 
        WHERE user_name = ? AND passwd2 = ?
      `;

      const results = await database.query(query, [usuario, password]);

      if (results.length === 1) {
        const user = results[0];
        const profile = user.profile;
        const usersID = user.user_id;
        const municipioID = user.id_municipio;

        // Obtener información del municipio
        const municipioQuery = `SELECT * FROM municipio WHERE id = ?`;
        const municipioResults = await database.query(municipioQuery, [municipioID]);
        const municipio = municipioResults.length > 0 ? municipioResults[0].nombre : '';

        // Generar JWT
        const userData = {
          id: usersID,
          username: usuario
        };

        const token = jwtUtils.generateUserToken(userData);

        const resultado = [{
          id_user: usersID,
          username: usuario,
          profile: profile,
          municipio: municipio,
          municipioID: municipioID,
          token: token
        }];

        return res.json({
          success: true,
          data: resultado,
          message: 'OK',
          errors: null
        });

      } else {
        return res.status(401).json({
          success: false,
          data: null,
          message: 'Credenciales inválidas',
          error: 'USER ERROR'
        });
      }

    } catch (error) {
      console.error('Error en validarUsuario:', error);
      
      if (error.code === 'ECONNREFUSED' || error.code === 'ER_ACCESS_DENIED_ERROR') {
        return res.status(500).json({
          success: false,
          data: null,
          message: 'Failed to connect to MySQL',
          error: 'Failed to connect to MySQL'
        });
      }

      return res.status(500).json({
        success: false,
        data: null,
        message: 'Error interno del servidor',
        error: error.message
      });
    }
  }

  // Migración de authenticate.php - Generar token simple
  async authenticate(req, res) {
    try {
      const userData = {
        id: 1,
        username: 'usuario'
      };

      const token = jwtUtils.generateUserToken(userData);

      return res.json({
        token: token
      });

    } catch (error) {
      console.error('Error en authenticate:', error);
      return res.status(500).json({
        success: false,
        data: null,
        message: 'Error generando token',
        error: error.message
      });
    }
  }
}

module.exports = new AuthController(); 