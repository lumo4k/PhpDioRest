<?php 

class UserController extends BaseController
{
    public function listAction()
    {
        $errorDescription = '';
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $stringParamsArray = $this->getStringParams();

        if (strtoupper($requestMethod) == 'GET') {
            try {
                $userModel = new UserModel();

                $intLimit = 10;
                if (isset($stringParamsArray['limit']) && $stringParamsArray['limit']){
                    $intLimit = $stringParamsArray['limit'];
                }

                $usersArray = $userModel->getUsers($intLimit);
                $respondeData = json_encode($usersArray);
            } catch (Error $e) {
                $errorDescription = $e->getMessage() . 'Something went Wrong! Please contact support.';
                $errorHeader = 'HTTP/1.1 500 Internal Server Error';
            } 


        } else {
            $errorDescription = 'Method not supported';
            $errorHeader = 'HTTP/1.1 Unprocessable Entity';
        }

        if (!$errorDescription) {
            $this->sendOutput(
                $respondeData,
                array('Content-type: application/json', 'HTTP/1.1 200 OK')
            );
        } else {
            $this->sendOutput(json_encode(array('error' => $errorDescription)), array('Content-Type: application/json', $errorHeader));
        }

    }
}



?>