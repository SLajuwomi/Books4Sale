<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stephen's Webpage</title>
    <link href="form.css" rel="stylesheet"/>
</head>
<body>
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
                        <input type="text" name="isbn" id="isbn"/>
                    </div>
            </section>
            <section role="condition">
                <label for="book-condition">Book Condition:</label>
                <select name="book-condition" id="book-conditon">
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
</body>
</html>