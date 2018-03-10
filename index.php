<!DOCTYPE html>
<html>
    <head>
        <title>ISBN-Schnittstelle</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="positioning.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <?php
        $isbn = (isset($_POST["isbn"]) && is_string($_POST["isbn"])) ? $_POST["isbn"] : "";
        
        // Formulardaten Serverseitig verwerten und ausgeben -->
        // Formulardaten validieren (Pflichtfelder auf Werte überprüfen) -->

        $ok = false;
        $fehlerferlder = array();
        if (isset($_POST["Submit"])) {
            $ok = true;
            
            if (!isset($_POST["isbn"]) ||
                    trim($_POST["isbn"]) == "" ||
                    validate("/^(97(8|9))-\d-\d{2}-\d{6}-(\d|X)$/", $_POST["isbn"])) {
                $ok = false;
                $fehlerfelder[] = "isbn";
            }
            
            if ($ok) {
                ?>
                <h1>Metadaten</h1>
                <?php
                // Formulardaten Serverseitig ausgeben
                $isbn = htmlspecialchars($isbn);
                

                echo "<b>isbn:</b> $isbn<br />";

                ?>
                <?php
                // Fehler ausgeben
            } else {
                echo "<p><b>Formular unvollstaendig</b></p>";
                echo "<ul><li>";
                echo implode("</li><li>", $fehlerfelder);
                echo "</li></ul>";
            }
        }
        if (!$ok) {
            ?>


        <div class="container">
            <form method="post" enctype="multipart/form-data" action="/action_page.php">
                <input type="text" id="isbn" name="ISBN" pattern="(?:-13)?:?\x20*(?=.{17}$)97(?:8|9)([ -])\d{1,5}\1\d{1,7}\1\d{1,6}\1\d$" placeholder="978-" value="<?php echo htmlspecialchars($isbn); ?>" /><br />
                <input type="submit" value="Submit">
            </form>
            <div id="contentarea">
				<div class="textblock">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</div>
				<div class="textblock">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</div>
				<div class="textblock">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</div>
			</div>
        </div>
<?php
        }
        ?>
    </body>
</html>