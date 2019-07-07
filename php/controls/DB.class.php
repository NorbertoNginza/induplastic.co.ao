<?php
  /**
   * Configurações e funcionalidades a respeitos do banco de dados do sistema da Monitoria
   ass.: Jéfter Lucas
   */

  // conexão Local 
  define( 'MYSQL_HOST', 'localhost' );
  define( 'MYSQL_USER', 'root' );
  define( 'MYSQL_PASSWORD', '' );
  define( 'MYSQL_DB_NAME', 'fabrica1' );

  // conexão no servidor 
  // define( 'MYSQL_HOST', 'localhost' );
  // define( 'MYSQL_USER', 'jefterlu_admin' );
  // define( 'MYSQL_PASSWORD', 'Desenv@123rz' );
  // define( 'MYSQL_DB_NAME', 'jefterlu_fabrica' );

  class Db{

    // function __construct(argument){
    //   $this->conectaMysql();
    //
    // }

    function __construct(){
      
    }

    public function getConection() {
      try {
          $conexao = new PDO('mysql:host='.MYSQL_HOST.';dbname='.MYSQL_DB_NAME.';charset=utf8', MYSQL_USER, MYSQL_PASSWORD);
          $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      } catch(PDOException $e) {
          return 'ERROR: ' . $e->getMessage();
      }

      return $conexao;
    }

    public function execSql($sql){
      try {
          $conn = $this->getConection();       
          $result = $conn->query($sql);

          $rows = $result->fetchAll();

          return $rows;

      } catch(PDOException $e) {
          return 'ERROR: ' . $e->getMessage();
      }

      return false;
    }

    public function execInsertUpdate($sql){
      try{
        $conn = $this->getConection(); 
        $result = $conn->query($sql);

        $count = $result->rowCount();

        if ($count > 0) {
            return 1;
        }

        return 47;

      } catch(PDOException $e) {
        // Dbug
        print_r($e->getMessage());
        return $e->getCode();
      }

      return false;

    } 

  }

?>