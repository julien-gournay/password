<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recommandations de mots de passe</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
</head>
<body class="bg-gray-100">
    <?php include 'navbar.php'; ?>
    
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-md p-6">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Recommandations pour des mots de passe sécurisés</h1>
            
            <div class="space-y-6">
                <!-- Section longueur -->
                <div class="bg-gray-50 p-6 rounded-lg">
                    <h2 class="text-xl font-semibold mb-4">Longueur du mot de passe</h2>
                    <div class="space-y-2">
                        <?php
                        $config = require 'config.php';
                        $length_reqs = $config['length_requirements'];
                        ?>
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-red-500 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                            </svg>
                            <span>Minimum: <?php echo $length_reqs['min']; ?> caractères</span>
                        </div>
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-yellow-500 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <span>Recommandé: <?php echo $length_reqs['recommended']; ?> caractères</span>
                        </div>
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <span>Fort: <?php echo $length_reqs['strong']; ?> caractères</span>
                        </div>
                    </div>
                </div>
                
                <!-- Section types de caractères -->
                <div class="bg-gray-50 p-6 rounded-lg">
                    <h2 class="text-xl font-semibold mb-4">Types de caractères requis</h2>
                    <div class="space-y-2">
                        <?php foreach ($config['character_types'] as $type => $requirements): ?>
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-blue-500 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <span><?php echo $requirements['description']; ?> (minimum: <?php echo $requirements['min_count']; ?>)</span>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                
                <!-- Section patterns à éviter -->
                <div class="bg-gray-50 p-6 rounded-lg">
                    <h2 class="text-xl font-semibold mb-4">Patterns à éviter</h2>
                    <div class="space-y-4">
                        <div>
                            <h3 class="font-medium mb-2">Séquences communes</h3>
                            <div class="flex flex-wrap gap-2">
                                <?php foreach ($config['avoid_patterns']['sequences'] as $sequence): ?>
                                <span class="px-2 py-1 bg-red-100 text-red-800 rounded"><?php echo $sequence; ?></span>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <div>
                            <h3 class="font-medium mb-2">Caractères répétés</h3>
                            <p>Évitez de répéter le même caractère plus de <?php echo $config['avoid_patterns']['repeated_chars']; ?> fois consécutivement.</p>
                        </div>
                        <div>
                            <h3 class="font-medium mb-2">Mots communs</h3>
                            <div class="flex flex-wrap gap-2">
                                <?php foreach ($config['avoid_patterns']['common_words'] as $word): ?>
                                <span class="px-2 py-1 bg-red-100 text-red-800 rounded"><?php echo $word; ?></span>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Section messages d'erreur
                <div class="bg-gray-50 p-6 rounded-lg">
                    <h2 class="text-xl font-semibold mb-4">Messages d'erreur</h2>
                    <div class="space-y-2">
                        //<?php //foreach ($config['error_messages'] as $key => $message): ?>
                        <div class="p-3 bg-gray-100 rounded">
                            <span class="font-medium"><?php //echo ucfirst(str_replace('_', ' ', $key)); ?>:</span>
                            <span><?php //echo $message; ?></span>
                        </div>
                        <?php //endforeach; ?>
                    </div>
                </div>-->
                
                <!-- Lien vers le site externe -->
                <div class="mt-8 text-center">
                    <a href="https://secretive-cicada-052.notion.site/Comment-bien-choisir-ses-mots-de-passe-196881d0d2df80768d34edb5f7d13c51" target="_blank" class="inline-flex items-center px-5 py-3 text-base font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        En savoir plus sur la sécurité des mots de passe
                        <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html> 