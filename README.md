localhost
=========

A small program that can be used to list files in your www directory on a Linux OS such as Ubuntu or Linux Mint

This should work out of the box on most versions of Linux, but it's really simple to change if you need to,
The reason why I did this was simply because there weren't any basic file listers out there, most were over complicated.

Now I did add some logic to it, like detecting frameworks in folders and such, but it's mostly just a few if statements.

You can use this in 2 ways that I accounted for:

1: Just dump it in the www folder and be done with it, then when you hit localhost, your should get a list of all your project folders. or
2: (Recommended) Create a vhost somewhere else and point your default route to it, then throw this into that folder, and make sure you add the path to your project folder (like /var/www) to the index.php file.
   Bear in mind, if you do this, you will pretty much need to create vhosts for all your projects.
