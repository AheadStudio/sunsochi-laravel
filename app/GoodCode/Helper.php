<?
namespace App\GoodCode;

// for convert date
use Jenssegers\Date\Date;

//for SEO
use SEO;

/**
 * The main class, which includes many usefull methods
 *
 * @method : (convertDate, setSEO, splitText)
 */
class Helper
{
    // methods convert date
    static public function convertDate($date) {
        $convertDate = Date::parse($date)->format("j F Y");
        return $convertDate;
    }

    // methods set SEO information
    static public function setSEO($title, $description, $url) {
        SEO::setTitle($title);
        SEO::setDescription($description);
        SEO::opengraph()->setUrl($url);
    }

    /**
     * explode string by words
     *
     * @return: [сropped string, other string, initial string]
    */
    static public function splitText($text, $maxWords) {
        $phraseArray = explode(' ', $text);
        if(count($phraseArray) > $maxWords && $maxWords > 0) {
            $phrase = implode(' ', array_slice($phraseArray, 0, $maxWords));
        }

        foreach ($phraseArray as $keyPhrase => $valPhrase) {
            if ($keyPhrase <= $maxWords) {
                unset($phraseArray[$keyPhrase]);
            }
        }
        $phraseArray = implode(' ', $phraseArray);

        return $finalString = [$phraseArray, $phrase."<span class='text-points'>...</span>", $text];
    }

}


?>
