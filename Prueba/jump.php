<?php
$requirement = [2,2,1,1,5,2,2,5,1,5,4,0,5,5,1,4,5,5,2,2,3,0,3,0,1,3,3,1,0,3,2,2,4,1,4,4,2,2,5,2,4,1,4,0,5,1,5,5,3,4,3,2,4,0,3,0,3,0,0,5,3,3,3,1,0,2,1,1,5,0,3,1,3,0,4,5,1,2,3,4,1,4,4,3,1,0,3,4,2,5,5,0,5,4,0,2,2,5,3,4];

function GetRequeriment($req)
{
    echo json_encode($req);
}

function CalculateJump($jumps)
{
    $messages = array('limit_jump_length' => false, 'limit_jumps' => false, 'result' => false);
    $jumpsLengt = count($jumps);
    //LIMITANTES:
    $messages["limit_jump_length"] = (1 <= $jumpsLengt && $jumpsLengt <= 500);
    if ($messages["limit_jump_length"]) {
        //VALIDAR JUMPS
        for ($i = 0; $i < $jumpsLengt; $i++) {
            $messages["limit_jumps"] = (0 <= $jumps[$i] && $jumps[$i] <= 10);
            if (!$messages["limit_jumps"]) break;
        }
        if ($messages["limit_jumps"]) {
            if ($jumpsLengt == 1) {
                //duda:??
                /*if($jumps[0]==0){
                    $_RESULT = false;
                }*/
                $_RESULT = true;
            } else {
                $_RESULT = true;
                for ($i = 0; $i < $jumpsLengt; $i++) {
                    if ($jumps[$i] == 0) {
                        //analizar obstaculo
                        if ($i == 0) {
                            $_RESULT = false;
                            break;
                        }
                        //elemento anterior
                        $beforeIndex = 1;
                        $positionsDiscarted = array();
                        $foundPositionAvailable = false;
                        while (true) {
                            $newIndex = $i - $beforeIndex;
                            if ($newIndex >= 0) {
                                $beforeValue = $jumps[$newIndex];
                                for ($j = 0; $j < $beforeValue; $j++) {
                                    $position = $i - ($beforeIndex - 1) + $j;
                                    if ($position >= $jumpsLengt) break;
                                    if ($jumps[$position] != 0) {
                                        if (!in_array($position, $positionsDiscarted)) {
                                            $i = $position;
                                            $foundPositionAvailable = true;
                                            break;
                                        }
                                    }
                                }
                            } else {
                                break;
                            }
                            if (!$foundPositionAvailable) {
                                //busca elementos anteriores
                                $positionsDiscarted[] = $newIndex;
                                $beforeIndex++;
                            }else{
                                break;
                            }
                        }
                        if (!$foundPositionAvailable) {
                            $_RESULT = false;
                        }
                    }
                }
            }
        }
    }
    $messages['result'] = $_RESULT;
    echo json_encode($messages);
}

if (isset($_GET["requirement"])) {
    GetRequeriment($requirement);
} else {
    CalculateJump($requirement);
}
?>