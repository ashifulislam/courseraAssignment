<?php
    session_start();

$user_id=$_SESSION['user_id'];

?>

<?php
    try{
        //Need to make a connection
        $con=new PDO("mysql:host=localhost;dbname=courseraassignment","root","");
        //You need to submit first the form
        if(isset($_POST['email'])){
            //Fetch the value from the input field
         $firstName=htmlentities($_POST['first_name']);
         $lastName=htmlentities($_POST['last_name']);
         $email=htmlentities($_POST['email']);
         $headline=htmlentities($_POST['headline']);
         $summary=htmlentities($_POST['summary']);


            if(empty($firstName) || empty($lastName) || empty($email) || empty($headline) || empty($summary)){
                $all_error="All fields are required";
                if (!strpos($email, "@") === true) {
                    $email_sign_error='Email address must contain @';
                }

            }



//...
            else {


                //To create an insert query
                $insert=$con->prepare("insert into profile(user_id,first_name,last_name,email,headline,summary)
            values(:user_id,:firstName,:lastName,:email,:headline,:summary)");
                //Here we need to bind those variable for storing value into the database
                $insert->bindParam(':user_id',$user_id);
                $insert->bindParam(':firstName',$firstName);
                $insert->bindParam(':lastName',$lastName);
                $insert->bindParam(':email',$email);
                $insert->bindParam(':headline',$headline);
                $insert->bindParam(':summary',$summary);
                //Now need to execute the operation
                $insert->execute();

                $_SESSION['profile_addition']='Profile added';
                header("location:index.php");


            }







            }









    }catch(PDOException $e){
        echo "error".$e->getMessage();
    }

?>
<!DOCTYPE html>
<html>
<head>
    <title>Ashiful Islam Prince</title>
    <!-- bootstrap.php - this is HTML -->

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet"
          href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
          integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7"
          crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet"
          href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css"
          integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r"
          crossorigin="anonymous">
    <script
            src="https://code.jquery.com/jquery-3.2.1.js"
            integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE="
            crossorigin="anonymous"></script>

</head>
<body>
<div class="container">


    <h1>Adding Profile for UMSI</h1>
    <?php

       if(isset($all_error)){
           echo '<span class="text-danger">';


            echo $all_error;



  echo  '</span>';
      }

    ?>
    <form id="add_post" method="post" action="add.php">
        <p>First Name:
            <input type="text" name="first_name" size="60"/></p><br>

        <p>Last Name:
            <input type="text" name="last_name" size="60"/></p>

        <p>Email:
            <input type="text" name="email" size="30"/></p><br>
            <span class="text-danger">
                <?php
                if(isset($email_sign_error))
                   echo $email_sign_error;
                ?>
            </span>


        <p>Headline:<br/>
            <input type="text" name="headline" size="80"/></p>


        <p>Summary:<br/>
            <textarea name="summary" rows="8" cols="80"></textarea></p>
        <p>Position : <input type="submit"  class="add_position" id="add_position" name="addPos" value="+">
           <div class="position_fields" id="position_fields">

           </div>
        </p>

        <p>
            <input type="submit" id="add_button" value="Add">
            <input type="submit" name="cancel" value="Cancel">
        </p>


    </form>
</div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        var max_field=9;//I restrict that how many times you are eligible to give input
        var add_button=$('#add_position');
        var wrapper=$('#position_fields');
        //How many field i need to add when click on the position
        var field_html='<div>' +
            ' <p>Year: <input type="text" name="year" value="" />&nbsp;' +
            '<input type="button" value="-"></p>' +
            '<textarea name="pos_details" rows="8" cols="80"></textarea></div>';
        var initial_input_field=1;
        $(add_button).click(function(event){
            event.preventDefault();
            if(initial_input_field<max_field){
                initial_input_field++;//increment initial input field
                $(wrapper).append(field_html);
            }
        });

    });
</script>

</body>
</html>
