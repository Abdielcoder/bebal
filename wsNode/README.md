# API Bebal Node.js

Migración completa de la API PHP del sistema Bebal a Node.js con Express y JWT.

## 🚀 Características

- **Framework**: Express.js
- **Base de datos**: MySQL con mysql2
- **Autenticación**: JWT (JSON Web Tokens)
- **Procesamiento de imágenes**: Sharp
- **Subida de archivos**: Multer
- **Seguridad**: Helmet, CORS, Rate Limiting
- **Puerto**: 5014

## 📁 Estructura del Proyecto

```
wsNode/
├── config.js                      # Configuración general
├── server.js                      # Servidor principal
├── package.json                   # Dependencias
├── README.md                      # Documentación
├── database/
│   └── connection.js              # Conexión a MySQL
├── middleware/
│   └── auth.js                    # Middleware de autenticación JWT
├── utils/
│   ├── jwt.js                     # Utilidades JWT
│   └── imageProcessor.js          # Procesamiento de imágenes
├── controllers/
│   ├── authController.js          # Controlador de autenticación
│   ├── consultaController.js      # Controlador de consultas
│   ├── actualizacionController.js # Controlador de actualizaciones
│   └── uploadController.js        # Controlador de subida de archivos
└── routes/
    ├── auth.js                    # Rutas de autenticación
    ├── consultas.js               # Rutas de consultas
    ├── actualizaciones.js         # Rutas de actualizaciones
    └── uploads.js                 # Rutas de subida
```

## 🔄 Migración de Endpoints PHP

| Archivo PHP Original | Endpoint Node.js | Método | Descripción |
|---------------------|------------------|--------|-------------|
| `validar_usuario.php` | `/api/auth/validar-usuario` | POST | Validación de credenciales |
| `authenticate.php` | `/api/auth/authenticate` | POST | Generación de token JWT |
| `consultaTableRows.php` | `/api/consultas/table-rows` | POST | Consulta de filas |
| `consultaTableRowsCount.php` | `/api/consultas/table-rows-count` | POST | Conteo de filas |
| `consultaUnRowXfolio.php` | `/api/consultas/row-by-folio` | POST | Consulta por folio |
| `ActualizaLatLonSupCom.php` | `/api/actualizaciones/lat-lon-sup-com` | POST | Actualizar coordenadas |
| `SubirFoto.php` | `/api/uploads/foto` | POST | Subida de fotos |

## 🛠️ Instalación

1. **Instalar dependencias**:
```bash
cd wsNode
npm install
```

2. **Configurar base de datos**:
   - Editar `config.js` con las credenciales correctas
   - Asegurar que MySQL esté corriendo
   - Verificar que las bases de datos `bebal` y `saveh` existan

3. **Crear directorios de subida**:
```bash
mkdir -p uploads/fotos/originales
mkdir -p uploads/fotos/medias
mkdir -p uploads/fotos/thumb
mkdir -p uploads/temp
```

## 🚀 Ejecución

### Modo desarrollo:
```bash
npm run dev
```

### Modo producción:
```bash
npm start
```

El servidor estará disponible en: `http://localhost:5014`

## 📋 Endpoints de la API

### 🔐 Autenticación

#### POST `/api/auth/validar-usuario`
Valida credenciales de usuario y retorna token JWT.

**Body**:
```json
{
  "usuario": "nombre_usuario",
  "password": "contraseña"
}
```

**Respuesta exitosa**:
```json
{
  "success": true,
  "data": [{
    "id_user": 1,
    "username": "usuario",
    "profile": "admin",
    "municipio": "Nombre Municipio",
    "municipioID": 1,
    "token": "jwt_token_aqui"
  }],
  "message": "OK",
  "errors": null
}
```

#### POST `/api/auth/authenticate`
Genera token JWT simple.

**Respuesta**:
```json
{
  "token": "jwt_token_aqui"
}
```

### 📊 Consultas (Requieren JWT)

#### POST `/api/consultas/table-rows`
Consulta filas de la tabla principal.

**Headers**:
```
Authorization: Bearer jwt_token_aqui
```

**Body**:
```json
{
  "id_municipio": "1"
}
```

#### POST `/api/consultas/table-rows-count`
Cuenta filas de la tabla principal.

**Headers**:
```
Authorization: Bearer jwt_token_aqui
```

**Body**:
```json
{
  "id_municipio": "1"
}
```

#### POST `/api/consultas/row-by-folio`
Consulta registro específico por folio.

**Headers**:
```
Authorization: Bearer jwt_token_aqui
```

**Body**:
```json
{
  "id_municipio": "1",
  "folio": "FOLIO123"
}
```

### ✏️ Actualizaciones (Requieren JWT)

#### POST `/api/actualizaciones/lat-lon-sup-com`
Actualiza coordenadas y datos de superficie/comensales.

**Headers**:
```
Authorization: Bearer jwt_token_aqui
```

**Body**:
```json
{
  "id": "1",
  "id_municipio": "1",
  "id_proceso_tramites": "1",
  "estatus": "RAD Realizado",
  "superficie_establecimiento": "100",
  "capacidad_comensales_personas": "50",
  "latitud": "25.123456",
  "longitud": "-100.123456"
}
```

### 📤 Subida de Archivos (Requieren JWT)

#### POST `/api/uploads/foto`
Sube foto con validación y procesamiento.

**Headers**:
```
Authorization: Bearer jwt_token_aqui
Content-Type: multipart/form-data
```

**Form Data**:
- `nuevafoto`: Archivo de imagen (JPEG, máx 5MB, mín 640x480px)
- `id`: ID principal
- `id_municipio`: ID del municipio
- `id_proceso_tramites`: ID del proceso
- `estatus`: Estatus actual

## 🔧 Configuración

### Base de Datos
```javascript
database: {
  host: 'localhost',
  user: 'root',
  password: 'Mexico@_1966',
  database: 'bebal',
  databaseSaveh: 'saveh'
}
```

### JWT
```javascript
jwt: {
  secret: 'tu_clave_secreta',
  expiresIn: '1h'
}
```

### Subida de Archivos
```javascript
upload: {
  maxFileSize: 5 * 1024 * 1024, // 5MB
  allowedTypes: ['image/jpeg', 'image/jpg'],
  anchoMedio: 800,
  altoMedio: 600,
  anchoThumb: 150,
  altoThumb: 150
}
```

## 🛡️ Seguridad

- **JWT**: Tokens con expiración de 1 hora
- **Rate Limiting**: 100 requests por 15 minutos
- **Helmet**: Headers de seguridad
- **CORS**: Configurado para permitir todos los orígenes
- **Validación**: Validación de parámetros en todos los endpoints

## 📝 Logs

El servidor registra:
- Todas las requests HTTP
- Errores de base de datos
- Errores de procesamiento de imágenes
- Conexiones y desconexiones

## 🔍 Health Check

**GET** `/health` - Verifica el estado del servidor

**Respuesta**:
```json
{
  "success": true,
  "message": "API Bebal Node.js funcionando correctamente",
  "timestamp": "2024-01-01T00:00:00.000Z",
  "version": "1.0.0"
}
```

## 🚨 Manejo de Errores

Todos los endpoints retornan errores en formato consistente:

```json
{
  "success": false,
  "data": null,
  "message": "Descripción del error",
  "error": "Detalle técnico del error"
}
```

## 🔄 Migración Completa

Esta API Node.js replica **exactamente** la funcionalidad de los archivos PHP originales:

- ✅ Misma lógica de autenticación
- ✅ Mismas consultas SQL
- ✅ Mismo formato de respuestas JSON
- ✅ Misma validación de archivos
- ✅ Mismo procesamiento de imágenes
- ✅ Misma estructura de datos
- ✅ Mismos códigos de error

## 📞 Soporte

Para cualquier problema o duda sobre la migración, revisar los logs del servidor y verificar la configuración de la base de datos. 