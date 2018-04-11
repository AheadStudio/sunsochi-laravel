<?
namespace App\GoodCode;


/**
 * class for parse csv
 */
class ParseCsv
{
    static public function parsingCsv($arrayDataCsv) {
        //final array
        $finalArray = [];

        // name field from csv
        $nameField = array_shift($arrayDataCsv);

        // merger two arrays in final array
        foreach ($arrayDataCsv as $keyData => $valData) {
            foreach ($nameField as $keyNameField => $valNameField) {
                $finalArray[$keyData][$valNameField] = $arrayDataCsv[$keyData][$keyNameField];
            }
        }

        return $finalArray;

    }

}


?>
