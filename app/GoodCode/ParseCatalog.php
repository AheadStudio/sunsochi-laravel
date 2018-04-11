<?
namespace App\GoodCode;


/**
 * class for parse data from catalog
 */
class ParseCatalog
{

    // old data
    public $dataOld;

    // new data after parse
    public $dataNew = [];

    public $finalArray = [];

    public function __construct($dataOld) {
        $this->dataOld = $dataOld;
    }

    public function parseCatalog() {
        $this->dataNew = self::changeKey();
        foreach ($this->dataNew as $keyData => $valData) {
            $this->createNewArr($keyData, $valData);
        }

        return $this->finalArray;
    }

    public function changeKey() {
        $nameField = array_shift($this->dataOld);
        // name fields include key array
        foreach ($this->dataOld as $keyReadFile => $valReadFile) {
            foreach ($valReadFile as $keyId => $valProp) {
                $finalArrChange[$keyReadFile][$nameField[$keyId]] = $valProp;
            }
        }

        return $finalArrChange;
    }

    public function createNewArr($keyEl, $valEl) {
        foreach ($valEl as $keyElField => $valElField) {
            if (!empty($valElField) || $valElField != "") {
                if (mb_strripos($keyElField, "_ISFILE") && $keyElField."_ISFILE" != false) {
                    $valElFieldNew = str_replace("_ISFILE", "", $keyElField);
                    $this->finalArray[$keyEl][$keyElField] = explode(",", $valEl[$valElFieldNew]);
                    continue;
                }

                // hightload block
                if (mb_strripos($keyElField, "_HL_ID")) {
                    $valElFieldNew = str_replace("_HL_ID", "", $keyElField);

                    $hlVal = $valEl[$valElFieldNew];
                    $hlVals = $valEl[$valElFieldNew."_HL_ID"];
                    $hlName = $valEl[$valElFieldNew."_HL_NAME_VALUE"];
                    $hlNames = $valEl[$valElFieldNew."_HL_NAME"];
                    $hlDescriptions = $valEl[$valElFieldNew."_HL_FULL_DESCRIPTION"];
                    $this->finalArray[$keyEl][$valElFieldNew] = array(
                        "VALUE"             =>  explode(",", $hlVal),
                        "NAME"              =>  explode(",", $hlName),
                        "ALL_VALUE"         =>  explode(",", $hlVals),
                        "ALL_NAME"          =>  explode(",", $hlNames),
                        "ALL_DESCRIPTION"   =>  explode(",", $hlDescriptions),
                    );
                    continue;
                }

                if ($keyElField == "SECTIONS_ID") {
                    $this->finalArray[$keyEl][$keyElField] = explode(",", $valEl[$keyElField]);
                    continue;
                }
                if ($keyElField == "SECTIONS_CODE") {
                    $this->finalArray[$keyEl][$keyElField] = explode(",", $valEl[$keyElField]);
                    continue;
                }
                if ($keyElField == "SECTIONS_NAME") {
                    $this->finalArray[$keyEl][$keyElField] = explode(",", $valEl[$keyElField]);
                    continue;
                }

                $this->finalArray[$keyEl][$keyElField] = $valElField;

            } else {
                $this->finalArray[$keyEl][$keyElField] = "";
            }
        }
    }

}


?>
