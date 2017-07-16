 <?php   
    $host="localhost";
    $username="akshay_baweja";
    $password="baweja9899";
    $database="twentyeight10_projects";
    $conn = mysqli_connect($host,$username,$password,$database);

	$method = $_SERVER['REQUEST_METHOD'];
	$data = explode('/', trim($_SERVER['PATH_INFO'],'/'));
    $request = $data[0];
    
    $returnJSON = Array();
    
    if($method=="POST"){
        switch($request){
            case 'user' : 
                $type = $_POST["type"];
                $email = $_POST["email"];
                $password = $_POST["password"];
                $sql = "SELECT token FROM rhok_users WHERE email='$email' AND password='$password' AND type='$type'";
                $result = mysqli_query($conn, $sql);
                if(mysqli_num_rows($result)>0){
                    $row = mysqli_fetch_array($result);
                    $returnJSON["response"] = "success";
                    $returnJSON["token"] = $row["token"];
                }
                else {
                    $returnJSON["response"] = "error";
                    $returnJSON["error_message"] = "Invalid User or Password";
                    echo "error bc";
                }
            break;
            case 'get' : 
                $token = $_POST["token"];
                $sql = "SELECT * FROM rhok WHERE token = $token";
                $result = mysqli_query($conn, $sql);
                if(mysqli_num_rows($result)>0){
                    $returnJSON["response"] = "success";
                    
                    $total_distance = 0;
                    $unpaid_distance = 0;
                    $paid = 0;
                    $carbon_footprint_multiplier = 0.0002691;
                    $amount_multiplier = 0.012322;

                    while ($row = mysqli_fetch_array($result)) {
                        $total_distance += $row["distance"];
                        if($row["paid"]==1)
                            $paid+=1;
                        else
                            $unpaid_distance += $row["distance"];
                    }
                       
                    $carbon_footprint = $total_distance * $carbon_footprint_multiplier;
                    $unpaid_amount = round($amount_multiplier * $unpaid_distance,2);
                    $total_amount = round($amount_multiplier * $total_distance,2)-$unpaid_amount;
                    $total_trips=mysqli_num_rows($result);

                    $returnJSON["total_distance"] = $total_distance;
                    $returnJSON["unpaid_distance"] = $unpaid_distance;
                    $returnJSON["carbon_footprint"] = $carbon_footprint;
                    $returnJSON["total_amount"] = $total_amount;
                    $returnJSON["unpaid_amount"] = $unpaid_amount;
                    $returnJSON["total_trips"] = $total_trips;
                    $returnJSON["unpaid_trips"] = $total_trips - $paid;
                }
                else {
                    $returnJSON["response"] = "error";
                    $returnJSON["error_message"] = "Invalid Token";
                }
            break;
            case 'donate':
                $token = $_POST["token"];
                $sql = "UPDATE rhok SET paid=1 WHERE token=$token";
                if (mysqli_query($conn, $sql)) {
                    $returnJSON["response"] = "success";
                } else {
                    $returnJSON["response"] = "error";
                    $returnJSON["error_message"] = mysqli_error($conn);
                }
            break;
        }
        header("Content-Type: application/json");
        echo json_encode($returnJSON);
    }
?>