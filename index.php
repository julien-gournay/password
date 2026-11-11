<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Générateur de mots de passe sécurisés</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
    <style>
        .word-animation {
            position: relative;
            height: 60px;
            overflow: hidden;
            background: linear-gradient(45deg, #3b82f6, #10b981);
            border-radius: 0.5rem;
            margin: 2rem 0;
        }
        
        .word-animation span {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            font-size: 1.5rem;
            font-weight: bold;
            opacity: 0;
            transition: opacity 0.5s ease-in-out;
        }
        
        .word-animation span.active {
            opacity: 1;
        }
        
        .service-card {
            transition: transform 0.3s ease-in-out;
        }
        
        .service-card:hover {
            transform: translateY(-5px);
        }
    </style>
</head>
<body class="bg-gray-100">
    <?php include 'navbar.php'; ?>
    
    <div class="container mx-auto px-4 py-8">
        <!-- Hero Section avec animation -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-800 mb-4">Générez des mots de passe sécurisés</h1>
            <p class="text-xl text-gray-600 mb-6">Protégez vos comptes avec des mots de passe forts et uniques</p>
            
            <div class="word-animation">
                <span class="active">Sécurisé</span>
                <span>Unique</span>
                <span>Fort</span>
                <span>Complexe</span>
                <span>Aléatoire</span>
            </div>
        </div>
        
        <!-- Services Section -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 max-w-6xl mx-auto">
            <!-- Générateur de mot de passe -->
            <div class="service-card bg-white rounded-lg shadow-md p-6">
                <div class="text-center mb-4">
                    <svg class="w-12 h-12 text-blue-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                </div>
                <h2 class="text-xl font-semibold text-center mb-3">Générateur de mot de passe</h2>
                <p class="text-gray-600 text-center mb-4">Créez des mots de passe sécurisés en quelques clics avec notre générateur intelligent.</p>
                <div class="text-center">
                    <a href="password_generator.php" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300">
                        Générer un mot de passe
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </a>
                </div>
            </div>
            
            <!-- Vérificateur de mot de passe -->
            <div class="service-card bg-white rounded-lg shadow-md p-6">
                <div class="text-center mb-4">
                    <svg class="w-12 h-12 text-green-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h2 class="text-xl font-semibold text-center mb-3">Vérificateur de mot de passe</h2>
                <p class="text-gray-600 text-center mb-4">Vérifiez la force de vos mots de passe et obtenez des recommandations d'amélioration.</p>
                <div class="text-center">
                    <a href="password_checker.php" class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-300">
                        Vérifier un mot de passe
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </a>
                </div>
            </div>
            
            <!-- Hachage de mot de passe -->
            <div class="service-card bg-white rounded-lg shadow-md p-6">
                <div class="text-center mb-4">
                    <svg class="w-12 h-12 text-orange-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                    </svg>
                </div>
                <h2 class="text-xl font-semibold text-center mb-3">Hachage de mot de passe</h2>
                <p class="text-gray-600 text-center mb-4">Hashez vos mots de passe avec différents algorithmes (BCrypt, Argon2, SHA-256).</p>
                <div class="text-center">
                    <a href="password_hasher.php" class="inline-flex items-center px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 focus:ring-4 focus:outline-none focus:ring-orange-300">
                        Hasher un mot de passe
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </a>
                </div>
            </div>
            
            <!-- Recommandations -->
            <div class="service-card bg-white rounded-lg shadow-md p-6">
                <div class="text-center mb-4">
                    <svg class="w-12 h-12 text-purple-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h2 class="text-xl font-semibold text-center mb-3">Recommandations</h2>
                <p class="text-gray-600 text-center mb-4">Découvrez nos conseils pour créer et gérer des mots de passe sécurisés.</p>
                <div class="text-center">
                    <a href="password_recommendations.php" class="inline-flex items-center px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 focus:ring-4 focus:outline-none focus:ring-purple-300">
                        Voir les recommandations
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Section de statistiques -->
        <div class="mt-16 bg-white rounded-lg shadow-md p-8 max-w-4xl mx-auto">
            <h2 class="text-2xl font-bold text-center mb-8">Pourquoi utiliser notre service ?</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="text-4xl font-bold text-blue-500 mb-2">100%</div>
                    <p class="text-gray-600">Sécurisé</p>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-bold text-green-500 mb-2">Gratuit</div>
                    <p class="text-gray-600">À utiliser sans limite</p>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-bold text-purple-500 mb-2">Simple</div>
                    <p class="text-gray-600">Facile à utiliser</p>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        // Animation des mots
        const words = document.querySelectorAll('.word-animation span');
        let currentIndex = 0;
        
        function showNextWord() {
            words.forEach(word => word.classList.remove('active'));
            words[currentIndex].classList.add('active');
            currentIndex = (currentIndex + 1) % words.length;
        }
        
        // Changer de mot toutes les 2 secondes
        setInterval(showNextWord, 2000);
    </script>
</body>
</html>