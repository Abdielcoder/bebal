const express = require('express');
const router = express.Router();
const actualizacionController = require('../controllers/actualizacionController');
const { authenticateToken } = require('../middleware/auth');

// POST /api/actualizaciones/lat-lon-sup-com - Migración de ActualizaLatLonSupCom.php
router.post('/lat-lon-sup-com', authenticateToken, actualizacionController.actualizaLatLonSupCom);

module.exports = router; 