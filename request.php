<?php

require $_SERVER["DOCUMENT_ROOT"]."/local/Validator.php";


$hook_url = "https://b24-4cq9v4.bitrix24.ru/rest/1/ff512y0po0qmmhjv";

function makeArrayFiles()
{
    $arrFiles = [];
    if (!empty($_FILES["file"]["tmp_name"]) && is_array($_FILES["file"]["tmp_name"])) {
        foreach ($_FILES["file"]["tmp_name"] as $k => $path) {
            $arrFiles[] = [
                "fileData" => [
                    $_FILES["file"]["name"][$k],
                    base64_encode(file_get_contents($path))
                ]
            ];
        }
    }
    return $arrFiles;
}




$validator = new \LocalValidator\Validator($_POST);

$validator->Expect("email","required, email");
$validator->Expect("name","required, alpha");
$validator->Expect("last_name","required, alpha");
$validator->Expect("phone","required, phone");
$validator->Expect("city","ruquired, alpha");


if($validator->Validate()){


    $ch = curl_init();

    $req = $hook_url."/crm.lead.add.json";

    $queryData = http_build_query(array(
        "fields" => array(
                "TITLE" => "Новый лид",
                "NAME" => $_POST["name"],
                "LAST_NAME" => $_POST["last_name"],
                "PHONE" => $_POST["phone"],
                "EMAIL"=>array(
                    "n0"=> array(
                        "VALUE" => $_POST["email"],
                        "VALUE_TYPE" => "WORK"
                    )
                ),
                "BIRTHDATE" => $_POST["date"],
                "ADDRESS_CITY" => $_POST["city"],

                "PHONE"=>array(
                    "n0"=>array(
                        "VALUE"=>$_POST["phone"],
                        "VALUE_TYPE" => "MOBILE"
                    )
                ),
                "COMMENTS" => $_POST["city"],
                "UF_CRM_1657198705" => makeArrayFiles(),
        'params' => array("REGISTER_SONET_EVENT" => "Y")
    )));



  curl_setopt_array($ch, array(
        CURLOPT_SSL_VERIFYPEER => 0,
        CURLOPT_POST => 1,
        CURLOPT_HEADER => 0,
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => $req,
        CURLOPT_POSTFIELDS => $queryData,
    ));
    $result = curl_exec($ch);


    curl_close($ch);

    if(!array_key_exists('error',$result))
        echo json_encode(array('success' => 1));
    else
        echo json_encode(array('success' => 0));


}else{
    echo json_encode(array('success' => 0));
}




?>