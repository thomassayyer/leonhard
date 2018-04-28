<?php

/**
 * Appelée à chaque appel d'une classe dont la déclaration n'est pas incluse
 * dans le fichier appelant.
 *
 * @param string $class Le nom complet de la classe.
 */
spl_autoload_register(function ($class)
{
    // On explose notre variable $class par \.
    $parts = explode('\\', $class);

    // On extrait le dernier element.
    $className = array_pop($parts);

    // On crée le chemin vers la classe.
    $path = implode('/', $parts);
    $file = $className . '.php';

    $filePath = __DIR__ . '/../' . strtolower($path) . '/' . $file;

    if (file_exists($filePath))
    {
        require $filePath;

        // Invocation du constructeur statique.
        if (method_exists($class, 'initialize'))
        {
            $class::initialize();
        }
    }
});
