const jwt = require('jsonwebtoken');
const config = require('../config');

class JWTUtils {
  constructor() {
    this.secretKey = config.jwt.secret;
  }

  // Codificar un JWT - equivalente a encode_jwt() en PHP
  encodeJWT(payload) {
    try {
      const issuedAt = Math.floor(Date.now() / 1000);
      const expirationTime = issuedAt + 3600; // 1 hora

      const fullPayload = {
        iat: issuedAt,
        exp: expirationTime,
        ...payload
      };

      return jwt.sign(fullPayload, this.secretKey, { algorithm: 'HS256' });
    } catch (error) {
      console.error('Error codificando JWT:', error);
      throw error;
    }
  }

  // Decodificar un JWT - equivalente a decode_jwt() en PHP
  decodeJWT(token) {
    try {
      const decoded = jwt.verify(token, this.secretKey);
      
      // Verificar si el token ha expirado
      const currentTime = Math.floor(Date.now() / 1000);
      if (decoded.exp && decoded.exp < currentTime) {
        return false;
      }

      return decoded;
    } catch (error) {
      console.error('Error decodificando JWT:', error);
      return false;
    }
  }

  // Generar token para usuario autenticado
  generateUserToken(userData) {
    const payload = {
      userData: userData
    };
    return this.encodeJWT(payload);
  }

  // Verificar token desde header Authorization
  verifyAuthHeader(authHeader) {
    if (!authHeader) {
      return { valid: false, error: 'No Se Proporciono el Encabezado de Autorizacion' };
    }

    const matches = authHeader.match(/Bearer\s(\S+)/);
    if (!matches || !matches[1]) {
      return { valid: false, error: 'Error en el Token Proporcionado' };
    }

    const token = matches[1];
    const decoded = this.decodeJWT(token);

    if (!decoded) {
      return { valid: false, error: 'Token NO Valido o Expirado' };
    }

    return { valid: true, decoded: decoded };
  }
}

module.exports = new JWTUtils(); 