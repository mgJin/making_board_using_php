
<html lang="en">
        <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Document</title>
        </head>
        <body>
                
                <?php
include('functions.php');
$input = file_get_contents("php://input");
parse_str($input,$result);

echo json_encode($result);
?>
                
                </body>
                </html>