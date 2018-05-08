<?
namespace App\GoodCode;

// for convert date
use Jenssegers\Date\Date;

// for models
use App\Catalog;
use App\ElementDirectory;
use App\Picture;
use App\Deadline;
use App\District;
use App\NumberRoom;

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

    /**
     * explode string by words
     *
     * @return: array = ["district", "deadline", "apartments", "path"] , section
    */
    static public function getGsk($elementsSection, $allSection, $districtSection, $deadlineSection) {
        $elements = $elementsSection;
        if ($elements) {

            foreach ($elements as $keyOffers => $valOffers) {
                if (!empty($valOffers) || isset($valOffers)) {

                    foreach ($allSection as $keyAllSection => $valAllSection) {
                        if ($valAllSection->id == $valOffers->basic_section) {
                            $subSection = $valAllSection;
                        }
                    }
                    foreach ($allSection as $keyAllSection => $valAllSection) {
                        if ($valAllSection->id == $subSection->parent_id) {
                            $catalogSection = $valAllSection;
                        }
                    }

                    // get photo offers
                    $photo = Picture::select("path")
                                    ->where("element_id", $valOffers->id)
                                    ->first();

                    $props = ElementDirectory::where("element_id", $valOffers->id)->get();

                    $district = new \stdClass();
                    $deadline = new \stdClass();

                    // dedline and district
                    foreach ($props as $keyProps => $valProps) {
                        if ($valProps->name_field == "district") {
                            foreach ($districtSection as $valParams) {
                                if ($valParams->code == $valProps->code) {
                                    $district->{"name"} = $valParams->name;
                                    break;
                                } else {
                                    $district->{"name"} = "";
                                }
                            }
                        }
                        if ($valProps->name_field == "deadline") {
                            foreach ($deadlineSection as $valParams) {
                                if ($valParams->code == $valProps->code) {
                                    $deadline->{"name"} = $valParams->name;
                                    break;
                                } else {
                                    $deadline->{"name"} = "";
                                }
                            }
                        }
                    }

                    $apartments = Catalog::select("id", "price")
                                         ->where([
                                            ["cottage_village", $valOffers->id],
                                            ["price", ">", "0"],
                                         ])
                                         ->orderBy("price", "asc")
                                         ->distinct()
                                         ->get();

                    $apartmnetItems = [];

                    foreach ($apartments as $keyApartment => $valApartment) {
                        $apartmentsProp = ElementDirectory::where([
                                                                ["element_id", $valApartment->id],
                                                                ["name_field", "number_rooms"],
                                                            ])
                                                            ->first();

                        if (!empty($apartmentsProp->code) || isset($apartmentsProp->code)) {
                            $apartmentRooms = NumberRoom::where("code", $apartmentsProp->code)->first();

                            // verification of existence apartments
                            if(!isset($apartmnetItems[$apartmentRooms->name])) {
                                $apartmnetItems[$apartmentRooms->name] = Array(
                                    "price" => $valApartment->price
                                );
                            } else {
                                if($apartmnetItems[$apartmentRooms->name]->price > $valApartment->price) {
                                    $apartmnetItems[$apartmentRooms->name]->price = $valApartment->price;
                                }
                            }

                            // convert array to object (for unification component)
                            $apartmnetItems = array_map(function($array){
                                return (object)$array;
                            }, $apartmnetItems);

                        } else {
                            $apartmnetItems = [];
                        }
                    }
                    ksort($apartmnetItems);


                    // create final object
                    if (isset($photo->path)) {
                        $valOffers->{"photo"} = $photo->path;
                    } else {
                        $valOffers->{"photo"} = "";
                    }

                    $elements[$keyOffers]->{"district"}    = $district->name;
                    $elements[$keyOffers]->{"deadline"}    = $deadline->name;
                    $elements[$keyOffers]->{"apartments"}  = (object)$apartmnetItems;
                    $elements[$keyOffers]->{"path"}        = route("CatalogShow", [$catalogSection->code, $subSection->code, $valOffers->code]);

                }

            }

        }

        return $elements;
    }

}


?>
