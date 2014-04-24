climbcomp - Joseph Furlott


----------------------------------
VISITING THE PAGE
----------------------------------
- The root of the web app is stored as index.php so to visit the page from a running virtual machine, visit http://192.168.56.102/
- There is a chance that this IP will change on your computer, so run "ifconfig" to see the inet under em0, and visit that URL instead.

----------------------------------
PASSWORDS
----------------------------------

- The user is still dev, however, the password has been changed to being empty.  So just press enter when it asks for a password from dev or sudo.
- "Tigers Rule" is the PEM password that needs to be issued when trying to set up nginx (or if you restart the server).
- To access phpmyadmin to look at the database tables,
the user is "root" and the password is "lionslionslions".

----------------------------------
NOTES
----------------------------------

-Edited /etc/hosts.allow
-Edited /etc/my.cnf with /usr/local/share/mysql/mysql-small.cnf


----------------------------------
INFORMATION ABOUT BUILDING THE DB
----------------------------------


Database Tables

- users
- comps
- routes
- results
- climbers

users
----
first_name
last_name
gym_location
email
password
user_id
ver_code
verified

comps
----
user_id         <--- foreign key to users
comp_id         <--- primary key auto increment
name            <--- name of the comp
date            <--- date of the comp


CREATE TABLE cc_db.comps (
    user_id INT NOT NULL,
    comp_id INT PRIMARY KEY AUTO_INCREMENT,
    comp_name    VARCHAR(150),
    comp_date    DATE
)

routes
-----
route_id        <--- primary key
comp_id         <--- foreign key to comps
route_num       <--- number of the route in the gym
color           <--- color in the route in the gym
points          <--- number of points route is worth
location        <--- location in the actual gym

CREATE TABLE cc_db.routes (
    comp_id INT NOT NULL,
    route_num INT,
    color VARCHAR(150),
    points INT,
    location VARCHAR(150),
    route_id INT PRIMARY KEY AUTO_INCREMENT
)


results
-------
route_id
comp_id
climber_id
num_falls

CREATE TABLE cc_db.results (
    comp_id INT NOT NULL,
    route_id INT NOT NULL,
    climber_id INT NOT NULL,
    num_falls INT
)

climbers
--------
climber_id just autoincrement
first_name text

CREATE TABLE cc_db.climbers (
    climber_id INT PRIMARY KEY AUTO_INCREMENT,
    first_name VARCHAR(150)
)
