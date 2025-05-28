module.exports = {
  port: 5014,
  nodeEnv: 'development',
  
  // Database Configuration
  database: {
    host: 'localhost',
    user: 'root',
    password: 'Mexico@_1966',
    database: 'bebal',
    databaseSaveh: 'saveh',
    charset: 'utf8mb4'
  },
  
  // JWT Configuration
  jwt: {
    secret: 'tu_clave_secreta',
    expiresIn: '1h'
  },
  
  // Server Configuration
  rowsPerPage: 5,
  
  // File Upload Configuration
  upload: {
    path: '../../uploads/',
    fotosOriginales: 'fotos/originales/',
    fotosMedias: 'fotos/medias/',
    fotosThumb: 'fotos/thumb/',
    anchoMedio: 800,
    altoMedio: 600,
    anchoThumb: 150,
    altoThumb: 150,
    maxFileSize: 5 * 1024 * 1024, // 5MB
    allowedTypes: ['image/jpeg', 'image/jpg']
  }
}; 