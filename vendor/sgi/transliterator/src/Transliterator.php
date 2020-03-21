<?php

declare(strict_types=1);

namespace SGI;

class Transliterator
{

    private static $replace = [
        "А" => "A", "Б" => "B", "В" => "V", "Г" => "G",
        "Д" => "D", "Ђ" => "Đ", "Е" => "E", "Ж" => "Ž",
        "З" => "Z", "И" => "I", "Ј" => "J", "К" => "K",
        "Л" => "L", "Љ" => "LJ","М" => "M", "Н" => "N",
        "Њ" => "NJ","О" => "O", "П" => "P", "Р" => "R",
        "С" => "S", "Ш" => "Š", "Т" => "T", "Ћ" => "Ć",
        "У" => "U", "Ф" => "F", "Х" => "H", "Ц" => "C",
        "Ч" => "Č", "Џ" => "DŽ","Ш" => "Š", "а" => "a",
        "б" => "b", "в" => "v", "г" => "g", "д" => "d",
        "ђ" => "đ", "е" => "e", "ж" => "ž", "з" => "z",
        "и" => "i", "ј" => "j", "к" => "k", "л" => "l",
        "љ" => "lj","м" => "m", "н" => "n", "њ" => "nj",
        "о" => "o", "п" => "p", "р" => "r", "с" => "s",
        "ш" => "š", "т" => "t", "ћ" => "ć", "у" => "u",
        "ф" => "f", "х" => "h", "ц" => "c", "ч" => "č",
        "џ" => "dž", "ш" => "š",
        "Ња" => "Nja", "Ње" => "Nje", "Њи" => "Nji",
        "Њо" => "Njo", "Њу" => "Nju", "Ља" => "Lja",
        "Ље" => "Lje", "Љи" => "Lji", "Љо" => "Ljo",
        "Љу" => "Lju", "Џа" => "Dža", "Џе" => "Dže",
        "Џи" => "Dži", "Џо" => "Džo", "Џу" => "Džu",
    ];

    private static $cut_replace = [
        "А" => "A", "Б" => "B", "В" => "V", "Г" => "G",
        "Д" => "D", "Ђ" => "Dj","Е" => "E", "Ж" => "Z",
        "З" => "Z", "И" => "I", "Ј" => "J", "К" => "K",
        "Л" => "L", "Љ" => "LJ","М" => "M", "Н" => "N",
        "Њ" => "NJ","О" => "O", "П" => "P", "Р" => "R",
        "С" => "S", "Ш" => "S", "Т" => "T", "Ћ" => "C",
        "У" => "U", "Ф" => "F", "Х" => "H", "Ц" => "C",
        "Ч" => "C", "Џ" => "Dz","Ш" => "S", "а" => "a",
        "б" => "b", "в" => "v", "г" => "g", "д" => "d",
        "ђ" => "dj","е" => "e", "ж" => "z", "з" => "z",
        "и" => "i", "ј" => "j", "к" => "k", "л" => "l",
        "љ" => "lj","м" => "m", "н" => "n", "њ" => "nj",
        "о" => "o", "п" => "p", "р" => "r", "с" => "s",
        "ш" => "s", "т" => "t", "ћ" => "c", "у" => "u",
        "ф" => "f", "х" => "h", "ц" => "c", "ч" => "c",
        "џ" => "dz","ш" => "s",
        "Ња" => "Nja", "Ње" => "Nje", "Њи" => "Nji",
        "Њо" => "Njo", "Њу" => "Nju", "Ља" => "Lja",
        "Ље" => "Lje", "Љи" => "Lji", "Љо" => "Ljo",
        "Љу" => "Lju", "Џа" => "Dža", "Џе" => "Dze",
        "Џи" => "Dzi", "Џо" => "Dzo", "Џу" => "Dzu",
    ];

    private static $cut_lat_replace = [
        'DŽ' => 'Dz','Dž' => 'Dz','dž' => 'dz','Č'  => 'C',
        'č'  => 'c', 'Ć'  => 'C', 'ć'  => 'c', 'Đ'  => 'Dj',
        'đ'  => 'dj','Š'  => 'S', 'š'  => 's', 'Ž'  => 'Z',
        'ž'  => 'z',
    ];

    private static $reverse = [
        'A' => 'А','B' => 'Б','V' => 'В','G' => 'Г',
        'D' => 'Д','Đ' => 'Ђ','E' => 'Е','Ž' => 'Ж',
        'Z' => 'З','I' => 'И','J' => 'Ј','K' => 'К',
        'L' => 'Л','LJ'=> 'Љ','M' => 'М','N' => 'Н',
        'NJ'=> 'Њ','O' => 'О','P' => 'П','R' => 'Р',
        'S' => 'С','Š' => 'Ш','T' => 'Т','Ć' => 'Ћ',
        'U' => 'У','F' => 'Ф','H' => 'Х','C' => 'Ц',
        'Č' => 'Ч','DŽ'=> 'Џ','a' => 'а','b' => 'б',
        'v' => 'в','g' => 'г','d' => 'д','đ' => 'ђ',
        'e' => 'е','ž' => 'ж','z' => 'з','i' => 'и',
        'j' => 'ј','k' => 'к','l' => 'л','lj'=> 'љ',
        'm' => 'м','n' => 'н','nj'=> 'њ','o' => 'о',
        'p' => 'п','r' => 'р','s' => 'с','š' => 'ш',
        't' => 'т','ć' => 'ћ','u' => 'у','f' => 'ф',
        'h' => 'х','c' => 'ц','č' => 'ч','dž'=> 'џ',
        'Nja' => 'Ња','Nje' => 'Ње','Nji' => 'Њи',
        'Njo' => 'Њо','Nju' => 'Њу','Lja' => 'Ља',
        'Lje' => 'Ље','Lji' => 'Љи','Ljo' => 'Љо',
        'Lju' => 'Љу','Dža' => 'Џа','Dže' => 'Џе',
        'Dži' => 'Џи','Džo' => 'Џо','Džu' => 'Џу'
    ];

    public static function lat_to_cut_lat(string $text)
    {
        return strtr($text,self::$cut_lat_replace);
    }

    public static function cir_to_cut_lat(string $text)
    {
        return strtr($text,self::$cut_replace); 
    }

    public static function cir_to_lat(string $text)
    {
        return strtr($text,self::$replace);
    }

    public static function lat_to_cir(string $text)
    {
        return strtr($text,self::$reverse);
    }

}