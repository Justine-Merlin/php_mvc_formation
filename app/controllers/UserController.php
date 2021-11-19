<?php

class UserController extends Controller
{
    public function inscriptionAction()
    {
        if(isset($_POST['firstname']) OR isset($_POST['name']) OR isset($_POST['pseudo']) OR isset($_POST['email'])){
            if(isset($_POST['name']) AND $_POST['name'] !== ''){
                $name = $this->_getParam('name');
                $this->view->errName = '';
            } else {
                $name = '';
                $this->view->errName = "Veuillez entrer votre nom.";
            }
            if(isset($_POST['firstname']) AND $_POST['firstname'] !== ''){
                $firstname = $this->_getParam('firstname');
                $this->view->errFirstname = '';
            } else {
                $firstname = '';
                $this->view->errFirstname = "Veuillez entrer votre prénom.";
            }
            if(isset($_POST['login']) AND $_POST['login'] !== ''){
                $login = $this->_getParam('login');
                $this->view->errLogin = '';
            } else {
                $login = '';
                $this->view->errLogin = "Veuillez entrer votre pseudo.";
            }
            if(isset($_POST['email']) AND $_POST['email'] !== ''){
                $email = $this->_getParam('email');
                $this->view->errEmail = '';
            } else {
                $email = '';
                $this->view->errEmail = "Veuillez entrer votre email.";
            }
            if(isset($_POST['password']) AND $_POST['password'] !== ''){
                if($_POST['first-password'] === $_POST['password']){
                    $password = $this->_getParam('password');
                    $hash = md5($password);
                    $this->view->errPassword = '';
                } else {
                    $password = '';
                    $this->view->errPassword = "Veuillez entrer le même mot de passe.";    
                }
            } else {
                $password = '';
                $hash = md5($password);
                $this->view->errPassword = "Veuillez entrer votre mot de passe.";
            }

            if($_FILES['image']['name'] != ""){
                $titleimg = md5(uniqid(rand(), true));
                $extensions_valides = array('jpg', 'jpeg', 'gif', 'png');
                $extension_upload = strtolower(substr(strrchr($_FILES['image']['name'], '.'), 1));
                $titleimg = $titleimg.'.'.$extension_upload;
                Utils::upload('image', 'images/avatar/'.$titleimg, FALSE, false);
            } else {
                $titleimg = "default.jpg";
            }
            
            $user = new User();
            
            $params = [
                'name'=> $name,
                'firstname'=> $firstname,
                'login'=> $login,
                'email'=> $email,
                'password'=> $hash,
                'image'=> $titleimg,
            ];
            
            if($name != '' AND $firstname != '' AND $login != '' AND $email != '' AND $hash != '' AND $titleimg != ''){
                $err = "Une erreur est survenue, veuillez réessayer.";
                $success = "Votre inscription a bien été prise en compte !";
                Utils::displayMessage($user->save($params), $success, $err);
            }
        }
    }

    public function loginAction()
    {
        $login = $this->_getParam('login');
        $password = $this-> _getParam('password');

        if($login !='' && $password !=''){
            $user = new User();

            $loginAct = $user->signIn($login, $password);

            if($loginAct->id > 0){
                $_SESSION['user']['profil'] = $loginAct;
                $this->view->login = 1;
            } else {
                $this->view->login = false;
            }
        }
    }
    public function deconnectionAction()
    {
        unset($_SESSION['user']);
        unset($_SESSION['basket']);
    }

    public function basketAction()
    {
            $this->view->basket = $_SESSION['basket'];
    }
}
