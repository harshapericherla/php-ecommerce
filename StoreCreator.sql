CREATE TABLE inventory (
   inventory_id int auto_increment,
   inventory_name varchar(255),
   quantity int(12),
   PRIMARY KEY(inventory_id)
);
CREATE TABLE inventory_order(
   order_id int auto_increment,
   first_name varchar(255),
   last_name varchar(255),
   card_type varchar(255),
   PRIMARY KEY(order_id)
);
CREATE TABLE inventory_order_details(
   order_details_id int auto_increment,
   order_id int not null,
   inventory_id int not null,
   PRIMARY KEY(order_details_id),
   FOREIGN KEY (inventory_id) REFERENCES inventory(inventory_id),
   FOREIGN KEY (order_id) REFERENCES inventory_order(order_id)
)
