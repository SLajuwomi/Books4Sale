<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Stephen's Webpage</title>
  <link href="form.css" rel="stylesheet" />
</head>

<body>
  <?php

  if (isset($_POST['isbn'])) {
    $isbn = $_POST['isbn'];
    $isbnclean = str_replace("-", "", $isbn);
    $valid = (preg_match("/^\d{9}[xX]|\d{10}$/", $isbnclean));

    if ($valid) {
      echo "ISBN is: $isbnclean<br>\n";
    } else {
      echo "ISBN is: Not valid<br>\n";
    }

    $bookcondition = $_POST['book-condition'];
    echo "Book condition is: $bookcondition<br>\n";


    if ($valid) {
      // Open the URL and read the HTML content
      $sourceStream = fopen("https://openlibrary.org/isbn/$isbnclean", 'r');
      $destinationStream = fopen("scraped.txt", 'w');

      while (!feof($sourceStream)) {
        fwrite($destinationStream, fgets($sourceStream));
      }

      fclose($sourceStream);
      fclose($destinationStream);

      $foundTitle = false;
      $foundAuthor = false;
      $foundPublisher = false;

      $destinationStream = fopen("scraped.txt", 'r');
      $fileContent = file_get_contents("scraped.txt");
      // echo $fileContent;
      $oneLine = str_replace(["\n", "\r", "\t"], "", $fileContent);
      // echo $oneLine;
  
      // Read each line from the opened URL until the end of the file
      // while (($line = fgets($handle)) !== false) {
      // echo $line;
      // Extract the title, author, and publisher from the HTML using regex
      if (preg_match("/<h1 class=\"work-title\" itemprop=\"name\">([^<]+)<\/h1>/", $oneLine, $result)) {
        echo "Title: $result[1]" . "<br>";
      }

      // reads only one line at a time
      if (preg_match("/\"author.{1,8}[A-Z][a-z]{3}\s+[A-Z][a-z]{6}/", $oneLine, $result)) {
        // echo "potential author: " . $oneLine . "<br>";
        echo "Author preg_match: " . preg_match("/\"author.{1,8}[A-Z][a-z]{3}\s+[A-Z][a-z]{6}/", $oneLine, $author) . "<br>";
      }

      // if (preg_match("/John Creasey/", $line, $result2)) {
      //   echo "potential author actual name: " . $line . "<br>";
      // }
      // Match author pattern
      if (
        (preg_match("/\"author.{1,8}([A-Z][a-z]{3}\s+[A-Z][a-z]{6})/", $oneLine, $author))
      ) {
        echo "here" . "<br>";
        // var_dump($author);
        echo "Author: $author[1]" . "<br>";

      }

      // Match publisher pattern
      if (preg_match("/publisher=([^|]+)\|/", $oneLine, $publisher)) {
        echo "Publisher: " . trim($publisher[1]) . "<br>";

      }

      // // If we found all three elements, we can stop reading
      // if ($foundTitle && $foundAuthor && $foundPublisher) {
      //   break;
      // }
  

      // if (!$foundTitle) {
      //   echo "Title: Not found<br>\n";
      // }
      // if (!$foundAuthor) {
      //   echo "Author: Not found<br>\n";
      // }
      // if (!$foundPublisher) {
      //   echo "Publisher: Not found<br>\n";
      // }
  
    }
    ?>

    <?php
  } else {
    ?>
    <h1>Something went wrong</h1>
    <?php
  }
  ?>
</body>

</html>