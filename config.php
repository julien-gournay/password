<?php
/**
 * Configuration des exigences de mots de passe
 */
return [
    // Exigences par longueur
    'length_requirements' => [
        'min' => 8,
        'recommended' => 12,
        'strong' => 16
    ],
    
    // Types de caractères requis
    'character_types' => [
        'uppercase' => [
            'required' => true,
            'min_count' => 1,
            'description' => 'Majuscules (A-Z)',
            'characters' => 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'
        ],
        'lowercase' => [
            'required' => true,
            'min_count' => 1,
            'description' => 'Minuscules (a-z)',
            'characters' => 'abcdefghijklmnopqrstuvwxyz'
        ],
        'numbers' => [
            'required' => true,
            'min_count' => 1,
            'description' => 'Chiffres (0-9)',
            'characters' => '0123456789'
        ],
        'special' => [
            'required' => true,
            'min_count' => 1,
            'description' => 'Caractères spéciaux (!@#$%^&*)',
            'characters' => '!@#$%^&*()_+-=[]{}|;:,.<>?'
        ]
    ],
    
    // Messages d'erreur
    'error_messages' => [
        'length' => 'Le mot de passe doit contenir au moins {min} caractères.',
        'length_recommended' => 'Pour une sécurité optimale, utilisez au moins {recommended} caractères.',
        'character_type' => 'Le mot de passe doit contenir au moins {min_count} {description}.',
        'weak_password' => 'Ce mot de passe est considéré comme faible et peut être facilement deviné.',
        'medium_password' => 'Ce mot de passe est de force moyenne. Pour plus de sécurité, utilisez plus de caractères et de types de caractères.',
        'strong_password' => 'Ce mot de passe est fort et offre une bonne protection.'
    ],
    
    // Patterns à éviter
    'avoid_patterns' => [
        'sequences' => ['123', 'abc', 'qwerty', 'azerty'],
        'repeated_chars' => 3, // Nombre maximum de caractères répétés consécutivement
        'common_words' => ['password', 'admin', 'user', 'login', 'welcome']
    ]
]; 