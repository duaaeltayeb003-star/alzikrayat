<?php
// core/Model.php

abstract class Model {
    protected PDO $db;

    public function __construct() {
        // مشاركة نفس اتصال قاعدة البيانات عبر الـ Singleton
        $this->db = Database::getConnection();
    }
}