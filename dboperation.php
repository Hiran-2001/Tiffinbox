<?php
class dboperation
{
    public $con,$res;
    function __construct()
    {
        $this->con=mysqli_connect("localhost","root","","db_bitebox");
        if(!$this->con){
            
            die("Connection failed:".mysqli_connect_error());
        }
    }
    public function executequery($sql)
    
    {
        $this->res=mysqli_query($this->con,$sql);
        return $this->res;
    }
    
    public function getConnection()
    {
        return $this->con;
    }


}
?>