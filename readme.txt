***DISCLAIMER***
This software is nowhere near ready for production.  I am not responsible for any losses if you choose to use this in a production website.  This repo is set up purely for educational purposes and curiosity.  YOU'VE BEEN WARNED.

How to set this thing up:

1. clone into the root of your web server
2. set up your db (sql)
	- change the database name in jambacms.sql and run it on your server
3. config the project
	- change the db info to work with your db server and the db that you defined above
	- change the encryption key to whatever you want
4. open up a browser and navigate to the server you installed this on, eg http://localhost.  You should see a little welcome screen.
5. to go to the admin section, browse to ./admin eg http://localhost/admin.  The default credentials are:
	Username: dev
	Password: dev
6. now you can add users, content blocks and blog posts.  The other features are still in development.
7. you can get your content blocks in your own public facing controllers with $this->content->get_by_name(<name>);

This project is still very much in development, and so is the documentation.  Stay tuned.

