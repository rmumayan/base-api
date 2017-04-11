<?php
class UserModel{
    private $db;
    private $id;
    private $username;
    private $password;
    private $fname;
    private $mname;
    private $lname;
    private $user_role_id;
    private $user_status_id;
    private $department_id;
    private $params;
    private $query_fields = array('id','fname','mname','lname','department_id','department_name','campus_id','campus_name','role_id');
    private $valid_columns = array(
                                'id' => 'user.id',
                                'fname' => 'user.fname',
                                'mname' => 'user.mname',
                                'lname' => 'user.lname',
                                'department_id' => 'user.department_id',
                                'department_name' =>  'department.name',
                                'campus_id' => 'campus.id',
                                'campus_name' =>  'campus.name',
                                'role_id' => 'user.user_role_id'
                            );



    public static $default_password = '123456789';

    public function __construct(){
        $this->db = new Database();
    }

    public function Set_id($val){
        $this->id = $val;
    }
    public function Set_username($val){
        $this->username = $val;
    }
    public function Set_password($val){
        $this->password = $val;
    }
    public function Set_user_role_id($val){
        $role = new User_role();
        $role->Set_id($val);
        if (!$role->Is_role_exist()) {
            throw new Exception("Role does not exist");
        }
        $this->user_role_id = $val;
    }
    public function Set_user_status_id($val){
        $status = new User_status();
        $status->Set_id($val);
        if ($status->Is_status_exist()) {
            throw new Exception("Status does not exist");
        }
        $this->user_status_id = $val;
    }
    public function Set_fname($val){
        $this->fname = $val;
    }
    public function Set_mname($val){
        $this->mname = $val;
    }
    public function Set_lname($val){
        $this->lname = $val;
    }
    public function Set_department_id($val){
        $this->department_id = $val;
    }

    public function query($params = []){
        $sql = $this->_generate_sql();
        $st = $this->db->prepare($sql);
        $st->execute();
        $data = array(
            'data' =>  $st->fetchAll(PDO::FETCH_ASSOC),
            'count' => $st->rowCount()
        );
        return $data;
    }


    private function _generate_sql(){
        $this->_set_query_fields();
        $sql = 'SELECT '.$this->_select_tables().' 
                FROM user 
                LEFT JOIN department ON user.department_id=department.id
                LEFT JOIN campus ON department.campus_id=campus.id
                WHERE 1 = 1'; 
        $sql .= $this->_generate_where_clause();
        return $sql;
    }








    private function _set_query_fields(){
        if(!isset($_GET['fields'])) return;
        $fields = rtrim($_GET['fields'],',');
        $this->query_fields = explode(',',filter_var($fields,FILTER_SANITIZE_URL));
    }

    private function _generate_where_clause(){
        $add_to_where = [];
        foreach ($_GET as $get => $value) { 
            if($this->_isValidColumn($get)) $add_to_where[] = array('field'=>$get, 'value'=>$value); 
        }

        if(!$add_to_where) return;

        $where_clause = '';
        for ($i=0; $i < count($add_to_where) ; $i++) { 
            $where_clause .= " AND ".$add_to_where[$i]['field']." LIKE '%".$add_to_where[$i]['value']."%'";
        }
        return $where_clause;

    }

    private function _select_tables(){
        $selected_columns = "";
        for ($i=0; $i < count($this->query_fields); $i++) { 
            $db_column_name = $this->_aliasToColumn($this->query_fields[$i]);
            if(!$db_column_name) continue;
            $selected_columns .= $selected_columns ? ', ' : '';
            $selected_columns .=  $db_column_name .' as '. $this->query_fields[$i];
        }
        return $selected_columns;
    }


    private function _isValidColumn($alias){
        if(!array_key_exists($alias,$this->valid_columns)) return false;
        return true;
    }


    private function _aliasToColumn($alias){
        if(!$this->_isValidColumn($alias)) throw new RequestException("Invalid field name '$alias'", 400);
        return $this->valid_columns[$alias];
    }





    public static function GetById($account_id){
        $db = new Database();
        $sql = 'SELECT user.id as id,
                    user.fname as fname,
                    user.mname as mname,
                    user.lname as lname,
                    user.department_id as department_id,
                    department.name as department_name,
                    campus.id as campus_id,
                    campus.name as campus_name,
                    user.user_role_id
                FROM user 
                LEFT JOIN department ON user.department_id=department.id
                LEFT JOIN campus ON department.campus_id=campus.id
                WHERE user.id = :id';
        $st = $db->prepare($sql);
        $st->execute(array(':id'=>$account_id));
        return $st->fetch(PDO::FETCH_ASSOC);
	}
}