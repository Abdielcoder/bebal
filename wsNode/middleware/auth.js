const jwtUtils = require('../utils/jwt');

const authenticateToken = (req, res, next) => {
  const authHeader = req.headers['authorization'];
  
  const verification = jwtUtils.verifyAuthHeader(authHeader);
  
  if (!verification.valid) {
    return res.status(401).json({
      success: false,
      data: null,
      message: 'HTTP/1.1 401 Unauthorized',
      error: verification.error
    });
  }

  // Agregar información del usuario decodificado al request
  req.user = verification.decoded;
  next();
};

module.exports = {
  authenticateToken
}; 