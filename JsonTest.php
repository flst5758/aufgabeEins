<!DOCTYPE html>
<html>
    <head>
        <title>ISBN-Schnittstelle</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="positioning.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <?php
        require_once 'IsbnServiceJson.php';
        require_once './DBCacheService.php';
        require_once 'Metadata.php';
        $isbn = "0596002815";
        $service = new DBCacheService(new IsbnServiceJson($isbn));
        $book = $service->getData($isbn);
        echo $book->getTitle();
        ?>
    </body>
</html>