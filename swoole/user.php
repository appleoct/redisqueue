<?php
class user
{
    public $user =array();
    
    private static $instance;
    
    /**
     * @return user
     */
    public static function getInstance()
    {
        if(!isset(self::$instance))
        {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    public function getAll(){
        return $this->user;
    }
    
    public function set($key,$value){
        $this->user[$key] = $value;
    }
    
    public function del($key){
        unset($this->user[$key]);
    }
    
    public function get($key)
    {
        return $this->user[$key];
    }
    
    public function getAllnickname()
    {
        $new_array = array();
        foreach ($this->user as $k => $va)
        {
            array_push($new_array, $va['nickname']);
        }
        
        return $new_array;
    }
}