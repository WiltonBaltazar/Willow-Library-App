<?php 

namespace App\Enums;    

enum BookTypeEnum: string
{
    case EBOOK = 'e-book';
    case PHYSICAL = 'physical';
}