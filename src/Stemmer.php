<?php

namespace PolishStemmer;

class Stemmer
{
    const VOWELS = ["a", "i", "e", "o", "u", "y"];

    const SUFFIXES = ["dziesiatko", "dziesiatce", "dziesiatka", "dziesiatke", "dziesiatki", "ynascioro", "anascioro", "enascioro", "nascioro", "dziesiat", "dziescia", "dziesci", "nastke", "nastka", "nastki", "iescie", "nastko", "nascie", "nastce", "iunio", "uszek", "iuset", "escie", "eczka", "yczek", "eczko", "iczek", "eczek", "setka", "iema", "iemu", "ysta", "ioma", "owie", "owym", "iego", "usia", "giem", "unia", "iami", "unio", "usui", "owi", "ych", "szy", "ema", "emu", "óch", "ymi", "ami", "set", "ich", "ech", "iom", "imi", "ach", "oma", "owa", "owe", "owy", "iem", "ego", "ym", "um", "yk", "om", "ow", "us", "im", "om", "ek", "ej", "ga", "gu", "ia", "ie", "aj", "ik", "iu", "ka", "ki", "ko", "mi", "em", "ce", "a", "e", "i", "y", "o", "u"];

    const STOPWORDS = ["aby", "albo", "ale", "ani", "az", "bardzo", "beda", "bedzie", "bez", "bo", "bowiem", "by", "byc", "byl", "byla", "byli", "bylo", "byly", "bym", "chce", "choc", "co", "coraz", "cos", "czesto", "czy", "czyli", "dla", "do", "dr", "gdy", "gdyby", "gdyz", "gdzie", "go", "godz", "hab", "i", "ich", "ii", "iii", "im", "inne", "inz", "iv", "ix", "iz", "ja", "jak", "jakie", "jako", "je", "jednak", "jednym", "jedynie", "jego", "jej", "jesli", "jest", "jeszcze", "jezeli", "juz", "kiedy", "kilku", "kto", "ktora", "ktore", "ktorego", "ktorej", "ktory", "ktorych", "ktorym", "ktorzy", "lat", "lecz", "lub", "ma", "maja", "mamy", "mgr", "mi", "mial", "mimo", "mnie", "moga", "moze", "mozna", "mu", "musi", "na", "nad", "nam", "nas", "nawet", "nic", "nich", "nie", "niej", "nim", "niż", "no", "nowe", "np", "nr", "o", "od", "ok", "on", "one", "o.o.", "oraz", "pan", "pl", "po", "pod", "ponad", "poniewaz", "poza", "prof", "przed", "przede", "przez", "przy", "raz", "razie", "roku", "rowniez", "sa", "sie", "sobie", "sposob", "swoje", "ta", "tak", "takich", "takie", "takze", "tam", "te", "tego", "tej", "tel", "temu", "ten", "teraz", "tez", "to", "trzeba", "tu", "tych", "tylko", "tym", "tys", "tzw", "u", "ul", "vi", "vii", "viii", "vol", "w", "we", "wie", "wiec", "wlasnie", "wsrod", "wszystko", "www", "xi", "xii", "xiii", "xiv", "xv", "z", "za", "zas", "ze", "zl"];

    const MAP = ["ą" => "a", "ę" => "e", "ó" => "o", "ś" => "s", "ł" => "l", "ż" => "z", "ź" => "z", "ć" => "c", "ń" => "n"];

    public static $encoding = "UTF-8";

    public static function filter($word){
        $word = mb_strtolower($word, self::$encoding);
        $word = strtr($word, self::MAP);
        if(strlen($word) and ctype_alpha($word)) {
            if(!in_array($word, self::STOPWORDS)) {
                return $word;
            }
        }
        return null;
    }

    public static function stem($word){
        $fword = self::filter($word);
        if($fword){
            $wl = mb_strlen($fword, self::$encoding);
            foreach (self::SUFFIXES as $suffix) {
                $l = mb_strlen($suffix, self::$encoding);
                if ($l > $wl) {
                    continue;
                } else {
                    $last_part = mb_substr($fword, -$l, null, self::$encoding);
                    if ($last_part == $suffix) {
                        $one_before_last_part = mb_substr($fword, -$l - 1, 1, self::$encoding);
                        if (!in_array($one_before_last_part, self::VOWELS)) {
                            return mb_substr($fword, 0, $wl - $l, self::$encoding);
                        }
                    }
                }

            }
            return $fword;
        }
        return null;
    }

}