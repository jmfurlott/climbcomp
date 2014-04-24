climbcomp - Joseph Furlott


###TODO
- login and authentication
- bugfixes
- make routes editable after being created
- make prettier
- registration email
- better statistics 
- better climber input of statistics



###NOTES

- Edited /etc/hosts.allow
- Edited /etc/my.cnf with /usr/local/share/mysql/mysql-small.cnf


###INFORMATION ABOUT BUILDING THE DB
---

####Database Tables

- users
- comps
- routes
- results
- climbers

#####users


- first_name
- last_name
- gym_location
- email
- password
- user_id
- ver_code
- verified

#####comps

- user_id         <--- foreign key to users
- comp_id         <--- primary key auto increment
- name            <--- name of the comp
- date            <--- date of the comp

```
CREATE TABLE cc_db.comps (
    user_id INT NOT NULL,
    comp_id INT PRIMARY KEY AUTO_INCREMENT,
    comp_name    VARCHAR(150),
    comp_date    DATE
)
```

#####routes

- route_id        <--- primary key
- comp_id         <--- foreign key to comps
- route_num       <--- number of the route in the gym
- color           <--- color in the route in the gym
- points          <--- number of points route is worth
- location        <--- location in the actual gym

```
CREATE TABLE cc_db.routes (
    comp_id INT NOT NULL,
    route_num INT,
    color VARCHAR(150),
    points INT,
    location VARCHAR(150),
    route_id INT PRIMARY KEY AUTO_INCREMENT
)
```


#####results

- route_id
- comp_id
- climber_id
- num_falls

```
CREATE TABLE cc_db.results (
    comp_id INT NOT NULL,
    route_id INT NOT NULL,
    climber_id INT NOT NULL,
    num_falls INT
)
```

#####climbers

- climber_id just autoincrement
- first_name text

```
CREATE TABLE cc_db.climbers (
    climber_id INT PRIMARY KEY AUTO_INCREMENT,
    first_name VARCHAR(150)
)
```
