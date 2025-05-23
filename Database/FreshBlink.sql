DROP TABLE Admin CASCADE CONSTRAINTS;
CREATE TABLE Admin (
  Admin_Id  integer NOT NULL,
  Username varchar2(25) NOT NULL,
  Password varchar2(15) NOT NULL,
  Profile_Image varchar2(200)  NULL,
  Email varchar2(100) NOT NULL,
  CONSTRAINT Admin_PK PRIMARY KEY (Admin_Id),
  CONSTRAINT Admin__UK UNIQUE (Username)
);


DROP TABLE Customer CASCADE CONSTRAINTS;
CREATE TABLE Customer (
  Customer_ID integer NOT NULL ,
  Full_Name varchar2(40) NOT NULL,
  Username varchar2(15) NOT NULL,
  Password varchar2(255) NOT NULL,
  Email varchar2(25) NOT NULL,
  Address varchar2(20) NOT NULL,
  Date_Of_Birth varchar2(20) NOT  NULL,
  Contact_number varchar2(10) NOT NULL,
  Sex varchar2(10) NOT NULL,
  Profile_Image varchar2(255)  NULL,
  Email_Verify integer  NULL,
  CONSTRAINT Customer_PK PRIMARY KEY (Customer_Id),
  CONSTRAINT Customer__UK UNIQUE (Username)
) ;


DROP TABLE Trader CASCADE CONSTRAINTS;
CREATE TABLE Trader (
  Trader_Id integer NOT NULL,
  Name varchar2(50) NOT NULL,
  Username varchar2(50) NOT NULL,
  Password varchar2(35) NOT NULL,
  Contact varchar2(10)  NULL,
  Email varchar2(255) NOT NULL,
  Profile_Image varchar(200)  NULL,
  Trader_Verification integer  NULL,
  CONSTRAINT Trader_PK PRIMARY KEY (Trader_Id),
  CONSTRAINT Trader__UK UNIQUE (Username)
);



DROP TABLE Discount CASCADE CONSTRAINTS;
CREATE TABLE Discount (
  Discount float NOT NULL,
  Customer_Id integer NOT NULL REFERENCES Customer(Customer_Id),
  Product_Id integer NOT NULL  REFERENCES Product(Product_Id)
);

DROP TABLE Cart CASCADE CONSTRAINTS;
CREATE TABLE Cart (
  Cart_Id integer NOT NULL,
  Total_Price float NOT NULL,
  Customer_Id integer NOT NULL REFERENCES Customer(Customer_Id),
  Product_Id integer NOT NULL  REFERENCES Product(Product_Id),
  CONSTRAINT Cart_PK PRIMARY KEY (Cart_Id)
);

DROP TABLE Orders CASCADE CONSTRAINTS;
CREATE TABLE Orders (
  Order_Id integer NOT NULL,
  Order_Date date NOT NULL,
  Quantity integer NOT NULL,
  Order_price float NOT NULL,
   Customer_Id integer NOT NULL REFERENCES Customer(Customer_Id),
  Product_Id integer NOT NULL  REFERENCES Product(Product_Id),
  Delivery_Status integer NULL,
  CONSTRAINT Order_PK PRIMARY KEY (Order_Id)
    
);


DROP TABLE Payment;
CREATE TABLE Payment (
  Payment_Id varchar2(50) NOT NULL,
  Payment_type varchar2(255) NOT NULL,
  Total_Payment float NOT NULL,
  Customer_Id integer NOT NULL,
  Order_Id integer NOT NULL 
);



DROP TABLE Product CASCADE CONSTRAINTS;
CREATE TABLE Product (
  Product_Id integer NOT NULL,
  Product_Type varchar2(20) NOT NULL,
  Product_Name varchar2(100) NOT NULL,
  Product_Price float NOT NULL,
  Product_Details varchar2(300) NOT NULL,
  Stock integer NOT NULL,
  Product_Image varchar2(200) NOT NULL,
  Shop_Id integer NOT NULL REFERENCES Shop(Shop_Id),
  Product_Verification integer NULL,
  CONSTRAINT Product_PK PRIMARY KEY (Product_Id)
 );



DROP TABLE Review CASCADE CONSTRAINTS;
CREATE TABLE Review (
  Review_Id integer NOT NULL,
  Rating integer NOT NULL,
  Description varchar2(300) NOT NULL,
   Customer_Id integer NOT NULL REFERENCES Customer(Customer_Id),
  Product_Id integer NOT NULL  REFERENCES Product(Product_Id),
  Dates date DEFAULT NULL,
  Review_Status integer NULL,
  CONSTRAINT Review_PK PRIMARY KEY (Review_Id)
 
) ;




DROP TABLE Shop CASCADE CONSTRAINTS;
CREATE TABLE Shop (
  Shop_Id integer NOT NULL,
  Shop_Name varchar2(20) NOT NULL,
  Shop_description varchar2(200) NOT NULL,
  Shop_location varchar2(20) NOT NULL,
  Trader_id integer NOT NULL REFERENCES Trader(Trader_id),
  Shop_Verification integer  NULL,
  CONSTRAINT Shop_PK PRIMARY KEY (Shop_Id)
);


DROP TABLE Time_Slot CASCADE CONSTRAINTS;
CREATE TABLE Time_Slot (
  Time_Slot_Id integer NOT NULL,
  Time_Slot_Date varchar2(50) NOT NULL,
  Time_Slot_Time varchar2(20) NOT NULL,
  Order_Id integer NOT NULL REFERENCES Orders(Order_id),
  Customer_Id Integer NOT NULL REFERENCES Customer(Customer_id),
 CONSTRAINT Time_Slot_PK PRIMARY KEY (Time_Slot_Id)
) ;




----Sequences
DROP SEQUENCE Admin_Id_seq;
CREATE SEQUENCE Admin_Id_seq
 START WITH     5100
MINVALUE 5100
MAXVALUE 999999999999999999
 INCREMENT BY   1
 NOCACHE
 NOCYCLE;
 

DROP SEQUENCE Customer_Id_seq;
CREATE SEQUENCE Customer_Id_seq
 START WITH     3100
MINVALUE 3100
MAXVALUE 999999999999999999
 INCREMENT BY   1
 NOCACHE
 NOCYCLE;
 
DROP SEQUENCE Trader_Id_seq;
CREATE SEQUENCE Trader_Id_seq
 START WITH     4100
MINVALUE 4100
MAXVALUE 999999999999999999
 INCREMENT BY   1
 NOCACHE
 NOCYCLE;
 
 DROP SEQUENCE Cart_Id_seq;
CREATE SEQUENCE Cart_Id_seq
 START WITH     2100
MINVALUE 2100
MAXVALUE 999999999999999999
 INCREMENT BY   1
 NOCACHE
 NOCYCLE;
 
 DROP SEQUENCE Order_Id_seq;
CREATE SEQUENCE Order_Id_seq
 START WITH     7100
MINVALUE 7100
MAXVALUE 999999999999999999
 INCREMENT BY   1
 NOCACHE
 NOCYCLE;
 
DROP SEQUENCE Product_Id_seq;
CREATE SEQUENCE Product_Id_seq
 START WITH     1100
MINVALUE 1100
MAXVALUE 999999999999999999
 INCREMENT BY   1
 NOCACHE
 NOCYCLE;
 
 
DROP SEQUENCE Review_Id_seq;
CREATE SEQUENCE Review_Id_seq
 START WITH     9001
MINVALUE 9001
MAXVALUE 999999999999999999
 INCREMENT BY   1
 NOCACHE
 NOCYCLE;
 
 
DROP SEQUENCE Shop_Id_seq;
CREATE SEQUENCE Shop_Id_seq
 START WITH     6015
MINVALUE 6015
MAXVALUE 999999999999999999
 INCREMENT BY   1
 NOCACHE
 NOCYCLE;
 
 
DROP SEQUENCE Time_Slot_Id_seq;
CREATE SEQUENCE Time_Slot_Id_seq
 START WITH     110
MINVALUE 110
MAXVALUE 999999999999999999
 INCREMENT BY   1
 NOCACHE
 NOCYCLE;

 
 
 ------Admin
INSERT INTO Admin (Admin_Id, Username, Password, Email) VALUES (5001, 'abitmahato712', 'Az@12345?','abit@gmail.com');
INSERT INTO Admin (Admin_Id, Username, Password, Email) VALUES (5002, 'Joshipratish12', 'Az@12345?','pratishjoshi07@gmail.com');


------Trader
INSERT INTO Trader (Trader_Id, Name, Username, Password, Contact, Email, Profile_Image, Trader_Verification) VALUES
(4001, 'Jack Morris', 'JackMorris756', 'Az@12345?', '9802365421', 'jackmorris756@gmail.com', '', 1);

INSERT INTO Trader (Trader_Id, Name, Username, Password, Contact, Email, Profile_Image, Trader_Verification) VALUES
(4002, 'Tim Hilton', 'timhilton31', 'Az@12345?', '9802365422', 'timhilton31@gmail.com', '', 1);

INSERT INTO Trader (Trader_Id, Name, Username, Password, Contact, Email, Profile_Image, Trader_Verification) VALUES
(4003, 'Jimmy Chu', 'jimmychu236', 'Az@12345?', '9802365423', 'jimmychu236@gmail.com', '', 1);

INSERT INTO Trader (Trader_Id, Name, Username, Password, Contact, Email, Profile_Image, Trader_Verification) VALUES
(4004, 'Kamala Harris', 'kamala54', 'Az@12345?', '9802365424', 'kamala54@gmail.com', '', 1);

INSERT INTO Trader (Trader_Id, Name, Username, Password, Contact, Email, Profile_Image, Trader_Verification) VALUES
(4005, 'Tom Hardy', 'hardytom69', 'Az@12345?', '9802365425', 'hardytom69@gmail.com', '', 1);

INSERT INTO Trader (Trader_Id, Name, Username, Password, Contact, Email, Profile_Image, Trader_Verification) VALUES
(4007, 'Pratish Joshi', 'Pratish', 'Azeeta@1', '9860802472', 'joshipratish12@gmail.com', '', 1);

--


------Customer

INSERT INTO Customer (Customer_Id,Full_Name,Username,Password,Email,Address,Date_Of_Birth,Contact_Number,Sex,Profile_Image,Email_Verify)VALUES
(3001, 'Abit Kumar Mahato', 'abitmahato712', 'Az@12345?', 'abitmahato712@gmail.com', 'Sukhipur,Siraha', '07/02/2021', '9808079576', 'Male', '', 0);

INSERT INTO Customer (Customer_Id,Full_Name,Username,Password,Email,Address,Date_Of_Birth,Contact_Number,Sex,Profile_Image,Email_Verify)VALUES
(3002, 'Pratish Joshi', 'joshipratish12', 'Azeeta@1', 'joshipratish12@gmail.com', 'Kathmandu', '06/02/2021', '9808079576', 'Male', 'images/customer/driving license.jpg', 0);

INSERT INTO Customer (Customer_Id,Full_Name,Username,Password,Email,Address,Date_Of_Birth,Contact_Number,Sex,Profile_Image,Email_Verify)VALUES
(3003, 'Apil Parajuli', 'parajuliapil105', 'Az@12345?', 'parajuliapil1056@gmail.co', 'Kathmandu', '05/02/2021', '980563978', 'Male', 'images/customer/Screenshot (17).png', 0);

INSERT INTO Customer (Customer_Id,Full_Name,Username,Password,Email,Address,Date_Of_Birth,Contact_Number,Sex,Profile_Image,Email_Verify)VALUES
(3004, 'Bibek Maharjan', 'bibekmaharjan71', 'Az@12345?', 'bibekmaharjan712@gmail.co', 'Lalitpur', '04/02/2021', '9856321458', 'Male', '', 0);

INSERT INTO Customer (Customer_Id,Full_Name,Username,Password,Email,Address,Date_Of_Birth,Contact_Number,Sex,Profile_Image,Email_Verify)VALUES
(3005, 'Bibek Shah', 'bibekshah256', 'Az@12345?', 'bibekshah256@gmail.com', 'Biratnagar', '03/02/2021', '9802366541', 'Male', '', 0);

INSERT INTO Customer (Customer_Id,Full_Name,Username,Password,Email,Address,Date_Of_Birth,Contact_Number,Sex,Profile_Image,Email_Verify)VALUES
(3023, 'ben', 'ben', 'Az@12345?', 'ben@gmail.com', 'ben', '10/12/2020', '9832651235', 'Female', '', 0);

INSERT INTO Customer (Customer_Id,Full_Name,Username,Password,Email,Address,Date_Of_Birth,Contact_Number,Sex,Profile_Image,Email_Verify)VALUES
(3024, 'krishna ', 'krishna ', 'Az@12345?', 'krishna@gmail.com', 'krishna ', '10/08/2003', ' ', 'Female', '', 0);

INSERT INTO Customer (Customer_Id,Full_Name,Username,Password,Email,Address,Date_Of_Birth,Contact_Number,Sex,Profile_Image,Email_Verify)VALUES
(3066, 'Sukuna Reaper', 'Sukuna', 'Sukuna@12', 'joshipratish997@gmail.com', 'Akron', '07/25/2006', '9860802472', 'Male', '', 0);



-----Shop
INSERT INTO Shop (Shop_Id, Shop_Name, Shop_description, Shop_location, Trader_id, Shop_Verification) VALUES
(6001, 'Butcher', 'We supply varities of fresh and healthy meat,steak', 'Cleckhuddersfax', 4001, 1);

INSERT INTO Shop (Shop_Id, Shop_Name, Shop_description, Shop_location, Trader_id, Shop_Verification) VALUES
(6003, 'Greengrocer', 'We have varities of vegetable and fruits', 'Cleckhuddersfax', 4004, 1);

INSERT INTO Shop (Shop_Id, Shop_Name, Shop_description, Shop_location, Trader_id, Shop_Verification) VALUES
(6002, 'Fishmonger', 'We supply different types of frozen and alive fish', 'Cleckhuddersfax', 4003, 1);

INSERT INTO Shop (Shop_Id, Shop_Name, Shop_description, Shop_location, Trader_id, Shop_Verification) VALUES
(6004, 'Bakery', 'We supply cakes,cookies,bread and many more', 'Cleckhuddersfax', 4002, 1);

INSERT INTO Shop (Shop_Id, Shop_Name, Shop_description, Shop_location, Trader_id, Shop_Verification) VALUES
(6005, 'Delicatessen', 'We sell cooked meat,salad,nachos,cheese and manymo', 'Cleckhuddersfax', 4005, 1);

INSERT INTO Shop (Shop_Id, Shop_Name, Shop_description, Shop_location, Trader_id, Shop_Verification) VALUES
(6010, 'AcE', '                             Beauty           ', 'Cleckhuddersfax', 4007, 1);


-----Product

INSERT INTO Product (Product_Id, Product_Type, Product_Name, Product_Price, Product_Details, Stock, Product_Image, Shop_Id, Product_Verification) VALUES
(1001, 'Bakery', 'Cake', 800, 'One pound of healthy and delicious black forest cake. Its allergic to diabetes patient', 0, 'images/bakery_03.png', 6004, 1);


INSERT INTO Product (Product_Id, Product_Type, Product_Name, Product_Price, Product_Details, Stock, Product_Image, Shop_Id, Product_Verification) VALUES
(1002, 'Bakery', 'Donught', 50, 'A cream filled donught.Its allergic to diabetes pateint', 4, 'images/bakery_04.png', 6004, 1);


INSERT INTO Product (Product_Id, Product_Type, Product_Name, Product_Price, Product_Details, Stock, Product_Image, Shop_Id, Product_Verification) VALUES
(1003, 'Bakery', 'Wholegrain Bread', 80, 'Whole grain bread enriched with fibres and vitamins.Not allergic to anyone', 8, 'images/bakery_01.png', 6004, 1);

INSERT INTO Product (Product_Id, Product_Type, Product_Name, Product_Price, Product_Details, Stock, Product_Image, Shop_Id, Product_Verification) VALUES
(1004, 'Bakery', 'Cookies', 100, 'Cookies made up of wheat and oats. Easy to digest and non allergic', 18, 'images/bakery_02.png', 6004, 1);

INSERT INTO Product (Product_Id, Product_Type, Product_Name, Product_Price, Product_Details, Stock, Product_Image, Shop_Id, Product_Verification) VALUES
(1005, 'Butcher', 'Mutton', 1300, 'Pack of a kg of fresh chopped mutton.Allergic to people with cholestrol', 10, 'images/butcher_02.png', 6001, 1);

INSERT INTO Product (Product_Id, Product_Type, Product_Name, Product_Price, Product_Details, Stock, Product_Image, Shop_Id, Product_Verification) VALUES
(1006, 'Butcher', 'Chicken', 300, 'Freshly cut chicken per kg.Non allergic', 8, 'images/butcher_03.png', 6001, 1);

INSERT INTO Product (Product_Id, Product_Type, Product_Name, Product_Price, Product_Details, Stock, Product_Image, Shop_Id, Product_Verification) VALUES
(1007, 'Butcher', 'Pork', 500, 'Freshly cut local pig per kg.Non allergic', 5, 'images/butcher_01.png', 6001, 1);

INSERT INTO Product (Product_Id, Product_Type, Product_Name, Product_Price, Product_Details, Stock, Product_Image, Shop_Id, Product_Verification) VALUES
(1008, 'Butcher', 'Buff meat', 400, 'One kg of fresh and clean buff meat.Allergic to cholestrol', 17, 'images/butcher_04.png', 6001, 1);

INSERT INTO Product (Product_Id, Product_Type, Product_Name, Product_Price, Product_Details, Stock, Product_Image, Shop_Id, Product_Verification) VALUES
(1009, 'Greengrocery', 'Brocolli', 80, 'Green and fresh local brocoli enriched in fibres and vitamins.Non allergic', 10, 'images/greengrocery_01.png', 6003, 1);

INSERT INTO Product (Product_Id, Product_Type, Product_Name, Product_Price, Product_Details, Stock, Product_Image, Shop_Id, Product_Verification) VALUES
(1010, 'Greengrocery', 'Spinach', 80, 'Fresh and multipurpose spinach. Can be used as veggies,salad.Non allergic', 10, 'images/greengrocery_02.png', 6003, 1);

INSERT INTO Product (Product_Id, Product_Type, Product_Name, Product_Price, Product_Details, Stock, Product_Image, Shop_Id, Product_Verification) VALUES
(1011, 'Greengrocery', 'Apple', 250, 'Fresh and tasty fuji apples per kg.Non allergic', 10, 'images/greengrocery_03.png', 6003, 1);

INSERT INTO Product (Product_Id, Product_Type, Product_Name, Product_Price, Product_Details, Stock, Product_Image, Shop_Id, Product_Verification) VALUES
(1012, 'Greengrocery', 'Avocado', 350, 'Avocado is a very nutritious fruit and can be consumed by ages of all people. Packet consists of half kg.Consumable by all ,non allergic', 5, 'images/greengrocery_04.png', 6003, 1);

INSERT INTO Product (Product_Id, Product_Type, Product_Name, Product_Price, Product_Details, Stock, Product_Image, Shop_Id, Product_Verification) VALUES
(1013, 'Fishmonger', 'Rohu fish', 500, 'Fresh fish brought from local ponds and lakes.Shelfish allergic', 10, 'images/fishmonger_01.png', 6002, 1);

INSERT INTO Product (Product_Id, Product_Type, Product_Name, Product_Price, Product_Details, Stock, Product_Image, Shop_Id, Product_Verification) VALUES
(1014, 'Fishmonger', 'Cat Fish', 800, 'Fish found very rare in local areas, especially found in sea areas.Shelfish allergic', 4, 'images/fishmonger_02.png', 6002, 1);

INSERT INTO Product (Product_Id, Product_Type, Product_Name, Product_Price, Product_Details, Stock, Product_Image, Shop_Id, Product_Verification) VALUES
(1015, 'Fishmonger', 'Prawn', 300, 'Prawns can be used in various ways. It can be transformed into chips also.Shelfish allergic', 3, 'images/fishmonger_03.png', 6002, 1);

INSERT INTO Product (Product_Id, Product_Type, Product_Name, Product_Price, Product_Details, Stock, Product_Image, Shop_Id, Product_Verification) VALUES
(1016, 'Fishmonger', 'Crab', 400, 'Special crabs only found in seas and oceans.As allergic as seafoods', 2, 'images/fishmonger_04.png', 6002, 1);

INSERT INTO Product (Product_Id, Product_Type, Product_Name, Product_Price, Product_Details, Stock, Product_Image, Shop_Id, Product_Verification) VALUES
(1017, 'Delicatesssen', 'Steaks', 200, 'Frozen steaks can be fried and used instantly in snacks or anytime.Not allergic', 2, 'images/delicatessen_01.png', 6005, 1);

INSERT INTO Product (Product_Id, Product_Type, Product_Name, Product_Price, Product_Details, Stock, Product_Image, Shop_Id, Product_Verification) VALUES
(1018, 'Delicatesssen', 'Cheese', 200, 'Multipurpose mozzirella Cheese made up of fresh cow milk. Consists half kg in a packet.Allergic to lactose intolerant', 6, 'images/delicatessen_02.png', 6005, 1);

INSERT INTO Product (Product_Id, Product_Type, Product_Name, Product_Price, Product_Details, Stock, Product_Image, Shop_Id, Product_Verification) VALUES
(1019, 'Delicatesssen', 'Hotdog', 150, 'Fresh hot dogs stuffed with cheese, veggies, meat and sauces.Non allergic', 15, 'images/delicatessen_03.png', 6005, 1);

INSERT INTO Product (Product_Id, Product_Type, Product_Name, Product_Price, Product_Details, Stock, Product_Image, Shop_Id, Product_Verification) VALUES
(1020, 'Delicatesssen', 'Sausage', 300, 'Chicken and buff sausages. Fry and enjoy it within no time.Non allergic', 15, 'images/delicatessen_04.png', 6005, 1);



-----------Order

INSERT INTO Orders (Order_Id, Order_Date, Quantity, Order_price, Customer_Id, Product_Id, Delivery_Status) VALUES
(7001, '06-05-2021', 1, 50, 3023, 1002, 0);


INSERT INTO Orders (Order_Id, Order_Date, Quantity, Order_price, Customer_Id, Product_Id, Delivery_Status) VALUES
(7002, '06-05-2021', 1, 80, 3023, 1003, 0);

INSERT INTO Orders (Order_Id, Order_Date, Quantity, Order_price, Customer_Id, Product_Id, Delivery_Status) VALUES
(7003, '06-05-2021', 18, 7200, 3002, 1016, 1);

INSERT INTO Orders (Order_Id, Order_Date, Quantity, Order_price, Customer_Id, Product_Id, Delivery_Status) VALUES
(7004, '06-05-2021', 1, 80, 3002, 1003, 0);

INSERT INTO Orders (Order_Id, Order_Date, Quantity, Order_price, Customer_Id, Product_Id, Delivery_Status) VALUES
(7005, '06-05-2021', 1, 80, 3002, 1003, 0);

INSERT INTO Orders (Order_Id, Order_Date, Quantity, Order_price, Customer_Id, Product_Id, Delivery_Status) VALUES
(7006, '06-05-2021', 1, 1300, 3002, 1005, 1);

INSERT INTO Orders (Order_Id, Order_Date, Quantity, Order_price, Customer_Id, Product_Id, Delivery_Status) VALUES
(7007, '06-05-2021', 1, 80, 3002, 1003, 0);

INSERT INTO Orders (Order_Id, Order_Date, Quantity, Order_price, Customer_Id, Product_Id, Delivery_Status) VALUES
(7008, '06-05-2021', 1, 80, 3066, 1003, 0);


INSERT INTO Orders (Order_Id, Order_Date, Quantity, Order_price, Customer_Id, Product_Id, Delivery_Status) VALUES
(7009, '06-05-2021', 2, 600, 3066, 1006, 0);


----Cart
INSERT INTO Cart (Cart_Id, Total_Price, Customer_Id, Product_Id) VALUES
(2001, 1, 3066, 1015);


INSERT INTO Cart (Cart_Id, Total_Price, Customer_Id, Product_Id) VALUES
(2002, 1, 3066, 1015);

INSERT INTO Cart (Cart_Id, Total_Price, Customer_Id, Product_Id) VALUES
(2003, 1, 3066, 1008);

INSERT INTO Cart (Cart_Id, Total_Price, Customer_Id, Product_Id) VALUES
(2004, 2, 3066, 1004);

INSERT INTO Cart (Cart_Id, Total_Price, Customer_Id, Product_Id) VALUES
(2005, 2, 3066, 1004);

INSERT INTO Cart (Cart_Id, Total_Price, Customer_Id, Product_Id) VALUES
(2006, 1, 3066, 1006);


----Review


INSERT INTO Review (Review_Id, Rating, Description, Customer_Id, Product_Id, Dates, Review_Status) VALUES
(1, 1, 'this product is trash.', 3004, 1001, '06-02-2021', 1);

INSERT INTO Review (Review_Id, Rating, Description, Customer_Id, Product_Id, Dates, Review_Status) VALUES
(2, 4, 'I love this product.', 3002, 1001, '06-12-2021', 1);

INSERT INTO Review (Review_Id, Rating, Description, Customer_Id, Product_Id, Dates, Review_Status) VALUES
(8, 5, 'This is super delicious and of high quality. :D', 3066, 1002, '07-01-2021', 0);

INSERT INTO Review (Review_Id, Rating, Description, Customer_Id, Product_Id, Dates, Review_Status) VALUES
(16, 5, 'The Bread was really Fresh and Soft. I loved it. Will be ordering more of these. <3', 3066, 1003, '07-01-2021', 0);









