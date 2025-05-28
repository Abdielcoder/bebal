const express = require('express');
const router = express.Router();
const consultaController = require('../controllers/consultaController');
const { authenticateToken } = require('../middleware/auth');

// POST /api/consultas/table-rows - Migración de consultaTableRows.php
router.post('/table-rows', authenticateToken, consultaController.consultaTableRows);

// POST /api/consultas/table-rows-count - Migración de consultaTableRowsCount.php
router.post('/table-rows-count', authenticateToken, consultaController.consultaTableRowsCount);

// POST /api/consultas/row-by-folio - Migración de consultaUnRowXfolio.php
router.post('/row-by-folio', authenticateToken, consultaController.consultaUnRowXfolio);

// GET /api/consultas/establecimiento/:id - Migración de generar_pdf_html.php (sin autenticación)
router.get('/establecimiento/:id', consultaController.obtenerDatosEstablecimiento);

module.exports = router; 