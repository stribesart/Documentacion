<?php	
$meses = array(
 "1" => "Enero",
 "2" => "Febrero",
 "3" => "Marzo",
 "4" => "Abril",
 "5" => "Mayo",
 "6" => "Junio",
 "7" => "Julio",
 "8" => "Agosto",
 "9" => "Septiembre",
 "10" => "Octubre",
 "11" => "Noviembre",
 "12" => "diciembre",
);

for($i=0; $i<12; ++$i){
    $data[$i] = array(
        "idMes" => $i+1,
        "nombreMes" => $meses[$i+1]
    );
}

header('Content-Type: application/json');
echo json_encode($data);
 