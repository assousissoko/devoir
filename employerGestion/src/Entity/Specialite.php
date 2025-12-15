<?php

namespace App\Entity;

enum Specialite: string
{
    case FULLSTACK = 'FullStack';
    case BACKEND = 'Back-End';
    case FRONTEND = 'Front-End';
}