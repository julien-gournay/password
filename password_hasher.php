<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hachage de mot de passe</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
</head>
<body class="bg-gray-100">
    <?php include 'navbar.php'; ?>
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-6xl mx-auto bg-white rounded-lg shadow-md p-6">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Hachage de mot de passe</h1>
                <a href="password_generator.php" class="text-blue-600 hover:text-blue-800">Générer un mot de passe</a>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Options de hachage (à gauche) -->
                <div class="bg-gray-50 p-6 rounded-lg">
                    <h2 class="text-xl font-semibold mb-4">Paramètres de hachage</h2>
                    
                    <!-- Formulaire de hachage -->
                    <form id="hash-form" action="process_hash.php" method="post">
                        <div class="mb-4">
                            <label for="password" class="block mb-2 text-sm font-medium text-gray-900">Mot de passe à hasher</label>
                            <input type="password" id="password" name="password" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                        </div>
                        
                        <div class="mb-4">
                            <label for="algorithm" class="block mb-2 text-sm font-medium text-gray-900">Algorithme de hachage</label>
                            <select id="algorithm" name="algorithm" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                                <option value="bcrypt">BCrypt (recommandé)</option>
                                <option value="argon2">Argon2 (plus sécurisé mais plus lent)</option>
                                <option value="sha256">SHA-256 (non recommandé pour les mots de passe)</option>
                            </select>
                        </div>
                        
                        <!-- Options spécifiques à l'algorithme -->
                        <div id="bcrypt-options" class="mb-4">
                            <label for="bcrypt-cost" class="block mb-2 text-sm font-medium text-gray-900">Coût (work factor)</label>
                            <input type="number" id="bcrypt-cost" name="bcrypt_cost" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" min="4" max="31" value="12">
                            <p class="mt-1 text-xs text-gray-500">Valeur recommandée: 12. Plus la valeur est élevée, plus le hachage est sécurisé mais plus il prend du temps.</p>
                        </div>
                        
                        <div id="argon2-options" class="mb-4 hidden">
                            <div class="mb-2">
                                <label for="argon2-memory" class="block mb-2 text-sm font-medium text-gray-900">Mémoire (KiB)</label>
                                <input type="number" id="argon2-memory" name="argon2_memory" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" min="8" max="65536" value="65536">
                            </div>
                            <div class="mb-2">
                                <label for="argon2-time" class="block mb-2 text-sm font-medium text-gray-900">Temps (itérations)</label>
                                <input type="number" id="argon2-time" name="argon2_time" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" min="1" max="4294967295" value="4">
                            </div>
                            <div class="mb-2">
                                <label for="argon2-threads" class="block mb-2 text-sm font-medium text-gray-900">Threads</label>
                                <input type="number" id="argon2-threads" name="argon2_threads" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" min="1" max="255" value="3">
                            </div>
                        </div>
                        
                        <div id="sha256-options" class="mb-4 hidden">
                            <div class="p-4 text-sm text-red-800 rounded-lg bg-red-50" role="alert">
                                <span class="font-medium">Attention !</span> SHA-256 n'est pas recommandé pour le hachage de mots de passe car il est vulnérable aux attaques par force brute et aux tables arc-en-ciel. Utilisez plutôt BCrypt ou Argon2.
                            </div>
                            <div class="mb-2">
                                <label for="sha256-salt" class="block mb-2 text-sm font-medium text-gray-900">Sel (optionnel)</label>
                                <input type="text" id="sha256-salt" name="sha256_salt" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                            </div>
                        </div>
                        
                        <!-- Bouton de hachage -->
                        <button type="submit" class="w-full mt-6 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                            Hasher le mot de passe
                        </button>
                    </form>
                </div>
                
                <!-- Résultat (à droite) -->
                <div class="bg-gray-50 p-6 rounded-lg">
                    <h2 class="text-xl font-semibold mb-4">Résultat</h2>
                    
                    <!-- Résultat initial -->
                    <div id="initial-message" class="text-center py-8 text-gray-500">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                        <p class="mt-2">Entrez un mot de passe et sélectionnez un algorithme pour générer son hash.</p>
                    </div>
                    
                    <!-- Résultat généré (initialement caché) -->
                    <div id="result" class="hidden">
                        <div class="p-4 mb-4 text-sm text-gray-800 rounded-lg bg-white border border-gray-200" role="alert">
                            <div class="font-medium mb-2">Hash généré :</div>
                            <div id="hash-result" class="font-mono text-sm p-3 bg-gray-100 rounded border border-gray-300 break-all"></div>
                        </div>
                        
                        <div class="flex space-x-2">
                            <button id="copy" class="flex-1 text-white bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                Copier le hash
                            </button>
                        </div>
                        
                        <!-- Informations sur l'algorithme -->
                        <div id="algorithm-info" class="mt-4 p-4 text-sm text-gray-800 rounded-lg bg-white border border-gray-200">
                            <div class="font-medium mb-2">Informations sur l'algorithme :</div>
                            <div id="algorithm-details" class="text-xs"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const algorithmSelect = document.getElementById('algorithm');
            const bcryptOptions = document.getElementById('bcrypt-options');
            const argon2Options = document.getElementById('argon2-options');
            const sha256Options = document.getElementById('sha256-options');
            const hashForm = document.getElementById('hash-form');
            const resultDiv = document.getElementById('result');
            const initialMessage = document.getElementById('initial-message');
            const hashResult = document.getElementById('hash-result');
            const copyBtn = document.getElementById('copy');
            const algorithmInfo = document.getElementById('algorithm-info');
            const algorithmDetails = document.getElementById('algorithm-details');

            // Gestion de l'affichage des options spécifiques à l'algorithme
            function toggleAlgorithmOptions() {
                const selectedAlgorithm = algorithmSelect.value;
                
                bcryptOptions.classList.toggle('hidden', selectedAlgorithm !== 'bcrypt');
                argon2Options.classList.toggle('hidden', selectedAlgorithm !== 'argon2');
                sha256Options.classList.toggle('hidden', selectedAlgorithm !== 'sha256');
                
                // Mettre à jour les informations sur l'algorithme
                updateAlgorithmInfo(selectedAlgorithm);
            }

            algorithmSelect.addEventListener('change', toggleAlgorithmOptions);
            
            // Mettre à jour les informations sur l'algorithme
            function updateAlgorithmInfo(algorithm) {
                let info = '';
                
                switch(algorithm) {
                    case 'bcrypt':
                        info = `
                            <p><strong>BCrypt</strong> est un algorithme de hachage adaptatif conçu spécifiquement pour le hachage de mots de passe.</p>
                            <p class="mt-2">Avantages :</p>
                            <ul class="list-disc pl-5">
                                <li>Conçu spécifiquement pour les mots de passe</li>
                                <li>Paramètre de coût ajustable pour rester sécurisé face à l'évolution du matériel</li>
                                <li>Intègre un sel automatiquement</li>
                            </ul>
                        `;
                        break;
                    case 'argon2':
                        info = `
                            <p><strong>Argon2</strong> est le gagnant du Password Hashing Competition et est considéré comme l'algorithme le plus sécurisé actuellement.</p>
                            <p class="mt-2">Avantages :</p>
                            <ul class="list-disc pl-5">
                                <li>Protection contre les attaques par matériel spécialisé (ASIC, FPGA)</li>
                                <li>Paramètres ajustables pour la mémoire, le temps et le parallélisme</li>
                                <li>Recommandé par l'OWASP pour les nouvelles applications</li>
                            </ul>
                        `;
                        break;
                    case 'sha256':
                        info = `
                            <p><strong>SHA-256</strong> est une fonction de hachage cryptographique, mais n'est pas conçue pour le hachage de mots de passe.</p>
                            <p class="mt-2">Limitations :</p>
                            <ul class="list-disc pl-5">
                                <li>Vulnérable aux attaques par force brute</li>
                                <li>Vulnérable aux attaques par tables arc-en-ciel</li>
                                <li>Ne ralentit pas intentionnellement les attaques</li>
                            </ul>
                        `;
                        break;
                }
                
                algorithmDetails.innerHTML = info;
            }
            
            // Initialiser les informations sur l'algorithme
            updateAlgorithmInfo(algorithmSelect.value);
            
            // Gestion de la soumission du formulaire
            hashForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const formData = new FormData(hashForm);
                
                fetch('process_hash.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        hashResult.textContent = data.hash;
                        resultDiv.classList.remove('hidden');
                        initialMessage.classList.add('hidden');
                    } else {
                        alert('Erreur : ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Erreur :', error);
                    alert('Une erreur est survenue lors du hachage du mot de passe.');
                });
            });
            
            // Fonction de copie du hash
            copyBtn.addEventListener('click', function() {
                const hash = hashResult.textContent;
                navigator.clipboard.writeText(hash).then(() => {
                    // Afficher une notification de succès
                    const notification = document.createElement('div');
                    notification.className = 'fixed bottom-4 right-4 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg';
                    notification.textContent = 'Hash copié !';
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