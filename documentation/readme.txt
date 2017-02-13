For database part:
We use the phpNow as our website-building tool, and it contains the 
php(you need to upgrade it from 5.2.14 to 5.3.5), Apache and Phpmyadmin(Mysql).
Here is the instruction of how to use it:
1. Install the phpnow and upgrade php file.
2. Build a database and user named "se2" in the phpmyadmin
3. Import the se2.sql(in SQL file folder) into the "se2" database
4. Put the whole "codefile" file folder exactly under the "htdocs" sub-folder of the phpNow
5. Copy "127.0.0.1/codefile/phase1_web.php" to chrome.
6. You can click the two link under the "Options" header to get current and history file.
7. You can click the two link under the "Database link" header to check the database system and file.
8. You can also copy "127.0.0.1/codefile/getCurrent.php" or "127.0.0.1/codefile/getCHistorical.php"
   to chrome and it will put the data to our database system.

For stock price prediction system part:
We also use php to connect the database.
1. First you need to click the homepage.html.
2. You can click the sign up to register an account, then you can login to index.php.
3. In index.php you can see many queries functionality, you can also jump to other 
   pages by click the sidebar.
4. In Historical.php and Realtime.php you can see the stock price after you search 
   a stock and add. Then you just need to click the button, it will show price diagram.
5. In price.php you can see the stock price prediction results.
6. In indictator,php you can see the VR and KDJ value, it can recommand some operation
   for your stock transaction.
7. In Email.php you can add the email notification, once the stock price is lower than
   the stop loss price you set, you will receive the email notification.

For price predition strategies:
1. We use bayesian curve fitting in java to predict short term stock price.
2. We use SVM in matlab to predict short term stock price.
3. We use Neural Network in java to predict long term stock price.