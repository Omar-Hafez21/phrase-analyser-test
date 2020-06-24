<?php

namespace App\Services;

class AnalyseService
{

    public function toAscii($character){
        return ord($character)-97;
    }

    public function analyse($request)
    {

        for ($i = 0; $i < 26; $i++) {
            $result[$i] = array(
                array(),
                array(),
                array()
            );
        }

        $arrStr = str_split(trim($request['string']), 1);
        $n = sizeof($arrStr);
        $before = '-';
        $after = '-';
        $current = $arrStr[0];
        $index = 0;


        for ($i = 1; $i < $n; $i++) {
            if (empty(trim($arrStr[$i]))) continue;
            if ($after == "-" && $arrStr[$i] >= "a" && $arrStr[$i] <= "z") {
                $after = $arrStr[$i];
            }

            if ($after != "-") {
                array_push($result[$this->toAscii($current)][0], $index);
                array_push($result[$this->toAscii($current)][1], $after);// after array
                if ($before != "-") {
                    array_push($result[$this->toAscii($current)][2], $before);// before array
                }
                $before = $current;
                $current = $after;
                $index = $i;
                $after = "-";
            }
        }

        array_push($result[$this->toAscii($current)][0], $n - 1);
        array_push($result[$this->toAscii($current)][2], $before);

        for ($i = 0,$j=0; $i < $n; $i++) {
            if( $arrStr[$i]>='a' && $arrStr[$i]<='z'){
                $index = $this->toAscii($arrStr[$i]);
                $arr_length = sizeof($result[$index][0]);
                if($arr_length  > 0){
                    $array_start = $result[$index][0][0];
                    $array_end = end($result[$index][0]);

                    if($arr_length < 2){
                      $maxDistance = '';
                    }elseif ($array_end-($array_start+1) >= 10){
                        $maxDistance = " max_distance:"."10";
                    }else{
                        $maxDistance = " max_distance:".($array_end-($array_start+1));
                    }

                    $before = sizeof($result[$index][1]) == 0 ? ":before:none" : ":before:".implode(',', array_unique ($result[$index][1]));
                    $after = sizeof($result[$index][2]) == 0 ? ":after:none" : ":after:".implode(',', array_unique ($result[$index][2]));

                    $response[$j] = array (
                        $arrStr[$i].":".$arr_length.$before.$after.$maxDistance
                    );
                    $j++;
                }
            }
            $result[$index][0] = [];
        }
        return $response;
    }




}
