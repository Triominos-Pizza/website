<?php
    require(FTP_ROOT_PATH . "/models/admin/stats.php");
    class_exists('controllerObjet') ? null : require(FTP_ROOT_PATH . "/controllers/controllerObjet.php");

    class controllerStats extends controllerObjet {
        public function __construct() {
            parent::__construct();
        }

        public static function showCA($type='m', $year=null, $month=null, $day=null) {
            if (is_null($month)) { $month = date("m"); }
            if (is_null($year)) { $year = date("Y"); }

            switch ($type) {
                case 'j':
                    $CA = Stats::getCAJournalier($year, $month, $day);
                    break;
                case 's':
                    $CA = Stats::getCAHebdomadaire($year, $month);
                    break;
                case 'm':
                    $CA = Stats::getCAMensuel($month, $year);
                    break;
                case 'a':
                    $CA = Stats::getCAAnnuel($year);
                    break;
                case 't':
                    $CA = Stats::getCAtotal();
                    break;
                default:
                    $CA = 0;
                    break;
            }

            echo $CA . " €";
        }
        
        public static function showCAJournalier($year=null, $month=null, $day=null) {
            static::showCA('j', $year, $month, $day);
        }

        public static function showCAHebdomadaire($year=null, $month=null, $day=null) {
            static::showCA('s', $year, $month, $day);
        }
            
        public static function showCAMensuel($year=null, $month=null) {
            static::showCA('m', $year, $month);
        }
            
        public static function showCAAnnuel($year=null) {
            static::showCA('a', $year, null);
        }

        public static function showCAtotal() {
            static::showCA('t');
        }
    }
?>
