<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Générateur de mot de passe</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
</head>
<body class="bg-gray-100">
    <?php include 'navbar.php'; ?>
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-6xl mx-auto bg-white rounded-lg shadow-md p-6">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Générateur de mot de passe</h1>
                <a href="password_checker.php" class="text-blue-600 hover:text-blue-800">Vérifier un mot de passe</a>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Options de génération (à gauche) -->
                <div class="bg-gray-50 p-6 rounded-lg">
                    <h2 class="text-xl font-semibold mb-4">Paramètres de génération</h2>
                    
                    <!-- Options de génération -->
                    <div class="mb-6">
                        <div class="flex items-center mb-4">
                            <input id="recommended" type="radio" value="recommended" name="generation-type" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500" checked>
                            <label for="recommended" class="ml-2 text-sm font-medium text-gray-900">Recommandé (12 caractères)</label>
                        </div>
                        <div class="flex items-center">
                            <input id="custom" type="radio" value="custom" name="generation-type" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500">
                            <label for="custom" class="ml-2 text-sm font-medium text-gray-900">Personnalisé</label>
                        </div>
                    </div>

                    <!-- Options personnalisées (initialement cachées) -->
                    <div id="custom-options" class="hidden space-y-4">
                        <div>
                            <label for="length" class="block mb-2 text-sm font-medium text-gray-900">Longueur du mot de passe</label>
                            <input type="number" id="length" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" min="8" value="12">
                        </div>
                        <div class="space-y-2">
                            <div class="flex items-center">
                                <input id="uppercase" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500" checked>
                                <label for="uppercase" class="ml-2 text-sm font-medium text-gray-900">Majuscules (A-Z)</label>
                            </div>
                            <div class="flex items-center">
                                <input id="lowercase" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500" checked>
                                <label for="lowercase" class="ml-2 text-sm font-medium text-gray-900">Minuscules (a-z)</label>
                            </div>
                            <div class="flex items-center">
                                <input id="numbers" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500" checked>
                                <label for="numbers" class="ml-2 text-sm font-medium text-gray-900">Chiffres (0-9)</label>
                            </div>
                            <div class="flex items-center">
                                <input id="special" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500" checked>
                                <label for="special" class="ml-2 text-sm font-medium text-gray-900">Caractères spéciaux (!@#$%^&*)</label>
                            </div>
                        </div>
                    </div>

                    <!-- Bouton de génération -->
                    <button id="generate" class="w-full mt-6 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                        Générer le mot de passe
                    </button>
                </div>
                
                <!-- Résultat (à droite) -->
                <div class="bg-gray-50 p-6 rounded-lg">
                    <h2 class="text-xl font-semibold mb-4">Résultat</h2>
                    
                    <!-- Résultat initial -->
                    <div id="initial-message" class="text-center py-8 text-gray-500">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                        <p class="mt-2">Cliquez sur "Générer le mot de passe" pour créer un nouveau mot de passe sécurisé.</p>
                    </div>
                    
                    <!-- Résultat généré (initialement caché) -->
                    <div id="result" class="hidden">
                        <div class="p-4 mb-4 text-sm text-gray-800 rounded-lg bg-white border border-gray-200" role="alert">
                            <div class="font-medium mb-2">Mot de passe généré :</div>
                            <div id="password" class="font-mono text-lg p-3 bg-gray-100 rounded border border-gray-300 break-all"></div>
                        </div>
                        
                        <div class="flex space-x-2">
                            <button id="copy" class="flex-1 text-white bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                Copier le mot de passe
                            </button>
                            <button id="regenerate" class="flex-1 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                Régénérer
                            </button>
                        </div>
                        
                        <!-- Message d'avertissement pour mot de passe faible -->
                        <div id="warning" class="hidden mt-4 p-4 text-sm text-red-800 rounded-lg bg-red-50" role="alert">
                            <span class="font-medium">Attention !</span> Un mot de passe de moins de 8 caractères est considéré comme faible et peut être facilement deviné par des attaquants. Il est recommandé d'utiliser un mot de passe d'au moins 12 caractères.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const recommendedRadio = document.getElementById('recommended');
            const customRadio = document.getElementById('custom');
            const customOptions = document.getElementById('custom-options');
            const generateBtn = document.getElementById('generate');
            const regenerateBtn = document.getElementById('regenerate');
            const resultDiv = document.getElementById('result');
            const initialMessage = document.getElementById('initial-message');
            const passwordDiv = document.getElementById('password');
            const copyBtn = document.getElementById('copy');
            const warningDiv = document.getElementById('warning');
            const lengthInput = document.getElementById('length');

            // Gestion de l'affichage des options personnalisées
            function toggleCustomOptions() {
                customOptions.classList.toggle('hidden', !customRadio.checked);
            }

            recommendedRadio.addEventListener('change', toggleCustomOptions);
            customRadio.addEventListener('change', toggleCustomOptions);

            // Fonction de génération de mot de passe
            function generatePassword() {
                const length = recommendedRadio.checked ? 12 : parseInt(lengthInput.value);
                const useUppercase = recommendedRadio.checked || document.getElementById('uppercase').checked;
                const useLowercase = recommendedRadio.checked || document.getElementById('lowercase').checked;
                const useNumbers = recommendedRadio.checked || document.getElementById('numbers').checked;
                const useSpecial = recommendedRadio.checked || document.getElementById('special').checked;

                let chars = '';
                if (useUppercase) chars += 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                if (useLowercase) chars += 'abcdefghijklmnopqrstuvwxyz';
                if (useNumbers) chars += '0123456789';
                if (useSpecial) chars += '!@#$%^&*()_+-=[]{}|;:,.<>?';

                if (chars === '') {
                    alert('Veuillez sélectionner au moins un type de caractères.');
                    return;
                }

                let password = '';
                for (let i = 0; i < length; i++) {
                    password += chars.charAt(Math.floor(Math.random() * chars.length));
                }

                passwordDiv.textContent = password;
                resultDiv.classList.remove('hidden');
                initialMessage.classList.add('hidden');
                warningDiv.classList.toggle('hidden', length >= 8);
            }

            generateBtn.addEventListener('click', generatePassword);
            regenerateBtn.addEventListener('click', generatePassword);

            // Fonction de copie du mot de passe
            copyBtn.addEventListener('click', function() {
                const password = passwordDiv.textContent;
                navigator.clipboard.writeText(password).then(() => {
                    // Afficher une notification de succès
                    const notification = document.createElement('div');
                    notification.className = 'fixed bottom-4 right-4 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg';
                    notification.textContent = 'Mot de passe copié !';
                    document.body.appendChild(notification);
                    
                    // Supprimer la notification après 2 secondes
                    setTimeout(() => {
                        notification.remove();
                    }, 2000);
                }).catch(err => {
                    console.error('Erreur lors de la copie :', err);
                });
            });
        });
    </script>
</body>
</html> 