<?
namespace App\GoodCode;

// for convert date
use Jenssegers\Date\Date;

// for models
use App\Catalog;
use App\CatalogsSection;

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
    public static function convertDate($date) {
        $convertDate = Date::parse($date)->format("j F Y");
        return $convertDate;
    }

    // methods set SEO information
    public static function setSEO($title, $description, $url) {
        SEO::setTitle($title);
        SEO::setDescription($description);
        SEO::opengraph()->setUrl($url);
    }

    /**
     * explode string by words
     *
     * @return: [сropped string, other string, initial string]
    */
    public static function splitText($text, $maxWords) {
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
    public static function getGsk($elements, $idMainSection, $codeMainSection) {
        if (!empty($elements) || isset($elements)) {
            // all section
            $allSection = CatalogsSection::select("id", "code", "parent_id")
                                            ->where("parent_id", $idMainSection)
                                            ->get()
                                            ->groupBy("id");

            // create array with elements id
            $idElements = $elements->sortBy("id")->pluck("id");

            // get one photo for every elements
            $photoElements = Picture::select("path", "element_id")
                                    ->whereIn("element_id", $idElements)
                                    ->distinct()
                                    ->get()
                                    ->unique("element_id")
                                    ->sortBy("element_id")
                                    ->groupBy("element_id");

            // get deadline for every elements
            $deadlineElementsCode = ElementDirectory::where("name_field", "deadline")
                                                    ->whereIn("element_id", $idElements)
                                                    ->get()
                                                    ->unique("element_id")
                                                    ->sortBy("element_id");

            $deadlineElements = Deadline::select("code", "name")
                                        ->whereIn("code", $deadlineElementsCode->pluck("code"))
                                        ->get()
                                        ->groupBy("code");

            $deadlineElementsCode = $deadlineElementsCode->groupBy("element_id");
            $deadlineElementsCode->each(function ($item, $key) use (&$deadlineElements) {
                $item[0]->{"name"} = $deadlineElements[$item[0]->code][0]->name;
            });

            // get distric for every elements
            $districtElementsCode = ElementDirectory::where("name_field", "district")
                                                    ->whereIn("element_id", $idElements)
                                                    ->get()
                                                    ->unique("element_id")
                                                    ->sortBy("element_id");

            $districtElements = District::select("code", "name")
                                        ->whereIn("code", $districtElementsCode->pluck("code"))
                                        ->get()
                                        ->groupBy("code");

            $districtElementsCode = $districtElementsCode->groupBy("element_id");
            $districtElementsCode->each(function ($item, $key) use (&$districtElements) {
                $item[0]->{"name"} = $districtElements[$item[0]->code][0]->name;
            });

            $elements->each(function ($item, $key) use (&$photoElements, &$allSection, &$codeMainSection, &$deadlineElementsCode, &$districtElementsCode) {
                // add in array photo
                if (isset($photoElements[$item->id])) {
                    $item->{"photo"} = $photoElements[$item->id][0]->path;
                } else {
                    $item->{"photo"} = "";
                }

                // add in array path
                $item->{"path"} = route("CatalogShow", [$codeMainSection, $allSection[$item->basic_section][0]->code, $item->code]);

                // add deadline
                if (isset($deadlineElementsCode[$item->id])) {
                    $item->{"deadline"} = $deadlineElementsCode[$item->id][0]->name;
                }

                // add region (district)
                if (isset($districtElementsCode[$item->id])) {
                    $item->{"distric"} = $districtElementsCode[$item->id][0]->name;
                }


                // apartments
                $apartments = Catalog::select("id", "price")
                                        ->where([
                                            ["cottage_village", $item->id],
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

                $item->{"apartments"}  = (object)$apartmnetItems;

            });

        }

        return $elements;
    }

}


?>
