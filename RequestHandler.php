<?php

/**
 * Created by PhpStorm.
 * User: HP ProBook 455 G1
 * Date: 6/22/2017
 * Time: 8:41 PM
 */
require_once ('vendor/autoload.php');
require_once('DatabaseConnect.php');
require_once("Crypto.php");

use libphonenumber\PhoneNumberUtil;

class RequestHandler
{
    private $conn;

    public function __construct()
    {
        $dbConn = new DatabaseConnect();
        $this->conn = $dbConn->connect();
    }

    /**
     * @param $requestData
     */
    public function handlePostRequest($requestData)
    {
        $data = json_decode($requestData, true);

        //Check for compulsory field
        if (!isset($data['email']) || !isset($data['phone'])){
            http_response_code(400);
            return json_encode(['error' => "Required data is missing - email or Phone"]);
        }

        if (count($data) != 10) {
            http_response_code(400);
            return json_encode(['error' => "error"]);
        }

        $email = $data ['email'];
        $phone = $data ['phone'];
        $Metadata = [];

        foreach ($data as $k => $d) {
            //Check if input is not email nor phone
            if ($k != 'email' && $k != 'phone')
                $Metadata[$k] = $d;
        }
        $jsonData = json_encode($Metadata);

        //Validate email
        $isEmailValid = preg_match('/^[A-z0-9._\-]+[@][A-z0-9_\-]+([.][A-z0-9_\-]+)+[A-z.]{2,4}$/', $email);

        if(!$isEmailValid){
            http_response_code(400);
            return json_encode(['error' => $email." is invalid"]);
        }

        $phoneUtil = PhoneNumberUtil::getInstance();
        //Validate phone
        try {
            $parsedPhone = $phoneUtil->parse($phone, 'GB');
            $isValid = $phoneUtil->isValidNumber($parsedPhone);
            if (!$isValid) {
                http_response_code(400);
                return json_encode(['error' => 'Invalid Phone number']);
            }
        } catch (\libphonenumber\NumberParseException $e) {
            http_response_code(400);
            return json_encode(['error' => 'Phone validation failed']);
        }

        //Encrypt phone
        $phoneCipher = Crypto::encrypt_decrypt('encrypt', $phone);

        //Store client data
        $sql_insert_query = "INSERT INTO clients (`email`, `phone`, `Metadata`) VALUES ('$email', '$phoneCipher', '$jsonData')";

        if($this->conn->query($sql_insert_query))
        {
            http_response_code(201);
            return json_encode(['message' => 'Client data successfully saved!']);
        }

        http_response_code(500);
        return json_encode(['error' => 'Client data wasn\'t saved!']);
    }

    public function handleGetRequest($requestData) {
        if(isset($requestData['q'])) {
            return json_encode($this->search($requestData['q']));
        }

        $result = $this->getAllClients();
        return json_encode($result);
    }

    /**
     * @return array
     */
    private function search($q)
    {
        $sql_retrieve_query = "SELECT * FROM clients WHERE email LIKE '%" . $q . "%' OR Metadata LIKE '%" . $q . "%'";

        $result = $this->executeQuery($sql_retrieve_query);
        return $result;
    }

    /**
     * @return array
     */
    public function getAllClients()
    {
        $sql_retrieve_query = "SELECT * FROM clients";
        $result = $this->executeQuery($sql_retrieve_query);
        return $result;
    }

    /**
     * @param $sql_retrieve_query
     * @return array
     */
    public function executeQuery($sql_retrieve_query)
    {
        $output = $this->conn->query($sql_retrieve_query);

        $result = [];
        if ($output->num_rows > 0) {
            while ($row = $output->fetch_assoc()) {
                $phone = $row['phone'];
                $phoneDecipher = Crypto::encrypt_decrypt('decrypt', $phone);
                $phone = "******" . substr($phoneDecipher, -4);

                $data = [];
                $data['email'] = $row['email'];
                $data['phone'] = $phone;

                $metaData = json_decode($row['Metadata']);
                foreach ($metaData as $key => $value) {
                    $data[$key] = htmlspecialchars($value);
                }

                $result[] = $data;
            }
        }
        return $result;
    }
}