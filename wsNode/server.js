const express = require('express');
const cors = require('cors');
const helmet = require('helmet');
const rateLimit = require('express-rate-limit');
const config = require('./config');
const database = require('./database/connection');

// Importar rutas
const authRoutes = require('./routes/auth');
const consultasRoutes = require('./routes/consultas');
const actualizacionesRoutes = require('./routes/actualizaciones');
const uploadsRoutes = require('./routes/uploads');

const app = express();

// Middleware de seguridad
app.use(helmet());

// Configuración de CORS - equivalente a los headers del PHP
app.use(cors({
  origin: '*',
  methods: ['GET', 'POST', 'PUT', 'DELETE', 'OPTIONS'],
  allowedHeaders: ['Content-Type', 'Authorization', 'X-Requested-With'],
  credentials: false
}));

// Rate limiting
const limiter = rateLimit({
  windowMs: 15 * 60 * 1000, // 15 minutos
  max: 100, // límite de 100 requests por ventana de tiempo
  message: {
    success: false,
    data: null,
    message: 'Demasiadas solicitudes, intenta de nuevo más tarde',
    error: 'Rate limit exceeded'
  }
});
app.use(limiter);

// Middleware para parsing de JSON y URL encoded
app.use(express.json({ limit: '10mb' }));
app.use(express.urlencoded({ extended: true, limit: '10mb' }));

// Middleware para logging de requests
app.use((req, res, next) => {
  console.log(`${new Date().toISOString()} - ${req.method} ${req.path}`);
  next();
});

// Rutas de la API
app.use('/api/auth', authRoutes);
app.use('/api/consultas', consultasRoutes);
app.use('/api/actualizaciones', actualizacionesRoutes);
app.use('/api/uploads', uploadsRoutes);

// Ruta de health check
app.get('/health', (req, res) => {
  res.json({
    success: true,
    message: 'API Bebal Node.js funcionando correctamente',
    timestamp: new Date().toISOString(),
    version: '1.0.0'
  });
});

// Ruta raíz con información de la API
app.get('/', (req, res) => {
  res.json({
    success: true,
    message: 'API Bebal Node.js - Migración desde PHP',
    version: '1.0.0',
    endpoints: {
      auth: {
        'POST /api/auth/validar-usuario': 'Validar credenciales de usuario',
        'POST /api/auth/authenticate': 'Generar token JWT'
      },
      consultas: {
        'POST /api/consultas/table-rows': 'Consultar filas de tabla (requiere JWT)',
        'POST /api/consultas/table-rows-count': 'Contar filas de tabla (requiere JWT)',
        'POST /api/consultas/row-by-folio': 'Consultar por folio específico (requiere JWT)',
        'GET /api/consultas/establecimiento/:id': 'Obtener datos de establecimiento por ID (público, sin JWT)'
      },
      actualizaciones: {
        'POST /api/actualizaciones/lat-lon-sup-com': 'Actualizar coordenadas y datos (requiere JWT)'
      },
      uploads: {
        'POST /api/uploads/foto': 'Subir foto (requiere JWT)'
      }
    },
    port: config.port
  });
});

// Middleware para rutas no encontradas
app.use('*', (req, res) => {
  res.status(404).json({
    success: false,
    data: null,
    message: 'Endpoint no encontrado',
    error: `Ruta ${req.method} ${req.originalUrl} no existe`
  });
});

// Middleware de manejo de errores
app.use((error, req, res, next) => {
  console.error('Error no manejado:', error);
  res.status(500).json({
    success: false,
    data: null,
    message: 'Error interno del servidor',
    error: process.env.NODE_ENV === 'development' ? error.message : 'Internal server error'
  });
});

// Función para inicializar el servidor
async function startServer() {
  try {
    // Conectar a la base de datos
    await database.connect();
    console.log('✅ Conexión a base de datos establecida');

    // Iniciar servidor
    const server = app.listen(config.port, () => {
      console.log(`🚀 Servidor corriendo en puerto ${config.port}`);
      console.log(`📍 URL: http://localhost:${config.port}`);
      console.log(`📋 Health check: http://localhost:${config.port}/health`);
      console.log(`📖 Documentación: http://localhost:${config.port}/`);
    });

    // Manejo de cierre graceful
    process.on('SIGTERM', async () => {
      console.log('🔄 Cerrando servidor...');
      server.close(async () => {
        await database.close();
        console.log('✅ Servidor cerrado correctamente');
        process.exit(0);
      });
    });

    process.on('SIGINT', async () => {
      console.log('🔄 Cerrando servidor...');
      server.close(async () => {
        await database.close();
        console.log('✅ Servidor cerrado correctamente');
        process.exit(0);
      });
    });

  } catch (error) {
    console.error('❌ Error iniciando servidor:', error);
    process.exit(1);
  }
}

// Iniciar servidor solo si este archivo es ejecutado directamente
if (require.main === module) {
  startServer();
}

module.exports = app; 