<?php
/**
 * Fichier pour charger la configuration et la rendre disponible au format JSON
 */

// Charger la configuration
$config = require_once 'config.php';

// Définir l'en-tête pour indiquer que la réponse est au format JSON
header('Content-Type: application/json');

// Renvoyer la configuration au format JSON
echo json_encode($config); 