<?php 

/*
*   NONIMIZER Version 0.3
*   Author: florian kuhlmann
*   Webpage: floriankuhlmann.com
*   2016
*
*/

// just include one class with the NON compiler logic
include('lib/noncompiler.php');

// check and prepare the input data
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// simple check of display state
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $noninputtext = test_input($_POST['noninputtext']);
    $non = new noncompiler();

    // ok we check if we really git something
    if (isset($noninputtext) && !empty($noninputtext)) {
        $non->setInputText($noninputtext);
        $non->compileText();
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>
        the non machine
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <style>

        body {
            font-size: 16px;
            font-family: Arial, sans-serif;
        }

        .thenon {
            background-color: #000;
            color:#fff;
            padding:1rem;
            margin-bottom: 1rem;;
        }

        textarea {
            width:100%;
            height:400px;
            margin-bottom: 1rem;
        }

        @media screen and (max-width: 480px)  {
            textarea {
                width:100%;
                height:200px;
                margin-bottom: 1rem;
            }
        }

        .submitnon {
            font-size: 1rem;
            padding:0.5rem;
            margin:0.5rem;
        }

    </style>
</head>
<body>

<h1>the non machine - beta 0.3</h1>
<p>This tool compiles every information of your choice into pure non.</p>
<h3>Your source:</h3> 
    <form action="index.php" method="post" name="nonsrc">
        <pre>
            <textarea name="noninputtext" id="noninputtext">
            <?php
                // do we have some compiled Text?
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    echo $non->getInputText();
                } else {
                // of show just information
                    echo "Please input information. It will be compiled into non now.";
                }
            ?>
        </textarea>
    </pre>
    <input class="submitnon" type="submit" value="Nonifiy Sourcedata">
</form>


    <?php
    // just display the NON compiled Textdata
    if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($non->getCompiledText())) {
    ?>
        <br>
        <br>
        <h3>Compiled NON:</h3>
        <div class="thenon">
            <?php echo $non->getCompiledText();?>
        </div>
    <?php
    }
    ?>

</body>
</html>


