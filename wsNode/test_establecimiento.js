const config = require('./config');

// Función para probar el endpoint de establecimiento
async function probarEndpointEstablecimiento() {
  const baseUrl = `http://localhost:${config.port}`;
  
  console.log('🧪 Iniciando pruebas del endpoint de establecimiento...\n');
  
  // Prueba 1: Endpoint raíz para ver documentación
  try {
    console.log('📋 Probando documentación de API...');
    const response = await fetch(`${baseUrl}/`);
    const data = await response.json();
    console.log('✅ Documentación obtenida correctamente');
    console.log('📄 Endpoint disponible:', data.endpoints.consultas['GET /api/consultas/establecimiento/:id']);
    console.log('');
  } catch (error) {
    console.log('❌ Error obteniendo documentación:', error.message);
    console.log('');
  }
  
  // Prueba 2: Consultar establecimiento con ID válido (ejemplo)
  try {
    console.log('🔍 Probando consulta con ID válido (1)...');
    const response = await fetch(`${baseUrl}/api/consultas/establecimiento/1`);
    const data = await response.json();
    
    if (data.success) {
      console.log('✅ Consulta exitosa');
      console.log('📊 Datos obtenidos:');
      console.log('   - Folio:', data.data.establecimiento.folio);
      console.log('   - Nombre comercial:', data.data.establecimiento.nombre_comercial_establecimiento);
      console.log('   - Giro:', data.data.establecimiento.giro_desc);
      console.log('   - Fecha consulta:', data.data.metadata.consulta_fecha);
    } else {
      console.log('❌ Error en consulta:', data.message);
    }
    console.log('');
  } catch (error) {
    console.log('❌ Error en consulta:', error.message);
    console.log('');
  }
  
  // Prueba 3: Consultar con ID inválido
  try {
    console.log('🚫 Probando consulta con ID inválido (abc)...');
    const response = await fetch(`${baseUrl}/api/consultas/establecimiento/abc`);
    const data = await response.json();
    
    if (!data.success) {
      console.log('✅ Validación correcta - ID inválido rechazado');
      console.log('📝 Mensaje:', data.message);
    } else {
      console.log('❌ Error: ID inválido debería ser rechazado');
    }
    console.log('');
  } catch (error) {
    console.log('❌ Error en consulta:', error.message);
    console.log('');
  }
  
  // Prueba 4: Consultar establecimiento inexistente
  try {
    console.log('🔍 Probando consulta con ID inexistente (999999)...');
    const response = await fetch(`${baseUrl}/api/consultas/establecimiento/999999`);
    const data = await response.json();
    
    if (!data.success && response.status === 404) {
      console.log('✅ Manejo correcto - Establecimiento inexistente');
      console.log('📝 Mensaje:', data.message);
    } else {
      console.log('⚠️  Respuesta inesperada para ID inexistente');
    }
    console.log('');
  } catch (error) {
    console.log('❌ Error en consulta:', error.message);
    console.log('');
  }
  
  console.log('🎯 Pruebas completadas');
  console.log('\n📚 Ejemplo de uso:');
  console.log(`   GET ${baseUrl}/api/consultas/establecimiento/1`);
  console.log('\n💡 Este endpoint es público y no requiere autenticación JWT');
}

// Ejecutar pruebas solo si este archivo es ejecutado directamente
if (require.main === module) {
  probarEndpointEstablecimiento().catch(console.error);
}

module.exports = { probarEndpointEstablecimiento }; 