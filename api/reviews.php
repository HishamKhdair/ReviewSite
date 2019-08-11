<?php

// The definition of Database class dealing with Raccoon and Review data table 

class ReviewDataBase {

    private static $conn ;

    public function Connect() {
        // Create connection to the review database
        $conn = new mysqli("localhost", "root", "", "raccoon");
        // Check connection and display the error message
        if ($conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function Disconnect() {
	 $conn = new mysqli("localhost", "root", "", "raccoon");
        // Check connection and display the error message
        if ($conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
        $conn->close();
    }

    public function Select($id = null) {
        if ($id === null) {
            $sql = "select r.id, r.name, r.Image_url, avg(e.rating) as RaccoonRating from raccoon as r inner join review as e on r.id=e.raccoon_id group by r.id";
			
         $conn = new mysqli("localhost", "root", "", "raccoon");
        // Check connection and display the error message
        if ($conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
        $result = $conn->query($sql);

        //define an array of raccoons
        $raccoon = array();
        if ($result->num_rows > 0) 
			{
            // output data of each row
            while ($row = $result->fetch_assoc()) {
			$raccoon[] = ["id" => $row["id"], "name" => $row["name"], "image" => $row["Image_url"], "rating" =>$row["RaccoonRating"]];
            }

            return $raccoon;
			} 
		else 
			{
				echo "0 results";
			}
		
		
		} 
		
		
		else {
            $sql = "select raccoon.id as id, raccoon.name as name, raccoon.image_url as image, avg(review.rating) as RaccoonRating from raccoon inner join review on raccoon.id=review.raccoon_id where review.raccoon_id=" . $id;
       
			$conn = new mysqli("localhost", "root", "", "raccoon");
        // Check connection and display the error message
        if ($conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
        $result = $conn->query($sql);

        //define an array of raccoons
        $raccoon = array();
        if ($result->num_rows > 0) 
			{
            // output data of each row
            while ($row = $result->fetch_assoc()) {
			$raccoon[] = ["id" => $row["id"], "name" => $row["name"], "image" => $row["image"], "rating" =>$row["RaccoonRating"]];
            }

            return $raccoon;
			} 
		else 
			{
				echo "0 results";
			}


	   }	
	}

    public function Insert($id,$name,$review, $rating) {
        $sql = "INSERT INTO review(raccoon_id, reviewer_name, review, rating) VALUES ('" . $id . "', '" . $name . "','" . $review . "','" . $rating . "')";
		 $conn = new mysqli("localhost", "root", "", "raccoon");
        // Check connection and display the error message
        if ($conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $this->conn->error;
        }
    }

    public function Update($reviewId, $review, $rating) {
		// Create connection
		$conn = new mysqli("localhost", "root", "", "raccoon");
        // Check connection and display the error message
        if ($conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
        $sql = "UPDATE review SET review = '" . $review . "', rating = '" . $rating . "' WHERE review.id =" . $reviewId;

        if ($conn->query($sql) === TRUE) {
            echo "Record updated successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $this->conn->error;
        }
    }

    public function Delete($id) {
		// Create connection
		$conn = new mysqli("localhost", "root", "", "raccoon");
        // Check connection and display the error message
        if ($conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }

		
		$sql = "DELETE FROM review WHERE id=".$id;

		if ($conn->query($sql) === TRUE) {
		echo "Record deleted successfully";
		} else {
		echo "Error deleting record: " . $conn->error;
	}
    
    }

}
?>
