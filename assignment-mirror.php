<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>For Hexile</title>
</head>

<body>

<?php
    error_reporting(E_ALL ^ E_WARNING); // Hide error message, it will be shown in the progress textarea

    function VerifyForm(&$values, &$errors) {
        // Do all necessary form verification
        if (strlen($values['text']) == 0) {
            if (strlen($values['delimiter']) == 0) {
                $errors = "Error: Input required!\nError: Delimiter required!";
            } else {
                $errors = 'Error: Input required!';
            }
        } else if (strlen($values['delimiter']) == 0) {
            $errors = 'Error: Delimiter required!';
        }
        else {
            $errors = 'Done!';
        }
        return (count($errors) == 0);
    }

    function DisplayForm($values, $errors) {
?>
        <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">
        <DIV STYLE="position: absolute; left:3%; top: 1%;">Input<br><textarea name="text" rows="5" cols="67"><?php echo htmlentities($values['text']); ?></textarea></DIV>
        <DIV STYLE="position: absolute; left:43%; top: 1%;">Delimiter<br><input name="delimiter" type="text" value="<?php echo htmlentities($values['delimiter']); ?>"/></DIV>
        <DIV STYLE="position: absolute; left:43%; top: 9%;"><input type="submit" name="submit"><input type="reset" name="reset"></DIV>
        </form>

        <DIV STYLE="position: absolute; left:43%; top: 24%;">Progress<br>
        <textarea disabled name="errorbox" rows="5" cols="67"><?php echo $errors; ?></textarea></DIV>

        <!-- Generated output -->
        <DIV STYLE="position: absolute; left:3%; top: 24%;">Output<br><textarea name="text" rows="5" cols="67">
<?php 
        error_reporting(E_ALL ^ E_NOTICE); // Hide error message, it will be shown in the progress textarea

        if ((strlen($values['text']) == 0) || (strlen($values['delimiter']) == 0)) {
            exit(0); // Output nothing except error message
        }

        str_replace("\r", "", $value['text']);
        $array = explode("\n", $values['text']);
        
        foreach ($array as $idx => $part) {
            $lines = explode($values['delimiter'], $array[$idx]);
			
			// update 2019 july 29 
			// quick and dirty fix
			
			// Could not get strpos to work, so we always modify the line, then we check for errors - This works, but might not be the best approach
			$result = str_replace(";", "", (trim($lines[1]) . $values['delimiter'] . trim($lines[0]))) . ";" . "\n";
			if($result[0] !== $values['delimiter']) // discard line modification if line shouldn't be edited. 
			{
				echo $result;
			}else{
				echo $lines[0];
			}
			
			
			/*
			old, 2011 may 3
			
			echo str_replace(";", "", (trim($lines[1]) . $values['delimiter'] . trim($lines[0]))) . ";" . "\n";
			*/
        }
    }

    function ProcessForm($values) {
        // Show input form again and the enterd text
        DisplayForm($values, null);
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $formValues = $_POST;
        $formErrors = array();

        if (!VerifyForm($formValues, $formErrors)) {
            DisplayForm($formValues, $formErrors);
        } else {
            ProcessForm($formValues);
        }
    } else {
        DisplayForm(null, null);
    }
?>
            </textarea>
        </div>
    </body>
</html>