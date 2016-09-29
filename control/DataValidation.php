<?php
namespace control;
/**
 * Created by PhpStorm.
 * User: t.ahmadian
 * Date: 9/28/2016
 * Time: 12:20 PM
 */
class DataValidation
{
    public function GeneralValidation($param,$pm){
        foreach($param as $key=>$val)
        {
            switch ($key){
                case 'name':
                    $this->checkNameValidity($val);
                    break;
                case 'email':
                    $this->checkEmailValidity($val);
                    break;
                case 'password':
                    $this->checkPasswordValidity($val);
                    break;
                case 'gender':
                    $this->checkGenderValidity($val);
                    break;
                case 'url':
                    $this->checkURLValidity($val);
                    break;
                case 'population':
                    $this->checkPopulationValidity($val);
                    break;
                case 'mobilenumber':
                    $this->checkMobileValidity($val);
                    break;
                case 'phonenumber':
                    $this->checkPhoneNumberValidity($val);
                    break;
                case 'address':
                    $this->checkAddressValidity($val);
                    break;
                case 'businessname':
                    $this->checkBusinessNameValidity($val);
                    break;
                case 'region':
                    $this->checkRegionValidity($val);
                    break;
                case 'city':
                    $this->checkCityValidity($val);
                    break;
                case 'state':
                    $this->checkStateValidity($val);
                    break;
                case 'category':
                    $this->checkCategoryValidity($val);
                    break;
            }
        }


    }

    public function checkPasswordValidity($pass,$pm){
        if(strlen(($pass))<8){
            $pm->show("your url address is very long!");
        }
    }

    public function checkGenderValidity($gender,$pm){

    }


    public function checkURLValidity($url,$pm){
        if(strlen(($url))>1000){
            $pm->show("your url address is very long!");
        }

    }

    public function checkPopulationValidity($pop,$pm){
        if(!is_numeric($pop)){
            $pm->show("variable that present population is not a number!");
        }
        $length = ceil(log10($pop));
        if($length>7){
            $pm->show("population number is very big!");
        }
    }



    public function checkBusinessNameValidity($businessname,$pm){

    }


    public function checkRegionValidity($region,$pm){

    }

    public function checkCityValidity($city,$pm){

    }

    public function checkStateValidity($state,$pm){

    }


    public function checkCategoryValidity($category,$pm){

    }

    public function checkNameValidity($name,$pm){

    }
    public function checkAreaCodeValidity($name,$pm){

    }
    public function checkEmailValidity($name,$pm){

    }
    public function checkAddressValidity($name,$pm){

    }
    public function checkPhoneNumber1Validity($phone,$pm){
        if(is_numeric(substr($phone,0,8))){
            if (strlen($phone) == 8) {
                if (substr($phone, 0, 1) == '0') {
                    $pm = new generate_message();
                    $pm->show("phonenumber should not start with 0 digit!");
                }
            } else {
                $pm = new generate_message();
                $pm->show("digits number of phonenumber must be 8!");
            }
        }
        else{
            $pm = new generate_message();
            $pm->show("phonenumber must have digit characters!");
        }

    }
    public function checkPhoneNumber2Validity($phone,$pm){
        if(is_numeric(substr($phone,0,10))){
            if (strlen($phone) == 11) {
                if (substr($phone, 0, 2) != '09') {
                    $pm = new generate_message();
                    $pm->show("prefix of phonenumber is wrong!");
                }
            } else {
                $pm = new generate_message();
                $pm->show("digits number of phonenumber must be 11!");
            }
        }
        else{
            $pm = new generate_message();
            $pm->show("phonenumber must have digit characters!");
        }

    }
    public function checkMobileValidity($phone,$pm){
        if(is_numeric(substr($phone,1,10))){
            if (strlen($phone) == 11) {
                if (substr($phone, 0, 2) != '09') {
                    $pm = new generate_message();
                    $pm->show("prefix of phonenumber is wrong!");
                }
            } else {
                $pm = new generate_message();
                $pm->show("digits number of phonenumber must be 11!");
            }
        }
        else{
                $pm = new generate_message();
                $pm->show("phonenumber must have digit characters!");
            }
    }
    public function checkIdValidity($id,$pm){
        if(is_numeric($id)){
            return true;
        }
        else{
            return false;
        }
    }
}