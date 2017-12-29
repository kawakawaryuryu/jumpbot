<?php

namespace TwitterBot\config;

class DBConfig {

     public static function getUser() {
         return getenv('MYSQL_USER');
     }

     public static function getPass() {
         return getenv('MYSQL_PASSWORD');
     }

     public static function getDatabase() {
         return getenv('MYSQL_DATABASE');
     }

     public static function getHost() {
         return getenv('MYSQL_HOST');
     }

     public static function getPort() {
         return getenv('MYSQL_PORT');
     }
}
