
insert into products (name, price, description, category_id, stock_qty , image_name) VALUES ("T shirt bailarina","29.90", "Blue slim ballerina","299","f.jpg");
insert into products (name, price, description, category_id, stock_qty , image_name) VALUES ("Mens t shirt","29.90","Mens outfit collection james'murr","1","g.jpg");
insert into products (name, price, description, category_id, stock_qty , image_name) VALUES ("t-shirt","34,99","Long hair style","2","100","h.jpg");
insert into products (name, price, description, category_id, stock_qty , image_name) VALUES ("Big bOys","27.98","Big boys dream","1","300","i.jpg");
insert into products (name, price, description, category_id, stock_qty , image_name) VALUES ("T shirt Gray", "19.99", "Dark gray modern style","2","100","j.jpg");
insert into products (name, price, description, category_id, stock_qty , image_name) VALUES ("Kids christmas theme" , "15.00", "I am only a morning person","3","100","u.jpg");
insert into products (name, price, description, category_id, stock_qty , image_name) VALUES ("t-betty girls purple" , "14.80", "Betty boop girls","3","34","z.jpg");
insert into products (name, price, description, category_id, stock_qty , image_name) VALUES ("girls t shirt" , "19.76", "Santa is coming to" ,"3","240","y.jpg");
insert into products (name, price, description, category_id, stock_qty , image_name) VALUES ("t-pig" , "27.19", "All lives matter","3", "80","s.jpg");
insert into products (name, price, description, category_id, stock_qty , image_name) VALUES ("t-night" , "25.80", "Christmas tree for kids","3","60","x.jpg");
insert into products (name, price, description, category_id, stock_qty , image_name) VALUES ("five people" , "14.00", "five people art","2","209","m.jpg");
insert into products (name, price, description, category_id, stock_qty , image_name) VALUES ("huge mistake t-shirt" , "37.99", "become a vegetarian","1","130","n.jpg");
insert into products (name, price, description, category_id, stock_qty , image_name) VALUES ("black t-shirt" , "9.99" , "basement boys records","3","15","o.jpg");
insert into products (name, price, description, category_id, stock_qty , image_name) VALUES ("pink playing" , "7.12" , "without warning","3","20","p.jpg");
insert into products (name, price, description, category_id, stock_qty , image_name) VALUES ("blue","45.00", "big boy drummer","3","900","r.jpg");
insert into products (name, price, description, category_id, stock_qty , image_name) VALUES ("white christmas", "8.10",  "white christmas theme","3","45","t.jpg");
insert into products (name, price, description, category_id, stock_qty , image_name) VALUES ("penguin","5.66","penguin cold","3","56","w.jpg");


insert into role (role_name, role_description) VALUES ("admin","administrator can do all actions");
insert into permission (permission_description) VALUES ("add product");
insert into permission (permission_description) VALUES ("update product");
insert into permission (permission_description) VALUES ("delete product");
insert into permission (permission_description) VALUES ("add user");
insert into permission (permission_description) VALUES ("update user");
insert into permission (permission_description) VALUES ("delete user");

insert into role_permission (role_id, permission_id) VALUES (1,1);
insert into role_permission (role_id, permission_id) VALUES (1,2);
insert into role_permission (role_id, permission_id) VALUES (1,3);
insert into role_permission (role_id, permission_id) VALUES (1,4);
insert into role_permission (role_id, permission_id) VALUES (1,5);
insert into role_permission (role_id, permission_id) VALUES (1,6);
insert into user_role (user_id, role_id) VALUES (1,1);
