const mysql = require('mysql2/promise');
const config = require('../config');

class Database {
  constructor() {
    this.connection = null;
    this.connectionSaveh = null;
  }

  async connect() {
    try {
      // Conexión principal a la base de datos bebal
      this.connection = await mysql.createConnection({
        host: config.database.host,
        user: config.database.user,
        password: config.database.password,
        database: config.database.database,
        charset: config.database.charset,
        timezone: 'Z'
      });

      // Conexión a la base de datos saveh
      this.connectionSaveh = await mysql.createConnection({
        host: config.database.host,
        user: config.database.user,
        password: config.database.password,
        database: config.database.databaseSaveh,
        charset: config.database.charset,
        timezone: 'Z'
      });

      console.log('Conexiones a base de datos establecidas correctamente');
      return true;
    } catch (error) {
      console.error('Error conectando a la base de datos:', error);
      throw error;
    }
  }

  async query(sql, params = []) {
    try {
      if (!this.connection) {
        await this.connect();
      }
      const [rows] = await this.connection.execute(sql, params);
      return rows;
    } catch (error) {
      console.error('Error ejecutando query:', error);
      throw error;
    }
  }

  async querySaveh(sql, params = []) {
    try {
      if (!this.connectionSaveh) {
        await this.connect();
      }
      const [rows] = await this.connectionSaveh.execute(sql, params);
      return rows;
    } catch (error) {
      console.error('Error ejecutando query en saveh:', error);
      throw error;
    }
  }

  async close() {
    try {
      if (this.connection) {
        await this.connection.end();
      }
      if (this.connectionSaveh) {
        await this.connectionSaveh.end();
      }
      console.log('Conexiones cerradas correctamente');
    } catch (error) {
      console.error('Error cerrando conexiones:', error);
    }
  }
}

module.exports = new Database(); 