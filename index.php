<!DOCTYPE html>
<html lang="cz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Commit message parser</title>
</head>
<body>
<?php
    require_once('CommitMessageParser.php');
    // form na vlkádání commit logu
    echo "<form method='post'>";
    echo "<textarea name='commit_message' style='width:600px; height:200px;'></textarea><br>";
    echo "<button type='submit'>parse</button>";
    echo "</form><br>";    

    // výpis po odeslání formu
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $commit_message = $_POST['commit_message'];
        $commit1 = new CommitMessageParser();
        $c1 = $commit1->Parse($commit_message);

        if ($c1->formatSatus()) {        
            echo "<strong>Full commit log:</strong> <br>".$commit_message."<br><br>";
                
            echo "<strong>Title:</strong> ".$c1->GetTitle();
            echo "<br>";
            
            echo "<strong>id:</strong> ".$c1->GetTaskId();
            echo "<br>";    

            $tags = $c1->GetTags();
            echo "<strong>Tags:</strong> ";
            foreach ($tags as $tag) {        
                echo $tag.", ";           
            }
            echo "<br>";

            $details = $c1->GetDetails();
            echo "<strong>Details:</strong> <br>";
            foreach ($details as $detail) {        
                echo "     ".$detail."<br>";           
            }
            
            $bcBreaks = $c1->GetBCBreaks();
            echo "<strong>BC breaks:</strong> <br>";
            foreach ($bcBreaks as $bc) {        
                echo "     ".$bc."<br>";           
            }
            
            $features = $c1->GetFeatures();
            echo "<strong>Features:</strong> <br>";
            foreach ($features as $feature) {        
                echo "     ".$feature."<br>";           
            }
            
            $todos = $c1->GetTodos();
            echo "<strong>Todos:</strong> <br>";
            foreach ($todos as $todo) {        
                echo "     ".$todo."<br>";           
            }
        } else {
            echo "Formát commit logu je ve špatném formátu!";
        }
    }
?>
</body>
</html>
