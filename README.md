Sign In Form
=================
2016-11-15


Php Sign In (and forgotten password) form example.


[![sign-in.png](https://s19.postimg.org/qpyr9rw0z/sign_in.png)](https://postimg.org/image/vbuvi4hjz/)





Why?
-------
If you have to do things from scratch (again), copy paste this form to get you started in no time.



How?
-----------
There are three important files:

- connexion.php
- forgotten_password.php
- styles.css


Copy paste those scripts in your application where you need them.




Boring & technical stuff
----------------------------


To support those example code snippets, I have an **users** table, with id, email, pseudo and url_photo fields.


### connexion.php

So this script displays the login form, and handles the associated errors.

Upon successful login, the script will call the callback referenced by the $onConnexionAfter variable.

In this case, I use **User::connect($item)** to create an user object via sessions, this is an actual working
code if you have implemented my other script: [session-user](https://github.com/lingtalfi/session-user).

But of course you can use any other code, the point is that it's where you should create your persistent user.


There is an option $use_forgotten_password to display/not display the "forgotten password" link.

I use [QuickPdo](https://github.com/lingtalfi/QuickPdo) to interact with the database (use whatever though).


### forgotten_password.php

Same principles as connexion.php: I'm using QuickPdo, and the script has the same structure, except that the function called upon successful credentials is **$onConnexionAfter**, which goal is to send a message to the
careless user.

In the example, I use [SwiftMailer](http://swiftmailer.org/) via the [sendMailTo](https://github.com/lingtalfi/send-mail-to) function. I've also defined a **WEBSITE_NAME** constant, used only in mail communication.




### styles.css
The styles.css defines the style for both connexion and forgotten_password scripts.
If you use my [sign up form](https://github.com/lingtalfi/sign-up-form), you will see that it uses almost 
the same styles.css (i.e. don't add the rules twice).











Related
===================
You might be interested in those other scripts as well:

- https://github.com/lingtalfi/sign-up-form
- https://github.com/lingtalfi/session-user





