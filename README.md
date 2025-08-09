Webform data entry, validation, and database storage.
You are required to create a PHP application which allows a user to register new users in a MySQL
database table via a web form. Each user data item must be validated against a valid data specification
before being allowed to be stored in the database. If data is valid when the form submit button is pressed,
then a successful database storage message should be displayed, otherwise suitable feedback should be
provided to the user to enable them to correct any data errors. The desired interaction and output can be
seen by clicking on the following link; click here to see a working example.
You are provided with template index.php file, which will contain your PHP solution code, a template html
form ‘userDataForm.html’ containg the required web form and a CSS file ‘styles.css’ which contains some
basic styles for formatting the web form fields. You should try to achieve good separation of concerns, with
valid HTML code produced by your PHP code.
Your php application should conform to the following requirements:
1. You are to use the PHP Data Objects (PDO) database abstraction layer/class to implement your
PHP database access code.
2. You should create a suitable MySQL table in your titan MySQL Database called ‘usersTable’ to
store the following user data:
Column Name : userID, email, username, password, userType
Datatype: INT, VARCHAR(45), VARCHAR(30), VARCHAR(15), VARCHAR(10)
PK (primary key): X
NN (not null): X, X, X, X, X
Validation rules: auto increment, RFC 822 standard and UNIQUE, No less than 10 characters, alphanumeric and UNIQUE, ">= than 10 characters; must include, uppercase,
lowercase alphabetic character, a number plus at least
one of these special characters: & - $ % & * ! #", “admin” or “academic” or “student”

3. If the user presses the “Clear” button on the form, all data fields should be cleared in the form and
the form should be redisplayed ready for data entry.
4. If the user presses the “Save” button on the form, all data fields should be validated against the
specification in requirement 2.
5. If all data fields pass validation, then the application should display “New user [username]
successfully inserted into database" and the form should be redisplayed with all data fields cleared.
6. If any field fails validation, the data form should be redisplayed with exactly the data entered by the
user, plus highlighted (in red) feedback to allow the user to correct any data entry errors.
7. After the web form, you should display all "Users stored in the Database" as a HTML heading 2,
followed by HTML paragraphs displaying either, “No users stored in the database", or a list of all
users successfully stored in the database, as separate HTML paragraphs:
"ID:[userID], Email:[email], Username:[username], Type:[userType]"
8. The CSS file should not be modified, but the HTML form in the “html” subdirectory will need to be
modified to display data entered by the user, plus relevant feedback on form re-display.
9. A basic HTML page is provided (index.php) which is linked to the CSS file (also provided), but your
solution should attempt to achieve good separation of concerns, using library and user defined
functions to display the required content and validate and feedback errors on the HTML form
