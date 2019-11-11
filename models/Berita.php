<?php 
  class Berita {
    // DB stuff
    private $conn;
    private $table = 'berita';

    // Atribut
    public $header;
    public $ringkasan;
    public $sumber;
    public $tanggal;
    public $link;
	public $id;

    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }

    // Get ALL News
    public function all_news() {
      $query = 'SELECT *
                FROM ' . $this->table .'
                ORDER BY tanggal DESC';

      $stmt = $this->conn->prepare($query);

      // Execute query
      $stmt->execute();

      return $stmt;
    }

	// Get News by date
    public function news_by_date() {
          // Create query
          $query = 'SELECT *
                    FROM ' . $this->table . ' 
                    WHERE tanggal = ?
					ORDER BY tanggal DESC';

          // Prepare statement
          $stmt = $this->conn->prepare($query);

          // Bind ID
          $stmt->bindParam(1, $this->tanggal);

          // Execute query
          $stmt->execute();
		  
		  return $stmt;
    }
	
	// Get News by Source
    public function news_by_source() {
          // Create query
          $query = 'SELECT *
                    FROM ' . $this->table . ' 
                    WHERE sumber = ?
					ORDER BY tanggal DESC';

          // Prepare statement
          $stmt = $this->conn->prepare($query);

          // Bind ID
          $stmt->bindParam(1, $this->sumber);

          // Execute query
          $stmt->execute();
		  
		  return $stmt;
    }
	
  }