<?
namespace App\GoodCode;

use Illuminate\Http\Request;

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
use App\Chess;

// for SEO
use SEO;

// for cookie
use Cookie;


/**
 * The class, which includes many usefull methods
 *
 * @method : (convertDate, setSEO, splitText, getGsk, hendlerCookie)
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
     * @return: array = [сropped string, other string, initial string]
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
     * get fields from catalog
     *
     * @return: array = ["district", "deadline", "apartments", "path"] , section
    */
    public static function getGsk($elements, $idMainSection = false, $codeMainSection = false) {
        if (!empty($elements) || isset($elements)) {
            if ($idMainSection != "") {
                $queryMainSection[] = ["parent_id", $idMainSection];
            } else {
                $queryMainSection[] = ["code", "<>", ""];
            }

            // all section
            $allSection = CatalogsSection::select("id", "code", "parent_id");
            if (is_array($idMainSection)) {
                $allSection = $allSection->whereIn("id", $idMainSection);
            } else {
                $allSection = $allSection->where($queryMainSection);
            }

            $allSection = $allSection->get()
                                     ->groupBy("id");

            // create array with elements id
            $idElements = $elements->sortBy("id")->pluck("id");
            //echo "<pre>"; print_r($idElements); echo "</pre>";
            // get one photo for every elements
            $photoElements = Picture::select("path", "element_id")
                                    ->whereIn("element_id", $idElements)
                                    ->distinct()
                                    ->get()
                                    ->unique("element_id")
                                    ->sortBy("element_id")
                                    ->groupBy("element_id");
            //dd($photoElements)                        ;
            // get property for every elements
            $propertyElementsCode = ElementDirectory::whereIn("name_field", ["deadline", "district"])
                                                    ->whereIn("element_id", $idElements)
                                                    ->get()
                                                    ->sortBy("element_id")
                                                    ->groupBy("element_id");

            $arProperty = [];

            foreach ($propertyElementsCode as $keyEl => $valEl) {
                foreach ($valEl as $keyField => $valField) {
                    $arProperty[$valField["name_field"]][] = $valField["code"];
                }
            }

            if (!empty($arProperty)) {
                if (!empty($arProperty["deadline"])) {
                    $deadlineElements = Deadline::select("code", "name")
                                                ->whereIn("code", $arProperty["deadline"])
                                                ->get()
                                                ->groupBy("code")
                                                ->toArray();
                }
                if (!empty($arProperty["district"])) {
                    $districtElements = District::select("code", "name")
                                                ->whereIn("code", $arProperty["district"])
                                                ->get()
                                                ->groupBy("code")
                                                ->toArray();
                }

                $propertyElementsCode->each(function ($item, $key) use (&$deadlineElements, &$districtElements) {
                    foreach ($item as $key => $valItem) {
                        if ($valItem["name_field"] == "district") {
                            $item[$key]["name"] = $districtElements[$valItem["code"]][0]["name"];
                        } elseif ($valItem["name_field"] == "deadline") {
                            $item[$key]["name"] = $deadlineElements[$valItem["code"]][0]["name"];
                        }
                    }
                });
            }

            // apartments
            $apartments = Catalog::select("catalogs.id", "catalogs.price", "catalogs.cottage_village", "element_directories.element_id", "element_directories.code","number_rooms.name as name")
                                 ->whereIn("cottage_village", $idElements)
                                 ->where("price", ">", "0")
                                 ->orderBy("price", "asc")
                                 ->distinct()
                                 ->join("element_directories", function ($join){
                                     $join->on("catalogs.id", "=", "element_directories.element_id");
                                         $join->where("name_field", "number_rooms");
                                 })
                                 ->join("number_rooms", "element_directories.code", "=", "number_rooms.code")
                                 ->get()
                                 ->groupBy("cottage_village");


            $elements->each(function ($item, $key) use (&$photoElements, &$allSection, &$codeMainSection, &$propertyElementsCode, &$apartments) {
                // add in array photo
                if (isset($photoElements[$item->id])) {
                    $item->{"photo"} = $photoElements[$item->id][0]->path;
                } else {
                    $item->{"photo"} = "";
                }

                if ($codeMainSection == "") {
                    if (is_null($allSection[$item->basic_section][0]->parent_id)) {
                        $codeMainSectionElement = $allSection[$item->basic_section][0]->code;
                    } else {
                        $codeMainSectionElement = $allSection[$allSection[$item->basic_section][0]->parent_id][0]->code;
                    }
                } else {
                    $codeMainSectionElement = $codeMainSection;
                }

                // add in array path
                $item->{"path"} = route("CatalogShow", [$codeMainSectionElement, $allSection[$item->basic_section][0]->code, $item->code]);

                if (!empty($propertyElementsCode[$item->id])) {
                    foreach ($propertyElementsCode[$item->id] as $keyElCode => $valElCode) {
                        $item->{$valElCode["name_field"]} = $valElCode["name"];
                    }
                }

                if ($apartments->isNotEmpty()) {
                    $apartmentsArray = [];
                    if (isset($apartments[$item->id])) {
                        $groupBy = $apartments[$item->id]->groupBy("name");
                        foreach ($groupBy as $key => $value) {
                            $apartmentsArray[$key] = $value[0]->price;
                        }
                        ksort($apartmentsArray);
                        $item->{"apartments"} = (object)$apartmentsArray;
                    }
                }
            });
            //dd();
        }

        return $elements;
    }

    /**
     * get, check and set cookie on site
     *
     * @return: array = [idElement, idElement,...]
    */
    public static function handlerCookie($element = false, $type) {
        $element = (int)$element;
        $cookie = json_decode(Cookie::get("sunsochi-favorite"));

        if (empty($element) || $element == false) {
            return $cookie;
        }

        if (empty($cookie)) {
            $cookie = [];
            if ($type == "post") {
                array_unshift($cookie, $element);
            } else {
                return false;
            }

        } else {
            if (in_array($element, $cookie)) {
                if ($type == "get") {
                    return true;
                }
                if ($type == "post") {
                    return $cookie;
                }
            } else {
                if ($type == "get") {
                    return false;
                }
                if ($type == "post") {
                    array_unshift($cookie, $element);
                }
            }
        }
        return $cookie;
    }

    /**
     * function for change format chess
     *
     * @return: element
    */
    public static function chessFormat($item, $width, $height) {
        if (is_null($width)) {
            $width = 1;
        }
        if (is_null($height)) {
            $height = 1;
        }
        $explodeItem = explode("_", $item);
        $final = "[";
        for ($i = 0; $i < $width; $i++) {
            for ($j = $explodeItem[1]; $j > $explodeItem[1]-$height; $j--) {
                $final .= '"' .  $j . "," . (int)($explodeItem[2] + ($i-1)) .'"' . ",";
            }
        }
        $final .= "]";
        $final = str_replace(",]", "]", $final);
        return ["section" => $explodeItem[0], "chess_obj" => $final];
    }

}


?>
