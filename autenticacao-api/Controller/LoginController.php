<?php
require("Repository/Services/LoginService.php");

class LoginController { 

    protected $loginService;

    public function Login($request, $response, $args)
    {
        $data = $request->getParsedBody();

        $login = $data['email']; 
        $senha = $data['senha'];    
        $user = $this->loginService->ValidarUsuario($login,$senha);
        if($user){
            $response->write(json_encode($user));
            $newResponse = $response->withHeader(
                'Content-type',
                'application/json; charset=utf-8'
            );
            return $newResponse->withStatus(200);
        }else{
            $response->write(null);
            return $response->withStatus(401);
        }
    }

    public function Logout($request, $response, $args)
    {
        session_start();
        $response->write(session_destroy());
        return $response->withStatus(200);
    }

    public function __construct()
    {
        $this->loginService = new LoginService();
    }


}
?>