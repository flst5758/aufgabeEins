<!DOCTYPE html>
<html>
    <head>
        <title>ISBN-Schnittstelle</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="positioning.css" rel="stylesheet" type="text/css"/>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="isbn.js"></script>
    </head>
    <body>



        <div class="container">
            <form id="searchForm" method="post" enctype="multipart/form-data" action="/action_page.php">
         pattern="(?:-13)?:?\x20*(?=.{17}$)97(?:8|9)([ -])\d{1,5}\1\d{1,7}\1\d{1,6}\1\d$"
                <input type="text" id="isbn" name="ISBN"  placeholder="978-" /><br />
                <input type="submit" value="Submit">
            </form>
            <div id="contentarea">
                
            </div>
        </div>

    </body>
</html>