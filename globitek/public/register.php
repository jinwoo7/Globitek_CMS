<?php
  require_once('../private/initialize.php');

  // Set default values for all variables the page needs.

  // if this is a POST request, process the form
  // Hint: private/functions.php can help

    // Confirm that POST values are present before accessing them.

    // Perform Validations
    // Hint: Write these in private/validation_functions.php

    // if there were no errors, submit data to database

      // Write SQL INSERT statement
      // $sql = "";

      // For INSERT statments, $result is just true/false
      // $result = db_query($db, $sql);
      // if($result) {
      //   db_close($db);

      //   TODO redirect user to success page

      // } else {
      //   // The SQL INSERT statement failed.
      //   // Just show the error, not the form
      //   echo db_error($db);
      //   db_close($db);
      //   exit;
      // }

?>

<?php $page_title = 'Register'; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<div id="main-content">
    <h1>Register</h1>
    <p>Register to become a Globitek Partner.</p>
    
    <?php
        $firstname  = isset($_POST['firstname'])    ? $_POST['firstname']   : '';
        $lastname   = isset($_POST['lastname'])     ? $_POST['lastname']    : '';
        $email      = isset($_POST['email'])        ? $_POST['email']       : '';
        $username   = isset($_POST['username'])     ? $_POST['username']    : '';
        if (is_post_request()) {            
            $inputs     = array($firstname, $lastname, $email, $username);
            $errors     = array();
            
            // validate inputs
            for ($x = 0; $x < 4; $x++) {
                $temp = input_check($inputs[$x], $x);
                
                // unique username check
                if ($x == 2 && $temp == 'null') {
                    $sql = "SELECT * FROM users WHERE username='" . $username . "';";
                    $query_result = db_query($db, $sql);
                    if (db_num_rows($query_result) > 0) {
                        $temp = "Username alreay taken, try another one!";
                    }
                }
                
                if ($temp != 'null'){
                    $errors[] = $temp;
                }
            }
            
            // redirect or nah
            if (count($errors) == 0) {
                // Write SQL INSERT statement
                 $sql = "INSERT INTO users (first_name, last_name, email, username, created_at) VALUES ('" . 
                     htmlentities($firstname) . "', '" . 
                     htmlentities($lastname) . "', '" . 
                     htmlentities($email) . "', '" . 
                     htmlentities($username) . "', '" . 
                     date("Y-m-d H:i:s") . "')";

                // For INSERT statments, $result is just true/false
                 $result = db_query($db, $sql);
                 if($result) {
                    db_close($db);

                    redirect_to('http://week1/globitek/public/registration_success.php');

                 } else {
                   // The SQL INSERT statement failed.
                   // Just show the error, not the form
                   echo db_error($db);
                   db_close($db);
                   exit;
                 }
                
            } else {
                echo display_errors($errors);
            }
        }
    ?>
    
    <form method="post" action="register.php">
        <p class="textFields">First name:</p>
        <input type="text" name="firstname" placeholder="John" value="<?php echo htmlentities($firstname) ?>">
        <p class="textFields">Last name:</p>
        <input type="text" name="lastname" placeholder="Doe" value="<?php echo htmlentities($lastname) ?>">
        <p class="textFields">Email:</p>
        <input type="text" name="email" placeholder="example@gmail.com" value="<?php echo htmlentities($email) ?>">
        <p class="textFields">Username:</p>
        <input type="text" name="username" placeholder="Username123" value="<?php echo htmlentities($username) ?>"></br>
        <input class="submit" type="submit" name="submit">
    </form>

    

  <!-- TODO: HTML form goes here -->

</div>

<?php include(SHARED_PATH . '/footer.php'); ?>
