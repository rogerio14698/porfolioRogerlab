<?php

return [
    'city' => env('SEO_CITY', 'Gijón'),
    'region' => env('SEO_REGION', 'Asturias'),
    'country' => env('SEO_COUNTRY', 'España'),
    'profile' => [
        'name' => env('SEO_PROFILE_NAME', 'Rogerio Lucas Viana'),
        'job_title' => env('SEO_JOB_TITLE', 'Desarrollador Web Full Stack Junior'),
        'description' => env('SEO_DESCRIPTION', 'Desarrollador Web Full Stack Junior titulado en DAW, especializado en Laravel, PHP y JavaScript. Experiencia en mantenimiento de software, refactorización, Docker y bases de datos relacionales.'),
        'email' => env('SEO_EMAIL', 'rogeriolucas14698@gmail.com'),
        'telephone' => env('SEO_TELEPHONE', '+34 629 948 107'),
        'portfolio' => env('SEO_PORTFOLIO_URL', 'https://rogerlab.es/home'),
        'linkedin' => env('SEO_LINKEDIN_URL', 'https://www.linkedin.com/in/rogerio-lucas-rogerlab'),
        'github' => env('SEO_GITHUB_URL', 'https://github.com/rogerio14698'),
        'image' => env('SEO_IMAGE', 'img/profileIMG.png'),
        'skills' => [
            'Laravel',
            'PHP',
            'JavaScript',
            'TypeScript',
            'SQL',
            'Docker',
            'Git',
            'AWS EC2',
            'n8n',
            'APIs REST',
        ],
    ],
];
