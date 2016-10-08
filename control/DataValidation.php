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
    /*
     * this function gets an array and check validity of values for every keys
     */
    public function GeneralValidation($param,$msg){
        $output="true";
        foreach($param as $key=>$val)
        {
            switch ($key){
                case 'name':
                    if($this->checkNameValidity($val,$msg)){
                    }
                    else{
                        $output="false";
                    }
                    break;
                case 'description':
                    if($this->checkDescriptionValidity($val,$msg)){
                    }
                    else{
                        $output="false";
                    }
                    break;
                case 'username':
                    if($this->checkUserNameValidity($val,$msg)){}
                    else{
                        $output="false";
                    }
                    break;
                case 'email':
                    if( $this->checkEmailValidity($val,$msg)){}
                    else{
                        $output="false";
                    }
                    break;
                case 'password':
                    if( $this->checkPasswordValidity($val,$msg)){}
                    else{
                        $output="false";
                    }
                    break;
                case 'gender':
                    if($this->checkGenderValidity($val,$msg)){}
                    else{
                        $output="false";
                    }
                    break;
                case 'url':
                    if($this->checkURLValidity($val,$msg)){}
                    else{
                        $output="false";
                    }
                    break;
                case 'population':
                    if($this->checkPopulationValidity($val,$msg)){}
                    else{
                        $output="false";
                    }
                    break;
                case 'mobilenumber':
                    if($this->checkMobileValidity($val,$msg)){}
                    else{
                        $output="false";
                    }
                    break;
                case 'phonenumber':
                    if($this->checkPhoneNumber1Validity($val,$msg)){}
                    else{
                        $output="false";
                    }
                    break;
                case 'address':
                    if($this->checkAddressValidity($val,$msg)){}
                    else{
                        $output="false";
                    }
                    break;
                case 'businessname':
                    if($this->checkBusinessNameValidity($val,$msg)){}
                    else{
                        $output="false";
                    }
                    break;
                case 'region':
                    if($this->checkRegionValidity($val,$msg)){}
                    else{
                        $output="false";
                    }
                    break;
                case 'city':
                    if($this->checkCityValidity($val,$msg)){}
                    else{
                        $output="false";
                    }
                    break;
                case 'state':
                    if($this->checkStateValidity($val,$msg)){}
                    else{
                        $output="false";
                    }
                    break;
                case 'category':
                    if($this->checkCategoryValidity($val,$msg)){}
                    else{
                        $output="false";
                    }
                    break;
            }
        }
        if($output=="true")
            return true;
        else
            return false;

    }


    /*
         * check password validity
         * password must be equals or biger than 8 characters
         * password is necessary always
         */
    public function checkDescriptionValidity($desc,$msg){
        if(strlen(($desc))>1000){
            $msg->show("your description is so long!");
            return false;
        }
        return true;
    }




    /*
     * check password validity
     * password must be equals or biger than 8 characters
     * password is necessary always
     */
    public function checkPasswordValidity($pass,$msg){
        if(strlen(($pass))<8){
            $msg->show("your password is small, must be bigger than 8 characters!");
            return false;
        }
        return true;
    }

    /*
     * check gender validity
     * gender must be number, 0 or 1
     * gender is optional
     */
    public function checkGenderValidity($gender,$msg){
        if($gender==null)
            return true;
        if($gender==0 || $gender==1){
            return true;
        }
        else{
            $msg->show("your gender is wrong!");
            return false;
        }

    }


    /*
     * check URL validity
     * URL must be less than 1001 characters
     */
    public function checkURLValidity($url,$msg){
        if(strlen(($url))>1000){
            $msg->show("your url address is very long!");
            return false;
        }
        return true;
    }

    /*
     * check population validity
     * population must be number with at last 7 digit.
     */
    public function checkPopulationValidity($pop,$msg){
        if(!is_numeric($pop)){
            $msg->show("variable that present population is not a number!");
            return false;
        }
        $length = ceil(log10($pop));
        if($length>7){
            $msg->show("population number is very big!");
            return false;
        }
        return true;
    }



    /*
     * check business name validity
     * business name must be combination of numbers and letters and space
     *
     */
    public function checkBusinessNameValidity($businessname,$msg){
        if(strlen($businessname)>50){
            $msg->show("your business name is very long!");
            return false;
        }
        else{
            //for($i=0;$i<50;$i++){
                //$chr=substr($businessname,$i,1);
                //if(ord($chr<48)||ord($chr>122)||((ord($chr)>57)&&(ord($chr)<65))||((ord($chr)>90)&&(ord($chr)<97))){
                 //   $msg->show("your business name must have alphabet and number characters!");
                 //   return false;
               // }
            if (!preg_match("/^[a-zA-Z0-9 ]*$/",$businessname)) {
                $msg->show("your business name must have alphabet and number characters!");
                return false;
            }
        }
            return true;

    }


    /*
     * check region validity
     * region must be a number
     * region is optional
     */
    public function checkRegionValidity($region,$msg){
        if($region==null)
            return true;
        if(is_numeric($region)){
            return true;
        }
        else{
            $msg = new generate_message();
            $msg->show("region value must be number!");
            return false;
        }
    }

    /*
     * check city validity
     * city must be a number
     * city is optional
     */
    public function checkCityValidity($city,$msg){
        if($city==null)
            return true;
        if(is_numeric($city)){
            return true;
        }
        else{
            $msg = new generate_message();
            $msg->show("city value must be number!");
            return false;
        }
    }

    /*
     * check state validity
     * state must be a number
     * state is optional
     */
    public function checkStateValidity($state,$msg){
        if($state==null)
            return true;
        if(is_numeric($state)){
            return true;
        }
        else{
            $msg = new generate_message();
            $msg->show("state value must be number!");
            return false;
        }
    }


    /*
     * check category validity
     * category must be a number
     */
    public function checkCategoryValidity($category,$msg){
        if(is_numeric($category)){
            return true;
        }
        else{
            $msg = new generate_message();
            $msg->show("category value must be number!");
            return false;
        }

    }
    /*
     * check username validity
     * username must be combination of letters and space
     *
     *
     */
    public function checkUserNameValidity($username,$msg){
       // echo "check username </br>";
        if(strlen($username)>50){
            $msg->show("your name is very long!");
           // echo "false </br>";
            return false;
        }
        else{
            if (!preg_match("/^[a-zA-Z ]*$/",$username)) {
                $msg->show("for name Only letters and white space allowed!");
                echo "false </br>";
                return false;
            }
        //    echo "true </br>";
            return true;
        }

    }

    /*
     * check name validity
     */
    public function checkNameValidity($name,$msg){
        if(strlen($name)>50){
            $msg->show("your name is very long!");
            return false;
        }
        else{
            if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
                $msg->show("for name Only letters and white space allowed!");
                return false;
            }
            return true;
        }

    }
    /*
     * check area code validity
     */
    public function checkAreaCodeValidity($phone,$msg){
      if(substr($phone , 0,1)=="+"){
          $length = length($phone);
          if(is_numeric(substr($phone,1,$length-1))){
              if(strlen($phone)>=2 && strlen($phone)<=4){
                  return true;
              }
              else{
                  $msg->show("area code must be between 2 and 4 characters!");
                  return false;
              }
          }
          else{
              $msg->show("area code must have digit characters that start with + characters!");
              return false;
          }
      }
      else{
            $msg->show("area code must  start with + character!");
            return false;
        }
    }
    /*
     * check email validity
     */
    public function checkEmailValidity($email,$msg){
        if($email==null)
            return true;
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $msg->show("invalid email format!");
            return false;
        }
        return true;

    }
    /*
     * check address validity
     */
    public function checkAddressValidity($address,$msg){
        if($address==null)
            return true;
        $arr1 = str_split($address);
        foreach($arr1 as $key=>$val){
            if($val=='@'||$val=='%'||$val=='_'||$val=='\''||$val=='"'||$val==';'||$val==':'){
                $msg->show("address include illegal special characters!");
                return false;
            }
        }
        return true;
    }
    /*
     * check phone number validity(home phone)(only 8 characters)
     */
    public function checkPhoneNumber1Validity($phone,$msg){
        if(strlen($phone)==8){
        if(is_numeric(substr($phone,0,8))){
                if (substr($phone, 0, 1) == '0' ||substr($phone, 0, 1) == '1') {
                    $msg->show("phonenumber should not start with 0 or 1 digits!");
                    return false;
                }
            } else {
                $msg->show("phonenumber must have digit characters!");
                return false;
            }
        }
        else{
            $msg->show("digit numbers of phonenumber must be 8!");
            return false;
        }
        return true;

    }
    /*
     * check phone number validity(home number)(special numbers)(between 3 - 8 characters)
     */
    public function checkPhoneNumber2Validity($phone,$msg){
        if(is_numeric(substr($phone,0,strlen($phone)))){
            if ((strlen($phone) >=3) && (strlen($phone) <=8 ) ) {
                if (substr($phone, 0, 1) == '0'||substr($phone, 0, 1) == '1') {
                    $msg->show("phonenumber should not start with 0 or 1 digits!");
                    return false;
                }
            } else {
                $msg->show("digit numbers of phonenumber must be between 3 and 8!");
                return false;
            }
        }
        else{
            $msg = new generate_message();
            $msg->show("phonenumber must have digit characters!");
            return false;
        }
        return true;

    }
    /*
     * check mobile validity
     */
    public function checkMobileValidity($phone,$msg){
        if($phone==""){
            return true;
        }
        if(is_numeric(substr($phone,1,10))){
            if (strlen($phone) == 11) {
                if (substr($phone, 0, 2) != '09') {
                    $msg = new generate_message();
                    $msg->show("prefix of phonenumber is wrong!");
                    return false;
                }
            } else {
                $msg = new generate_message();
                $msg->show("digits number of phonenumber must be 11!");
                return false;
            }
        }
        else{
            $msg = new generate_message();
            $msg->show("phonenumber must have digit characters!");
            return false;
            }
            return true;
    }
    /*
     * check id validity
     */
    public function checkIdValidity($id,$msg){
        if(is_numeric($id)){
            return true;
        }
        else{
            $msg->show("id must be a number!");
            return false;
        }
    }
}