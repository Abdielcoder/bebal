# Mapeo de Campos - Formulario vs API Response

Este documento muestra cómo se mapean los campos del formulario mostrado en la imagen con la respuesta del endpoint `/api/consultas/establecimiento/:id`.

## Estructura de la Respuesta

### Folio (Esquina superior derecha)
- **Campo en imagen**: "Folio: 3-8"
- **Campo en API**: `data.folio`
- **Ejemplo**: `"3-8"`

---

## TIPO DE TRAMITE: NUEVO PERMISO

| Campo en Imagen | Campo en API | Ejemplo |
|----------------|--------------|---------|
| **Giro** | `data.tipo_tramite.giro` | `"Tienda de Autoservicio y Licorería"` |
| **Modalidad de Graduación Alcohólica** | `data.tipo_tramite.modalidad_graduacion_alcoholica` + `data.tipo_tramite.numero_modalidad_graduacion_alcoholica` | `"(Cerveza, Vinos y Licores) y (Bebidas Alcoholicas en Envase Cerrado) * [2]"` |
| **Servicios Adicionales** | `data.tipo_tramite.servicios_adicionales` + `data.tipo_tramite.numero_servicios_adicionales` | `"0 * [0]"` |
| **Fecha Registro** | `data.tipo_tramite.fecha_registro` | `"2025-05-27"` |

---

## DATOS DEL ESTABLECIMIENTO

| Campo en Imagen | Campo en API | Ejemplo |
|----------------|--------------|---------|
| **Nombre Comercial** | `data.establecimiento.nombre_comercial` | `"7-ELEVEN MEXICO, S. A. DE C. V."` |
| **Domicilio** | `data.establecimiento.domicilio` | `"BLVD. FRANCISCO BLAKE MORA #8202"` |
| **Colonia Delegación / Ciudad / CP** | `data.establecimiento.colonia_delegacion_ciudad_cp` | `"EJIDO MATAMOROS SECCION TORRES La Presa / Tijuana / 22510"` |
| **Clave Catastral** | `data.establecimiento.clave_catastral` | `"EV-402-001"` |
| **No. de Comensales / Superficie** | `data.establecimiento.comensales_superficie` | `"0 Personas / 191 (m²)"` |
| **Horario Funcionamiento** | `data.establecimiento.horario_funcionamiento` | `"DE LAS 10:00 HORAS A LAS 24:00 HORAS"` |

---

## DATOS DEL SOLICITANTE

| Campo en Imagen | Campo en API | Ejemplo |
|----------------|--------------|---------|
| **Persona Física/Moral** | `data.solicitante.persona_fisica_moral` | `"7-ELEVEN MEXICO, S. A. DE C. V."` |
| **Representante Legal** | `data.solicitante.representante_legal` | `"Juan Pérez García"` |
| **RFC / Persona Física o Moral** | `data.solicitante.rfc` + `data.solicitante.tipo_persona` | `"SEV123456789 (MORAL)"` |
| **Domicilio** | `data.solicitante.domicilio` | `"Av. Principal #123, Col. Centro"` |
| **Email / Teléfono** | `data.solicitante.email` + `data.solicitante.telefono` | `"contacto@7eleven.com.mx / 664-123-4567"` |

---

## Ejemplo Completo de Respuesta

```bash
GET http://localhost:5014/api/consultas/establecimiento/1
```

```json
{
  "success": true,
  "data": {
    "folio": "3-8",
    "tipo_tramite": {
      "operacion": "NUEVO",
      "giro": "Tienda de Autoservicio y Licorería",
      "modalidad_graduacion_alcoholica": "(Cerveza, Vinos y Licores) y (Bebidas Alcoholicas en Envase Cerrado)",
      "numero_modalidad_graduacion_alcoholica": "2",
      "servicios_adicionales": "0",
      "numero_servicios_adicionales": "0",
      "fecha_registro": "2025-05-27"
    },
    "establecimiento": {
      "nombre_comercial": "7-ELEVEN MEXICO, S. A. DE C. V.",
      "domicilio": "BLVD. FRANCISCO BLAKE MORA #8202",
      "colonia_delegacion_ciudad_cp": "EJIDO MATAMOROS SECCION TORRES La Presa / Tijuana / 22510",
      "clave_catastral": "EV-402-001",
      "comensales_superficie": "0 Personas / 191 (m²)",
      "horario_funcionamiento": "DE LAS 10:00 HORAS A LAS 24:00 HORAS"
    },
    "solicitante": {
      "persona_fisica_moral": "7-ELEVEN MEXICO, S. A. DE C. V.",
      "representante_legal": "Juan Pérez García",
      "rfc": "SEV123456789",
      "tipo_persona": "MORAL",
      "domicilio": "Av. Principal #123, Col. Centro",
      "email": "contacto@7eleven.com.mx",
      "telefono": "664-123-4567"
    }
  },
  "message": "Datos del establecimiento obtenidos correctamente",
  "error": null
}
```

---

## Campos con Manejo Especial

### Si los datos están vacíos o nulos:
- Todos los campos retornan `"N/A"` cuando no hay información disponible
- Los campos numéricos (como números de modalidad) retornan `"N/A"` si están vacíos

### Campos concatenados:
- **Domicilio**: Se construye como `"calle #numero Int. interno"` (si aplica)
- **Ubicación**: Se forma como `"colonia delegacion / ciudad / CP"`
- **Comensales/Superficie**: Se presenta como `"X Personas / Y (m²)"`

### Validaciones:
- Si no existe calle o número, el domicilio aparece como `"N/A"`
- Si faltan datos de ubicación, se muestran los disponibles o `"N/A"` 