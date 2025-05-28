# Mapeo de Campos - Formulario vs API Response

Este documento muestra cómo se mapean los campos del formulario mostrado en la imagen con la respuesta del endpoint `/api/consultas/establecimiento/:id`.

## Estructura de la Respuesta

**IMPORTANTE**: Todos los campos ahora están directamente en `data`, sin subbloques.

### Folio (Esquina superior derecha)
- **Campo en imagen**: "Folio: 3-79"
- **Campo en API**: `data.folio`
- **Ejemplo**: `"3-79"`

---

## TIPO DE TRAMITE

| Campo en Imagen | Campo en API | Ejemplo |
|----------------|--------------|---------|
| **Giro** | `data.giro` | `"Tienda de Autoservicio y Licorería"` |
| **Modalidad de Graduación Alcohólica** | `data.modalidad_graduacion_alcoholica` | `"(Cerveza, Vinos y Licores) y (Bebidas Alcoholicas en Envase Cerrado)"` |
| **Servicios Adicionales** | `data.servicios_adicionales` + `data.numero_servicios_adicionales` | `"0" + "N/A"` |
| **Fecha Registro** | `data.fecha_registro` | `"2025-04-25T00:00:00.000Z"` |

**Campos eliminados:**
- ❌ `operacion` (eliminado por solicitud)
- ❌ `numero_modalidad_graduacion_alcoholica` (eliminado por solicitud)

---

## DATOS DEL ESTABLECIMIENTO

| Campo en Imagen | Campo en API | Ejemplo |
|----------------|--------------|---------|
| **Nombre Comercial** | `data.nombre_comercial` | `"OXXO SILBONA"` |
| **Domicilio** | `data.domicilio` | `"AVE. DEL AGUILA REAL #19500"` |
| **Colonia Delegación / Ciudad / CP** | `data.colonia_delegacion_ciudad_cp` | `"BAJA MAQ.EL AGUILA Cerro Colorado / Tijuana / 22416"` |
| **Clave Catastral** | `data.clave_catastral` | `"GY-003-038"` |
| **No. de Comensales / Superficie** | `data.comensales_superficie` | `"N/A Personas / 227 (m²)"` |
| **Horario Funcionamiento** | `data.horario_funcionamiento` | `"DE LAS 10:00 HORAS A LAS 24:00 HORAS"` |

---

## Ejemplo Completo de Respuesta

```bash
GET http://localhost:5014/api/consultas/establecimiento/1
```

```json
{
  "success": true,
  "data": {
    "folio": "3-79",
    "giro": "Tienda de Autoservicio y Licorería",
    "modalidad_graduacion_alcoholica": "(Cerveza, Vinos y Licores) y (Bebidas Alcoholicas en Envase Cerrado)",
    "servicios_adicionales": "0",
    "numero_servicios_adicionales": "N/A",
    "fecha_registro": "2025-04-25T00:00:00.000Z",
    "nombre_comercial": "OXXO SILBONA",
    "domicilio": "AVE. DEL AGUILA REAL #19500",
    "colonia_delegacion_ciudad_cp": "BAJA MAQ.EL AGUILA Cerro Colorado / Tijuana / 22416",
    "clave_catastral": "GY-003-038",
    "comensales_superficie": "N/A Personas / 227 (m²)",
    "horario_funcionamiento": "DE LAS 10:00 HORAS A LAS 24:00 HORAS"
  },
  "message": "Datos del establecimiento obtenidos correctamente",
  "error": null
}
```

---

## Campos con Manejo Especial

### Si los datos están vacíos o nulos:
- Todos los campos retornan `"N/A"` cuando no hay información disponible

### Campos concatenados:
- **Domicilio**: Se construye como `"calle #numero Int. interno"` (si aplica)
- **Ubicación**: Se forma como `"colonia delegacion / ciudad / CP"`
- **Comensales/Superficie**: Se presenta como `"X Personas / Y (m²)"`

### Validaciones:
- Si no existe calle o número, el domicilio aparece como `"N/A"`
- Si faltan datos de ubicación, se muestran los disponibles o `"N/A"`

---

## Cambios Realizados

### ✅ Estructura simplificada:
- Todos los campos ahora están directamente en `data`
- Eliminados los subbloques `tipo_tramite`, `establecimiento`, `solicitante`

### ❌ Campos eliminados por solicitud:
- `operacion`
- `numero_modalidad_graduacion_alcoholica`
- **Todos los campos del solicitante**: `persona_fisica_moral`, `representante_legal`, `rfc`, `tipo_persona`, `domicilio_solicitante`, `email`, `telefono`

### 📊 Campos finales incluidos:
- `folio`
- `giro`
- `modalidad_graduacion_alcoholica`
- `servicios_adicionales`
- `numero_servicios_adicionales`
- `fecha_registro`
- `nombre_comercial`
- `domicilio`
- `colonia_delegacion_ciudad_cp`
- `clave_catastral`
- `comensales_superficie`
- `horario_funcionamiento` 