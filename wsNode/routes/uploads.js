const express = require('express');
const router = express.Router();
const uploadController = require('../controllers/uploadController');
const { authenticateToken } = require('../middleware/auth');

// POST /api/uploads/foto - Migración de SubirFoto.php
router.post('/foto', authenticateToken, uploadController.subirFoto);

module.exports = router; 