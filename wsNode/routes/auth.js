const express = require('express');
const router = express.Router();
const authController = require('../controllers/authController');

// POST /api/auth/validar-usuario - Migración de validar_usuario.php
router.post('/validar-usuario', authController.validarUsuario);

// POST /api/auth/authenticate - Migración de authenticate.php
router.post('/authenticate', authController.authenticate);

module.exports = router; 