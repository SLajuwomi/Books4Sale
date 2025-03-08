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
            $handle = fopen("https://www.amazon.com/exec/obidos/ISBN=$isbnclean", 'r');
            // Read each line from the opened URL until the end of the file
            while (($line = fgets($handle)) !== false) {
                // Extract the title, author, and publisher from the HTML using regex
                if (preg_match("/<span id=\"productTitle\" class=\"a-size-extra-large[^>]*>([^<]+)<\/span>/", $line, $result)) {
                    echo "Title: $result[1]<br>\n";
                }

                // if (preg_match("/<a class=\"a-link-normal\".+>(.+)<\/a>     <span class=\"contribution\" spacing=\"none\">/",$line,$author)) {
                //     echo "Author: $author[1]<br>\n";
                // } 
    
                if (preg_match("/<a class=\"a-link-normal\".+>(.+)<\/a>     <span class=\"contribution\" spacing=\"none\">/", $line, $author)) {
                    echo "Author: $author[1]<br>\n";
                }
                /* if (preg_match("/<span class=\"a-text-bold\">Publisher\n\s+&rlm;\n\s+:\n\s+&lrm;\n\s+<\/span>\s*<span>([^<]+)<\/span>/", $line, $publisher)) {
                    echo "Publisher: $publisher[1]<br>\n";
                } */

                // if (($line = preg_match("/<span class=\"a-text-bold\">Publisher/"))) {
                //         if (preg_match("/(?<=Publisher).+<\/span>\s<span>(.+)<\/span>/gsU", $line, $publisher))
                //         echo "Publisher: $publisher[1]<br>\n";
                // }
    
                if (preg_match("/(?<=<span>).+\(.+\d{4}\)(?=<\/span>)/", $line, $publisher)) {
                    // echo json_encode($publisher),"\n";
                    echo "Publisher: $publisher[0]<br>\n";
                }

                // // Extract publisher from the detail bullets section
                // if (preg_match('/<span class="a-text-bold">Publisher[^<]*<\/span>\s*<span>([^<]+)<\/span>/', $line, $publisher)) {
                //     echo "Publisher: " . trim($publisher[1]) . "<br>\n";
                // }
            }
            if (!isset($publisher) || empty($publisher)) {
                echo "Publisher: Not found<br>\n";
            }
            if (!isset($author) || empty($author)) {
                echo "Author: Not found<br>\n";
            }
            if (!isset($result) || empty($result)) {
                echo "Title: Not found<br>\n";
            }
        }
        ?>

        <?php
    } else {
        ?>
        <div class="header">

            <h1>Stephen's Webpage</h1>
            <p class="created">Date Created: <span class="datecreated">Jan. 17, 2024</span></p>
        </div>
        <div class="helloworld">
            <main>
                <hr>
                <section class="beginning">
                    <h3>
                        <span class="multicolortext">Hello World</span>
                    </h3>
                    <p class="today-date">This is today's date: <span><?php echo date("F j, Y, g:i a"); ?></span></p>
                </section>
            </main>
        </div>
        <div class="form">
            <form method="post" action="scraper.php">
                <section role="ISBN">
                    <h2 class="book-form-heading">Book Form</h2>
                    <div class="isbn-entry">
                        <label for="isbn">ISBN:</label>
                        <input type="text" name="isbn" id="isbn" />
                    </div>
                </section>
                <section role="condition">
                    <label for="bookcondition">Book Condition:</label>
                    <select name="bookcondition" id="bookconditon">
                        <option value="">Select an option</option>
                        <option value="poor">1=poor</option>
                        <option value="fair">2=fair</option>
                        <option value="good">3=good</option>
                        <option value="excellent">4=excellent</option>
                    </select>
                </section>
                <input type="submit" value="Submit">
            </form>

        </div>
        <?php
    }
    ?>
</body>

</html>