<?php
// Définir l'en-tête pour renvoyer du JSON
header('Content-Type: application/json');

// Vérifier si la requête est de type POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Méthode non autorisée']);
    exit;
}

// Récupérer les données du formulaire
$password = $_POST['password'] ?? '';
$algorithm = $_POST['algorithm'] ?? '';

// Vérifier si le mot de passe est vide
if (empty($password)) {
    echo json_encode(['success' => false, 'message' => 'Le mot de passe est requis']);
    exit;
}

// Vérifier si l'algorithme est valide
if (!in_array($algorithm, ['bcrypt', 'argon2', 'sha256'])) {
    echo json_encode(['success' => false, 'message' => 'Algorithme non valide']);
    exit;
}

// Fonction pour générer un sel aléatoire
function generateSalt($length = 16) {
    return bin2hex(random_bytes($length));
}

// Hasher le mot de passe selon l'algorithme sélectionné
$hash = '';
$error = '';

try {
    switch ($algorithm) {
        case 'bcrypt':
            // Récupérer le coût (work factor) pour bcrypt
            $cost = isset($_POST['bcrypt_cost']) ? intval($_POST['bcrypt_cost']) : 12;
            
            // Limiter le coût entre 4 et 31 (limites de bcrypt)
            $cost = max(4, min(31, $cost));
            
            // Générer le hash avec bcrypt
            $hash = password_hash($password, PASSWORD_BCRYPT, ['cost' => $cost]);
            break;
            
        case 'argon2':
            // Vérifier si Argon2 est disponible
            if (!defined('PASSWORD_ARGON2ID')) {
                throw new Exception('Argon2 n\'est pas disponible sur ce serveur');
            }
            
            // Récupérer les paramètres pour Argon2
            $memory = isset($_POST['argon2_memory']) ? intval($_POST['argon2_memory']) : 65536;
            $time = isset($_POST['argon2_time']) ? intval($_POST['argon2_time']) : 4;
            $threads = isset($_POST['argon2_threads']) ? intval($_POST['argon2_threads']) : 3;
            
            // Limiter les valeurs selon les recommandations
            $memory = max(8, min(65536, $memory));
            $time = max(1, min(4294967295, $time));
            $threads = max(1, min(255, $threads));
            
            // Générer le hash avec Argon2id (le plus sécurisé des variantes Argon2)
            $hash = password_hash($password, PASSWORD_ARGON2ID, [
                'memory_cost' => $memory,
                'time_cost' => $time,
                'threads' => $threads
            ]);
            break;
            
        case 'sha256':
            // Récupérer le sel pour SHA-256
            $salt = $_POST['sha256_salt'] ?? '';
            
            // Si aucun sel n'est fourni, en générer un
            if (empty($salt)) {
                $salt = generateSalt();
            }
            
            // Générer le hash avec SHA-256
            $hash = hash('sha256', $password . $salt) . ':' . $salt;
            break;
    }
    
    // Renvoyer le hash généré
    echo json_encode([
        'success' => true,
        'hash' => $hash,
        'algorithm' => $algorithm
    ]);
    
} catch (Exception $e) {
    // En cas d'erreur, renvoyer un message d'erreur
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
} 