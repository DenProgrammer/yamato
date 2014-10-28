<?php

class Report {

    protected $db;
    protected static $_instance;
    public $reportId;
    public $mk_start;
    public $mk_finish;

    private function __construct() {
        $this->db = JFactory::getDbo();

//        $this->db->setQuery("SET time_zone = 'Asia/Bishkek'");
        $this->db->query();
    }

    private function __clone() {
        
    }

    public static function getInstance() {
        if (!self::$_instance) {
            self::$_instance = new Report();
        }

        return self::$_instance;
    }

    public function init($type = 'all') {
        $request_data    = $_SERVER['QUERY_STRING'];
        $start_date_unix = time();

        $this->mk_start = microtime(true);

        $sql = "INSERT INTO `#__sincronise_report` (
					`start_date`, `type`, `request_data`, `start_date_unix`
					) VALUES (
					NOW(), '$type', '$request_data', '$start_date_unix')";
        $this->db->setQuery($sql);
        $this->db->query();

        $this->reportId = $this->db->insertid();
    }

    public function stop($result_data = null) {
        $finish_date_unix = time();
        $this->mk_finish  = microtime(true);

        $work_time = $this->mk_finish - $this->mk_start;

        $sql = "UPDATE `#__sincronise_report`
				SET `finish_date` = NOW(), `status` = 1, `finish_date_unix` = $finish_date_unix, 
				`result_data` = '$result_data', `work_time` = $work_time
				WHERE `id` = " . $this->reportId;
        $this->db->setQuery($sql);
        $this->db->query();
    }

}
