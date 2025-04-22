<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vérificateur de mot de passe</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
    <style>
        .password-strength-meter {
            height: 10px;
            border-radius: 5px;
            margin-top: 10px;
            transition: width 0.3s ease;
        }
        .strength-weak { background-color: #ef4444; width: 25%; }
        .strength-medium { background-color: #f59e0b; width: 50%; }
        .strength-good { background-color: #10b981; width: 75%; }
        .strength-strong { background-color: #3b82f6; width: 100%; }
    </style>
</head>
<body class="bg-gray-100">
    <?php include 'navbar.php'; ?>
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-md p-6">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Vérificateur de mot de passe</h1>
                <a href="password_generator.php" class="text-blue-600 hover:text-blue-800">Retour au générateur</a>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Formulaire de vérification -->
                <div class="bg-gray-50 p-6 rounded-lg">
                    <h2 class="text-xl font-semibold mb-4">Vérifier un mot de passe</h2>
                    <form id="check-form" class="space-y-4">
                        <div>
                            <label for="password" class="block mb-2 text-sm font-medium text-gray-900">Mot de passe</label>
                            <input type="password" id="password" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                        </div>
                        <button type="submit" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                            Vérifier
                        </button>
                    </form>
                </div>
                
                <!-- Résultats de vérification -->
                <div id="results" class="bg-gray-50 p-6 rounded-lg hidden">
                    <h2 class="text-xl font-semibold mb-4">Résultats</h2>
                    
                    <!-- Indicateur de force -->
                    <div class="mb-4">
                        <div class="flex justify-between mb-1">
                            <span class="text-sm font-medium text-gray-700">Force du mot de passe</span>
                            <span id="strength-text" class="text-sm font-medium"></span>
                        </div>
                        <div id="strength-meter" class="password-strength-meter"></div>
                    </div>
                    
                    <!-- Critères de vérification -->
                    <div id="criteria-list" class="space-y-2">
                        <!-- Les critères seront ajoutés ici dynamiquement -->
                    </div>
                    
                    <!-- Recommandations -->
                    <div id="recommendations" class="mt-4 p-4 bg-blue-50 text-blue-800 rounded-lg hidden">
                        <h3 class="font-medium mb-2">Recommandations</h3>
                        <ul id="recommendations-list" class="list-disc pl-5 space-y-1">
                            <!-- Les recommandations seront ajoutées ici dynamiquement -->
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkForm = document.getElementById('check-form');
            const resultsDiv = document.getElementById('results');
            const strengthMeter = document.getElementById('strength-meter');
            const strengthText = document.getElementById('strength-text');
            const criteriaList = document.getElementById('criteria-list');
            const recommendationsDiv = document.getElementById('recommendations');
            const recommendationsList = document.getElementById('recommendations-list');
            
            // Charger la configuration
            fetch('get_config.php')
                .then(response => response.json())
                .then(config => {
                    window.passwordConfig = config;
                })
                .catch(error => {
                    console.error('Erreur lors du chargement de la configuration:', error);
                });
            
            // Vérifier le mot de passe
            checkForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const password = document.getElementById('password').value;
                
                if (!window.passwordConfig) {
                    alert('Erreur: Configuration non chargée');
                    return;
                }
                
                const results = checkPassword(password, window.passwordConfig);
                displayResults(results);
            });
            
            // Fonction de vérification du mot de passe
            function checkPassword(password, config) {
                const results = {
                    length: password.length,
                    meetsMinLength: password.length >= config.length_requirements.min,
                    meetsRecommendedLength: password.length >= config.length_requirements.recommended,
                    meetsStrongLength: password.length >= config.length_requirements.strong,
                    characterTypes: {},
                    hasCommonPatterns: false,
                    hasRepeatedChars: false,
                    strength: 'weak',
                    recommendations: []
                };
                
                // Vérifier les types de caractères
                for (const [type, requirements] of Object.entries(config.character_types)) {
                    const count = countCharacters(password, requirements.characters);
                    results.characterTypes[type] = {
                        count: count,
                        meets: count >= requirements.min_count
                    };
                }
                
                // Vérifier les séquences communes
                for (const sequence of config.avoid_patterns.sequences) {
                    if (password.toLowerCase().includes(sequence)) {
                        results.hasCommonPatterns = true;
                        results.recommendations.push(`Évitez les séquences communes comme "${sequence}"`);
                        break;
                    }
                }
                
                // Vérifier les caractères répétés
                for (let i = 0; i < password.length - config.avoid_patterns.repeated_chars; i++) {
                    const char = password[i];
                    let repeated = true;
                    for (let j = 1; j < config.avoid_patterns.repeated_chars; j++) {
                        if (password[i + j] !== char) {
                            repeated = false;
                            break;
                        }
                    }
                    if (repeated) {
                        results.hasRepeatedChars = true;
                        results.recommendations.push(`Évitez de répéter le même caractère plus de ${config.avoid_patterns.repeated_chars} fois`);
                        break;
                    }
                }
                
                // Vérifier les mots communs
                for (const word of config.avoid_patterns.common_words) {
                    if (password.toLowerCase().includes(word)) {
                        results.recommendations.push(`Évitez les mots communs comme "${word}"`);
                        break;
                    }
                }
                
                // Déterminer la force du mot de passe
                let strengthScore = 0;
                
                // Points pour la longueur
                if (results.meetsMinLength) strengthScore += 1;
                if (results.meetsRecommendedLength) strengthScore += 1;
                if (results.meetsStrongLength) strengthScore += 1;
                
                // Points pour les types de caractères
                let typesCount = 0;
                for (const type in results.characterTypes) {
                    if (results.characterTypes[type].meets) typesCount++;
                }
                strengthScore += typesCount;
                
                // Points pour l'absence de patterns communs
                if (!results.hasCommonPatterns) strengthScore += 1;
                if (!results.hasRepeatedChars) strengthScore += 1;
                
                // Déterminer la force finale
                if (strengthScore <= 2) results.strength = 'weak';
                else if (strengthScore <= 4) results.strength = 'medium';
                else if (strengthScore <= 6) results.strength = 'good';
                else results.strength = 'strong';
                
                return results;
            }
            
            // Compter les caractères d'un certain type
            function countCharacters(password, characters) {
                let count = 0;
                for (let i = 0; i < password.length; i++) {
                    if (characters.includes(password[i])) count++;
                }
                return count;
            }
            
            // Afficher les résultats
            function displayResults(results) {
                // Afficher la section des résultats
                resultsDiv.classList.remove('hidden');
                
                // Mettre à jour l'indicateur de force
                strengthMeter.className = 'password-strength-meter';
                strengthMeter.classList.add(`strength-${results.strength}`);
                
                // Texte de force
                const strengthTexts = {
                    weak: 'Faible',
                    medium: 'Moyen',
                    good: 'Bon',
                    strong: 'Fort'
                };
                strengthText.textContent = strengthTexts[results.strength];
                strengthText.className = `text-sm font-medium ${
                    results.strength === 'weak' ? 'text-red-600' :
                    results.strength === 'medium' ? 'text-yellow-600' :
                    results.strength === 'good' ? 'text-green-600' : 'text-blue-600'
                }`;
                
                // Afficher les critères
                criteriaList.innerHTML = '';
                
                // Longueur
                const lengthItem = document.createElement('div');
                lengthItem.className = `flex items-center ${results.meetsMinLength ? 'text-green-600' : 'text-red-600'}`;
                lengthItem.innerHTML = `
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    Longueur: ${results.length} caractères (minimum: ${window.passwordConfig.length_requirements.min})
                `;
                criteriaList.appendChild(lengthItem);
                
                // Types de caractères
                for (const [type, data] of Object.entries(results.characterTypes)) {
                    const typeItem = document.createElement('div');
                    typeItem.className = `flex items-center ${data.meets ? 'text-green-600' : 'text-red-600'}`;
                    typeItem.innerHTML = `
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        ${window.passwordConfig.character_types[type].description}: ${data.count} (minimum: ${window.passwordConfig.character_types[type].min_count})
                    `;
                    criteriaList.appendChild(typeItem);
                }
                
                // Patterns communs
                if (results.hasCommonPatterns) {
                    const patternItem = document.createElement('div');
                    patternItem.className = 'flex items-center text-red-600';
                    patternItem.innerHTML = `
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                        </svg>
                        Contient des séquences communes à éviter
                    `;
                    criteriaList.appendChild(patternItem);
                }
                
                // Caractères répétés
                if (results.hasRepeatedChars) {
                    const repeatedItem = document.createElement('div');
                    repeatedItem.className = 'flex items-center text-red-600';
                    repeatedItem.innerHTML = `
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                        </svg>
                        Contient des caractères répétés
                    `;
                    criteriaList.appendChild(repeatedItem);
                }
                
                // Afficher les recommandations
                if (results.recommendations.length > 0) {
                    recommendationsList.innerHTML = '';
                    results.recommendations.forEach(recommendation => {
                        const li = document.createElement('li');
                        li.textContent = recommendation;
                        recommendationsList.appendChild(li);
                    });
                    recommendationsDiv.classList.remove('hidden');
                } else {
                    recommendationsDiv.classList.add('hidden');
                }
            }
        });
    </script>
</body>
</html> 